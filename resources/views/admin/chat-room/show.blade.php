@extends('admin.layouts.main')

@section('title', $chatRoom->name)

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div class="mb-4 sm:mb-0">
            <div class="flex items-center space-x-2 mb-2">
                <i class="fas fa-comments text-blue-600"></i>
                <h1 class="text-2xl font-bold text-gray-900">{{ $chatRoom->name }}</h1>
                {!! $chatRoom->status_badge !!}
                @if($chatRoom->is_private)
                    <i class="fas fa-lock text-yellow-500" title="Room Private"></i>
                @endif
            </div>
            <p class="text-gray-600">{{ $chatRoom->description }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.chat-room.edit', $chatRoom) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('admin.chat-room.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Chat Area -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200" style="height: 70vh;">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-comments text-blue-600 mr-2"></i> Diskusi
                    </h3>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-users mr-1"></i> {{ $chatRoom->participant_count }} peserta
                        </span>
                        @if($chatRoom->topic)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-tag mr-1"></i> {{ ucfirst($chatRoom->topic) }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Messages Container -->
                <div class="p-0 overflow-y-auto" style="height: calc(100% - 140px);" id="messages-container">
                    <div id="messages-list" class="p-3">
                        <!-- Messages will be loaded here -->
                    </div>
                </div>

                <!-- Message Input -->
                @if($chatRoom->status === 'active')
                <div class="px-6 py-4 border-t border-gray-200">
                    <form id="message-form" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-end space-x-2">
                            <button type="button" class="flex-shrink-0 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200" id="file-upload-btn">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="file" id="file-input" class="hidden" accept="image/*,application/pdf,.doc,.docx">
                            
                            <div class="flex-1">
                                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" 
                                          id="message-input" name="message" 
                                          placeholder="Ketik pesan Anda..." rows="1"></textarea>
                            </div>
                            
                            <button type="submit" class="flex-shrink-0 p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200" id="send-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div id="file-preview" class="mt-2 hidden">
                            <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-file text-blue-600 mr-2"></i>
                                    <span id="file-name" class="text-sm text-blue-800"></span>
                                </div>
                                <button type="button" class="text-red-600 hover:text-red-800 transition-colors duration-200" id="remove-file">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                        <i class="fas fa-lock text-yellow-600 mr-2"></i>
                        <span class="text-yellow-800">Room ini telah ditutup. Tidak dapat mengirim pesan baru.</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Room Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i> Informasi Room
                    </h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dibuat oleh:</dt>
                        <dd class="text-sm text-gray-900">{{ $chatRoom->creator->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dibuat pada:</dt>
                        <dd class="text-sm text-gray-900">{{ $chatRoom->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Aktivitas terakhir:</dt>
                        <dd class="text-sm text-gray-900">{{ $chatRoom->last_activity_human }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total pesan:</dt>
                        <dd class="text-sm text-gray-900">{{ $chatRoom->message_count }}</dd>
                    </div>
                    @if($chatRoom->max_participants)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Batas peserta:</dt>
                        <dd class="text-sm text-gray-900">{{ $chatRoom->max_participants }} orang</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Participants -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-users text-green-600 mr-2"></i> Peserta Aktif
                    </h3>
                </div>
                <div class="px-6 py-4 max-h-80 overflow-y-auto">
                    <div id="participants-list">
                        <!-- Participants will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cogs text-yellow-600 mr-2"></i> Aksi Cepat
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-2">
                        @if($chatRoom->status === 'active')
                            <button onclick="updateRoomStatus('closed')" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-pause mr-2"></i> Tutup Room
                            </button>
                        @elseif($chatRoom->status === 'closed')
                            <button onclick="updateRoomStatus('active')" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-play mr-2"></i> Buka Room
                            </button>
                        @endif
                        
                        @if($chatRoom->status !== 'archived')
                            <button onclick="updateRoomStatus('archived')" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-archive mr-2"></i> Arsipkan
                            </button>
                        @endif
                        
                        <button onclick="exportMessages()" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i> Export Chat
                        </button>
                        
                        <button onclick="confirmDelete()" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i> Hapus Room
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                <button type="button" onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <p class="text-gray-700 mb-3">Apakah Anda yakin ingin menghapus room chat ini?</p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                    <p class="text-red-800 text-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Peringatan:</strong> Semua pesan dalam room ini akan ikut terhapus dan tidak dapat dikembalikan.
                    </p>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-lg transition-colors duration-200">
                    Batal
                </button>
                <form action="{{ route('admin.chat-room.destroy', $chatRoom) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <div id="modalImageName" class="absolute bottom-4 left-4 text-white bg-black bg-opacity-50 px-3 py-1 rounded"></div>
    </div>
</div>
@endsection

@push('styles')
<style>
.message-item {
    margin-bottom: 1rem;
    padding: 0.75rem;
    border-radius: 0.75rem;
    max-width: 80%;
}

.message-own {
    background-color: #3b82f6;
    color: white;
    margin-left: auto;
    text-align: right;
}

.message-other {
    background-color: #f9fafb;
    border: 1px solid #e5e7eb;
    color: #374151;
}

.message-system {
    background-color: #fef3c7;
    border: 1px solid #f59e0b;
    text-align: center;
    margin: 0.75rem auto;
    max-width: 60%;
    font-style: italic;
    color: #92400e;
}

.message-header {
    font-size: 0.75rem;
    opacity: 0.8;
    margin-bottom: 0.25rem;
}

.message-content {
    word-wrap: break-word;
    line-height: 1.5;
}

.message-time {
    font-size: 0.625rem;
    opacity: 0.7;
    margin-top: 0.25rem;
}

.file-attachment {
    background-color: rgba(255,255,255,0.1);
    padding: 0.5rem;
    border-radius: 0.375rem;
    margin-top: 0.25rem;
}

.participant-item {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.participant-item:last-child {
    border-bottom: none;
}

.online-indicator {
    width: 0.5rem;
    height: 0.5rem;
    background-color: #10b981;
    border-radius: 50%;
    margin-right: 0.5rem;
}

#messages-container {
    scroll-behavior: smooth;
}
</style>
@endpush

@push('scripts')
<script>
// Setup CSRF token for all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let chatRoomId = {{ $chatRoom->id }};
let currentUserId = {{ auth()->id() }};
let lastMessageId = 0;
let messagePolling;

$(document).ready(function() {
    // Load initial messages
    loadMessages();
    loadParticipants();
    
    // Start polling for new messages
    startMessagePolling();
    
    // Auto-resize message input
    $('#message-input').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Handle message form submission
    $('#message-form').on('submit', function(e) {
        e.preventDefault();
        sendMessage();
    });
    
    // Handle file upload button
    $('#file-upload-btn').on('click', function() {
        $('#file-input').click();
    });
    
    // Handle file selection
    $('#file-input').on('change', function() {
        if (this.files.length > 0) {
            showFilePreview(this.files[0]);
        }
    });
    
    // Handle remove file
    $('#remove-file').on('click', function() {
        removeFilePreview();
    });
    
    // Handle Enter key in message input
    $('#message-input').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#message-form').submit();
        }
    });
});

function loadMessages() {
    $.get(`/admin/chat-room/${chatRoomId}/messages`, function(data) {
        displayMessages(data.messages);
        if (data.messages.length > 0) {
            lastMessageId = data.messages[data.messages.length - 1].id;
        }
        scrollToBottom();
    });
}

function loadParticipants() {
    // This would typically load from an API endpoint
    // For now, we'll show a placeholder
    $('#participants-list').html(`
        <div class="participant-item">
            <div class="online-indicator"></div>
            <span>{{ auth()->user()->name }} (Anda)</span>
        </div>
    `);
}

function displayMessages(messages) {
    let html = '';
    messages.forEach(function(message) {
        html += formatMessage(message);
    });
    $('#messages-list').html(html);
}

function formatMessage(message) {
    let messageClass = 'message-other';
    let headerHtml = `<div class="message-header">${message.user.name}</div>`;
    
    if (message.user_id == currentUserId) {
        messageClass = 'message-own';
        headerHtml = '';
    }
    
    if (message.message_type === 'system') {
        messageClass = 'message-system';
        headerHtml = '';
    }
    
    let contentHtml = '';
    
    // Handle image messages
    if (message.message_type === 'image' && message.file_path) {
        console.log('Image URL:', message.file_url); // Debug log
        // Encode the URL to handle spaces and special characters
        const encodedUrl = encodeURI(message.file_url);
        contentHtml += `
            <div class="message-image mb-3">
                <img src="${encodedUrl}" alt="${message.file_name}" 
                     class="max-w-xs rounded-lg shadow-sm cursor-pointer hover:shadow-md transition-shadow duration-200"
                     onclick="showImageModal('${encodedUrl}', '${message.file_name}')"
                     onerror="console.error('Failed to load image:', this.src); this.style.display='none';">
            </div>
        `;
    }
    
    // Handle file messages
    if (message.message_type === 'file' && message.file_path) {
        contentHtml += `
            <div class="file-attachment bg-white bg-opacity-10 p-3 rounded-lg mb-2">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-file text-current"></i>
                    <a href="${message.file_url}" target="_blank" class="text-white font-medium">
                        ${message.file_name}
                    </a>
                </div>
            </div>
        `;
    }
    
    // Handle text message
    if (message.message) {
        contentHtml += `<div class="message-text">${message.message.replace(/\n/g, '<br>')}</div>`;
    }
    
    let timeHtml = `<div class="message-time">${message.time_ago}</div>`;
    
    return `
        <div class="message-item ${messageClass}" data-message-id="${message.id}">
            ${headerHtml}
            <div class="message-content">${contentHtml}</div>
            ${timeHtml}
        </div>
    `;
}

function sendMessage() {
    let message = $('#message-input').val().trim();
    let fileInput = $('#file-input')[0];
    
    if (!message && !fileInput.files.length) {
        return;
    }
    
    let formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('message', message);
    
    if (fileInput.files.length > 0) {
        formData.append('file', fileInput.files[0]);
    }
    
    $('#send-btn').prop('disabled', true);
    
    $.ajax({
        url: `/admin/chat-room/${chatRoomId}/messages`,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#message-input').val('');
            removeFilePreview();
            
            // Add the new message to the list instead of reloading all messages
            if (response.success && response.message) {
                $('#messages-list').append(formatMessage(response.message));
                lastMessageId = response.message.id;
                scrollToBottom();
            }
        },
        error: function(xhr) {
            console.error('Error sending message:', xhr.responseText);
            let errorMessage = 'Gagal mengirim pesan. Silakan coba lagi.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
            }
            
            alert(errorMessage);
        },
        complete: function() {
            $('#send-btn').prop('disabled', false);
            $('#message-input').focus();
        }
    });
}

function showFilePreview(file) {
    $('#file-name').text(file.name);
    $('#file-preview').removeClass('hidden').show();
}

function removeFilePreview() {
    $('#file-input').val('');
    $('#file-preview').addClass('hidden').hide();
}

function scrollToBottom() {
    let container = $('#messages-container');
    container.scrollTop(container[0].scrollHeight);
}

function startMessagePolling() {
    messagePolling = setInterval(function() {
        checkNewMessages();
    }, 3000); // Check every 3 seconds
}

function checkNewMessages() {
    $.get(`/admin/chat-room/${chatRoomId}/messages?last_message_id=${lastMessageId}`, function(data) {
        if (data.messages.length > 0) {
            data.messages.forEach(function(message) {
                $('#messages-list').append(formatMessage(message));
                lastMessageId = message.id;
            });
            scrollToBottom();
        }
    }).fail(function(xhr) {
        console.error('Error checking new messages:', xhr.responseText);
    });
}

function updateRoomStatus(status) {
    if (confirm(`Apakah Anda yakin ingin mengubah status room menjadi ${status}?`)) {
        $.ajax({
            url: `/admin/chat-room/${chatRoomId}/status`,
            method: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: status
            },
            success: function() {
                location.reload();
            },
            error: function() {
                alert('Gagal mengubah status room.');
            }
        });
    }
}

