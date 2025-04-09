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
                            class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"
                            ><span class="path1"></span
                            ><span class="path2"></span
                        ></i>
                        <!--end::Icon-->

                        <!--begin::Input-->
                        <input
                            type="text"
                            class="form-control form-control-solid px-13"
                            name="search"
                            value=""
                            placeholder="Search by username or email..."
                        />
                        <!--end::Input-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-5" id="kt_chat_contacts_body">
                    <!--begin::List-->
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
                            <div>
                                <div
                                    class="d-flex align-items-center"
                                    v-if="candidate && candidate.user"
                                >
                                    <div
                                        class="symbol symbol-45px symbol-circle"
                                    >
                                        <span
                                            class="symbol-label bg-light-danger text-danger fs-6 fw-bolder"
                                            >{{
                                                candidate.user.first_name
                                                    .charAt(0)
                                                    .toUpperCase()
                                            }}</span
                                        >
                                    </div>

                                    <div class="ms-5">
                                        <a
                                            @click.prevent="
                                                selectUser(candidate.user)
                                            "
                                            href="#"
                                            :class="[
                                                'fs-5 fw-bold text-gray-900 text-hover-primary mb-2',
                                                selectedUser &&
                                                selectedUser.id ===
                                                    candidate.user.id
                                                    ? 'active-user'
                                                    : '',
                                            ]"
                                        >
                                            {{ candidate.user.first_name }}
                                            {{ candidate.user.last_name }}
                                        </a>

                                        <p>{{ candidate.user.email }}</p>
                                    </div>
                                </div>
                            </div>
                            <!--begin::Details-->
                            <div
                                class="d-flex align-items-center"
                                v-for="user in contributors"
                                :key="user.id"
                            >
                                <!--begin::Avatar-->
                                <div class="symbol symbol-45px symbol-circle">
                                    <span
                                        class="symbol-label bg-light-danger text-danger fs-6 fw-bolder"
                                        >{{
                                            user.name.charAt(0).toUpperCase()
                                        }}</span
                                    >
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Details-->
                                <div class="ms-5">
                                    <a
                                        @click.prevent="selectContributor(user)"
                                        href="#"
                                        :class="[
                                            'fs-5 fw-bold text-gray-900 text-hover-primary mb-2',
                                            selectedContributor &&
                                            selectedContributor.id === user.id
                                                ? 'active-contributor'
                                                : '',
                                        ]"
                                    >
                                        {{ user.name }}
                                    </a>

                                    <p>{{ user.email }}</p>
                                </div>
                                <!--end::Details-->
                                <!--begin::Lat seen-->
                                <div
                                    class="d-flex flex-column align-items-end ms-5"
                                >
                                    <span class="text-muted fs-7 mb-1"
                                        >5 hrs</span
                                    >

                                    <span
                                        class="badge badge-sm badge-circle badge-light-warning"
                                        >9</span
                                    >
                                </div>
                                <!--end::Lat seen-->
                            </div>
                            <!--end::Details-->
                        </div>
                        <!--end::User-->

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
                    <h3 class="card-title">
                        Chat with
                        {{
                            selectedContributor
                                ? selectedContributor.name
                                : selectedUser?.first_name || "Candidate?"
                        }}
                    </h3>
                </div>
                <div class="card-body chat-box" id="chatBox">
                    <!-- Example Chat Messages -->
                    <div class="chat-message received">
                        <strong>Candidate:</strong>
                        <p>Hello! I'm excited about the opportunity.</p>
                        <small class="text-muted">10:00 AM</small>
                    </div>
                    <div class="chat-message sent">
                        <strong>You:</strong>
                        <p>
                            Thank you for your interest. Let's discuss further.
                        </p>
                        <small class="text-muted">10:05 AM</small>
                    </div>
                    <!-- More messages will be appended here dynamically -->
                </div>
                <div class="card-footer">
                    <form id="chatForm" @submit.prevent="handleSubmit">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Type your message..."
                                id="chatInput"
                                v-model="message"
                                required
                            />
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
export default {
    props: {
        contributors: {
            type: Array,
            required: true,
            default: () => [],
        },
        candidate: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            selectedContributor: null,
            selectedUser: null,
            message: "",
        };
    },
    methods: {
        selectContributor(user) {
            this.selectedContributor = user;
            this.selectedUser = null;
            console.log("Selected contributor: ", this.selectedContributor);
        },
        selectUser(user) {
            this.selectedUser = user;
            this.selectedContributor = null;
            console.log("Selected user: ", this.selectedUser);
        },
        handleSubmit() {
            alert(`You wrote: ${this.message}`);
            this.message = ""; // Optionally clear the message after submitting
        },
    },
    mounted() {
        console.log("Users:", this.contributors);
        console.log("Candidate: ", this.candidate);
    },
};
</script>
<style>
.active-user {
    color: #0d6efd !important;
}
.active-contributor {
    color: #0d6efd !important;
}
</style>