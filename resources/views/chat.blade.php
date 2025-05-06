<!DOCTYPE html>
<html>
<head>
    <title>Laravel Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Real-Time Chat</h1>

    <div id="messages" style="border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: auto;"></div>

    <input type="hidden" id="sender_id" value="{{ auth()->id() }}">
    <input type="text" id="receiver_id" placeholder="Receiver ID">
    <input type="text" id="message_input" placeholder="Write a message...">
    <button id="send">Send</button>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="module">
        import Echo from 'https://cdn.skypack.dev/laravel-echo';
        import Pusher from 'https://cdn.skypack.dev/pusher-js';

        window.Pusher = Pusher;

        const token = '{{ auth()->user()?->createToken("chat-token")->plainTextToken }}';

        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: import.meta.env?.VITE_REVERB_APP_KEY ?? 'local',
            wsHost: window.location.hostname,
            wsPort: 6001,
            forceTLS: false,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: 'application/json'
                }
            }
        });

        const userId = document.getElementById('sender_id').value;

        Echo.private(`chat.${userId}`)
            .listen('.MessageSent', (e) => {
                const div = document.createElement('div');
                div.textContent = `New: ${e.message.text}`;
                document.getElementById('messages').appendChild(div);
            });

        document.getElementById('send').addEventListener('click', () => {
            const receiverId = document.getElementById('receiver_id').value;
            const text = document.getElementById('message_input').value;

            axios.post('/api/messages', {
                receiver_id: receiverId,
                sender_id: userId,
                text: text,
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(res => {
                console.log('Message sent!', res.data);
            });
        });
    </script>
</body>
</html>
