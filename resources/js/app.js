import setupNotifications from './notifications.js';
import { createApp } from 'vue';
import Chat from './components/Chat.vue';
import ChatContributor from './components/Chat-contributor.vue';
import Notification from './components/Notification.vue';
import FreelancerNotification from './components/NotificationFreelancer.vue';
import ReacruiterNorification from './components/NotificationRecruiter.vue';
import ChatFreelancerAll from './components/Chat-freelancerAll.vue';
import ChatRecruiterAll from './components/Chat-recruiterAll.vue';
import Echo from 'laravel-echo';
import emitter from './eventBus'; // OBAVEZNO!

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
app.component('chat-component-freelancer-all', ChatFreelancerAll);
app.component('chat-component-recruiter-all', ChatRecruiterAll);
app.mount('#app');

const notifApp = createApp({});
notifApp.component('component-notification', Notification);
notifApp.mount('#notificationUnreadMessages')


const notifFreelancerApp = createApp({});
notifFreelancerApp.component('component-freelancer-notification', FreelancerNotification);
notifFreelancerApp.mount('#notificationFreelancerUnreadMessages')

const notifRecruiterApp = createApp({});
notifRecruiterApp.component('component-recruiter-notification', ReacruiterNorification);
notifRecruiterApp.mount('#notificationReacruiterUnreadMessages');



// ✅ Direktno dodaj listener za sve poruke (bez zasebnog fajla)
window.onload = function () {
    // ✅ Pokrećemo notifikacije kada se stranica učita

    setupNotifications();
   
    const userId = window.authUserId;

    if (userId) {
        window.Echo.private(`chat.${userId}`)
            .listen('.MessageSent', (payload) => {
                const message = payload.message;
                
                if (
                    message.user_id !== parseInt(userId) &&
                    (!window.location.pathname.includes('/contributor/chats') &&
                    !window.location.pathname.includes('/recruiter/chats') && !window.location.pathname.includes('/company/freelancer/chats'))
                ) {
                    console.log('📨 Nova poruka od drugog korisnika dok nismo u chatu');
                    emitter.emit('increment-navbar-badge');
                }
            });
    }
};
