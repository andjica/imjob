<template>
    <div class="notification-wrapper">
        <a href="/company/freelancer/chats" class="nav-icon" @click="prepareForReset">
            <i class="fa-solid fa-message"></i>
            <span v-if="unreadTotal > 0" class="badge badge-danger">
                {{ unreadTotal }}
            </span>
        </a>
    </div>
</template>

<script>
import emitter from "../eventBus";

export default {
    name: "Notification",
    data() {
        return {
            unreadTotal: 0,
            boundIncrementBadge: null,
            boundUpdateUnreadTotal: null,
            boundResetUnreadTotal: null,
        };
    },
    mounted() {
        if (localStorage.getItem("resetBadgeFreelancer") === "1") {
            emitter.emit("reset-navbar-badge");
            localStorage.removeItem("resetBadgeFreelancer");
            return;
        }

        this.refreshUnreadTotal();

        // Binduj metode da zadrže `this`
        this.boundIncrementBadge = this.incrementBadge.bind(this);
        this.boundUpdateUnreadTotal = this.updateUnreadTotal.bind(this);
        this.boundResetUnreadTotal = this.resetUnreadTotal.bind(this);

        emitter.on("increment-navbar-badge", this.boundIncrementBadge);
        emitter.on("update-navbar-badge", this.boundUpdateUnreadTotal);
        emitter.on("reset-navbar-badge", this.boundResetUnreadTotal);
    },
    beforeUnmount() {
        emitter.off("increment-navbar-badge", this.boundIncrementBadge);
        emitter.off("update-navbar-badge", this.boundUpdateUnreadTotal);
        emitter.off("reset-navbar-badge", this.boundResetUnreadTotal);
    },
    methods: {
        prepareForReset() {
            localStorage.setItem("resetBadgeFreelancer", "1");
        },
        refreshUnreadTotal() {
            fetch("/messages/unread-total", {
                method: "GET",
                headers: {
                    Accept: "application/json",
                    "X-CSRF-TOKEN": window.csrfToken,
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    this.unreadTotal = data.unread_total;
                })
                .catch((err) => {
                    console.error(
                        "Greška pri dohvatanju ukupnog broja nepročitanih poruka:",
                        err
                    );
                });
        },
        updateUnreadTotal(total) {
            this.unreadTotal = total;
        },
        incrementBadge() {
            this.refreshUnreadTotal(); // OVDE JE BILA GREŠKA
        },
        resetUnreadTotal() {
            this.unreadTotal = 0;
        },
    },
};
</script>

<style>
.notification-wrapper {
    position: relative;
}

.notification-wrapper .nav-icon .badge {
    position: absolute;
    top: -10px;
    right: -18px;
}
</style>