function exportMessages() {
    window.open(`/admin/chat-room/${chatRoomId}/export`, '_blank');
}

function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function editMessage(messageId) {
    // Get the message element
    const messageElement = $(`.message-item[data-message-id="${messageId}"]`);
    const messageText = messageElement.find('.message-text').text().trim();
    
    // Create edit form
    const editForm = `
        <div class="edit-message-form bg-gray-50 p-3 rounded-lg">
            <textarea class="w-full p-2 border border-gray-300 rounded-lg resize-none" 
                      rows="3" id="edit-message-${messageId}">${messageText}</textarea>
            <div class="flex justify-end space-x-2 mt-2">
                <button type="button" class="px-3 py-1 text-sm bg-gray-500 text-white rounded hover:bg-gray-600" 
                        onclick="cancelEdit(${messageId})">Batal</button>
                <button type="button" class="px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600" 
                        onclick="saveEdit(${messageId})">Simpan</button>
            </div>
        </div>
    `;
    
    // Replace message content with edit form
    messageElement.find('.message-content').html(editForm);
}

function cancelEdit(messageId) {
    // Reload the page to restore original message
    location.reload();
}

function saveEdit(messageId) {
    const newMessage = $(`#edit-message-${messageId}`).val().trim();
    
    if (!newMessage) {
        alert('Pesan tidak boleh kosong');
        return;
    }
    
    $.ajax({
        url: `/admin/chat-room/messages/${messageId}`,
        method: 'PUT',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            message: newMessage
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr) {
            alert('Gagal mengupdate pesan: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
        }
    });
}

