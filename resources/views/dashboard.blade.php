<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>white chat - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" />
    <style>
        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            flex-direction: row-reverse;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .app-title {
            height: 50px;
            padding-top: 10px;
            text-align: center;
        }

        .message-box {
            height: calc(100vh - 100px);
            overflow-y: scroll;
        }

        .message-box::-webkit-scrollbar {
            display: none;
        }

        .chat-header,
        .chat-footer {
            height: 75px;
        }

        .chat {
            height: calc(100vh - 250px);
            overflow-y: scroll;
        }

        .chat::-webkit-scrollbar {
            display: none;
        }
    </style>

    <script>
        var me = {{ Auth::user()->id }};
        var chanal = "user.{{ Auth::user()->id }}";
    </script>

</head>

<body>
    <main class="content">
        <div class="container p-0">

            <h1 class="h3 app-title">Messages</h1>
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-right">

                        <div class="px-4 d-none d-md-block">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <input type="text" class="form-control my-3" placeholder="Search...">
                                </div>
                            </div>
                        </div>

                        @foreach ($users as $user)
                            <a data-user="{{ $user->id }}"
                                class="users list-group-item list-group-item-action border-0">
                                <div class="badge bg-success float-right"></div>
                                <div class="d-flex align-items-start">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar5.png"
                                        class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                    <div class="flex-grow-1 ml-3">
                                        {{ $user->name }}
                                        <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                                    </div>
                                </div>
                            </a>
                        @endforeach


                        <hr class="d-block d-lg-none mt-1 mb-0">
                    </div>
                    <div class="col-12 col-lg-7 col-xl-9 message-box">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block chat-header">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong id="chat_user">Demo</strong>
                                    <div class="text-muted small" id="chat_user_status"><em>Typing...</em></div>
                                </div>
                                <div>
                                    <button class="btn btn-light border btn-lg px-3"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-more-horizontal feather-lg">
                                            <circle cx="12" cy="12" r="1"></circle>
                                            <circle cx="19" cy="12" r="1"></circle>
                                            <circle cx="5" cy="12" r="1"></circle>
                                        </svg></button>
                                </div>
                            </div>
                        </div>

                        <div class="position-relative chat">
                            <div class="chat-messages p-4" id="chat-messages">
                            </div>
                        </div>

                        <div class="flex-grow-0 py-3 px-4 border-top chat-footer">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your message" id="msg">
                                <button class="btn btn-primary" id="msg_send">Send</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script>
        
    </script>
</body>

</html>
