import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import axios from 'axios';

window.Pusher = Pusher;

window.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="api-token"]')?.content;
    const userId = document.getElementById('current_user_id')?.value;


    if (!token || !userId) {
        console.error('❌ Missing token or user ID');
        return;
    }

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY ?? 'local',
        wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
        wsPort: import.meta.env.VITE_REVERB_PORT ?? 6001,
        wssPort: import.meta.env.VITE_REVERB_PORT ?? 6001,
        forceTLS: false,
        enabledTransports: ['ws'],
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept: 'application/json'
            }
        }
    });
    window.Echo.connector.pusher.connection.bind('connected', () => {
        console.log('✅ WebSocket connected');
    });

    const echoInstance = window.Echo;

    echoInstance.private(`chat.${userId}`)
        .listen('.MessageSent', (e) => {
            console.log('📥 Received (auto):', e.message.text);

            const div = document.createElement('div');
            div.textContent = `From ${e.message.sender_id}: ${e.message.text}`;
            document.getElementById('messages')?.appendChild(div);
        });

    document.getElementById('send')?.addEventListener('click', () => {
        const receiverId = document.getElementById('receiver_id').value;
        const text = document.getElementById('message_input').value;

        if (!receiverId || !text) {
            alert('Receiver ID and message are required');
            return;
        }

        axios.post('/api/messages', {
            sender_id: userId,
            receiver_id: receiverId,
            text: text,
        }, {
            headers: {
                Authorization: `Bearer ${token}`,
            }
        }).then(res => {
            console.log('✅ Message sent:', res.data);
            document.getElementById('message_input').value = '';
        }).catch(err => {
            console.error('❌ Send failed:', err.response?.data ?? err.message);
        });
    });
});
