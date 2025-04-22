<template>
    <div class="notification-wrapper">
        <a href="/contributor/chats" class="nav-icon">
            <i class="fa-solid fa-message"></i>
            <span v-if="unreadTotal > 0" class="badge badge-danger">{{
                unreadTotal
            }}</span>
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
        };
    },
    mounted() {
        this.refreshUnreadTotal();

        // Listen for emitted updates
        emitter.on("update-navbar-badge", this.updateUnreadTotal);
        emitter.on("reset-navbar-badge", this.resetUnreadTotal); // <-- NOVO
    },
    beforeUnmount() {
        emitter.off("update-navbar-badge", this.updateUnreadTotal);

        emitter.off("reset-navbar-badge", this.resetUnreadTotal); // <-- NOVO
    },
    methods: {
        refreshUnreadTotal() {
            fetch("/api/messages/unread-total", {
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
            console.log("Updated badge:", total);
        },
        resetUnreadTotal() {
            this.unreadTotal = 0;
        },
    },
};
</script>

<style scoped>
.nav-icon {
    position: relative;
    display: inline-block;
}

.badge {
    position: absolute;
    top: -5px;
    right: -10px;
}
</style>
