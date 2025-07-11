<template>
    <div class="row">
        <div class="col-lg-5 mb-5">
            <div class="card card-flush">
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <form class="w-100 position-relative" autocomplete="off">
                        <i
                            class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"
                        >
                            <span class="path1"></span
                            ><span class="path2"></span>
                        </i>
                        <input
                            type="text"
                            class="form-control form-control-solid px-13"
                            name="search"
                            value=""
                            placeholder="Search by username or email..."
                        />
                    </form>
                </div>
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <div
                        class="scroll-y me-n5 pe-5 h-200px h-lg-auto"
                        data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body"
                        data-kt-scroll-offset="5px"
                        style="max-height: 362px"
                    >
                        <div class="d-flex d-flex__column">
                            <!-- Freelancers Section -->
                            <div class="gap-4 user-card__scroll">
                                <div
                                    v-for="recruiter in uniqueRecruiters.filter(
                                        (r) => r.is_freelancer === 0
                                    )"
                                    :key="'freelancer-' + recruiter.user_id"
                                >
                                    <div
                                        v-if="recruiter && recruiter.user_id"
                                        class="d-flex align-items-center px-2 user-card"
                                        @click.prevent="
                                            selectUser(recruiter.user)
                                        "
                                        :class="{
                                            'user-active':
                                                selectedUser &&
                                                selectedUser.id ===
                                                    recruiter.user_id,
                                        }"
                                    >
                                        <div
                                            class="symbol symbol-45px symbol-circle"
                                        >
                                            <img
                                                :src="
                                                    recruiter.profile_image
                                                        ? getImageFileUrl(
                                                              recruiter.profile_image
                                                          )
                                                        : defaultImage
                                                "
                                                alt="Profile Image"
                                                class="img-fluid rounded-circle shadow-sm"
                                                style="
                                                    width: 60px;
                                                    height: 60px;
                                                "
                                            />
                                        </div>
                                        <div class="ms-5">
                                            <a
                                                href="#"
                                                class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2"
                                            >
                                                {{ recruiter.user.first_name }}
                                                {{ recruiter.user.last_name }}
                                            </a>
                                            <p>{{ recruiter.user.email }}</p>
                                            <small><i>Recruiter</i></small>
                                        </div>
                                        <span
                                            v-if="unreadMap[recruiter.user.id]"
                                            class="badge badge-danger"
                                        >
                                            {{ unreadMap[recruiter.user.id] }}
                                        </span>
                                    </div>
                                </div>
                                <div v-if="uniqueRecruiters.length === 0">
                                    <p>You don't have Recruiters</p>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <!-- Recruiters Section -->
                            <div class="gap-4 user-card__scroll">
                                <div
                                    v-for="recruiter in uniqueRecruiters.filter(
                                        (r) => r.is_freelancer !== 0
                                    )"
                                    :key="'recruiter-' + recruiter.user_id"
                                >
                                    <div
                                        v-if="recruiter && recruiter.user_id"
                                        class="d-flex align-items-center px-2 user-card"
                                        @click.prevent="
                                            selectUser(recruiter.user)
                                        "
                                        :class="{
                                            'user-active':
                                                selectedUser &&
                                                selectedUser.id ===
                                                    recruiter.user_id,
                                        }"
                                    >
                                        <div
                                            class="symbol symbol-45px symbol-circle"
                                        >
                                            <img
                                                :src="
                                                    recruiter.profile_image
                                                        ? getImageFileUrl(
                                                              recruiter.profile_image
                                                          )
                                                        : defaultImage
                                                "
                                                alt="Profile Image"
                                                class="img-fluid rounded-circle shadow-sm"
                                                style="
                                                    width: 60px;
                                                    height: 60px;
                                                "
                                            />
                                        </div>
                                        <div class="ms-5">
                                            <a
                                                href="#"
                                                class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2"
                                            >
                                                {{ recruiter.user.first_name }}
                                                {{ recruiter.user.last_name }}
                                            </a>
                                            <p>{{ recruiter.user.email }}</p>
                                            <small><i>Freelancer</i></small>
                                        </div>
                                        <span
                                            v-if="unreadMap[recruiter.user.id]"
                                            class="badge badge-danger"
                                        >
                                            {{ unreadMap[recruiter.user.id] }}
                                        </span>
                                    </div>
                                </div>
                                <div v-if="uniqueRecruiters.length === 0">
                                    <p>You don't have Freelancers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card card-flush h-100">
                <div v-if="selectedUser" class="d-flex align-items-center">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            Chat with {{ selectedUser.first_name }}
                            {{ selectedUser.last_name }}
                        </h3>
                    </div>
                </div>
                <div v-else>
                    <h3 class="card-title">Select a user</h3>
                </div>
                <div
                    class="card-body chat-box chat-box__contributor"
                    id="chatBox__contributor"
                >
                    <div
                        v-for="msg in sortedMessages"
                        :key="msg.id"
                        :class="[
                            'chat-message',
                            msg.user_id === currentUserId ? 'sent' : 'received',
                        ]"
                    >
                        <div
                            :class="
                                msg.user_id === currentUserId
                                    ? 'text-end'
                                    : 'text-start'
                            "
                        >
                            <!-- Prikaz teksta poruke -->
                            <div
                                :class="
                                    msg.user_id === currentUserId
                                        ? 'p-3 rounded bg-primary text-white d-inline-block'
                                        : 'p-3 rounded bg-light text-dark d-inline-block'
                                "
                                v-if="msg.text"
                            >
                                {{ msg.text }}
                            </div>

                            <!-- Prikaz fajla -->
                            <div v-if="msg.file_path" style="margin-top: 10px">
                                <div
                                    v-if="
                                        getFileDisplayType(msg.file_type) ===
                                        'image'
                                    "
                                >
                                    <img
                                        :src="getImageFileUrl(msg.file_path)"
                                        alt="image"
                                        style="max-width: 200px"
                                    />
                                </div>
                                <div
                                    v-else-if="
                                        getFileDisplayType(msg.file_type) ===
                                        'pdf'
                                    "
                                >
                                    <a
                                        :class="
                                            msg.user_id === currentUserId
                                                ? 'p-3 rounded bg-primary text-white d-inline-block'
                                                : 'p-3 rounded bg-light text-dark d-inline-block'
                                        "
                                        :href="getImageFileUrl(msg.file_path)"
                                        target="_blank"
                                    >
                                        📄 View PDF
                                    </a>
                                </div>
                                <div
                                    v-else-if="
                                        getFileDisplayType(msg.file_type) ===
                                        'word'
                                    "
                                >
                                    <a
                                        :class="
                                            msg.user_id === currentUserId
                                                ? 'p-3 rounded bg-primary text-white d-inline-block'
                                                : 'p-3 rounded bg-light text-dark d-inline-block'
                                        "
                                        :href="getImageFileUrl(msg.file_path)"
                                        target="_blank"
                                    >
                                        📎 Word Document
                                    </a>
                                </div>
                                <div v-else>
                                    <a
                                        :class="
                                            msg.user_id === currentUserId
                                                ? 'p-3 rounded bg-primary text-white d-inline-block'
                                                : 'p-3 rounded bg-light text-dark d-inline-block'
                                        "
                                        :href="getImageFileUrl(msg.file_path)"
                                        target="_blank"
                                    >
                                        📁 Download file
                                    </a>
                                </div>
                            </div>

                            <!-- Vreme -->
                            <div class="mt-1">
                                <small class="text-muted">
                                    {{
                                        new Date(
                                            msg.created_at
                                        ).toLocaleTimeString()
                                    }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Poruka kada nema nijedne poruke -->
                    <div v-if="messages.length === 0">
                        <p class="message-info">
                            Start a conversation with user
                            {{
                                selectedUser?.first_name +
                                " " +
                                selectedUser?.last_name
                            }}
                            to begin your collaboration. Introduce yourself,
                            share your ideas, or ask any questions to get things
                            moving.
                        </p>
                    </div>
                </div>

                <div class="card-footer border-top pt-4">
                    <form
                        id="chatForm"
                        @submit.prevent="handleSubmit"
                        enctype="multipart/form-data"
                    >
                        <div class="d-flex align-items-center gap-2">
                            <input
                                type="text"
                                class="form-control form-control-solid px-13"
                                name="input"
                                placeholder="Type your message..."
                                v-model="message"
                                @keydown.enter.prevent="handleSubmit"
                            />
                            <button
                                type="button"
                                class="btn btn-light position-relative p-22"
                                @click="triggerFileInput"
                            >
                                <i class="fa-solid fa-image icon-img"></i>
                                <i class="fa-solid fa-file icon-file"></i>
                            </button>
                            <input
                                type="file"
                                id="fileUpload-contributor"
                                ref="fileInput"
                                @change="handleFileChange"
                                accept="image/*,.pdf,.doc,.docx"
                                class="d-none"
                            />
                            <button
                                class="btn-emojis"
                                ref="emojiBtn"
                                @click.prevent="toggleEmojiPicker"
                            >
                                😀
                            </button>

                            <button class="btn btn-primary" type="submit">
                                Send
                            </button>
                        </div>
                        <div class="message-error" v-if="messageError">
                            {{ messageError }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { EmojiButton } from "@joeattardi/emoji-button";
import userImage from "../../../public/images/user-286.png";
import emitter from "../eventBus";

export default {
    props: {
        recruiters: Array,
        currentUserId: Number,
    },
    data() {
        return {
            selectedRecruiter: null,
            selectedUser: null,
            picker: null,
            message: "",
            file: "",
            messages: [],
            unreadMap: {},
            unreadTotal: 0,
            messageError: "",
        };
    },
    computed: {
        defaultImage() {
            return userImage;
        },
        sortedMessages() {
            return this.messages
                .slice()
                .sort(
                    (a, b) => new Date(a.created_at) - new Date(b.created_at)
                );
        },
        uniqueRecruiters() {
            const seen = new Set();
            const unique = this.recruiters.filter((r) => {
                if (seen.has(r.user_id)) return false;
                seen.add(r.user_id);
                return true;
            });

            return unique.sort((a, b) => {
                const aHasMessages = this.unreadMap.hasOwnProperty(a.user_id);
                const bHasMessages = this.unreadMap.hasOwnProperty(b.user_id);

                if (aHasMessages !== bHasMessages) {
                    return bHasMessages - aHasMessages; // Put those with messages first
                }

                // Then sort by freelancer status: freelancers (is_freelancer === 0) first
                return a.is_freelancer - b.is_freelancer;
            });
        },
    },
    watch: {
        messages() {
            this.$nextTick(() => {
                const chatBox = document.getElementById("chatBox__contributor");
                if (chatBox) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
        },
    },
    methods: {
        getImageFileUrl(path) {
            return `/storage/${path}`;
        },
        resetUnreadTotal() {
            this.unreadTotal = 0;
        },
        updateUnreadTotal() {
            this.unreadTotal = Object.values(this.unreadMap).reduce(
                (sum, count) => sum + count,
                0
            );

            emitter.emit("update-navbar-badge", this.unreadTotal);
        },
        selectRecruiter(user) {
            this.selectedRecruiter = user;
            this.selectedUser = null;
            this.fetchMessages(user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(user));
        },
        selectUser(user) {
            this.selectedUser = user;
            this.selectedRecruiter = null;
            this.fetchMessages(user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(user));
            fetch(`/messages/mark-as-read/${this.selectedUser.id}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken,
                },
            })
                .then((res) => res.json())
                .then(() => {
                    // Set the unread count to 0 for this user
                    if (this.unreadMap[this.selectedUser.id]) {
                        this.unreadMap[this.selectedUser.id] = 0;
                    }

                    this.updateUnreadTotal();
                })
                .catch((err) => {
                    console.error(
                        "Greška pri označavanju poruka kao pročitanih:",
                        err
                    );
                });
        },
        getActiveChatUserId() {
            return (
                this.selectedUser?.id ||
                this.selectedRecruiter?.user?.id ||
                null
            );
        },
        clearFileInput() {
            if (this.$refs.fileInput) {
                this.$refs.fileInput.value = "";
            }
            this.file = null;
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file && file.size > 5 * 1024 * 1024) {
                this.messageError = "File must be less than 5MB.";
                this.$refs.fileInput.value = "";
                this.file = null;
                return;
            }
            this.messageError = ""; // Clear previous errors
            this.file = file;
        },
        getFileDisplayType(fileType) {
            if (fileType?.startsWith("image/")) return "image";
            if (fileType === "application/pdf") return "pdf";
            if (
                fileType ===
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            )
                return "word";
            return "other";
        },
        fetchMessages(receiverId) {
            if (!receiverId) return;

            fetch(`/messages/${receiverId}`, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": window.csrfToken,
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    this.messages = data;
                    this.scrollToBottom();
                })
                .catch((err) => {
                    console.error("Greška pri dohvatanju poruka:", err);
                });
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const chatBox = document.getElementById("chatBox__contributor");
                if (chatBox) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
        },
        toggleEmojiPicker() {
            if (this.picker && this.$refs.emojiBtn) {
                this.picker.togglePicker(this.$refs.emojiBtn);
            } else {
                console.warn("Emoji picker nije inicijalizovan.");
            }
        },
        handleSubmit() {
            if (!this.message.trim() && !this.file) {
                this.messageError = "Please enter a text or upload a file!";
                return;
            }

            const receiverId =
                this.selectedUser?.id || this.selectedRecruiter?.user?.id;
            if (!receiverId) {
                this.messageError = "The user is not selected.";
                return;
            }
            const formData = new FormData();

            formData.append("user_id", this.currentUserId);
            formData.append("text", this.message);
            formData.append("receiver_id", receiverId);
            formData.append("candidate_id", this.selectedUser?.id || 0);
            if (this.file) {
                formData.append("file", this.file);
            }

            console.log("Form data sadrži:");
            for (let [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }
            fetch("/messages", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": window.csrfToken,
                },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    this.message = "";
                    this.messageError = "";
                    this.clearFileInput();
                    if (data.message) {
                        this.messages = [...this.messages, data.message].sort(
                            (a, b) =>
                                new Date(a.created_at) - new Date(b.created_at)
                        );

                        this.scrollToBottom();
                    }
                })
                .catch((error) => {
                    console.error("Greška pri slanju poruke:", error);
                });
        },
    },
    mounted() {
        this.$nextTick(() => {
            emitter.emit("reset-navbar-badge");
        });

        // Dohvati nepročitane poruke po korisniku
        fetch("/messages/unread-count", {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": window.csrfToken,
                Accept: "application/json",
            },
        })
            .then((res) => res.json())
            .then((data) => {
                data.forEach((item) => {
                    this.unreadMap[item.user_id] = item.unread_count;
                });
                this.updateUnreadTotal();
            })
            .catch((err) => {
                console.error(
                    "Greška pri dohvatanju nepročitanih poruka:",
                    err
                );
            });

        // Emoji picker
        this.picker = new EmojiButton({ position: "top-end" });
        if (this.picker) {
            this.picker.on("emoji", (emoji) => {
                this.message += emoji.emoji;
            });
        }

        // Zapamti poslednjeg korisnika (ako postoji) ili selektuj prvog ako nema
        const lastUser = localStorage.getItem("lastChatUser");

        if (lastUser) {
            const parsed = JSON.parse(lastUser);
            this.selectUser(parsed);
        } else if (this.uniqueRecruiters.length > 0) {
            const firstFreelancer = this.uniqueRecruiters.find(
                (r) => r.is_freelancer === 0
            );
            if (firstFreelancer && firstFreelancer.user) {
                this.selectUser(firstFreelancer.user);
            } else {
                const firstRecruiter = this.uniqueRecruiters[0];
                if (firstRecruiter && firstRecruiter.user) {
                    this.selectUser(firstRecruiter.user);
                }
            }
        }

        // WebSocket povezivanje
        Echo.private("chat." + this.currentUserId)
            .subscribed(() => {
                console.log(
                    "✅ Subscribed na kanal: chat." + this.currentUserId
                );
            })
            .listen(".MessageSent", (payload) => {
                console.log("📥 Novi payload:", payload);
                const message = payload.message;
                const activeReceiverId = this.getActiveChatUserId();
                console.log("Kontributor activeReceiverId: ", activeReceiverId);
                // Ako je poruka za aktivnog korisnika – dodaj direktno u chat
                if (
                    message.user_id === activeReceiverId ||
                    message.receiver_id === activeReceiverId
                ) {
                    this.messages.push(message);
                    this.scrollToBottom();

                    fetch(`/messages/mark-as-read/${activeReceiverId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": window.csrfToken,
                        },
                    })
                        .then((res) => res.json())
                        .then(() => {
                            // Set the unread count to 0 for this user
                            if (this.unreadMap[activeReceiverId]) {
                                this.unreadMap[activeReceiverId] = 0;
                            }

                            this.updateUnreadTotal();
                        })
                        .catch((err) => {
                            console.error(
                                "Greška pri označavanju poruka kao pročitanih:",
                                err
                            );
                        });
                } else {
                    // Inače, povećaj broj nepročitanih i pokaži badge
                    const senderId = message.user_id;
                    if (this.unreadMap[senderId]) {
                        this.unreadMap[senderId]++;
                    } else {
                        this.unreadMap[senderId] = 1;
                    }

                    this.updateUnreadTotal();
                    // Emituj ka nav-baru ako koristiš globalni badge (npr. crveni broj u headeru)
                    emitter.emit("update-navbar-badge", this.unreadTotal);
                }
            })
            .error((error) => {
                console.error("❌ Greška:", error);
            });
    },
    beforeUnmount() {
        // Cleanup event listener
        emitter.off("reset-navbar-badge", this.resetUnreadTotal);
    },
};
</script>

<style>
.chat-box__contributor {
    background: #f5f8fa !important;
    height: 400px;
    overflow-y: auto;
    border: 1px solid #e4e6ef;
}

.user-card {
    background-color: transparent;
}

.user-card:hover {
    background-color: #f5f5f5;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.user-active {
    background: #f5f8fa !important;
}

.user-card__scroll {
    max-height: 300px;
    overflow-y: auto;
}

.p-22 {
    padding: 22px !important;
}

.btn-emojis {
    background: transparent;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    background: #f5f8fa;
    padding: 8px;
    border-radius: 10%;
}

.icon-img {
    position: absolute;
    left: 6px;
}

.icon-file {
    position: absolute;
    right: 3px;
}

.form-control-file {
    max-width: 150px;
}

.chat-message.sent {
    text-align: right;
}

.chat-message.sent p {
    background-color: #0d6efd;
    color: #fff;
}

.chat-message.received {
    text-align: left;
}

.bg-light {
    background-color: #e4e6ef !important;
    color: #000;
}

.chat-message p {
    display: inline-block;
    padding: 10px 15px;
    border-radius: 15px;
    max-width: 70%;
}

.message-info {
    position: absolute;
    bottom: 90px;
    left: 21px;
    background-color: #e4e6ef !important;
    padding: 10px 15px;
    border-radius: 15px;
}

.message-error {
    margin-top: 5px;
    color: red;
}
</style>
