<!--views/hotline/show.blade.php-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>
                    Hotline Case: {{ $hotline->case_number }}
                    <span class="badge bg-secondary ms-2">{{ ucfirst($hotline->hotline_type) }}</span>
                </h2>
                
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Status: {{ ucfirst($hotline->status) }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
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
            <p class="text-muted">{{ $hotline->title }}</p>
            <p>{{ $hotline->description }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Conversation</h5>
                </div>
                <div class="card-body chat-container" style="height: 500px; overflow-y: auto;">
                    @foreach($messages as $message)
                        <div class="mb-3 d-flex @if($message->sender_id === Auth::id()) justify-content-end @endif">
                            <div class="message-bubble @if($message->sender_id === Auth::id()) bg-primary text-white @else bg-light @endif">
                                @if($message->type === 'system')
                                    <div class="system-message text-center text-muted">
                                        <small>{{ $message->content }}</small>
                                    </div>
                                @else
                                    <div class="message-header">
                                        <strong>{{ $message->sender->name }}</strong>
                                        <small class="text-muted ms-2">
                                            {{ $message->created_at->format('M j, H:i') }}
                                        </small>
                                    </div>
                                    <div class="message-content">
                                        {{ $message->content }}
                                    </div>
                                    @if($message->attachments->count() > 0)
                                        <div class="attachments mt-2">
                                            @foreach($message->attachments as $attachment)
                                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="d-block">
                                                    <i class="fas fa-paperclip"></i> {{ $attachment->original_name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form action="{{ route('hotline.send-message', $hotline->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <textarea name="content" class="form-control" placeholder="Type your message..." rows="1"></textarea>
                            <div class="input-group-append">
                                <label class="btn btn-outline-secondary">
                                    <i class="fas fa-paperclip"></i>
                                    <input type="file" name="attachments[]" multiple style="display: none;">
                                </label>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .message-bubble {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 18px;
        margin-bottom: 5px;
    }
    .system-message {
        padding: 5px;
        font-style: italic;
    }
    .message-header {
        margin-bottom: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-scroll to bottom of chat
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.chat-container');
        container.scrollTop = container.scrollHeight;
    });
</script>
@endpush