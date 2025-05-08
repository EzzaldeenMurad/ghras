@extends('layouts.master-with-header')

@section('title')
    الدردشة
@endsection

@section('css')
    <style>
        /* Chat container styles */
        .chat-container {
            height: calc(100vh - 120px);
            background-color: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
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
            background: linear-gradient(90deg, #54B6B7 0%, #61528B 100%);
            color: white;
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

        .chat-content {
            max-height: 440px;
        }

        /* .chat-input {
                            padding: 15px;
                            background-color: #fff;
                            border-top: 1px solid #e0e0e0;
                        } */

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
    <div class="container">
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
                            <div class="chat-sidebar-header">
                                <i class="fas fa-comments me-2"></i>
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
                                                {{ $user->last_message ?? 'لا توجد رسائل' }}
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
                                            <h5 id="chatHeaderSpecialization"></h5>
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
                                            placeholder="اكتب رسالتك هنا..." autocomplete="off">
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
            let currentUserId = null;
            const authUserId = {{ Auth::id() }};

            // Pusher setup
            const pusherAppKey = '{{ config('broadcasting.connections.pusher.key') }}';
            const pusherAppCluster = '{{ config('broadcasting.connections.pusher.options.cluster') }}';

            const pusher = new Pusher(pusherAppKey, {
                cluster: pusherAppCluster,
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                // auth: {
                //     headers: {
                //         'X-CSRF-Token': '{{ csrf_token() }}',
                //         'Authorization': 'Bearer ' + '{{ auth()->user()->token ?? '' }}'
                //     }
                // }
            });

            // DOM elements
            const chatContacts = document.querySelectorAll('.chat-contact');
            const noChatSelected = document.getElementById('noChatSelected');
            const chatArea = document.getElementById('chatArea');
            const chatMessages = document.getElementById('chatMessages');
            const chatForm = document.getElementById('chatForm');
            const messageInput = document.getElementById('messageInput');
            const chatHeaderName = document.getElementById('chatHeaderName');
            const chatHeaderSpecialization = document.getElementById('chatHeaderSpecialization');
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
                    chatContacts.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    const userId = this.dataset.userId;
                    const userName = this.dataset.userName;
                    const specialization = this.dataset.chatHeaderSpecialization;
                    const userAvatar = this.querySelector('.contact-avatar').src;

                    currentUserId = userId;

                    // Update chat header
                    chatHeaderName.textContent = userName;
                    chatHeaderSpecialization.textContent = specialization;
                    chatHeaderAvatar.src = userAvatar;

                    // Show chat area
                    noChatSelected.style.display = 'none';
                    chatArea.style.display = 'flex';

                    // Load messages and subscribe to channel
                    loadMessages(userId);
                    subscribeToChannel(authUserId, userId);

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

            function loadMessages(userId) {
                chatMessages.innerHTML =
                    '<div class="text-center my-3"><div class="spinner-border text-primary" role="status"></div></div>';

                fetch(`/chat/messages?user_id=${userId}`)
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
                        } else {
                            chatMessages.innerHTML =
                                '<div class="text-center my-3 text-muted">لا توجد رسائل بعد</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading messages:', error);
                        chatMessages.innerHTML =
                            '<div class="text-center my-3 text-danger">حدث خطأ أثناء تحميل الرسائل</div>';
                    });
            }

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

            function subscribeToChannel(user1Id, user2Id) {
                const ids = [parseInt(user1Id), parseInt(user2Id)].sort();
                const channelName = `private-chat.${ids[0]}.${ids[1]}`;

                if (window.currentChannel) {
                    pusher.unsubscribe(window.currentChannel);
                }

                const channel = pusher.subscribe(channelName);
                window.currentChannel = channelName;

                channel.bind('NewMessage', function(data) {
                    if (data.message && (data.message.sender_id == currentUserId || data.message
                            .receiver_id == currentUserId)) {
                        appendMessage(data.message, authUserId);
                        scrollToBottom();
                    }
                });
            }

            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message || !currentUserId) return;

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
                            console.error('Error sending message:', data.error || 'Unknown error');
                            alert('حدث خطأ أثناء إرسال الرسالة');
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('حدث خطأ أثناء إرسال الرسالة');
                    });
            });

            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
@endsection
