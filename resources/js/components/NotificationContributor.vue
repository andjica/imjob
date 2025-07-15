<template>
    <div class="notification-wrapper">
        <a
            href="/contributor/chats"
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
        if (localStorage.getItem("resetBadgeContributor") === "1") {
            emitter.emit("reset-contributor-navbar-badge");
            localStorage.removeItem("resetBadgeContributor");
            return;
        }

        this.refreshUnreadTotal();

        // Slušaj emitove iz globalnog WebSocket listenera
        this.boundIncrementBadge = this.incrementBadge.bind(this);
        this.boundUpdateUnreadTotal = this.updateUnreadTotal.bind(this);
        this.boundResetUnreadTotal = this.resetUnreadTotal.bind(this);

        emitter.on("increment-contributor-navbar-badge", this.boundIncrementBadge);
        // emitter.on("update-navbar-badge", this.boundUpdateUnreadTotal);
        emitter.on("reset-contributor-navbar-badge", this.boundResetUnreadTotal);
    },
    beforeUnmount() {
        emitter.off("increment-contributor-navbar-badge", this.boundIncrementBadge);
        emitter.off("update-contributor-navbar-badge", this.boundUpdateUnreadTotal);
        emitter.off("reset-contributor-navbar-badge", this.boundResetUnreadTotal);
    },
    methods: {
        prepareForReset() {
            // Kad kliknemo na ikoncu → postavi flag da se resetuje badge
            localStorage.setItem("resetBadgeContributor", "1");
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
                    console.log("andjica",this.unreadTotal);
                
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
            this.refreshUnreadTotal();
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