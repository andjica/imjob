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
                        <div class="d-flex d-flex__column py-4">
                            <div
                                v-for="recruiter in uniqueRecruiters"
                                :key="recruiter.user_id"
                            >
                                <div
                                    v-if="recruiter && recruiter.user_id"
                                    class="d-flex align-items-center px-2 user-card"
                                    @click.prevent="selectUser(recruiter.user)"
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
                                                    ? recruiter.profile_image
                                                    : defaultImage
                                            "
                                            alt="Profile Image"
                                            class="img-fluid rounded-circle shadow-sm"
                                            style="width: 60px; height: 60px"
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
                                        <small
                                            ><i>{{
                                                recruiter.is_freelancer === 0
                                                    ? "Freelancer"
                                                    : "Recruiter"
                                            }}</i></small
                                        >
                                    </div>
                                </div>
                                <div v-else>
                                    <p class="text-danger">
                                        Missing user for recruiter ID:
                                        {{ recruiter.user_id }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-flush h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        Chat with
                        {{
                            selectedUser
                                ? selectedUser.first_name + " " + selectedUser.last_name
                                : "Select a user"
                        }}
                    </h3>
                </div>
                <div
                    class="card-body chat-box chat-box__contributor"
                    id="chatBox__contributor"
                >
                    <div
                        v-for="msg in messages"
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
                            <p
                                :class="
                                    msg.user_id === currentUserId
                                        ? 'p-3 rounded bg-primary text-white d-inline-block'
                                        : 'p-3 rounded bg-light text-dark d-inline-block'
                                "
                            >
                                {{ msg.text }}
                            </p>
                            <div class="mt-1">
                                <small class="text-muted">{{
                                    new Date(
                                        msg.created_at
                                    ).toLocaleTimeString()
                                }}</small>
                            </div>
                        </div>
                    </div>
                    <div v-if="messages.length === 0">
                        <p class="message-info">Start a conversation with user {{ selectedUser?.first_name + " " + selectedUser?.last_name }} to begin your collaboration. Introduce yourself, share your ideas, or ask any questions to get things moving</p>
                    </div>
                </div>
                <div class="card-footer border-top pt-4">
                    <form id="chatForm">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control form-control-solid px-13"
                                name="input"
                                placeholder="Type your message..."
                                v-model="message"
                            />
                            <button
                                class="btn-emojis"
                                ref="emojiBtn"
                                @click.prevent="toggleEmojiPicker"
                            >
                                😀
                            </button>
                            <button
                                class="btn btn-primary"
                                type="submit"
                                @click.prevent="handleSubmit"
                            >
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { EmojiButton } from "@joeattardi/emoji-button";
import userImage from '../../../public/images/user-286.png';

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
            messages: [],
        };
    },
    computed: {
              defaultImage() {
        return userImage;
      },
        uniqueRecruiters() {
            const seen = new Set();
            return this.recruiters.filter((r) => {
                if (seen.has(r.user_id)) return false;
                seen.add(r.user_id);
                return true;
            });
        },
    },
    methods: {
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
        },
        fetchMessages(receiverId) {
            if (!receiverId) return;

            fetch(`/web/messages/${receiverId}`, {
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
            if (this.message.trim() === "") return alert("Unesi poruku!");

            const receiverId =
                this.selectedUser?.id || this.selectedRecruiter?.user?.id;
            if (!receiverId)
                return alert("Nije odabran korisnik za slanje poruke.");

            const payload = {
                user_id: this.currentUserId,
                text: this.message,
                receiver_id: receiverId,
                candidate_id: this.selectedUser?.id || 0,
            };

            fetch("/web/messages", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken,
                },
                body: JSON.stringify(payload),
            })
                .then((res) => res.json())
                .then((data) => {
                    this.message = "";
                })
                .catch((error) => {
                    console.error("Greška pri slanju poruke:", error);
                });
        },
    },
    mounted() {
        this.picker = new EmojiButton({ position: "top-end" });

        if (this.picker) {
            this.picker.on("emoji", (emoji) => {
                this.message += emoji.emoji;
            });
        } else {
            console.warn("Emoji picker failed to initialize.");
        }

        const lastUser = localStorage.getItem("lastChatUser");

        if (lastUser) {
            const parsed = JSON.parse(lastUser);
            this.selectedUser = parsed;
            this.fetchMessages(parsed.id);
        }

        Echo.private("chat." + this.currentUserId)
            .subscribed(() => {
                console.log(
                    "✅ Subscribed na kanal: chat." + this.currentUserId
                );
            })
            .listen(".MessageSent", (payload) => {
                console.log("📡 WebSocket primio:", payload);
                
                const message = payload.message;
                const activeReceiverId =
                    this.selectedUser?.id || this.selectedRecruiter?.user?.id;

                if (
                    message.user_id === activeReceiverId ||
                    message.receiver_id === activeReceiverId
                ) {
                    this.messages.push(message);
                    this.scrollToBottom();
                }
            });
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

.btn-emojis {
    background: transparent;
    border: none;
    position: absolute;
    right: 80px;
    top: 11px;
    z-index: 9999 !important;
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

.chat-message.received p {
    background-color: #E4E6EF!important;
    color: #000;
}

.chat-message p {
    display: inline-block;
    padding: 10px 15px;
    border-radius: 15px;
    max-width: 70%;
}
.message-info{
    position: absolute;
    bottom: 90px;
    left: 21px;
    background-color: #E4E6EF!important;
    padding: 10px 15px;
    border-radius: 15px;
}
</style>
