import setupNotifications from './notifications';
import { createApp } from 'vue';
import Chat from './components/Chat.vue';
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY || 'localkey',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws'],
    cluster: 'mt1',
    namespace: null
});

const app = createApp({});
app.component('chat-component', Chat);
app.mount('#app');

// ✅ Pokrećemo notifikacije kada se stranica učita
window.onload = function () {
    setupNotifications();
    
};