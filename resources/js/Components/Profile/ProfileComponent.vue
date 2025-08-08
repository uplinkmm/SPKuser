<template>
    <div class="frame-container min-h-[100vh]">
        <Navbar :title="$t(title)" :back-btn="backBtn"></Navbar>

        <div>
            <div v-show="step == 'mainProfile'">
                <div
                    class="px-12 py-12 shadow-lg rounded-2xl mb-8 bg-white text-black font-semibold"
                >
                    <div class="flex justify-center mb-3">
                        <img src="../../../../public/img/profile.png" alt="" />
                    </div>
                    <div class="text-center font-inter mb-4">
                        <p class="mb-1 lg:mb-2">
                            {{ user_profile_data?.name }}
                        </p>
                        <p class="text-sm mb-1 lg:mb-2">
                            {{ user_profile_data?.phone_number }}
                        </p>
                        <p class="text-sm mb-1 lg:mb-2">
                            Since
                            {{ dateFormat(user_profile_data.verified_at) }}
                        </p>
                    </div>
                    <div class="flex justify-between text-xs">
                        <p>
                            <i class="fal fa-wallet"></i>
                            {{
                                user_profile_data?.main_money_balance?.toLocaleString()
                            }}
                            MMK
                        </p>
                        <p>
                            <i class="fal fa-wallet"></i>
                            {{
                                user_profile_data?.game_money_balance?.toLocaleString()
                            }}
                            MMK
                        </p>
                    </div>
                </div>
                <div class="px-12 py-16 shadow-lg rounded-2xl mb-8 bg-white">
                    <div class="flex flex-col gap-y-4">
                        <button
                            type="button"
                            @click="clickChangePass()"
                            class="flex items-center"
                        >
                            <i class="fal fa-key mr-4 w-4"></i>
                            <p class="">{{ $t("Change Password") }}</p>
                        </button>
                        <a
                            @click="changeLocale()"
                            class="cursor-pointer flex items-center"
                        >
                            <i class="fal fa-sort-alt mr-4 w-4"></i>
                            <p>{{ $t("Myanmar/English") }}</p>
                        </a>
                        <!-- <a href="/history" class="flex items-center">
                            <i class="fal fa-book mr-4 w-4"></i>
                            <p>{{ $t("History") }}</p>
                        </a> -->
                        <a
                            href="/deposit_withdrawal_histories"
                            class="flex items-center"
                        >
                            <i class="fal fa-money-check-alt mr-4 w-4"></i>
                            <p>{{ $t("Deposit Withdrawal History") }}</p>
                        </a>
                        <a
                            href="#"
                            @click="
                                step = 'termsAndConditions';
                                title = 'Term & Condition';
                            "
                            class="flex"
                        >
                            <i class="fal fa-scroll-old mr-4 w-4 pt-1"></i>
                            <p>{{ $t("Term & Condition") }}</p>
                        </a>
                        <a href="#" class="flex items-center">
                            <i class="fal fa-comment-alt-lines mr-4 w-4"></i>
                            <button
                                data-twe-toggle="modal"
                                data-twe-target="#add_feedback_modal"
                            >
                                {{ $t("Feedback") }}
                            </button>
                        </a>
                        <a href="#" class="flex items-center">
                            <i class="fal fa-phone mr-4 w-4"></i>
                            <button
                                data-twe-toggle="modal"
                                data-twe-target="#contact_modal"
                            >
                                {{ $t("Contacts") }}
                            </button>
                        </a>
                        <a @click="logOut" class="flex items-center">
                            <i class="fal fa-sign-out-alt mr-4 w-4"></i>
                            <p>{{ $t("Logout") }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div
                v-show="step == 'changePass'"
                class="px-8 py-12 shadow-lg rounded-2xl mb-8 bg-white mt-[25%]"
            >
                <div class="mb-4">
                    <label
                        for="old_password"
                        class="text-sm mb-2 relative block"
                        >Old Password</label
                    >
                    <input
                        type="password"
                        id="old_password"
                        placeholder="Old Password"
                        v-model="current_password"
                        class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="new_password"
                        class="text-sm mb-2 relative block"
                        >New Password
                    </label>
                    <input
                        type="password"
                        id="new_password"
                        placeholder="New Password"
                        v-model="new_password"
                        class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                    />
                </div>
                <div class="mb-8">
                    <label
                        for="confirm_password"
                        class="text-sm mb-2 relative block"
                        >Confirm Password</label
                    >
                    <input
                        type="password"
                        id="confirm_password"
                        placeholder="Confirm Password"
                        v-model="new_password_confirmation"
                        class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                    />
                </div>
                <div class="mb-0">
                    <button
                        @click="changePassword()"
                        class="bg-[#FDC652] text-white px-4 py-2 w-full"
                    >
                        Done
                    </button>
                </div>
            </div>
            <div
                v-show="step == 'termsAndConditions'"
                class="px-8 py-16 shadow-lg rounded-2xl mb-8 bg-white"
            >
                <div class="mb-0">
                    <p v-html="terms_and_conditions.name"></p>
                </div>
            </div>
        </div>

        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="add_feedback_modal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                data-twe-modal-dialog-ref
                class="pointer-events-none relative w-[400px] mx-auto mt-[15%] translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[400px]"
            >
                <div
                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-neutral-100 py-8 px-6"
                    >
                        <h4
                            class="text-xl font-medium leading-normal text-surface text-center w-full"
                            id="exampleModalLabel"
                        >
                            {{ $t("Feedback") }}
                        </h4>
                        <button
                            type="button"
                            id="close_feedback"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div
                        class="relative flex-auto pb-6 px-16"
                        data-twe-modal-body-ref
                    >
                        <div class="mb-8">
                            <label
                                for="feedback"
                                class="text-sm mb-3 relative block"
                                >{{ $t("Feedback") }}</label
                            >
                            <textarea
                                v-model="feedback"
                                type="text"
                                rows="8"
                                id="feedback"
                                placeholder="Feed Back"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
                            ></textarea>
                        </div>

                        <div class="mb-4">
                            <button
                                @click="sendFeedback"
                                class="px-4 py-2 lg:py-3 bg-[#FFBF33] text-white text-sm rounded-lg w-full"
                            >
                                Send
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="contact_modal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                data-twe-modal-dialog-ref
                class="pointer-events-none relative w-[400px] mx-auto mt-[15%] translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[400px]"
            >
                <div
                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-neutral-100 py-8 px-6"
                    >
                        <h4
                            class="text-xl font-medium leading-normal text-surface text-center w-full"
                            id="exampleModalLabel"
                        >
                            {{ $t("Contacts") }}
                        </h4>
                        <button
                            type="button"
                            id="close_contact"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div
                        class="relative flex-auto pb-6 px-16"
                        data-twe-modal-body-ref
                    >
                        <div class="mb-8">
                            <div
                                v-for="(contact, index) in contacts"
                                :key="index"
                                class="flex items-center p-4 bg-gray-50 rounded-lg shadow-sm"
                            >
                                <div
                                    class="flex items-center justify-center w-12 h-12 bg-blue-500 text-white rounded-full"
                                >
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="ml-4">
                                    <p
                                        class="text-lg font-medium text-gray-800"
                                    >
                                        {{ contact.name }}
                                    </p>
                                    <a
                                        :href="'tel:' + contact.phone_number"
                                        class="text-blue-500 hover:underline"
                                    >
                                        {{ contact.phone_number }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal, Ripple, Dropdown, initTWE } from "tw-elements";
import { mapGetters, mapMutations } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import moment from "moment";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            step: "mainProfile", //changePass
            title: "Profile",
            user_profile_data: {},
            current_password: "",
            new_password: "",
            new_password_confirmation: "",
            terms_and_conditions: "",
            feedback: "",
            contacts: [],
        };
    },
    computed: {
        ...mapGetters(["getToken"]),
        currentLocale() {
            return this.$i18n.locale;
        },
    },
    mixins: [CheckAuthMixin],
    methods: {
        ...mapMutations(["setLanguageCode"]),
        clickChangePass() {
            this.step = "changePass";
            this.title = "Change Password";
        },
        backBtn() {
            if (
                this.step == "changePass" ||
                this.step == "contacts" ||
                this.step == "termsAndConditions"
            ) {
                this.step = "mainProfile";
                this.title = "Profile";
                return;
            }
            if (this.step == "mainProfile") {
                window.location.href = "/home";
            }
        },
        async getProfile() {
            let response = await getApiData({
                url: `api/get_profile`,
                token: this.getToken,
            });
            this.user_profile_data = response.data;
            this.contacts = response.data.contact;
        },
        async getTermsAndConditions() {
            let response = await getApiData({
                url: `api/get_term_and_condition`,
                token: this.getToken,
            });
            this.terms_and_conditions = response.data;
        },
        async sendFeedback() {
            if (!this.feedback) {
                this.$notify({
                    text: "Fill the feedback form!.",
                    type: "error",
                });
                return;
            }
            let url = "/api/feedbacks";
            let formData = new FormData();
            formData.append("text", this.feedback);

            let response = await postApiData({
                url: url,
                form_data: formData,
                token: this.getToken,
            });
            if (response.success) {
                this.$notify({
                    text: "Successfully send feedback.",
                    type: "info",
                });
                this.feedback = "";
                this.modalClose("close_feedback");
            } else {
                this.$notify({
                    text: response.message?.text,
                    type: "error",
                });
            }
        },
        modalClose(id) {
            const button = document.getElementById(id);
            if (button) {
                button.click();
            }
        },
        dateFormat(date_time) {
            return moment(date_time).format("MM DD YYYY");
        },
        async changePassword() {
            if (
                this.new_password == "" ||
                this.current_password == "" ||
                this.new_password_confirmation == ""
            ) {
                this.$notify({
                    text: "Please fill all fields.",
                    type: "error",
                });
                return;
            }
            if (
                this.new_password.length < 6 ||
                this.current_password.length < 6 ||
                this.new_password_confirmation.length < 6
            ) {
                this.$notify({
                    text: "Password must be at least 6 characters long.",
                    type: "info",
                });
                return;
            }
            let url = "/api/change_password";
            let formData = new FormData();
            formData.append("current_password", this.current_password);
            formData.append("new_password", this.new_password);
            formData.append(
                "new_password_confirmation",
                this.new_password_confirmation
            );

            let response = await postApiData({
                url: url,
                form_data: formData,
                token: this.getToken,
            });
            if (response.success) {
                this.$notify({
                    text: response.message,
                    type: "info",
                });
                this.step = "mainProfile";
                this.title = "Profile";
            } else {
                this.$notify({
                    text:
                        response.message?.new_password ||
                        response.message?.current_password ||
                        response.message?.new_password_confirmation,
                    type: "error",
                });
            }
        },
        changeLocale() {
            if (this.currentLocale == "mm") {
                this.$i18n.locale = "en";
                this.setLanguageCode("en");
                return;
            }
            if (this.currentLocale == "en") {
                this.$i18n.locale = "mm";
                this.setLanguageCode("mm");

                return;
            }
        },
        async logOut() {
            let url = "/api/logout";

            let response = await postApiData({
                url: url,
                token: this.getToken,
            });
            if (response.success) {
                localStorage.clear();

                this.$notify({
                    text: response.message,
                    type: "info",
                });
                window.location.href = "/home";
            } else {
            }
        },
    },

    mounted() {
        initTWE({ Modal, Ripple, Dropdown });
        this.getProfile();
        this.getTermsAndConditions();
    },
};
</script>
