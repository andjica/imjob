<template>
  <div class="row">
    <div class="col-lg-5 mb-5">
      <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header pt-7" id="kt_chat_contacts_header">
          <!--begin::Form-->
          <form class="w-100 position-relative" autocomplete="off">
            <i
              class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"
            >
              <span class="path1"></span><span class="path2"></span>
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

        <!--begin::Card body-->
        <div class="card-body pt-5" id="kt_chat_contacts_body">
          <div
            class="scroll-y me-n5 pe-5 h-lg-auto"
            data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}"
            data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header"
            data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body"
            data-kt-scroll-offset="5px"
            style="max-height: 362px"
          >
            <div class="d-flex d-flex__column py-1">
              <!-- Kandidati -->
              <div class="scroll-container candidates-scroll scroll-section">
                <div
                  v-for="user in candidatesList"
                  :key="user.user?.id || user.id"
                  class="d-flex flex-column align-items-center"
                  @click.prevent="selectUser(user.user)"
                >
                  <div
                    class="user__details"
                    :class="{
                      'user-active': selectedUser?.id === user.user?.id,
                    }"
                  >
                    <div class="symbol symbol-45px symbol-circle">
                      <img
                        :src="user.profile_image ? getImageFileUrl(user.profile_image) : defaultImage"
                        alt="Profile Image"
                        class="img-fluid rounded-circle shadow-sm"
                        style="width: 60px; height: 60px"
                      />
                    </div>
                    <div class="ms-5">
                      <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                        {{ user.user?.first_name }} {{ user.user?.last_name }}
                      </a>
                      <p>{{ user.user?.email }}</p>
                      <small><i>Candidate</i></small>
                    </div>
                    <span
                      v-if="unreadMap[user.user?.id]"
                      class="badge badge-danger"
                    >
                      {{ unreadMap[user.user.id] }}
                    </span>
                  </div>
                </div>
              </div>

              <hr class="hr_custome" />

              <!-- Kontributeri -->
              <div class="scroll-container contributors-scroll scroll-section">
                <div
                  v-for="user in contributorsList"
                  :key="user.user?.id || user.id"
                  class="d-flex flex-column align-items-center"
                  @click.prevent="selectContributor(user)"
                >
                  <div
                    class="user__details"
                    :class="{
                      'user-active': selectedContributor?.user?.id === user.user?.id,
                    }"
                  >
                    <div class="symbol symbol-45px symbol-circle">
                      <img
                        :src="user.user.profile_image ? getImageFileUrl(user.user.profile_image) : defaultImage"
                        alt="Profile Image"
                        class="img-fluid rounded-circle shadow-sm"
                        style="width: 60px; height: 60px"
                      />
                    </div>
                    <div class="ms-5">
                      <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">
                        {{ user.user?.first_name }} {{ user.user?.last_name }}
                      </a>
                      <p>{{ user.user?.email }}</p>
                      <small><i>Contributor</i></small>
                    </div>
                    <span
                      v-if="unreadMap[user.user?.id]"
                      class="badge badge-danger"
                    >
                      {{ unreadMap[user.user.id] }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end::List of Users-->
        </div>
      </div>
    </div>

    <!-- Chat Box -->
    <div class="col-lg-7">
      <div class="card h-100">
        <div class="card-header">
          <h3 class="card-title">
            Chat with
            {{
              selectedContributor?.user?.first_name + ' ' +
              selectedContributor?.user?.last_name || "Candidate"
            }}
          </h3>
        </div>

        <div
          class="card-body chat-box chat-box__contributor"
          id="chatBox__freelancerAll"
        >
          <div
            v-for="msg in sortedMessages"
            :key="msg.id"
            :class="['chat-message', msg.user_id === currentUserId ? 'sent' : 'received']"
          >
            <div :class="msg.user_id === currentUserId ? 'text-end' : 'text-start'">
              <!-- Message text -->
              <div
                :class="msg.user_id === currentUserId
                  ? 'p-3 rounded bg-primary text-white d-inline-block'
                  : 'p-3 rounded bg-light text-dark d-inline-block'"
                v-if="msg.text"
              >
                {{ msg.text }}
              </div>

              <!-- File -->
              <div v-if="msg.file_path" style="margin-top: 10px">
                <div v-if="getFileDisplayType(msg.file_type) === 'image'">
                  <img :src="getImageFileUrl(msg.file_path)" alt="image" style="max-width: 200px" />
                </div>
                <div v-else-if="getFileDisplayType(msg.file_type) === 'pdf'">
                  <a
                    :class="msg.user_id === currentUserId
                      ? 'p-3 rounded bg-primary text-white d-inline-block'
                      : 'p-3 rounded bg-light text-dark d-inline-block'"
                    :href="getImageFileUrl(msg.file_path)"
                    target="_blank"
                  >
                    📄 View PDF
                  </a>
                </div>
                <div v-else-if="getFileDisplayType(msg.file_type) === 'word'">
                  <a
                    :class="msg.user_id === currentUserId
                      ? 'p-3 rounded bg-primary text-white d-inline-block'
                      : 'p-3 rounded bg-light text-dark d-inline-block'"
                    :href="getImageFileUrl(msg.file_path)"
                    target="_blank"
                  >
                    📎 Word Document
                  </a>
                </div>
                <div v-else>
                  <a
                    :class="msg.user_id === currentUserId
                      ? 'p-3 rounded bg-primary text-white d-inline-block'
                      : 'p-3 rounded bg-light text-dark d-inline-block'"
                    :href="getImageFileUrl(msg.file_path)"
                    target="_blank"
                  >
                    📁 Download file
                  </a>
                </div>
              </div>

              <!-- Time -->
              <div class="mt-1">
                <small class="text-muted">
                  {{ new Date(msg.created_at).toLocaleTimeString() }}
                </small>
              </div>
            </div>
          </div>

          <div v-if="messages.length === 0">
            <p class="message-info">
              Start a conversation with user {{ chatPlaceholderName }} to begin
              your collaboration. Introduce yourself, share your ideas, or ask any
              questions to get things moving.
            </p>
          </div>
        </div>

        <!-- Footer -->
        <div class="card-footer">
          <form id="chatForm" @submit.prevent="handleSubmit" enctype="multipart/form-data">
            <div class="d-flex align-items-center gap-2">
              <input
                type="text"
                class="form-control form-control-solid px-13"
                name="input"
                placeholder="Type your message..."
                v-model="message"
                @keydown.enter.prevent="handleSubmit"
              />
              <button type="button" class="btn btn-light position-relative p-22" @click="triggerFileInput">
                <i class="fa-solid fa-image icon-img"></i>
                <i class="fa-solid fa-file icon-file"></i>
              </button>
              <input
                type="file"
                id="fileUpload-freelancer"
                ref="fileInput"
                @change="handleFileChange"
                accept="image/*,.pdf,.doc,.docx"
                class="d-none"
              />
              <button class="btn-emojis" ref="emojiBtn" @click.prevent="toggleEmojiPicker">😀</button>
              <button class="btn btn-primary" type="submit">Send</button>
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
            unreadTotal: 0,
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
                .sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
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
            console.log("2",this.selectedContributor?.user)
            const user = this.selectedContributor?.user;
                if (user?.first_name && user?.last_name) {
                return `${user.first_name} ${user.last_name}`;
                } else {
                return 'Unknown User';
                }
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
        candidatesList() {
            return (Array.isArray(this.candidates) ? this.candidates : [])
                .map((c) => ({
                    ...c,
                    userType: "candidate",
                    user: c.user || {
                        id: c.id,
                        first_name: c.first_name ?? c.name?.split(" ")[0] ?? "N/A",
                        last_name: c.last_name ?? c.name?.split(" ")[1] ?? "",
                    },
                }))
                .sort((a, b) => {
                    const timeA = new Date(a.last_message_at || 0).getTime();
                    const timeB = new Date(b.last_message_at || 0).getTime();
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
    watch: {
        contributorsList(newList) {
    if (newList.length > 0 && !this.selectedContributor) {
      this.selectedContributor = newList[0];
    }
  }
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
            if (Array.isArray(this.candidates)) updateUser(this.candidates);
            if (Array.isArray(this.contributorData)) updateUser(this.contributorData);
        },
        selectContributor(user) {
            this.selectedContributor = user;
            this.selectedUser = null;
            const fetchContributorId = user?.user?.id || user?.id;
            this.fetchMessages(fetchContributorId);
            localStorage.setItem("lastChatUser", JSON.stringify(user));
            this.markMessagesAsRead(fetchContributorId);
        },
        selectUser(user) {
            this.selectedUser = user;
            this.selectedContributor = null;
            this.fetchMessages(user.id);
            localStorage.setItem("lastChatUser", JSON.stringify(user));
            this.markMessagesAsRead(user.id);
        },
        selectFirstCandidat() {
            if (this.candidatesList.length > 0) {
                const firstCandidate = this.candidatesList[0];
                this.selectedUser = firstCandidate;
                this.selectedContributor = null;
                this.fetchMessages(firstCandidate.id);
                localStorage.setItem("lastChatUser", JSON.stringify(firstCandidate));
            }
        },
        selectFirstContributor() {
            if (!this.contributorData.length) return;

            const firstContributor = this.contributorData[0];
            this.selectContributor(firstContributor);
        },
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
                    },
                };
            });
        },
        markMessagesAsRead(userId) {
            if (!userId) return;
            fetch(`/messages/mark-as-read/${userId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.csrfToken,
                },
            })
                .then((res) => res.json())
                .then(() => {
                    if (this.unreadMap[userId]) {
                        this.unreadMap[userId] = 0;
                    }
                    this.updateUnreadTotal();
                })
                .catch((err) => {
                    console.error("Greška pri označavanju poruka kao pročitanih:", err);
                });
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file && file.size > 5 * 1024 * 1024) {
                this.messageError = "File must be less than 5MB.";
                this.clearFileInput();
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
            ) return "word";
            return "other";
        },
        clearFileInput() {
            if (this.$refs.fileInput) this.$refs.fileInput.value = "";
            this.file = null;
        },
        triggerFileInput() {
            this.$refs.fileInput?.click();
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
                const chatBox = document.getElementById("chatBox__freelancerAll");
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
        async handleSubmit() {
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

            fetch("/messages", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": window.csrfToken },
                body: formData,
            })
                .then((res) => res.json())
                .then((data) => {
                    this.message = "";
                    this.clearFileInput();
                    if (data.message) {
                        this.messages = [...this.messages, data.message].sort(
                            (a, b) => new Date(a.created_at) - new Date(b.created_at)
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
        emitter.emit("reset-navbar-badge");

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
                console.error("Greška pri dohvatanju nepročitanih poruka:", err);
            });

        this.picker = new EmojiButton({ position: "top-end" });
        if (this.picker) {
            this.picker.on("emoji", (emoji) => {
                this.message += emoji.emoji;
            });
        }

        this.prepareContributors();

    // If there is a last selected user saved, restore it
    const lastUser = localStorage.getItem("lastChatUser");
    if (lastUser) {
        const parsed = JSON.parse(lastUser);
        if (parsed.userType === "candidate") {
            this.selectUser(parsed);  // Use method for candidates
        } else if (parsed.userType === "contributor") {
            const matched = this.contributorData.find(
                (c) => c.user.id === parsed.id
            );
            if (matched) {
                this.selectContributor(matched);  // Use method for contributors
            }
        }
    } else {
        // If no last user, select first contributor by calling the method (not just setting variable)
        this.selectFirstContributor();
    }

        Echo.private("chat." + this.currentUserId)
            .listen(".MessageSent", (payload) => {
                const activeReceiverId =
                    this.selectedUser?.id ||
                    this.selectedContributor?.user?.id ||
                    this.selectedContributor?.id;

                const updateUserLastMessage = (userId) => {
                    const contributor = this.contributorData.find(
                        (c) => c.user.id === userId
                    );
                    if (contributor) {
                        contributor.last_message_at = payload.message.created_at;
                        return;
                    }

                    if (Array.isArray(this.candidates)) {
                        const candidate = this.candidates.find(
                            (c) => c.id === userId
                        );
                        if (candidate) {
                            candidate.last_message_at = payload.message.created_at;
                        }
                    }
                };

                updateUserLastMessage(payload.message.user_id);
                updateUserLastMessage(payload.message.receiver_id);

                if (
                    payload.message &&
                    (payload.message.user_id === activeReceiverId ||
                        payload.message.receiver_id === activeReceiverId)
                ) {
                    this.messages.push(payload.message);
                    this.scrollToBottom();
                    this.markMessagesAsRead(activeReceiverId);
                    this.fetchMessages(activeReceiverId);
                } else {
                    if (payload.message.user_id !== this.currentUserId) {
                        if (this.unreadMap[payload.message.user_id]) {
                            this.unreadMap[payload.message.user_id]++;
                        } else {
                            this.unreadMap[payload.message.user_id] = 1;
                        }
                        this.updateUnreadTotal();
                        emitter.emit("update-navbar-badge", this.unreadTotal);
                    }
                }
            })
            .error((error) => {
                console.error("❌ Greška:", error);
            });
    },
    beforeUnmount() {
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

.hr_custome {
    height: 5px !important;
    width: 100%;
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
    /* ili koliko god želiš */
    overflow-y: auto;
    margin-bottom: 1rem;
    padding: 0.5rem;
}

.badge-danger {
    height: 20px;
}
</style>
