@extends('layouts.app')

@section('title')
    {{ __('محادثات المستشار') }}
@endsection

@section('css')
    <link href="{{ asset('build/assets/css/welcome.css') }}" rel="stylesheet">
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
            /* background-color: #3a2a6c; */
            background: linear-gradient(90deg, #54B6B7 0%, #61528B 100%);

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
            border-right: 3px solid #3a2a6c;
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
            /* max-width: 75%; */
            max-width: 50%;
        }

        .message-sent {
            align-self: flex-start;
        }

        .message-received {
            align-self: flex-end;
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
            /* background-color: #3a2a6c; */
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
            align-self: flex-start;
        }

        .chat-input {
            padding: 15px;
            background-color: #fff;
            border-top: 1px solid #e0e0e0;
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
            background: linear-gradient(90deg, #54B6B7 0%, #61528B 100%);
            /* background-color: #3a2a6c; */
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
                                <i class="fas fa-comments me-2"></i> المحادثات
                            </div>
                            <div class="chat-contacts">
                                @forelse($students as $student)
                                    <div class="chat-contact d-flex align-items-center"
                                        data-student-id="{{ $student->id }}" data-student-name="{{ $student->name }}">
                                        <img src="{{ $student->profile_image ? asset($student->profile_image) : asset('images/default.jpeg') }}"
                                            alt="{{ $student->name }}" class="contact-avatar">
                                        <div class="contact-info ms-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="contact-name">{{ $student->name }}</div>
                                                @if ($student->unread_count > 0)
                                                    <div class="unread-badge">{{ $student->unread_count }}</div>
                                                @endif
                                            </div>
                                            <div class="contact-last-message">
                                                {{ $student->last_message ?? 'لا توجد رسائل' }}
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
                                <p>اختر طالب من القائمة للبدء في المحادثة</p>
                            </div>

                            <div id="chatArea" class="flex-column" style="display: none; height: 100%;">
                                <!-- Chat Header -->
                                <div class="d-flex flex-column">
                                    <div class="chat-header">
                                        <img id="chatHeaderAvatar" src="" alt="" class="chat-header-avatar">
                                        <div class="chat-header-info">
                                            <h5 id="chatHeaderName"></h5>
                                            <p>طالب</p>
                                        </div>
                                    </div>

                                    <!-- Student Name Above Messages -->
                                    {{-- <div id="currentStudentName" class="text-center my-3"
                                        style="font-weight: bold; font-size: 1.2rem;"></div> --}}

                                    <!-- Chat Messages -->
                                    <div class="chat-messages" id="chatMessages">
                                        <div class="chat-input">
                                            <form id="chatForm" class="chat-input-form">
                                                <input type="text" id="messageInput" class="chat-input-field"
                                                    placeholder="اكتب رسالتك هنا..." autocomplete="off">
                                                <button type="submit" class="chat-send-btn">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <!-- Messages will be loaded here -->
                                    </div>
                                </div>
                                <!-- Chat Input -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStudentId = null;
            const consultantId = {{ Auth::id() }};

            // Pusher setup
            const pusherAppKey = '{{ config('broadcasting.connections.pusher.key') }}';
            const pusherAppCluster = '{{ config('broadcasting.connections.pusher.options.cluster') }}';

            const pusher = new Pusher(pusherAppKey, {
                cluster: pusherAppCluster,
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

                    const studentId = this.dataset.studentId;
                    const studentName = this.dataset.studentName;

                    currentStudentId = studentId;

                    chatHeaderName.textContent = studentName;
                    chatHeaderAvatar.src = this.querySelector('.contact-avatar').src;

                    noChatSelected.style.display = 'none';
                    chatArea.style.display = 'flex';

                    loadMessages(studentId);
                    subscribeToChannel(consultantId, studentId);

                    if (window.innerWidth < 768) {
                        chatSidebar.classList.remove('show');
                    }

                    const unreadBadge = this.querySelector('.unread-badge');
                    if (unreadBadge) {
                        unreadBadge.remove();
                    }
                });
            });

            function loadMessages(studentId) {
                chatMessages.innerHTML =
                    '<div class="text-center my-3"><div class="spinner-border text-primary" role="status"></div></div>';

                fetch(`/chat/messages?user_id=${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        chatMessages.innerHTML = '';

                        if (data.messages && data.messages.length > 0) {
                            data.messages.forEach(message => {
                                appendMessage(message, consultantId);
                            });
                            scrollToBottom();
                        } else {
                            chatMessages.innerHTML =
                                '<div class="text-center my-3 text-muted">لا توجد رسائل</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading messages:', error);
                        chatMessages.innerHTML =
                            '<div class="text-center my-3 text-danger">حدث خطأ أثناء تحميل الرسائل</div>';
                    });
            }

            function appendMessage(message, consultantId) {
                const isReceived = message.sender_id != consultantId;
                const messageElement = document.createElement('div');
                messageElement.className = `message message-${isReceived ? 'received ms-auto' : 'sent me-auto'}`;

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
                scrollToBottom();
            }

            function subscribeToChannel(consultantId, studentId) {
                const ids = [parseInt(consultantId), parseInt(studentId)].sort();
                const channelName = `private-chat.${ids[0]}.${ids[1]}`;

                if (window.currentChannel) {
                    pusher.unsubscribe(window.currentChannel);
                }

                const channel = pusher.subscribe(channelName);
                window.currentChannel = channelName;

                channel.bind('NewChatMessage', function(data) {
                    if (data.message.sender_id == currentStudentId || data.message.receiver_id ==
                        currentStudentId) {
                        appendMessage(data.message, consultantId);
                    }
                });
            }

            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = messageInput.value.trim();
                if (!message || !currentStudentId) return;

                fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            receiver_id: currentStudentId,
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.message) {
                            messageInput.value = '';
                            appendMessage(data.message, consultantId);
                        } else {
                            console.error('Error sending message:', data.error || 'Unknown error');
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                    });
            });

            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
@endsection
