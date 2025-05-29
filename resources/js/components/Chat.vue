<template>
    <div class="row">
        <div class="col-lg-5 mb-5">
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <form class="w-100 position-relative" autocomplete="off">
                        <i
                            class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"
                            ><span class="path1"></span
                            ><span class="path2"></span
                        ></i>
                        <input
                            type="text"
                            class="form-control form-control-solid pr-13"
                            name="search"
                            value=""
                            placeholder="Search by username or email..."
                        />
                    </form>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <!--begin::List-->
                    <div
                        class="scroll-y me-n5 h-200px h-lg-auto"
                        data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body"
                        data-kt-scroll-offset="5px"
                        style="max-height: 362px"
                    >
                        <div class="d-flex d-flex__column py-1">
                            <div v-if="isFreelancerChatRoute">
                                <div class="d-flex d-flex__column py-4">
                                    <div
                                        v-for="user in contributorData"
                                        class="d-flex flex-row align-items-center"
                                        :class="{
                                            'active-user':
                                                (selectedContributor &&
                                                    selectedContributor.user
                                                        .id === user.user.id) ||
                                                user.id,
                                        }"
                                        @click.prevent="selectContributor(user)"
                                    >
                                        <!--begin::Avatar-->
                                        <div
                                            class="symbol symbol-45px symbol-circle"
                                        >
                                            <img
                                                :src="
                                                    user.user.profile_image
                                                        ? getImageFileUrl(
                                                              user.user
                                                                  .profile_image
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
                                        <!--end::Avatar-->
                                        <div class="ms-5">
                                            <a
                                                href="#"
                                                :class="[
                                                    'fs-5 fw-bold text-gray-900 text-hover-primary mb-2',
                                                    selectedContributor?.user
                                                        ?.id === user?.user?.id,
                                                ]"
                                            >
                                                {{ user.user.first_name }}
                                                {{ user.user.last_name }}
                                            </a>

                                            <p>{{ user.user.email }}</p>
                                            <small><i>Contributor</i></small>
                                        </div>
                                        <span
                                            v-if="unreadMap[user.user.id]"
                                            class="badge badge-danger"
                                            >{{ unreadMap[user.user.id] }}</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div v-else class="d-flex d-flex__column py-4">
                                <div
                                    class="d-flex align-items-center user-card"
                                    :class="[
                                        selectedUser &&
                                        selectedUser.id === candidate.user.id
                                            ? 'active-user'
                                            : '',
                                    ]"
                                    v-if="candidate && candidate.user"
                                    @click.prevent="selectUser(candidate.user)"
                                >
                                    <div
                                        class="symbol symbol-45px symbol-circle pr-16"
                                    >
                                        <img
                                            :src="
                                                candidate.user.profile_image
                                                    ? getImageFileUrl(
                                                          candidate.user
                                                              .profile_image
                                                      )
                                                    : defaultImage
                                            "
                                            alt="Profile Image"
                                            class="img-fluid rounded-circle shadow-sm"
                                            style="width: 60px; height: 60px"
                                        />
                                    </div>
                                    <div class="">
                                        <a
                                            href="#"
                                            class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2"
                                        >
                                            {{ candidate.user.first_name }}
                                            {{ candidate.user.last_name }}
                                        </a>
                                        <p>{{ candidate.user.email }}</p>
                                        <small><i>Candidate</i></small>
                                    </div>
                                </div>
                                <!--begin::Details-->
                                <div
                                    class="d-flex align-items-center"
                                    v-for="user in sortedContributors"
                                    :key="user?.user?.id || user?.id"
                                >
                                    <!--begin::Avatar-->
                                    <div
                                        class="symbol symbol-45px symbol-circle"
                                    >
                                        <img
                                            :src="
                                                user.profile_image
                                                    ? getImageFileUrl(
                                                          user.profile_image
                                                      )
                                                    : defaultImage
                                            "
                                            alt="Profile Image"
                                            class="img-fluid rounded-circle shadow-sm"
                                            style="width: 60px; height: 60px"
                                        />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Details-->
                                    <div
                                        class="ms-5"
                                        @click.prevent="selectContributor(user)"
                                    >
                                        <a
                                            href="#"
                                            :class="[
                                                'fs-5 fw-bold text-gray-900 text-hover-primary mb-2',
                                                selectedContributor?.user
                                                    ?.id === user?.user?.id,
                                            ]"
                                        >
                                            {{ user.name }}
                                        </a>

                                        <p>{{ user.user.email }}</p>
                                        <small><i>Contributor</i></small>
                                    </div>
                                    <span
                                        v-if="unreadMap[user.user.id]"
                                        class="badge badge-danger"
                                        >{{ unreadMap[user.user.id] }}</span
                                    >
                                    <!--end::Details-->
                                </div>
                                <!--end::Details-->
                            </div>
                        </div>
                        <!--begin::Separator-->
                        <div class="separator separator-dashed d-none"></div>
                        <!--end::Separator-->
                    </div>
                    <!--end::List-->
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header">
                    <div v-if="isFreelancerChatRoute">
                        <h3 class="card-title">
                            Chat with
                            {{ chatTitle }}
                        </h3>
                    </div>
                    <div v-else-if="isRecruiterChatRoute">
                        <h3 class="card-title">
                            Chat with
                            {{ selectedContributor?.name || "Candidate" }}
                        </h3>
                    </div>
                    <div v-else>
                        <h3 class="card-title">
                            Chat with
                            {{
                                selectedContributor?.name ||
                                candidate?.user?.first_name +
                                    " " +
                                    candidate?.user?.last_name ||
                                "Candidate?"
                            }}
                        </h3>
                    </div>
                </div>
                <div
                    class="card-body chat-box chat-box__contributor"
                    id="chatBox"
                >
                    <div
                        v-for="msg in sortedMessages"
                        :key="msg.id"
                        :class="
                            msg.user_id === currentUserId
                                ? 'chat-message sent'
                                : 'chat-message received'
                        "
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
                </div>
                <div v-if="messages.length === 0">
                    <p class="message-info">
                        Start a conversation with user
                        {{ chatPlaceholderName }}
                        to begin your collaboration. Introduce yourself, share
                        your ideas, or ask any questions to get things moving
                    </p>
                </div>
            </div>
            <div class="card-footer">
                <form
                    id="chatForm"
                    @submit.prevent="handleSubmit"
                    enctype="multipart/form-data"
                >
                    <div class="d-flex align-items-center gap-2">
                        <input
                            type="text"
                            class="form-control form-control-solid pr-13"
                            name="input"
                            value=""
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
                            id="fileUpload"
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
</template>

