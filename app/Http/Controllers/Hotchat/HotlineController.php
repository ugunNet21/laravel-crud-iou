<?php

namespace App\Http\Controllers\Hotchat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageAttachment;
use App\Models\MessageReadStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HotlineController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hotlinesQuery = Conversation::hotline()
            ->with(['lastMessage', 'participants', 'creator', 'recipient']);

        // If user is not PIC, Admin, or Back Office Kota, show only their created conversations
        if (!$user->hasAnyRole(['PIC', 'Admin', 'Back Office Kota'])) {
            $hotlinesQuery->where('created_by', $user->id);
        }

        $hotlines = $hotlinesQuery->orderByDesc('created_at')->get();

        return view('hotline.index', compact('hotlines'));
    }

    public function create()
    {
        // Get available recipient types (Back Office Kota / PIC)
        $recipientTypes = [
            'Back Office Kota' => User::role('Back Office Kota')->get(),
            'PIC' => User::role('PIC')->get()
        ];

        // Service types
        $serviceTypes = ['DTKS', 'KPM', 'Other'];

        return view('hotline.create', compact('recipientTypes', 'serviceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'service_type' => 'required|string',
            'recipient_type' => 'required|in:Back Office Kota,PIC',
            'recipient_id' => 'required|exists:users,id',
            'attachments.*' => 'file|max:10240', // 10MB max
        ]);

        // Create conversation
        $conversation = Conversation::create([
            'title' => $request->subject,
            'subject' => $request->subject,
            'type' => 'hotline',
            'status' => 'open',
            'priority' => $request->priority,
            'service_type' => $request->service_type,
            'recipient_type' => $request->recipient_type,
            'recipient_id' => $request->recipient_id,
            'created_by' => Auth::id(),
            'case_number' => 'HL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
        ]);

        // Add participants (creator and recipient)
        $conversation->participants()->attach(Auth::id(), ['role' => 'sender']);
        $conversation->participants()->attach($request->recipient_id, ['role' => 'recipient']);

        // Create initial message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => $request->message,
            'type' => 'text',
            'status' => 'sent',
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_attachments', 'public');

                MessageAttachment::create([
                    'message_id' => $message->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Update conversation's last message
        $conversation->update(['last_message_id' => $message->id]);

        return redirect()->route('hotline.show', $conversation->id)
            ->with('success', 'Hotline case created successfully');
    }

    public function show(Conversation $hotline)
    {
        // Verify this is a hotline conversation
        if ($hotline->type !== 'hotline') {
            abort(404);
        }

        // Check if user is participant
        if (!$hotline->participants->contains(Auth::id())) {
            abort(403);
        }

        // Get messages with senders and attachments
        $messages = $hotline->messages()
            ->with(['sender', 'attachments', 'replies'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('hotline.show', compact('hotline', 'messages'));
    }

    public function updateStatus(Request $request, Conversation $hotline)
    {
        $request->validate([
            'status' => 'required|in:processing,resolved,archived',
        ]);

        $hotline->update(['status' => $request->status]);

        // Create system message about status change
        Message::create([
            'conversation_id' => $hotline->id,
            'sender_id' => Auth::id(),
            'content' => "Status changed to: " . ucfirst($request->status),
            'type' => 'system',
            'status' => 'delivered',
        ]);

        return back()->with('success', 'Status updated successfully');
    }

    public function sendMessage(Request $request, Conversation $hotline)
    {
        $request->validate([
            'content' => 'required_without:attachments|string|nullable',
            'attachments.*' => 'file|max:10240', // 10MB max
        ]);

        $message = Message::create([
            'conversation_id' => $hotline->id,
            'sender_id' => Auth::id(),
            'content' => $request->content,
            'type' => $request->hasFile('attachments') ? 'file' : 'text',
            'status' => 'sent',
        ]);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('message_attachments', 'public');

                MessageAttachment::create([
                    'message_id' => $message->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Update conversation's last message
        $hotline->update(['last_message_id' => $message->id]);

        // Mark as read by sender
        MessageReadStatus::create([
            'message_id' => $message->id,
            'user_id' => Auth::id(),
            'read_at' => now(),
        ]);

        return back()->with('success', 'Message sent');
    }
    public function getRecipients(Request $request)
    {
        $type = $request->query('type');
        
        if (!$type) {
            return response()->json([]);
        }
    
        $users = User::role($type)
            ->select('id', 'name', 'email')
            ->get();
    
        return response()->json($users);
    }

    public function createGroup()
    {
        // Only admin can create groups
        if (!Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $users = User::where('id', '!=', Auth::id())->get();
        return view('hotline.create-group', compact('users'));
    }

    public function storeGroup(Request $request)
    {
        // Only admin can create groups
        if (!Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $request->validate([
            'group_name' => 'required|string|max:255',
            'members' => 'required|array',
            'members.*' => 'exists:users,id',
        ]);

        // Create group conversation
        $conversation = Conversation::create([
            'title' => $request->group_name,
            'type' => 'group',
            'status' => 'active',
            'created_by' => Auth::id(),
        ]);

        // Add admin as participant
        $conversation->participants()->attach(Auth::id(), ['role' => 'admin']);

        // Add members
        foreach ($request->members as $memberId) {
            $conversation->participants()->attach($memberId, ['role' => 'member']);
        }

        return redirect()->route('hotline.show', $conversation->id)
            ->with('success', 'Group created successfully');
    }
}