function deleteMessage(messageId) {
    if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
        $.ajax({
            url: `/admin/chat-room/messages/${messageId}`,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $(`.message-item[data-message-id="${messageId}"]`).fadeOut(300, function() {
                    $(this).remove();
                });
            },
            error: function(xhr) {
                alert('Gagal menghapus pesan: ' + (xhr.responseJSON?.message || 'Terjadi kesalahan'));
            }
        });
    }
}

// Image modal functions
function showImageModal(imageUrl, imageName) {
    $('#modalImage').attr('src', imageUrl).attr('alt', imageName);
    $('#modalImageName').text(imageName);
    $('#imageModal').removeClass('hidden').addClass('flex');
    
    // Close modal when clicking outside the image
    $('#imageModal').on('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
    
    // Close modal with Escape key
    $(document).on('keydown.imageModal', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
}

function closeImageModal() {
    $('#imageModal').addClass('hidden').removeClass('flex');
    $('#modalImage').attr('src', '').attr('alt', '');
    $('#modalImageName').text('');
    
    // Remove event listeners
    $('#imageModal').off('click');
    $(document).off('keydown.imageModal');
}

// Cleanup on page unload
$(window).on('beforeunload', function() {
    if (messagePolling) {
        clearInterval(messagePolling);
    }
});
</script>
@endpush