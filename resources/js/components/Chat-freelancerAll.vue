<template>
    <div class="row">
        <div class="col-lg-5 mb-5">
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header pt-7" id="kt_chat_contacts_header">
                    <!--begin::Form-->
                    <form class="w-100 position-relative" autocomplete="off">
                        <!--begin::Icon-->
                        <i
                            class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"><span
                                class="path1"></span><span class="path2"></span></i>
                        <!--end::Icon-->

                        <!--begin::Input-->
                        <input type="text" class="form-control form-control-solid px-13" name="search" value=""
                            placeholder="Search by username or email..." />
                        <!--end::Input-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <div class="scroll-y me-n5 pe-5 h-lg-auto" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body"
                        data-kt-scroll-offset="5px" style="max-height: 362px">
                        <!--begin::List of Users-->
                        <div class="d-flex d-flex__column py-1">
                            <!-- Kandidati -->
                            <div class="scroll-container candidates-scroll scroll-section">
                                <div v-for="user in candidatesList" :key="user.user?.id || user.user_id"
                                    class="d-flex flex-column align-items-center"
                                    @click.prevent="selectUser(user.user)">
                                    <div class="user__details" :class="{
                                        'user-active':
                                            selectedUser?.id ===
                                            user.user?.id,
                                    }">
                                        <div class="symbol symbol-45px symbol-circle">
                                            <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">
                                                {{
                                                    user.user?.first_name
                                                        ?.charAt(0)
                                                        .toUpperCase() || "?"
                                                }}
                                            </span>
                                        </div>

                                        <div class="ms-5">
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                {{ user.user?.first_name }}
                                                {{ user.user?.last_name }}
                                            </a>
                                            <p>{{ user.user?.email }}</p>
                                            <small><i>Candidate</i></small>
                                        </div>

                                        <span v-if="unreadMap[user.user?.id]" class="badge badge-danger">
                                            {{ unreadMap[user.user.id] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <!-- Kontributeri -->
                            <div class="scroll-container contributors-scroll scroll-section">
                                <div v-for="user in contributorsList" :key="user.user?.id || user.user_id"
                                    class="d-flex flex-column align-items-center"
                                    @click.prevent="selectContributor(user)">
                                    <div class="user__details" :class="{
                                        'user-active':
                                            selectedContributor?.user
                                                ?.id === user.user?.id,
                                    }">
                                        <div class="symbol symbol-45px symbol-circle">
                                            <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">
                                                {{
                                                    user.user?.first_name
                                                        ?.charAt(0)
                                                        .toUpperCase() || "?"
                                                }}
                                            </span>
                                        </div>

                                        <div class="ms-5">
                                            <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                                {{ user.user?.first_name }}
                                                {{ user.user?.last_name }}
                                            </a>
                                            <p>{{ user.user?.email }}</p>
                                            <small><i>Contributor</i></small>
                                        </div>

                                        <span v-if="unreadMap[user.user?.id]" class="badge badge-danger">
                                            {{ unreadMap[user.user.id] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::List of Users-->
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
                                candidates?.user?.first_name +
                                " " +
                                candidates?.user?.last_name ||
                                "Candidate?"
                            }}
                        </h3>
                    </div>
                </div>
                <div class="card-body chat-box chat-box__contributor" id="chatBox-freelancerAll">
                    <div v-for="msg in messages" :key="msg.id" :class="msg.user_id === currentUserId
                        ? 'chat-message sent'
                        : 'chat-message received'
                        ">
                        <p>{{ msg.text }}</p>
                        <br />
                        <small class="text-muted">{{
                            new Date(msg.created_at).toLocaleTimeString()
                        }}</small>
                    </div>
                    <div v-if="messages.length === 0">
                        <p class="message-info">
                            Start a conversation with user
                            {{ chatPlaceholderName }}
                            to begin your collaboration. Introduce yourself,
                            share your ideas, or ask any questions to get things
                            moving
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <form id="chatForm" @submit.prevent="handleSubmit" enctype="multipart/form-data">
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" class="form-control form-control-solid px-13" name="input"
                                placeholder="Type your message..." v-model="message"
                                @keydown.enter.prevent="handleSubmit" />
                            <button type="button" class="btn btn-light position-relative p-22"
                                @click="triggerFileInput">
                                <i class="fa-solid fa-image icon-img"></i>
                                <i class="fa-solid fa-file icon-file"></i>
                            </button>
                            <input type="file" id="fileUpload-freelancer" ref="fileInput" @change="handleFileChange"
                                accept="image/*,.pdf,.doc,.docx" class="d-none" />
                            <button class="btn-emojis" ref="emojiBtn" @click.prevent="toggleEmojiPicker">
                                😀
                            </button>

                            <button class="btn btn-primary" type="submit">
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
import userImage from "../../../public/images/user-286.png";
import emitter from "../eventBus";

export default {
    props: {
        contributors: Array,
        candidates: Array,
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
            candidateData: [],
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
        chatTitle() {
            if (this.selectedContributor?.user) {
                return `${this.selectedContributor.user.first_name} ${this.selectedContributor.user.last_name}`;
            } else if (this.selectedUser) {
                return `${this.selectedUser.first_name} ${this.selectedUser.last_name}`;
            }
            return "Unknown";
        },
        chatPlaceholderName() {
            if (
                this.selectedContributor?.user?.first_name ||
                this.selectedContributor?.user?.last_name
            ) {
                return `${this.selectedContributor.user.first_name || ""} ${this.selectedContributor.user.last_name || ""
                    }`.trim();
            }
            if (this.selectedContributor?.name) {
                return this.selectedContributor.name;
            }
            if (this.selectedUser?.first_name || this.selectedUser?.last_name) {
                return `${this.selectedUser.first_name || ""} ${this.selectedUser.last_name || ""
                    }`.trim();
            }
            if (
                this.candidates?.user?.first_name ||
                this.candidates?.user?.last_name
            ) {
                return `${this.candidates.user.first_name || ""} ${this.candidates.user.last_name || ""
                    }`.trim();
            }
            return "Unknown User";
        },
        sortedCandidates() {
            const lastUser = localStorage.getItem("lastChatUser");
            if (!lastUser) return this.candidates;

            const parsed = JSON.parse(lastUser);
            const sorted = [...this.candidates];

            // Nađi indeks kandidata sa istim ID-em
            const index = sorted.findIndex((c) => {
                const id = c.user?.id ?? c.id;
                return id === parsed.id;
            });

            if (index > -1) {
                const [last] = sorted.splice(index, 1);
                sorted.unshift(last);
            }

            return sorted;
        },
        sortedContributors() {
            const lastUser = localStorage.getItem("lastChatUser");
            if (!lastUser) return this.contributors;

            const parsed = JSON.parse(lastUser);
            const sorted = [...this.contributors];

            // Prvo nađi indeks poslednjeg
            const index = sorted.findIndex((c) => c.user?.id === parsed.id);
            if (index > -1) {
                const [last] = sorted.splice(index, 1);
                sorted.unshift(last); // Stavi ga na početak
            }

            return sorted;
        },
        candidatesList() {
            return (Array.isArray(this.candidateData) ? this.candidateData : [])
                .map((c) => ({
                    ...c,
                    id: c.user?.id ?? c.id,
                    userType: "candidate",
                }))
                .sort((a, b) => {
                    const timeA = new Date(a.last_message_at || 0).getTime();
                    const timeB = new Date(b.last_message_at || 0).getTime();
                    console.log(a.id, timeA, b.id, timeB);
                    return timeB - timeA;
                });

        },
        contributorsList() {
            return (
                Array.isArray(this.contributorData) ? this.contributorData : []
            )
                .map((c) => ({
                    ...c,
                    userType: "contributor",
                }))
                .sort((a, b) => {
                    const timeA = new Date(a.last_message_at || 0);
                    const timeB = new Date(b.last_message_at || 0);
                    return timeB - timeA;
                });
        },
    },
    methods: {
        updateLastMessageTime(userId, timestamp) {
            const updateUser = (arr) => {
                const index = arr.findIndex((u) => {
                    const id = u.user?.id || u.id;
                    return id === userId;
                });
                if (index !== -1) {
                    arr[index].last_message_at = timestamp;
                }
            };

            if (Array.isArray(this.candidateData)) {
                updateUser(this.candidateData);
            }

            if (Array.isArray(this.contributorData)) {
                updateUser(this.contributorData);
            }
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
        selectContributor(user) {
            this.selectedContributor = user;
            this.selectedUser = null;

            const fetchContributorId =
                this.selectedContributor?.user?.id ||
                this.selectedContributor?.id;

            this.fetchMessages(fetchContributorId);

            localStorage.setItem("lastChatUser", JSON.stringify(user));
            fetch(`/api/messages/mark-as-read/${fetchContributorId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken,
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    console.log(data.upit); // Set the unread count to 0 for this user
                    if (this.unreadMap[this.selectedContributor.user.id]) {
                        this.unreadMap[this.selectedContributor.user.id] = 0;
                    }

                    this.updateUnreadTotal();
                })
                .catch((err) => {
                    console.error(
                        "Greška pri označavanju poruka kao pročitanih CONTRIBUTOR:",
                        err
                    );
                });
        },
        selectUser(user) {
            this.selectedUser = user;
            this.selectedContributor = null;
            this.fetchMessages(user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(user));

            // Koristimo selectedUser.id umesto selectedContributor.id
            fetch(`/api/messages/mark-as-read/${this.selectedUser.id}`, {
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
                        "Greška pri označavanju poruka kao pročitanih USER:",
                        err
                    );
                });
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file && file.size > 5 * 1024 * 1024) {
                alert("File must be less than 5MB.");
                this.$refs.fileInput.value = "";
                this.file = null;
                return;
            }
            this.file = file;
        },
        fetchMessages(receiverId) {
            if (!receiverId) return;
            console.log("Ko je primio poruke: ", receiverId);
            fetch(`/web/messages/${receiverId}`, {
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": window.csrfToken,
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    console.log("Received DATA: ", data);
                    this.messages = data;
                    this.scrollToBottom();
                })
                .catch((err) => {
                    console.error("Greška pri dohvatanju poruka:", err);
                });
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const chatBox = document.getElementById(
                    "chatBox-freelancerAll"
                );
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
                return alert("Please enter a text or select a file!");
            }

            const receiverId =
                this.selectedUser?.id ||
                this.selectedContributor?.user?.id ||
                this.selectedContributor?.id;
            if (!receiverId) {
                alert("The user is not selected.");
                return;
            }

            const formData = new FormData();

            formData.append("user_id", this.currentUserId);
            formData.append("text", this.message);
            formData.append("receiver_id", receiverId);
            if (this.file) {
                formData.append("file", this.file);
            }

            console.log("Form data sadrži:");
            for (let [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }

            fetch("/web/messages", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": window.csrfToken,
                },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    console.log("Send message: ", data);
                    this.message = "";
                    this.file = null;
                    this.messages.push(data.message);
                    if (this.$refs.fileInput) {
                        this.$refs.fileInput.value = "";
                    }

                    this.scrollToBottom();
                })
                .catch((error) => {
                    console.error("Greška pri slanju poruke:", error);
                });
        },
        selectFirstCandidat() {
            if (this.candidatesList.length > 0) {
                const firstCandidate = this.candidatesList[0];

                this.selectedUser = firstCandidate;
                this.selectedContributor = null;

                this.fetchMessages(firstCandidate.id);

                localStorage.setItem(
                    "lastChatUser",
                    JSON.stringify(firstCandidate)
                );
            } else {
                console.warn("Nema dostupnih kandidata.");
            }
        },

    },
    mounted() {
        console.log("Kontributeri: ", this.contributors);
        console.log("Kandidati: ", this.candidates);
        this.$nextTick(() => {
            emitter.emit("reset-navbar-badge");
        });

        // Dohvati nepročitane poruke po korisniku
        fetch("/api/messages/unread-count", {
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
        } else if (this.candidateData.length > 0) {
            const firstCandidate = this.candidateData[0];
            this.selectedUser = firstCandidate;
            this.fetchMessages(firstCandidate.id);
            localStorage.setItem(
                "lastChatUser",
                JSON.stringify(firstCandidate)
            );
        } else if (this.contributorData.length > 0) {
            const firstContributor = this.contributorData[0];
            this.selectedContributor = firstContributor;
            this.selectedUser = firstContributor.user;
            this.fetchMessages(firstContributor.user.id);
            localStorage.setItem(
                "lastChatUser",
                JSON.stringify(firstContributor.user)
            );
        }
        this.prepareContributors();

        this.candidateData = Array.isArray(this.candidates)
            ? this.candidates.map(c => ({ ...c }))
            : [];


        Echo.private(`chat.${this.currentUserId}`)
            .subscribed(() => {
                console.log(
                    "✅ Subscribed na kanal: chat." + this.currentUserId
                );
            })
            .listen(".MessageSent", (payload) => {
                console.log("📡 WebSocket primio:", payload);

                const activeReceiverId =
                    this.selectedUser?.id ||
                    this.selectedContributor?.user?.id ||
                    this.selectedContributor?.id;
                console.log("Active id: ", activeReceiverId);

                // Funkcija za update last_message_at na odgovarajućem korisniku
                const updateUserLastMessage = (userId) => {
                    // Traži u contributorData
                    const contributor = this.contributorData.find(
                        (c) => c.user.id === userId
                    );
                    if (contributor) {
                        contributor.last_message_at =
                            payload.message.created_at;
                        return;
                    }

                    // Ako candidates je niz, traži tamo
                    // Ako candidates je niz, traži tamo
                    const candidateIndex = this.candidateData.findIndex((c) => c.id === userId);
                    if (candidateIndex !== -1) {
                        this.$set(
                            this.candidateData[candidateIndex],
                            'last_message_at',
                            payload.message.created_at
                        );

                        // Move the updated candidate to the top
                        const updatedCandidate = this.candidateData.splice(candidateIndex, 1)[0];
                        this.candidateData.unshift(updatedCandidate);
                    }
                };

                // Ažuriraj vreme poslednje poruke za pošiljaoca i primaoca
                updateUserLastMessage(payload.message.user_id);
                updateUserLastMessage(payload.message.receiver_id);

                // Proveri da li je poruka za trenutno aktivnog korisnika
                if (
                    payload.message &&
                    (payload.message.user_id === activeReceiverId ||
                        payload.message.receiver_id === activeReceiverId)
                ) {
                    this.messages.push(payload.message);
                    this.scrollToBottom();

                    fetch(`/api/messages/mark-as-read/${activeReceiverId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": window.csrfToken,
                        },
                    })
                        .then((res) => res.json())
                        .then(() => {
                            // Set the unread count to 0 for this user
                            if (this.unreadMap[this.selectedUser?.id]) {
                                this.unreadMap[this.selectedUser?.id] = 0;
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
                    // Poruka nije za selektovanog korisnika, povećaj broj nepročitanih
                    if (this.unreadMap[payload.message.user_id]) {
                        this.unreadMap[payload.message.user_id]++;
                    } else {
                        this.unreadMap[payload.message.user_id] = 1;
                    }

                    this.updateUnreadTotal();

                    // Emituj ka nav-baru za globalni badge
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
.user-active {
    background: #f5f8fa !important;
}

.user__details {
    display: flex;
    justify-content: flex-start;
    width: 100%;
}

.active-contributor {
    background: #f5f8fa !important;
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

.message-info {
    position: absolute;
    bottom: 90px;
    left: 21px;
    background-color: #e4e6ef !important;
    padding: 10px 15px;
    border-radius: 15px;
}

.scroll-section {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #eee;
    margin-bottom: 1rem;
    padding: 0.5rem;
}

.badge-danger {
    height: 20px;
}
</style>
