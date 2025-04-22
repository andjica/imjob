import setupNotifications from './notifications';
import { createApp } from 'vue';
import Chat from './components/Chat.vue';
import ChatContributor from './components/Chat-contributor.vue';
import Notification from './components/Notification.vue';
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
    namespace: null,
    //novo
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }
});

const app = createApp({});

app.component('chat-component', Chat);
app.component('chat-component-contributor', ChatContributor);
app.mount('#app');

const notifApp = createApp({});
notifApp.component('component-notification', Notification);
notifApp.mount('#notificationUnreadMessages')

// ✅ Pokrećemo notifikacije kada se stranica učita
window.onload = function () {
    setupNotifications();

};