<!-- views/hotline/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for conversation list (unchanged) -->
        <div class="col-md-4 col-lg-3 p-0 border-end">
            <div class="d-flex flex-column h-100">
                <div class="p-3 border-bottom">
                    <h5 class="mb-0">Hotline Cases</h5>
                </div>
                <div class="flex-grow-1 overflow-auto">
                    @foreach($conversations as $conversation)
                    <a href="{{ route('hotline.show', $conversation->id) }}" 
                       class="d-flex align-items-center p-3 border-bottom text-decoration-none text-dark 
                              {{ $hotline->id == $conversation->id ? 'bg-light' : '' }}">
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">{{ $conversation->case_number }}</h6>
                                <small class="text-muted">{{ $conversation->lastMessage->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 text-truncate text-muted" style="max-width: 200px;">
                                @if($conversation->lastMessage->sender_id == Auth::id())
                                    You: 
                                @endif
                                {{ Str::limit($conversation->lastMessage->content, 30) }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main chat area -->
        <div class="col-md-8 col-lg-9 p-0 d-flex flex-column" style="height: 100vh;">
            <!-- Chat header (unchanged) -->
            <div class="d-flex align-items-center p-3 border-bottom bg-light">
                <div class="flex-grow-1">
                    <h5 class="mb-0">
                        {{ $hotline->case_number }}
                        <span class="badge bg-{{ $hotline->status == 'resolved' ? 'success' : ($hotline->status == 'processing' ? 'warning' : 'secondary') }} ms-2">
                            {{ ucfirst($hotline->status) }}
                        </span>
                    </h5>
                    <small class="text-muted">
                        @foreach($hotline->participants as $participant)
                            @if($participant->id != Auth::id())
                                {{ $participant->name }}
                            @endif
                        @endforeach
                    </small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach(['processing', 'resolved', 'archived'] as $status)
                            @if($hotline->status !== $status)
                            <li>
                                <form action="{{ route('hotline.update-status', $hotline->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button type="submit" class="dropdown-item">
                                        Mark as {{ ucfirst($status) }}
                                    </button>
                                </form>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Chat messages -->
            <div class="flex-grow-1 p-3 overflow-auto bg-light" id="chat-messages"  style="display: flex; flex-direction: column !important; background-color: #e5ddd5; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABsSURBVDhP7cxBCsAgDETR6P3P3KVLFwVB8D8IMwEXD5J5qYg8tNY+ZmbXzOxa7/3WWt+llF1K2aWUXUrZpZRdStmllF1K2aWUXUrZpZRdStmllF1K2aWUXUrZpZRdStmllF1K2aWUXUrZpZRdStmllF1K2f0BzXkZQZ6w6j0AAAAASUVORK5CYII=');">
                @foreach($messages as $message)
                    @if($message->type === 'system')
                        <div class="text-center my-2">
                            <span class="badge bg-secondary">{{ $message->content }}</span>
                        </div>
                    @else
                        <div class="d-flex mb-3 @if($message->sender_id === Auth::id()) justify-content-end @else justify-content-start @endif">
                            <div class="message-container" data-message-id="{{ $message->id }}" style="max-width: 80%;">
                                @if($message->parent_id)
                                    <div class="reply-container p-2 mb-1 rounded" style="background-color: rgba(0,0,0,0.05); border-left: 3px solid #25D366;">
                                        <small class="d-block text-muted">Replying to {{ $message->parent->sender->name }}</small>
                                        <p class="mb-0">{{ Str::limit($message->parent->content, 50) }}</p>
                                    </div>
                                @endif
                                <div class="message-bubble p-3 rounded @if($message->sender_id === Auth::id()) bg-primary text-white @else bg-white text-dark @endif">
                                    @if($message->sender_id !== Auth::id())
                                        <div class="message-sender mb-1">
                                            <strong>{{ $message->sender->name }}</strong>
                                        </div>
                                    @endif
                                    <div class="message-content">
                                        {!! $message->parsed_content !!}
                                    </div>
                                    @if($message->attachments->count() > 0)
                                        <div class="attachments mt-2">
                                            @foreach($message->attachments as $attachment)
                                                <div class="attachment mb-2">
                                                    @if(Str::startsWith($attachment->file_type, 'image/'))
                                                        <img src="{{ Storage::url($attachment->file_path) }}" 
                                                            class="img-thumbnail" 
                                                            style="max-width: 200px; max-height: 200px;"
                                                            alt="{{ $attachment->original_name }}">
                                                    @else
                                                        <a href="{{ Storage::url($attachment->file_path) }}" 
                                                           target="_blank" 
                                                           class="d-block p-2 bg-{{ $message->sender_id === Auth::id() ? 'dark' : 'light' }} rounded">
                                                            <i class="fas fa-file me-2"></i> 
                                                            {{ $attachment->original_name }}
                                                            <small class="text-muted">({{ \App\Http\Controllers\Hotchat\HotlineController::formatFileSize($attachment->file_size) }})</small>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="message-time text-end mt-1" style="font-size: 0.75rem;">
                                        <span class="@if($message->sender_id === Auth::id()) text-white-50 @else text-muted @endif">
                                            {{ $message->created_at->format('H:i') }}
                                            @if($message->sender_id === Auth::id())
                                               <i class="fas fa-check @if($message->isReadByOthers()) text-info @endif"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Reply preview (unchanged) -->
            <div class="reply-preview p-2 border-top bg-light" id="reply-preview" style="display: none;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Replying to <span id="reply-to-name"></span></small>
                        <p class="mb-0 small" id="reply-to-content" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"></p>
                    </div>
                    <button class="btn btn-sm btn-outline-danger" id="cancel-reply">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Message input -->
            <div class="p-3 border-top bg-light">
                <form action="{{ route('hotline.send-message', $hotline->id) }}" method="POST" enctype="multipart/form-data" id="message-form">
                    @csrf
                    <input type="hidden" name="parent_id" id="parent_id" value="">
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-secondary" id="attach-btn">
                            <i class="fas fa-paperclip"></i> <!-- Ensure Font Awesome is loaded -->
                            <input type="file" name="attachments[]" multiple style="display: none;" id="file-input" accept="image/*,application/pdf">
                        </button>
                        <div class="form-floating flex-grow-1">
                            <textarea name="content" class="form-control" placeholder="Type your message..." 
                                      id="message-input" style="height: 50px; resize: none;"></textarea>
                            <label for="message-input">Type your message...</label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="send-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <div class="mt-2" id="file-preview"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .message-bubble {
        max-width: 100%;
        border-radius: 7.5px;
        position: relative;
        box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
    }
    
    .message-bubble.bg-primary:after {
        content: '';
        position: absolute;
        right: -8px;
        top: 0;
        width: 0;
        height: 0;
        border: 10px solid transparent;
        border-left-color: #007bff;
        border-right: 0;
        margin-top: 0;
        margin-right: -10px;
    }
    
    .message-bubble.bg-white:after {
        content: '';
        position: absolute;
        left: -8px;
        top: 0;
        width: 0;
        height: 0;
        border: 10px solid transparent;
        border-right-color: #fff;
        border-left: 0;
        margin-top: 0;
        margin-left: -10px;
    }
    
    .chat-container {
        scroll-behavior: smooth;
    }
    
    .mention {
        background-color: #d1e7ff;
        color: #0066cc;
        padding: 0 2px;
        border-radius: 3px;
    }
    
    #file-preview img {
        max-height: 50px;
        margin-right: 10px;
        border-radius: 5px;
    }
    #file-preview .badge {
        padding: 5px 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const attachBtn = document.getElementById('attach-btn');
        const fileInput = document.getElementById('file-input');
        const filePreview = document.getElementById('file-preview');
        const messageForm = document.getElementById('message-form');
        const replyPreview = document.getElementById('reply-preview');
        const cancelReply = document.getElementById('cancel-reply');
        const parentIdInput = document.getElementById('parent_id');
        const replyToName = document.getElementById('reply-to-name');
        const replyToContent = document.getElementById('reply-to-content');

        // Auto-scroll to bottom on load
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Handle file attachments
        attachBtn.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            filePreview.innerHTML = '';
            Array.from(fileInput.files).forEach(file => {
                const preview = document.createElement('div');
                preview.className = 'd-inline-block me-2 mb-2 position-relative';

                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.maxHeight = '50px';
                    img.className = 'img-thumbnail';
                    preview.appendChild(img);
                } else {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-secondary';
                    badge.innerHTML = `<i class="fas fa-file me-1"></i> ${file.name}`;
                    preview.appendChild(badge);
                }

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-sm btn-outline-danger position-absolute top-0 end-0';
                removeBtn.style.right = '-10px';
                removeBtn.style.top = '-5px';
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.onclick = function() {
                    const dataTransfer = new DataTransfer();
                    Array.from(fileInput.files).forEach(f => {
                        if (f !== file) dataTransfer.items.add(f);
                    });
                    fileInput.files = dataTransfer.files;
                    preview.remove();
                };

                preview.appendChild(removeBtn);
                filePreview.appendChild(preview);
            });
        });

        // Handle message reply (unchanged)
        document.querySelectorAll('.message-bubble').forEach(bubble => {
            bubble.addEventListener('click', function(e) {
                if (e.target.tagName === 'A' || e.target.tagName === 'IMG') return;

                const messageContainer = this.closest('.message-container');
                if (messageContainer) {
                    const messageId = messageContainer.dataset.messageId;
                    const senderName = messageContainer.querySelector('.message-sender')?.textContent.trim() || 'You';
                    const messageContent = messageContainer.querySelector('.message-content').textContent.trim();

                    parentIdInput.value = messageId;
                    replyToName.textContent = senderName;
                    replyToContent.textContent = messageContent;
                    replyPreview.style.display = 'block';

                    messageInput.focus();
                }
            });
        });

        // Cancel reply (unchanged)
        cancelReply.addEventListener('click', function() {
            parentIdInput.value = '';
            replyPreview.style.display = 'none';
        });

        // Auto-resize textarea (unchanged)
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Auto-scroll to bottom after submit
        messageForm.addEventListener('submit', function() {
            setTimeout(() => {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 100);
        });
    });
</script>
@endpush