<script>
import { EmojiButton } from "@joeattardi/emoji-button";
import userImage from "../../../public/images/user-286.png";
import emitter from "../eventBus";

export default {
    props: {
        contributors: Array,
        candidate: { type: Object, required: true },
        currentUserId: Number,
    },
    data() {
        return {
            selectedContributor: null,
            selectedUser: null,
            picker: null,
            message: "",
            file: "",
            messages: [],
            unreadMap: {},
            contributorData: [],
            messageError: "",
        };
    },
    computed: {
        currentPath() {
            return window.location.pathname;
        },
        isFreelancerChatRoute() {
            return this.currentPath === "/company/freelancer/chats";
        },
        isRecruiterChatRoute() {
            return this.currentPath === "/recruiter/chats";
        },
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
        chatTitle() {
            return (
                this.getUserFullName(this.selectedContributor?.user) ||
                this.getUserFullName(this.selectedUser) ||
                "Unknown User"
            );
        },
        chatPlaceholderName() {
            return (
                this.getUserFullName(this.selectedContributor?.user) ||
                this.selectedContributor?.name ||
                this.getUserFullName(this.selectedUser) ||
                this.getUserFullName(this.candidate?.user) ||
                "Unknown User"
            );
        },
        sortedContributors() {
            const lastUser = localStorage.getItem("lastChatUser");
            if (!lastUser) return this.contributors;

            const parsed = JSON.parse(lastUser);
            const sorted = [...this.contributors];
            const index = sorted.findIndex((c) => c.user?.id === parsed.id);

            if (index > -1) {
                const [last] = sorted.splice(index, 1);
                sorted.unshift(last);
            }
            return sorted;
        },
    },
    watch: {
        messages() {
            this.$nextTick(() => {
                const chatBox = document.getElementById("chatBox");
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
        getUserFullName(user) {
            return user
                ? `${user.first_name || ""} ${user.last_name || ""}`.trim()
                : "";
        },
        prepareContributors() {
            this.contributorData = this.contributors.map((c) => {
                const user = c.user ?? {};
                return {
                    original: c,
                    user: {
                        id: user.id ?? c.id,
                        first_name:
                            user.first_name ?? c.name?.split(" ")[0] ?? "N/A",
                        last_name:
                            user.last_name ?? c.name?.split(" ")[1] ?? "",
                        email: user.email ?? c.email,
                        profile_image: user.profile_image ?? null,
                    },
                };
            });
        },
        updateUnreadTotal() {
            this.unreadTotal = Object.values(this.unreadMap).reduce(
                (sum, count) => sum + count,
                0
            );
            emitter.emit("update-navbar-badge", this.unreadTotal);
        },
        markMessagesAsRead(userId) {
            fetch(`/api/messages/mark-as-read/${userId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken,
                },
            })
                .then((res) => res.json())
                .then(() => {
                    this.$set(this.unreadMap, userId, 0);
                    this.updateUnreadTotal();
                })
                .catch((err) =>
                    console.error("Error marking messages as read:", err)
                );
        },
        selectContributor(user) {
            this.selectedContributor = user;
            this.selectedUser = null;
            const id = user?.user?.id || user?.id;
            this.fetchMessages(id);
            localStorage.setItem("lastChatUser", JSON.stringify(user));
            this.markMessagesAsRead(id);
        },
        selectUser(user) {
            this.selectedUser = user;
            this.selectedContributor = null;
            this.fetchMessages(user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(user));
            this.markMessagesAsRead(user.id);
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
                this.file = null;
                return;
            }
            this.messageError = "";
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
            fetch(`/web/messages/${receiverId}`, {
                headers: {
                    "X-CSRF-TOKEN": window.csrfToken,
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    console.log("Chat: ", data);
                    this.messages = data.sort(
                        (a, b) =>
                            new Date(a.created_at) - new Date(b.created_at)
                    );
                    this.scrollToBottom();
                })
                .catch((err) => console.error("Error fetching messages:", err));
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
            }
        },
        handleSubmit() {
            if (!this.message.trim() && !this.file) {
                this.messageError = "Please enter a text or upload a file!";
                return;
            }

            const receiverId =
                this.selectedUser?.id ||
                this.selectedContributor?.user?.id ||
                this.selectedContributor?.id;
            if (!receiverId) {
                this.messageError = "The user is not selected.";
                return;
            }

            const formData = new FormData();
            formData.append("user_id", this.currentUserId);
            formData.append("text", this.message);
            formData.append("receiver_id", receiverId);
            if (this.file) formData.append("file", this.file);

            fetch("/web/messages", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": window.csrfToken },
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
                .catch((error) =>
                    console.error("Error sending message:", error)
                );
        },
        subscribeToWebSocket() {
            Echo.private(`chat.${this.currentUserId}`)
                .subscribed(() =>
                    console.log(`Subscribed to chat.${this.currentUserId}`)
                )
                .listen(".MessageSent", (payload) => {
                    const activeId =
                        this.selectedUser?.id ||
                        this.selectedContributor?.user?.id ||
                        this.selectedContributor?.id;

                    if (
                        payload.message &&
                        (payload.message.user_id === activeId ||
                            payload.message.receiver_id === activeId)
                    ) {
                        this.messages.push(payload.message);
                        this.scrollToBottom();
                        this.markMessagesAsRead(activeId);
                    } else {
                        this.unreadMap[payload.message.user_id] =
                            (this.unreadMap[payload.message.user_id] || 0) + 1;
                        this.updateUnreadTotal();
                        emitter.emit("update-navbar-badge", this.unreadTotal);
                    }
                })
                .error((error) => console.error("WebSocket error:", error));
        },
    },
    mounted() {
        this.prepareContributors();

        const lastUser = localStorage.getItem("lastChatUser");
        if (lastUser) {
            const parsed = JSON.parse(lastUser);
            this.selectedUser = parsed;
            this.fetchMessages(parsed.id);
        } else if (this.candidate?.user) {
            this.selectedUser = this.candidate.user;
            this.fetchMessages(this.candidate.user.id);
            localStorage.setItem(
                "lastChatUser",
                JSON.stringify(this.candidate.user)
            );
        } else if (this.contributorData.length > 0) {
            const first = this.contributorData[0];
            this.selectedContributor = first;
            this.selectedUser = first.user;
            this.fetchMessages(first.user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(first.user));
        }

        fetch("/api/messages/unread-count", {
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
            .catch((err) =>
                console.error("Error fetching unread counts:", err)
            );

        this.picker = new EmojiButton({ position: "top-end" });
        this.picker.on("emoji", (emoji) => {
            this.message += emoji.emoji;
        });

        this.subscribeToWebSocket();
    },
    beforeUnmount() {
        emitter.off("reset-navbar-badge", this.resetUnreadTotal);
    },
};
</script>

<style>
.active-user {
    background: #f5f8fa !important;
}

.p-22 {
    padding: 22px !important;
}

.pr-16 {
    padding-right: 16px;
}

.pr-13 {
    padding-right: 3.25rem !important;
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

.message-info {
    position: absolute;
    bottom: 90px;
    left: 21px;
    background-color: #e4e6ef !important;
    padding: 10px 15px;
    border-radius: 15px;
}

.card-footer {
    padding: 2rem 1rem !important;
}

.message-error {
    margin-top: 5px;
    color: red;
}
</style>
