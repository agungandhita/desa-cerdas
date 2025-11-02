@php
    $isOwn = $message->user_id == auth()->id();
    $messageClass = $message->message_type === 'system' ? 'message-system' : ($isOwn ? 'message-own' : 'message-other');
@endphp

<div class="message-item {{ $messageClass }} group" data-message-id="{{ $message->id }}">
    @if($message->message_type !== 'system' && !$isOwn)
        <div class="message-header">
            <div class="flex items-center space-x-2">
                <strong class="text-sm font-semibold">{{ $message->user->name }}</strong>
                @if(method_exists($message->user, 'hasRole') && $message->user->hasRole('admin'))
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Admin
                    </span>
                @endif
            </div>
        </div>
    @endif

    @if($message->reply_to)
        <div class="message-reply bg-gray-100 border-l-4 border-gray-400 pl-3 py-2 mb-2 rounded">
            <div class="flex items-start space-x-2">
                <i class="fas fa-reply text-gray-500 mt-0.5"></i>
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Membalas {{ $message->replyTo->user->name }}:</span>
                    <p class="mt-1">{{ Str::limit($message->replyTo->message, 50) }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="message-content">
        @if($message->message_type === 'image' && $message->file_path)
            <div class="message-image mb-3">
                <img src="{{ $message->file_url }}" alt="{{ $message->file_name }}"
                     class="max-w-xs rounded-lg shadow-sm cursor-pointer hover:shadow-md transition-shadow duration-200"
                     onclick="showImageModal('{{ $message->file_url }}', '{{ $message->file_name }}')"
                     onerror="console.error('Failed to load image:', this.src); this.style.display='none';">
                <div class="text-xs text-gray-500 mt-1">{{ $message->file_name }}</div>
            </div>
        @endif

        @if($message->message_type === 'file' && $message->file_path)
            <div class="file-attachment bg-white bg-opacity-10 p-3 rounded-lg mb-2">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-file text-current"></i>
                    <a href="{{ $message->file_url }}" target="_blank"
                       class="{{ $isOwn ? 'text-white hover:text-blue-100' : 'text-blue-600 hover:text-blue-800' }} font-medium">
                        {{ $message->file_name }}
                    </a>
                </div>
                <div class="text-xs opacity-75 mt-1">
                    {{ number_format($message->file_size / 1024, 1) }} KB
                </div>
            </div>
        @endif

        @if($message->message)
            <div class="message-text">
                {!! nl2br(e($message->message)) !!}
            </div>
        @endif
    </div>

    <div class="message-time flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <span class="text-xs opacity-70">{{ $message->time_ago }}</span>
            @if($message->is_edited)
                <span class="text-xs opacity-60">(diedit)</span>
            @endif
        </div>

        @if($isOwn && $message->message_type !== 'system')
            <div class="message-actions flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                <button type="button"
                        class="p-1 text-current hover:bg-white hover:bg-opacity-20 rounded transition-colors duration-200"
                        onclick="editMessage({{ $message->id }})" title="Edit">
                    <i class="fas fa-edit text-xs"></i>
                </button>
                <button type="button"
                        class="p-1 text-red-400 hover:text-red-300 hover:bg-white hover:bg-opacity-20 rounded transition-colors duration-200"
                        onclick="deleteMessage({{ $message->id }})" title="Hapus">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            </div>
        @endif
    </div>
</div>
