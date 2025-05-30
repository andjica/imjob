<template>
    <div class="notification-wrapper">
        <a
            href="/recruiter/chats"
            class="nav-icon"
            @click="prepareForReset"
        >
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
        };
    },
    mounted() {
        // Ako dolazimo sa badge resetom (klik sa ikonice)
        if (localStorage.getItem("resetBadgeFromChat") === "1") {
            this.unreadTotal = 0;
            localStorage.removeItem("resetBadgeFromChat");
            return;
        }

        this.refreshUnreadTotal();

        // Slušaj emitove iz globalnog WebSocket listenera
        emitter.on("increment-navbar-badge", this.incrementBadge);
        emitter.on("update-navbar-badge", this.updateUnreadTotal);
        emitter.on("reset-navbar-badge", this.resetUnreadTotal);
    },
    beforeUnmount() {
        emitter.off("increment-navbar-badge", this.incrementBadge);
        emitter.off("update-navbar-badge", this.updateUnreadTotal);
        emitter.off("reset-navbar-badge", this.resetUnreadTotal);
    },
    methods: {
        prepareForReset() {
            // Kad kliknemo na ikoncu → postavi flag da se resetuje badge
            localStorage.setItem("resetBadgeFromChat", "1");
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
            this.unreadTotal++;
        },
        resetUnreadTotal() {
            this.unreadTotal = 0;
        },
    },
};
</script>

<style scoped>
.logo__notification {
  display: flex;
    flex-direction: column;
    justify-content: center;
}


</style>