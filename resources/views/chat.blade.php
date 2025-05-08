@extends('layouts.master-with-header')

@section('title')
    الدردشة
@endsection

@section('css')
    <style>
        /* Chat container styles */
        .chat-container {
            /* height: calc(100vh - 120px); */
            background-color: var(--primary-bg);
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            height: 500px
        }

        /* Sidebar styles */
        .chat-sidebar {
            background-color: #fff;
            border-left: 1px solid #e0e0e0;
            height: 100%;
            overflow-y: auto;
            padding-left: 0 !important;
        }

        .chat-sidebar-header {
            padding: 15px;
            background: var(--main-color);
            color: white;
            font-weight: bold;
            border-bottom: 1px solid #e0e0e0;
        }

        .chat-contacts {
            overflow-y: auto;
            height: calc(100% - 60px);
        }

        .chat-contact {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s;
        }

        .chat-contact:hover {
            background-color: #f5f5f5;
        }

        .chat-contact.active {
            background-color: #e8f0fe;
            border-right: 3px solid var(--main-color-hover);
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .contact-info {
            width: calc(100% - 60px);
        }

        .contact-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .contact-last-message {
            color: #666;
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .unread-badge {
            background-color: #3a2a6c;
            color: white;
            border-radius: 50%;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        /* Chat main area styles */
        .chat-main {
            display: flex;
            flex-direction: column;
            height: 100%;
            background-color: #f8f9fa;
        }

        .chat-header {
            padding: 15px;
            padding-left: 0 !important;
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }

        .chat-header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
            object-fit: cover;
        }

        .chat-header-info h5 {
            margin-bottom: 0;
            font-weight: bold;
        }

        .chat-header-info p {
            color: #666;
            margin-bottom: 0;
            font-size: 0.85rem;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fa;
            min-height: 368px;
            max-height: 336px;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            max-width: 50%;
        }

        .message-sent {
            align-self: flex-end;
        }

        .message-received {
            align-self: flex-start;
            margin-right: auto;
        }

        .message-content {
            padding: 10px 15px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }

        .message-sent .message-content {
            background-color: #e8f0fe;
            border-bottom-right-radius: 5px;
        }

        .message-received .message-content {
            background: var(--primary-bg);
            color: black;
            border-bottom-left-radius: 5px;
        }

        .message-time {
            font-size: 0.7rem;
            color: #999;
            margin-top: 5px;
            align-self: flex-end;
        }

        .message-sent .message-time {
            align-self: flex-end;
        }

        .message-received .message-time {
            align-self: flex-start;
        }

        /* .chat-content {
                                                        max-height: 440px;
                                                    } */

        #chatArea {
            gap: 14px;
        }

        .chat-input-form {
            display: flex;
            align-items: center;
        }

        .chat-input-field {
            flex: 1;
            border: 1px solid #e0e0e0;
            border-radius: 24px;
            padding: 10px 15px;
            outline: none;
            transition: border-color 0.2s;
        }

        .chat-input-field:focus {
            border-color: #3a2a6c;
        }

        .chat-send-btn {
            background: var(--main-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .chat-send-btn:hover {
            background-color: #2a1a5c;
        }

        .no-chat-selected {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #999;
        }

        .no-chat-selected i {
            font-size: 5rem;
            margin-bottom: 20px;
            color: #ddd;
        }

        .no-chat-selected h4 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Mobile responsiveness */
        @media (max-width: 767.98px) {
            .chat-sidebar {
                position: fixed;
                top: 0;
                right: 0;
                width: 80%;
                height: 100vh;
                z-index: 1000;
                transform: translateX(100%);
                transition: transform 0.3s ease;
            }

            .chat-sidebar.show {
                transform: translateX(0);
            }

            .chat-sidebar-toggle {
                display: block !important;
            }

            .chat-container {
                height: calc(100vh - 80px);
            }
        }

        .chat-sidebar-toggle {
            display: none;
            background-color: #3a2a6c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1001;
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="row">
            <div class="col-12">
                <div class="chat-container">
                    <div class="row h-100">
                        <!-- Sidebar Toggle Button (Mobile) -->
                        <button class="chat-sidebar-toggle" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>

                        <!-- Chat Sidebar -->
                        <div class="col-md-4 col-lg-3 chat-sidebar" id="chatSidebar">
                            <div class="chat-sidebar-header text-center">

                                @if (Auth::user()->role != 'consultant')
                                    <span>المستشارين</span>
                                @else
                                    <span>البائعين</span>
                                @endif
                            </div>
                            <div class="chat-contacts">
                                @forelse($users as $user)
                                    <div class="chat-contact d-flex align-items-center" data-user-id="{{ $user->id }}"
                                        data-specialization="{{ $user->specialization }}"
                                        data-user-name="{{ $user->name }}">
                                        <img src="{{ $user->image ? asset($user->image) : asset('images/default.jpeg') }}"
                                            alt="{{ $user->name }}" class="contact-avatar">
                                        <div class="contact-info ms-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="contact-name">{{ $user->name }}</div>
                                                @if ($user->received_messages_count > 0)
                                                    <span
                                                        class="badge bg-danger unread-badge">{{ $user->received_messages_count }}</span>
                                                @endif
                                            </div>
                                            <div class="contact-last-message">
                                                {{ $user->last_message->message ?? 'لا توجد رسائل' }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted">
                                        لا توجد محادثات حالية
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Chat Main Area -->
                        <div class="col-md-8 col-lg-9 chat-main">
                            <div id="noChatSelected" class="no-chat-selected">
                                <i class="fas fa-comments"></i>
                                <h4>اختر محادثة للبدء</h4>
                                <p>يرجى الانتقال إلى المحادثات لبدء المحادثة.</p>
                            </div>

                            <div id="chatArea" class="flex-column" style="display: none; height: 100%;">
                                <!-- Chat Header -->
                                <div class="chat-content d-flex flex-column">
                                    <div class="chat-header">
                                        <img id="chatHeaderAvatar" src="" alt="" class="chat-header-avatar">
                                        <div class="chat-header-info">
                                            <h5 id="chatHeaderName"></h5>
                                            {{-- <h5 id="chatHeaderSpecialization"></h5> --}}
                                        </div>
                                    </div>
                                    <!-- Student Name Above Messages -->
                                    {{-- <div id="currentStudentName" class="text-center my-3"
                                        style="font-weight: bold; font-size: 1.2rem;"></div> --}}

                                    <!-- Chat Messages -->
                                    <div class="chat-messages" id="chatMessages">
                                        <!-- Messages will be loaded here -->
                                    </div>
                                </div>
                                <!-- Chat Input -->
                                <div class="chat-input">
                                    <form id="chatForm" class="chat-input-form">
                                        <input type="text" id="messageInput" class="chat-input-field"
                                            placeholder="اكتب رسالتك ..." autocomplete="off">
                                        <button type="submit" class="chat-send-btn">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variables
            let currentUserId = null;
            const authUserId = {{ Auth::id() }};
            let pusherChannel = null;

            // Initialize Pusher
            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    }
                }
            });

            // DOM elements
            const chatContacts = document.querySelectorAll('.chat-contact');
            const noChatSelected = document.getElementById('noChatSelected');
            const chatArea = document.getElementById('chatArea');
            const chatMessages = document.getElementById('chatMessages');
            const chatForm = document.getElementById('chatForm');
            const messageInput = document.getElementById('messageInput');
            const chatHeaderName = document.getElementById('chatHeaderName');
            // const chatHeaderSpecialization = document.getElementById('chatHeaderSpecialization');
            const chatHeaderAvatar = document.getElementById('chatHeaderAvatar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const chatSidebar = document.getElementById('chatSidebar');

            // Mobile sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    chatSidebar.classList.toggle('show');
                });
            }

            // Handle contact selection
            chatContacts.forEach(contact => {
                contact.addEventListener('click', function() {
                    // Update active state
                    chatContacts.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Get user data
                    const userId = this.dataset.userId;
                    const userName = this.dataset.userName;
                    const specialization = this.dataset.specialization;
                    const userAvatar = this.querySelector('.contact-avatar').src;

                    // Update current user
                    currentUserId = userId;

                    // Update chat header
                    chatHeaderName.textContent = userName;
                    // chatHeaderSpecialization.textContent = specialization;
                    chatHeaderAvatar.src = userAvatar;

                    // Show chat area
                    noChatSelected.style.display = 'none';
                    chatArea.style.display = 'flex';

                    // Load messages
                    loadMessages(userId);

                    // Subscribe to Pusher channel
                    subscribeToChannel(authUserId, userId);

                    // Mark messages as read
                    markMessagesAsRead(userId);

                    // Hide sidebar on mobile
                    if (window.innerWidth < 768) {
                        chatSidebar.classList.remove('show');
                    }

                    // Remove unread badge
                    const unreadBadge = this.querySelector('.unread-badge');
                    if (unreadBadge) {
                        unreadBadge.remove();
                    }
                });
            });

            // Load messages for a user
            function loadMessages(userId) {
                chatMessages.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">جاري التحميل...</span>
                    </div>
                    <p class="mt-2">جاري تحميل الرسائل...</p>
                </div>`;

                fetch(`/chat/messages?user_id=${userId}`, )

                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        chatMessages.innerHTML = '';

                        if (data.messages && data.messages.length > 0) {
                            data.messages.forEach(message => {
                                appendMessage(message, authUserId);
                            });
                            scrollToBottom();
                            const notFound = document.querySelector('.not-found');
                            if (notFound) {
                                notFound.remove();
                            }
                        } else {
                            chatMessages.innerHTML = `
                            <div class="not-found text-center py-5 text-muted">
                                <i class="fas fa-comment-slash fa-2x mb-3"></i>
                                <p>لا توجد رسائل بعد</p>
                            </div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading messages:', error);
                        chatMessages.innerHTML = `
                        <div class="text-center py-5 text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <p>حدث خطأ أثناء تحميل الرسائل</p>
                        </div>`;
                    });
            }

            // Append a message to the chat
            function appendMessage(message, authUserId) {
                const isReceived = message.sender_id != authUserId;
                const messageElement = document.createElement('div');
                messageElement.className = `message message-${isReceived ? 'received' : 'sent'}`;

                const date = new Date(message.created_at);
                const timeString = date.toLocaleTimeString('ar-SA', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                messageElement.innerHTML = `
                <div class="message-content">${message.message}</div>
                <div class="message-time">${timeString}</div>
            `;

                chatMessages.appendChild(messageElement);
            }

            // Subscribe to Pusher channel
            // استبدال كود الاشتراك في Pusher بهذا الكود
            function subscribeToChannel(user1Id, user2Id) {
                // إلغاء أي اشتراكات سابقة
                if (pusherChannel) {
                    pusher.unsubscribe(pusherChannel);
                }

                // ترتيب IDs لضمان اسم قناة متسق
                const ids = [parseInt(user1Id), parseInt(user2Id)].sort();
                const channelName = `private-chat.${ids[0]}.${ids[1]}`;

                // الاشتراك في القناة الجديدة
                pusherChannel = channelName;
                const channel = pusher.subscribe(channelName);

                // الاستماع للرسائل الجديدة
                channel.bind('NewChatMessage', function(data) {
                    console.log('New message received:', data); // لأغراض التصحيح

                    // التحقق من أن الرسالة موجهة للمحادثة الحالية
                    if (data.message &&
                        (data.message.sender_id == currentUserId ||
                            data.message.receiver_id == currentUserId)) {

                        appendMessage(data.message, authUserId);
                        scrollToBottom();

                        // تحديث حالة القراءة إذا كانت الرسالة واردة
                        if (data.message.receiver_id == authUserId) {
                            markMessageAsRead(data.message.id);
                        }

                        // تحديث قائمة المحادثات الجانبية
                        updateSidebarConversation(data.message);
                    }
                });
            }

            // دالة مساعدة لتحديث المحادثة في القائمة الجانبية
            function updateSidebarConversation(message) {
                const contact = document.querySelector(`.chat-contact[data-user-id="${message.sender_id}"]`);
                if (contact) {
                    const lastMessageEl = contact.querySelector('.contact-last-message');
                    if (lastMessageEl) {
                        lastMessageEl.textContent = message.message;
                    }

                    // نقل المحادثة إلى الأعلى
                    const contactsContainer = document.querySelector('.chat-contacts');
                    if (contactsContainer) {
                        contactsContainer.prepend(contact.parentNode);
                    }
                }
            }
            // Mark messages as read
            function markMessagesAsRead(userId) {
                fetch('/chat/mark-as-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        sender_id: userId
                    })
                }).catch(error => console.error('Error marking messages as read:', error));
            }

            // Mark single message as read
            function markMessageAsRead(messageId) {
                fetch('/chat/mark-as-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message_id: messageId
                    })
                }).catch(error => console.error('Error marking message as read:', error));
            }

            // Handle message submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message || !currentUserId) return;

                // Disable input during submission
                messageInput.disabled = true;
                chatForm.querySelector('button').disabled = true;

                fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            receiver_id: currentUserId,
                            message: message
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.message) {
                            messageInput.value = '';
                            appendMessage(data.message, authUserId);
                            scrollToBottom();
                        } else {
                            throw new Error(data.error || 'Unknown error');
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('حدث خطأ أثناء إرسال الرسالة');
                    })
                    .finally(() => {
                        messageInput.disabled = false;
                        chatForm.querySelector('button').disabled = false;
                        messageInput.focus();
                    });
            });

            // Scroll to bottom of chat
            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Auto focus input when chat area is shown
            chatArea.addEventListener('transitionend', function() {
                if (chatArea.style.display === 'flex') {
                    messageInput.focus();
                }
            });
        });
    </script>
@endsection
