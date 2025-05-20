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
                    <!--begin::List-->
                    <div class="scroll-y me-n5 pe-5 h-lg-auto" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
                        data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body"
                        data-kt-scroll-offset="5px" style="max-height: 362px">
                        <!--end::User-->
                        <!-- Add a condition to check in witch route, user is -->
                            <div class="d-flex d-flex__column py-4">
                                <div v-for="user in contributorData" class="d-flex flex-row align-items-center" :class="{
                                    'user-active':
                                        selectedContributor &&
                                        selectedContributor.user.id ===
                                        user.user.id || user.id,
                                }">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-45px symbol-circle">
                                        <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">{{
                                            user.user.first_name
                                                .charAt(0)
                                                .toUpperCase()
                                        }}</span>
                                    </div>
                                    <!--end::Avatar-->
                                    <div class="ms-5">
                                        <a @click.prevent="
                                            selectContributor(user)
                                            " href="#" :class="[
                                                'fs-5 fw-bold text-gray-900 text-hover-primary mb-2',
                                                selectedContributor?.user
                                                    ?.id === user?.user?.id,
                                            ]">
                                            {{ user.user.first_name }}
                                            {{ user.user.last_name }}
                                        </a>

                                        <p>{{ user.user.email }}</p>
                                        <small><i>Contributor</i></small>
                                    </div>
                                    <span v-if="unreadMap[user.user.id]" class="badge badge-danger">{{
                                        unreadMap[user.user.id]
                                        }}</span>
                                </div>
                            </div>
                        </div>

                            <div class="d-flex d-flex__column py-4">
                                <div v-for="candidate in candidates" class="d-flex align-items-center px-2 user-card" :class="[
                                    selectedUser &&
                                        selectedUser.id === candidate.user.id
                                        ? 'user-active'
                                        : '',
                                ]" @click.prevent="
                                            selectUser(candidate.user)
                                            ">
                                    <div class="symbol symbol-45px symbol-circle">
                                        <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">{{
                                            candidate.user.first_name
                                                .charAt(0)
                                                .toUpperCase()
                                        }}</span>
                                    </div>
                                    <div class="ms-5">
                                        <a  href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                                            {{ candidate.user.first_name }}
                                            {{ candidate.user.last_name }}
                                        </a>

                                        <p>{{ candidate.user.email }}</p>
                                        <small><i>Candidate</i></small>
                                    </div>
                                </div>
                                <!--begin::Details-->
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
                            {{
                                chatTitle
                            }}
                        </h3>
                    </div>
                    <div v-else-if="isRecruiterChatRoute">
                        <h3 class="card-title">
                            Chat with
                            {{
                                selectedContributor?.name || "Candidate"
                            }}
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
                <div class="card-body chat-box chat-box__contributor" id="chatBox">
                   
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
                            {{
                                chatPlaceholderName
                            }}
                            to begin your collaboration. Introduce yourself,
                            share your ideas, or ask any questions to get things
                            moving
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <form id="chatForm" @submit.prevent="handleSubmit" enctype="multipart/form-data">
                        <div class="d-flex align-items-center gap-2" >
                                <input type="text" class="form-control form-control-solid px-13" name="input"
                                placeholder="Type your message..." v-model="message" @keydown.enter.prevent="handleSubmit" />
                                <button type="button" class="btn btn-light position-relative p-22" @click="triggerFileInput">
                                <i class="fa-solid fa-image icon-img"></i>
                                <i class="fa-solid fa-file icon-file"></i>
                            </button>
                            <input
                                type="file"
                                id="fileUpload-recruiter"
                                ref="fileInput"
                                @change="handleFileChange"
                                 accept="image/*,.pdf,.doc,.docx"
                                class="d-none"
                            />    
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
        candidates: {
            type: Object,
            required: true,
        },
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
        };
    },
    computed: {
        currentPath() {
            return window.location.pathname;
        },
        isFreelancerChatRoute() {
            return this.currentPath === '/company/freelancer/chats';
        },
        isRecruiterChatRoute() {
            return this.currentPath === '/recruiter/chats';
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
            if (this.selectedContributor?.user?.first_name || this.selectedContributor?.user?.last_name) {
                return `${this.selectedContributor.user.first_name || ''} ${this.selectedContributor.user.last_name || ''}`.trim();
            }
            if (this.selectedContributor?.name) {
                return this.selectedContributor.name;
            }
            if (this.selectedUser?.first_name || this.selectedUser?.last_name) {
                return `${this.selectedUser.first_name || ''} ${this.selectedUser.last_name || ''}`.trim();
            }
            if (this.candidates?.user?.first_name || this.candidates?.user?.last_name) {
                return `${this.candidates.user.first_name || ''} ${this.candidates.user.last_name || ''}`.trim();
            }
            return "Unknown User";
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
    },
    methods: {
        prepareContributors() {
            this.contributorData = this.contributors.map((c) => {
                const user = c.user ?? {};
                return {
                    original: c,
                    user: {
                        id: user.id ?? c.id,
                        first_name: user.first_name ?? c.name?.split(" ")[0] ?? "N/A",
                        last_name: user.last_name ?? c.name?.split(" ")[1] ?? "",
                        email: user.email ?? c.email,
                        profile_image: user.profile_image ?? null,
                    }
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
            console.log("selectContributor: ", user);
            this.selectedContributor = user;
            this.selectedUser = null;
            const fetchContributorId = this.selectedContributor?.user?.id || this.selectedContributor?.id;
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
                .then(() => {
                    // Set the unread count to 0 for this user
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
                    console.log("Received: ", data);
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
                alert("Please enter a text!");
                return;
            }

            const receiverId =
                this.selectedUser?.id || this.selectedContributor?.user?.id || this.selectedContributor?.id;
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
        selectFirstContributor() {
            if (this.contributors && this.contributors.length > 0) {
                const firstContributor = this.contributors[0];

                // Ako kontributor ima user, selektuj usera, inače samo kontributer
                if (firstContributor.user) {
                    this.selectedUser = firstContributor.user;
                } else {
                    this.selectedUser = null; // Ako nema usera
                }

                // Uvek postavi firstContributor kao selectedContributor
                this.selectedContributor = firstContributor;

                // Pošaljemo zahtev za poruke (koristi user.id ako postoji)
                this.fetchMessages(firstContributor.user?.id || firstContributor.id);

                // Spremi korisnika u localStorage (ako postoji user, spasavaj tog user-a)
                localStorage.setItem("lastChatUser", JSON.stringify(firstContributor.user || firstContributor));
            } else {
                console.warn("Nema dostupnih kontributera.");
            }
        },
    },
    mounted() {
        // da napravim upit da se proveri u contributeru da li postoji objekat user ako da prosledi se njegovi podaci ako ne onda se prosledi
        if (this.contributors && this.contributors.length > 0) {
            this.selectFirstContributor();
        }

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
        } else if (this.candidates && this.candidates.user) {
            this.selectedUser = this.candidates.user;
            this.fetchMessages(this.candidates.user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(this.candidates.user));
        } else if (this.contributorData.length > 0) {
            // automatski selektuj prvog iz contributorData
            const firstContributor = this.contributorData[0];
            this.selectedContributor = firstContributor;
            this.selectedUser = firstContributor.user;
            this.fetchMessages(firstContributor.user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(first.user));
        }
        this.prepareContributors();

        Echo.private(`chat.${this.currentUserId}`)
            .subscribed(() => {
                console.log("✅ Subscribed na kanal: chat." + this.currentUserId);
            })
            .listen(".MessageSent", (payload) => {
                console.log("📡 WebSocket primio:", payload);

                const activeReceiverId =
                    this.selectedUser?.id || this.selectedContributor?.user?.id || this.selectedContributor?.id;
                console.log("Active id: ", activeReceiverId);

                // Proverite da li je poruka od korisnika sa selektovanim ID-jem
                if (
                    payload.message &&
                    (payload.message.user_id === activeReceiverId || payload.message.receiver_id === activeReceiverId)
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
                            console.error("Greška pri označavanju poruka kao pročitanih:", err);
                        });
                } else {
                    // Ako poruka nije za selektovanog korisnika, povećajte broj nepročitanih poruka
                    if (this.unreadMap[payload.message.user_id]) {
                        this.unreadMap[payload.message.user_id]++;
                    } else {
                        this.unreadMap[payload.message.user_id] = 1;
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
.user-active {
    background: #f5f8fa !important;
}

.active-contributor {
    background: #f5f8fa !important;
}

.p-22 {
    padding: 22px!important;
}
.btn-emojis {
    background: transparent;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    background: #F5F8FA;
    padding: 8px;
    border-radius: 10%;
}

.icon-img{
    position: absolute;
    left: 6px;
}
.icon-file{
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
</style>
