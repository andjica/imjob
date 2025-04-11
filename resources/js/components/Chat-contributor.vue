<template>
    <div class="row">
        <div class="col-lg-6 mb-5">
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <form class="w-100 position-relative" autocomplete="off">
                        <i
                            class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"><span
                                class="path1"></span><span class="path2"></span></i>
                        <input type="text" class="form-control form-control-solid px-13" name="search" value=""
                            placeholder="Search by username or email..." />
                    </form>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <!--begin::Details-->
                    <div v-for="recruiter in recruiters" :key="recruiter.user_id">
                        <div v-if="recruiter && recruiter.user_id" class="d-flex align-items-center px-2 user-card"
                            @click.prevent="selectUser(recruiter.user)"
                            :class="{ 'user-active': selectedUser && selectedUser.id === recruiter.user_id }">
                            <div class="symbol symbol-45px symbol-circle">
                                <img :src="recruiter.profile_image ? recruiter.profile_image : defaultImage"
                                    alt="Profile Image" class="img-fluid rounded-circle shadow-sm"
                                    style="width: 60px; height: 60px;" />
                            </div>
                            <div class="ms-1">
                                <p class="fs-5 fw-bold text-gray-900 mb-2">{{ recruiter.user.first_name }} {{
                                    recruiter.user.last_name }}</p>
                                <p>{{ recruiter.user.email }}</p>
                                <small><i>
                                        {{ recruiter.is_freelancer === 0 ? 'Freelancer' : 'Recruiter' }}
                                    </i></small>
                            </div>
                        </div>
                        <div v-else>
                            <p class="text-danger">Missing user for recruiter ID: {{ recruiter.user_id }}</p>
                        </div>
                    </div>
                    <!--end::Details-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        Chat with
                        {{ selectedUser ? selectedUser.first_name : 'Select a user' }}
                    </h3>
                </div>
                <div class="card-body chat-box" id="chatBox">
                    <div v-for="msg in messages" :key="msg.id"
                        :class="msg.user_id === currentUserId ? 'chat-message sent' : 'chat-message received'">
                        <strong>{{ msg.user_id === currentUserId ? 'You' : 'Them' }}:</strong>
                        <p>{{ msg.text }}</p>
                        <small class="text-muted">{{ new Date(msg.created_at).toLocaleTimeString() }}</small>
                    </div>
                    <div v-if="messages.length === 0">
                        <p>No messages yet.</p>
                    </div>
                </div>
                <div class="card-footer">
                    <form id="chatForm">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-solid px-13" name="input" value=""
                                placeholder="Type your message..." v-model="message" />
                            <button class="btn-emojis" ref="emojiBtn" @click.prevent="toggleEmojiPicker">😀</button>
                            <button class="btn btn-primary" type="submit" @click.prevent="handleSubmit">Send</button>
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
        recruiters: {
            type: Array,
            required: true,
            default: () => [],
        },
        currentUserId: {
            type: Number,
            required: true,
        },
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
        }
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
                    "Accept": "application/json",
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
                const chatBox = document.getElementById("chatBox");
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
            if (this.message.trim() === "") {
                alert("Unesi poruku!");
                return;
            }

            const payload = {
                user_id: this.currentUserId,
                text: this.message,
                receiver_id: this.selectedUser.id,
                candidate_id: this.selectedUser.id,
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
                    this.messages.push(data.message);
                    this.message = "";
                    this.scrollToBottom();
                })
                .catch((error) => {
                    console.error("Greška pri slanju poruke:", error);
                });
        },
    },
    mounted() {
        this.picker = new EmojiButton({
            position: "top-end",
        });

        this.picker.on("emoji", (emoji) => {
            this.message += emoji.emoji;
        });

        const lastUser = localStorage.getItem("lastChatUser");
        if (lastUser) {
            const parsed = JSON.parse(lastUser);
            this.selectedUser = parsed;
            this.fetchMessages(parsed.id);
        }
    },
};
</script>

<style>
.user-card {
    background-color: transparent;
}

.user-card:hover {
    background-color: #f5f5f5;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.user-active {
    background: #e4e6ef !important;
}

.active-contributor {
    color: #e4e6ef !important;
}

.btn-emojis {
    background: transparent;
    border: none;
    position: absolute;
    right: 80px;
    top: 11px;
    z-index: 9999 !important;
}
</style>
