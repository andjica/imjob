import './bootstrap';  
import Echo from 'laravel-echo';  
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,  
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

window.onload = function () {
    const companyId = document.querySelector('meta[name="company-id"]')?.content;
    if (!companyId) return;

    const channelName = `company.${companyId}`;

    if (!window.subscribedChannels) {
        window.subscribedChannels = new Set();
    }

    // ✅ Ako je kanal već pretplaćen, zaustavi osluškivanje i resetuj kanal
    if (window.subscribedChannels.has(channelName)) {
        console.warn("⚠️ Resetujem kanal:", channelName);
        window.Echo.leave(channelName);
    } else {
        window.subscribedChannels.add(channelName);
    }

    const channel = window.Echo.channel(channelName);

    // ✅ Resetujemo event pre nego što dodamo novi listener
    channel.stopListening('.new-follow').listen('.new-follow', (event) => {
        console.log("✅ Nova notifikacija primljena:", event);

        let notificationIcon = document.getElementById("notification-icon");
        let notificationBadge = document.getElementById("notification-badge");

        if (!notificationIcon || !notificationBadge) return;

        notificationIcon.classList.add("text-danger");

        let notificationCount = parseInt(notificationBadge.innerText) || 0;
        notificationBadge.innerText = notificationCount + 1;
        notificationBadge.style.display = "inline";
    });

    console.log(`✅ Subscribed to: ${channelName}`);
};

