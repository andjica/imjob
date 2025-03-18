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
    const recruiterId = document.querySelector('meta[name="recruiter-id"]')?.content;

    if (!window.subscribedChannels) {
        window.subscribedChannels = new Set();
    }

    // Function for listening to channels
    function subscribeToChannel(entityType, entityId) {
        if (!entityId) return;

        const channelName = `${entityType}.${entityId}`;

        // If channel already exists, reset it
        if (window.subscribedChannels.has(channelName)) {
            console.warn("Reset channel:", channelName);
            window.Echo.leave(channelName);
        } else {
            window.subscribedChannels.add(channelName);
        }

        const channel = window.Echo.channel(channelName);

        // Reset event before adding new listener
        channel.stopListening('.new-follow').listen('.new-follow', (event) => {
            console.log("New notification arrived:", event);

            let notificationIcon = document.getElementById("notification-icon");
            let notificationBadge = document.getElementById("notification-badge");

            if (!notificationIcon || !notificationBadge) return;

            let notificationCount = 0;

            // ✅ Save status for notification in `localStorage` separately for recruiter and company
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
        });

        console.log(`Subscribed to: ${channelName}`);
    }

    // ✅ Check stored notifications
    function checkStoredNotifications() {
        let notificationIcon = document.getElementById("notification-icon");
        let notificationBadge = document.getElementById("notification-badge");

        let isCompanyDashboard = window.location.pathname.includes("company/dashboard");
        let isRecruiterDashboard = window.location.pathname.includes("recruiter");
        let isFreelancerDashboard = window.location.pathname.includes("company/freelancer"); // ✅ Freelancer koristi Recruiter notifikacije

        let notificationCount = 0; // Ensure notificationCount exists

        if (isCompanyDashboard && localStorage.getItem("companyHasNewNotification") === "true") {
            notificationIcon.classList.add("text-danger");
            notificationCount = localStorage.getItem("companyNotificationCount") || "0";
            notificationBadge.innerText = notificationCount;
            notificationBadge.style.display = "inline";
        }

        if ((isRecruiterDashboard || isFreelancerDashboard) && localStorage.getItem("recruiterHasNewNotification") === "true") {
            notificationIcon.classList.add("text-danger");
            notificationCount = localStorage.getItem("recruiterNotificationCount") || "0";
            notificationBadge.innerText = notificationCount;
            notificationBadge.style.display = "inline";
        }
    }

    // ✅ Clear notifications when user visits notification route
    function clearNotificationsOnRoute() {
        let isCompanyNotificationPage = window.location.pathname === "/company/dashboard/notifications";
        let isRecruiterNotificationPage = window.location.pathname === "/recruiter/notifications";
        let isFreelancerNotificationPage = window.location.pathname === "/company/freelancer/notifications"; // ✅ Freelancer koristi istu logiku kao recruiter

        if (isCompanyNotificationPage) {
            localStorage.removeItem("companyHasNewNotification");
            localStorage.removeItem("companyNotificationCount");

            let notificationIcon = document.getElementById("notification-icon");
            let notificationBadge = document.getElementById("notification-badge");

            notificationIcon.classList.remove("text-danger");
            notificationBadge.style.display = "none";
        }

        if ((isRecruiterNotificationPage || isFreelancerNotificationPage)) {
            localStorage.removeItem("recruiterHasNewNotification");
            localStorage.removeItem("recruiterNotificationCount");

            let notificationIcon = document.getElementById("notification-icon");
            let notificationBadge = document.getElementById("notification-badge");

            notificationIcon.classList.remove("text-danger");
            notificationBadge.style.display = "none";
        }
    }

    // ✅ Listen for company and recruiter (freelancer == recruiter)
    subscribeToChannel('company', companyId);
    subscribeToChannel('recruiter', recruiterId);

    // Check saved notifications from localStorage
    checkStoredNotifications();

    // Reset if user goes to notifications route
    clearNotificationsOnRoute();
};
