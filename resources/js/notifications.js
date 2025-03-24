import './bootstrap';
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

function setupNotifications() {
    const companyId = document.querySelector('meta[name="company-id"]')?.content;
    const recruiterId = document.querySelector('meta[name="recruiter-id"]')?.content;

    const isCompanyLoggedIn = Boolean(companyId);
    const isRecruiterLoggedIn = Boolean(recruiterId);

    if (!window.subscribedChannels) {
        window.subscribedChannels = new Set();
    }

    function subscribeToChannel(entityType, entityId) {
        if (!entityId) return;

        // Spreči pretplatu na kanal koji ne pripada ulogovanom korisniku
        if (entityType === 'company' && !isCompanyLoggedIn) return;
        if (entityType === 'recruiter' && !isRecruiterLoggedIn) return;

        const channelName = `${entityType}.${entityId}`;

        if (window.subscribedChannels.has(channelName)) {
            console.warn("Reset channel:", channelName);
            window.Echo.leave(channelName);
        } else {
            window.subscribedChannels.add(channelName);
        }

        const channel = window.Echo.channel(channelName);

        channel.stopListening('.new-follow').listen('.new-follow', (event) => {
            console.log(`📬 New notification on ${channelName}:`, event);

            const isFollowedCompany =
                event.followed_type === 'company' &&
                event.company_id.toString() === entityId.toString();

            const isFollowedRecruiter =
                event.followed_type === 'recruiter' &&
                event.recruiter_id.toString() === entityId.toString();

            if (!isFollowedCompany && !isFollowedRecruiter) {
                console.log("🚫 Ignored — current user is NOT the followed entity.");
                return;
            }

            console.log("🔔 Showing notification to FOLLOWED entity:", channelName);

            const notificationIcon = document.getElementById("notification-icon");
            const notificationBadge = document.getElementById("notification-badge");
            const notificationMenuTitles = document.querySelectorAll(".notification-menu-title");

            if (!notificationIcon || !notificationBadge) return;

            let notificationCount = 0;

            if (entityType === "company") {
                localStorage.setItem("companyHasNewNotification", "true");
                notificationCount = parseInt(localStorage.getItem("companyNotificationCount") || "0") + 1;
                localStorage.setItem("companyNotificationCount", notificationCount);
            }

            if (entityType === "recruiter") {
                localStorage.setItem("recruiterHasNewNotification", "true");
                notificationCount = parseInt(localStorage.getItem("recruiterNotificationCount") || "0") + 1;
                localStorage.setItem("recruiterNotificationCount", notificationCount);
            }

            notificationIcon.classList.add("text-danger");
            notificationBadge.innerText = notificationCount;
            notificationBadge.style.display = "inline";
            notificationMenuTitles.forEach(menu => menu.classList.add("text-danger"));
        });

        console.log(`✅ Subscribed to: ${channelName}`);
    }

    function checkStoredNotifications() {
        const notificationIcon = document.getElementById("notification-icon");
        const notificationBadge = document.getElementById("notification-badge");
        const notificationMenuTitles = document.querySelectorAll(".notification-menu-title");

        const isCompanyDashboard = window.location.pathname.includes("company/dashboard");
        const isRecruiterDashboard = window.location.pathname.includes("recruiter");
        const isFreelancerDashboard = window.location.pathname.includes("company/freelancer");

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
        const isCompanyNotificationPage = window.location.pathname === "/company/dashboard/notifications";
        const isRecruiterNotificationPage = window.location.pathname === "/recruiter/notifications";
        const isFreelancerNotificationPage = window.location.pathname === "/company/freelancer/notifications";

        if (isCompanyNotificationPage || isRecruiterNotificationPage || isFreelancerNotificationPage) {
            localStorage.removeItem("companyHasNewNotification");
            localStorage.removeItem("companyNotificationCount");
            localStorage.removeItem("recruiterHasNewNotification");
            localStorage.removeItem("recruiterNotificationCount");

            const notificationIcon = document.getElementById("notification-icon");
            const notificationBadge = document.getElementById("notification-badge");
            const notificationMenuTitles = document.querySelectorAll(".notification-menu-title");

            notificationIcon.classList.remove("text-danger");
            notificationBadge.style.display = "none";
            notificationMenuTitles.forEach(menu => menu.classList.remove("text-danger"));
        }
    }

    function setupNotificationClickReset() {
        const notificationLinks = document.querySelectorAll('.menu-link[href*="notifications"]');
        notificationLinks.forEach(link => {
            link.addEventListener('click', () => {
                console.log("🔄 Resetting notifications on menu click...");
                clearNotificationsOnRoute();
            });
        });
    }

    if (isCompanyLoggedIn) {
        subscribeToChannel('company', companyId);
    }

    if (isRecruiterLoggedIn) {
        subscribeToChannel('recruiter', recruiterId);
    }

    checkStoredNotifications();
    clearNotificationsOnRoute();
    setupNotificationClickReset();
}

export default setupNotifications;
