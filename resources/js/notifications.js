import './bootstrap';  
import Echo from 'laravel-echo';  
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,  
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

function setupNotifications() {
    const companyId = document.querySelector('meta[name="company-id"]')?.content;
    const recruiterId = document.querySelector('meta[name="recruiter-id"]')?.content;

    if (!window.subscribedChannels) {
        window.subscribedChannels = new Set();
    }

    function subscribeToChannel(entityType, entityId) {
        if (!entityId) return;

        const channelName = `${entityType}.${entityId}`;

        if (window.subscribedChannels.has(channelName)) {
            console.warn("Reset channel:", channelName);
            window.Echo.leave(channelName);
        } else {
            window.subscribedChannels.add(channelName);
        }

        const channel = window.Echo.channel(channelName);

        channel.stopListening('.new-follow').listen('.new-follow', (event) => {
            console.log("New notification arrived:", event);

            let notificationIcon = document.getElementById("notification-icon");
            let notificationBadge = document.getElementById("notification-badge");
            let notificationMenuTitles = document.querySelectorAll(".notification-menu-title");

            if (!notificationIcon || !notificationBadge) return;

            let notificationCount = 0;

            if (entityType === "company") {
                localStorage.setItem("companyHasNewNotification", "true");
                notificationCount = parseInt(localStorage.getItem("companyNotificationCount") || "0") + 1;
                localStorage.setItem("companyNotificationCount", notificationCount);
            } 
            else if (entityType === "recruiter") {
                localStorage.setItem("recruiterHasNewNotification", "true");
                notificationCount = parseInt(localStorage.getItem("recruiterNotificationCount") || "0") + 1;
                localStorage.setItem("recruiterNotificationCount", notificationCount);
            }

            notificationIcon.classList.add("text-danger");
            notificationBadge.innerText = notificationCount;
            notificationBadge.style.display = "inline";
            notificationMenuTitles.forEach(menu => menu.classList.add("text-danger"));
        });

        console.log(`Subscribed to: ${channelName}`);
    }

    function checkStoredNotifications() {
        let notificationIcon = document.getElementById("notification-icon");
        let notificationBadge = document.getElementById("notification-badge");
        let notificationMenuTitles = document.querySelectorAll(".notification-menu-title");

        let isCompanyDashboard = window.location.pathname.includes("company/dashboard");
        let isRecruiterDashboard = window.location.pathname.includes("recruiter");
        let isFreelancerDashboard = window.location.pathname.includes("company/freelancer");

        let notificationCount = 0;

        if (isCompanyDashboard && localStorage.getItem("companyHasNewNotification") === "true") {
            notificationIcon.classList.add("text-danger");
            notificationMenuTitles.forEach(menu => menu.classList.add("text-danger"));
            notificationCount = localStorage.getItem("companyNotificationCount") || "0";
            notificationBadge.innerText = notificationCount;
            notificationBadge.style.display = "inline";
        }

        if ((isRecruiterDashboard || isFreelancerDashboard) && localStorage.getItem("recruiterHasNewNotification") === "true") {
            notificationIcon.classList.add("text-danger");
            notificationMenuTitles.forEach(menu => menu.classList.add("text-danger"));
            notificationCount = localStorage.getItem("recruiterNotificationCount") || "0";
            notificationBadge.innerText = notificationCount;
            notificationBadge.style.display = "inline";
        }
    }

    function clearNotificationsOnRoute() {
        let isCompanyNotificationPage = window.location.pathname === "/company/dashboard/notifications";
        let isRecruiterNotificationPage = window.location.pathname === "/recruiter/notifications";
        let isFreelancerNotificationPage = window.location.pathname === "/company/freelancer/notifications";

        if (isCompanyNotificationPage || isRecruiterNotificationPage || isFreelancerNotificationPage) {
            localStorage.removeItem("companyHasNewNotification");
            localStorage.removeItem("companyNotificationCount");
            localStorage.removeItem("recruiterHasNewNotification");
            localStorage.removeItem("recruiterNotificationCount");

            let notificationIcon = document.getElementById("notification-icon");
            let notificationBadge = document.getElementById("notification-badge");
            let notificationMenuTitles = document.querySelectorAll(".notification-menu-title");

            notificationIcon.classList.remove("text-danger");
            notificationBadge.style.display = "none";
            notificationMenuTitles.forEach(menu => menu.classList.remove("text-danger"));
        }
    }

    function setupNotificationClickReset() {
        let notificationLinks = document.querySelectorAll('.menu-link[href*="notifications"]');
        notificationLinks.forEach(link => {
            link.addEventListener('click', () => {
                console.log("🔄 Resetting notifications on menu click...");
                clearNotificationsOnRoute();
            });
        });
    }

    subscribeToChannel('company', companyId);
    subscribeToChannel('recruiter', recruiterId);

    checkStoredNotifications();
    clearNotificationsOnRoute();
    setupNotificationClickReset(); 
}

export default setupNotifications;
