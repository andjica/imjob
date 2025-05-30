import setupNotifications from "./notifications.js";
import { createApp } from "vue";
import Chat from "./components/Chat.vue";
import ChatContributor from "./components/Chat-contributor.vue";
import Notification from "./components/Notification.vue";
import FreelancerNotification from "./components/NotificationFreelancer.vue";
import RecruiterNorification from "./components/NotificationRecruiter.vue";
import ChatFreelancerAll from "./components/Chat-freelancerAll.vue";
import ChatRecruiterAll from "./components/Chat-recruiterAll.vue";
import Echo from "laravel-echo";
import emitter from "./eventBus"; // OBAVEZNO!

window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY || "localkey",
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    encrypted: false,
    disableStats: true,
    enabledTransports: ["ws"],
    cluster: "mt1",
    namespace: null,
    authEndpoint: "/broadcasting/auth",
    auth: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
    },
});

// ✅ Helper funkcija za sigurno mount-ovanje komponente ako element postoji
function safeMount(selector, components) {
    const el = document.querySelector(selector);
    if (el) {
        const app = createApp({});
        for (const [name, component] of Object.entries(components)) {
            app.component(name, component);
        }
        app.mount(el);
    }
}

// ✅ Chat aplikacije
safeMount("#app", {
    "chat-component": Chat,
    "chat-component-contributor": ChatContributor,
    "chat-component-freelancer-all": ChatFreelancerAll,
    "chat-component-recruiter-all": ChatRecruiterAll,
});

// ✅ Notifikacije
safeMount("#notificationUnreadMessages", {
    "component-notification": Notification,
});

safeMount("#notificationFreelancerUnreadMessages", {
    "component-freelancer-notification": FreelancerNotification,
});

safeMount("#notificationRecruiterUnreadMessages", {
    "component-recruiter-notification": RecruiterNorification,
});

// ✅ Pokreći notifikacije i slušaj događaje kada se stranica učita
window.onload = function () {
    setupNotifications();

    const userId = window.authUserId;

    if (userId) {
        window.Echo.private(`chat.${userId}`).listen(".MessageSent", (payload) => {
            const message = payload.message;

            if (
                message.user_id !== parseInt(userId) &&
                !window.location.pathname.includes("/contributor/chats") &&
                !window.location.pathname.includes("/recruiter/chats") &&
                !window.location.pathname.includes("/company/freelancer/chats")
            ) {
                console.log("📨 Nova poruka od drugog korisnika dok nismo u chatu");
                emitter.emit("increment-navbar-badge");
            }
        });
    }
};
