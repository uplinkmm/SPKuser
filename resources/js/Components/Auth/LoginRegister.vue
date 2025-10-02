<template>
    <notifications position="top center" />
    <div class="w-full h-full bg-gray-200">
        <main
            class="frame-container  relative"
        >
            <button @click="isLogin = false" class="text-black text-base absolute top-8 right-4 font-semibold z-30" :class="isLogin ? 'block' : 'hidden'">
                အကောင့်ဖွင့်ရန်
            </button>
            <div
                v-if="forgot_password"
                class="flex justify-center items-center flex-col min-h-screen"
            >
                <div class="tab-content w-full">
                    <div>
                        <forgot-password
                            :fcm-token="fcmToken"
                            :change-forgot-password="changeForgotPassword"
                            :set-error-box="setErrorBox"
                        ></forgot-password>
                    </div>
                </div>
            </div>
            <div
                v-if="!forgot_password"
                class="flex justify-center items-center flex-col min-h-screen w-[93%] mx-auto"
            >
                
                <div v-if="isLogin" class="w-full">
                    <login-component
                                :fcm-token="fcmToken"
                                :change-forgot-password="changeForgotPassword"
                                :set-error-box="setErrorBox"
                    ></login-component>
                </div>
                <div v-else class="w-full">
                    <register-component
                                :fcm-token="fcmToken"
                                :set-error-box="setErrorBox"
                    ></register-component>
                </div>

                <!-- <ul class="flex space-x-4 mb-6" role="tablist" data-twe-nav-ref>
                    <li role="presentation">
                        <a
                            href="#tabs-twoD"
                            class="my-2 block pr-4 pb-3.5 font-semibold pt-4 text-md primary-text data-[twe-nav-active]:after:!block underline-border relative"
                            data-twe-toggle="pill"
                            data-twe-target="#tabs-twoD"
                            data-twe-nav-active
                            role="tab"
                            aria-controls="tabs-twoD"
                            aria-selected="true"
                            >Login</a
                        >
                    </li>
                    <li role="presentation">
                        <a
                            href="#tabs-threeD"
                            class="my-2 block pr-4 pb-3.5 font-semibold pt-4 text-md primary-text data-[twe-nav-active]:after:!block underline-border relative"
                            data-twe-toggle="pill"
                            data-twe-target="#tabs-threeD"
                            role="tab"
                            aria-controls="tabs-threeD"
                            aria-selected="false"
                            >Register</a
                        >
                    </li>
                </ul>

                <div class="tab-content w-full">
                    <div
                        class="hidden data-[twe-tab-active]:block"
                        id="tabs-twoD"
                        role="tabpanel"
                        aria-labelledby="tabs-twoD-tab"
                        data-twe-tab-active
                    >
                        <login-component
                            :fcm-token="fcmToken"
                            :change-forgot-password="changeForgotPassword"
                            :set-error-box="setErrorBox"
                        ></login-component>
                    </div>
                    <div
                        class="hidden data-[twe-tab-active]:block"
                        id="tabs-threeD"
                        role="tabpanel"
                        aria-labelledby="tabs-threeD-tab"
                    >
                        <register-component
                            :fcm-token="fcmToken"
                            :set-error-box="setErrorBox"
                        ></register-component>
                    </div>
                </div> -->
            </div>
        </main>
    </div>
    <div
        data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none bg-black bg-opacity-50"
        id="error_modal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div
            data-twe-modal-dialog-ref
            class="pointer-events-none relative w-[400px] mx-auto mt-[20vh] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-[20vh] min-[576px]:max-w-[400px]"
        >
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none"
            >
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b border-neutral-200 py-4 px-6"
                >
                    <h4
                        class="text-xl font-medium leading-normal text-surface w-full text-center"
                        :class="
                            error_box.error ? 'text-red-600' : 'text-green-600'
                        "
                    >
                        {{ error_box.error ? "Error" : "Success" }}
                    </h4>
                    <button
                        type="button"
                        id="close_modal"
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
                <div class="relative flex-auto p-6" data-twe-modal-body-ref>
                    <div class="flex items-center justify-center">
                        <div
                            class="flex items-center p-4 rounded-lg shadow-sm"
                            :class="
                                error_box.error ? 'bg-red-50' : 'bg-green-50'
                            "
                        >
                            <i
                                v-if="error_box.error"
                                class="fas fa-exclamation-circle text-red-600 text-2xl mr-4"
                            ></i>
                            <i
                                v-else
                                class="fas fa-check-circle text-green-600 text-2xl mr-4"
                            ></i>
                            <div class="text-md text-gray-700">
                                {{ error_box.message }}
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-shrink-0 items-center justify-end rounded-b-md border-t border-neutral-200 py-3 px-6"
                >
                    <button
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-white rounded-md"
                        :class="
                            error_box.error
                                ? 'bg-red-600 hover:bg-red-700'
                                : 'bg-green-600 hover:bg-green-700'
                        "
                        data-twe-modal-dismiss
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <button
        data-twe-toggle="modal" class=" hidden"
        data-twe-target="#error_modal"
        id="error_modal_btn"
    ></button>
</template>

<script>
import { mapMutations } from "vuex";
import { postApiData } from "../../utilities/ajax-helpers";
import fcmMixin from "../../mixins/fcmMixin";
import LoginComponent from "./LoginComponent.vue";
import RegisterComponent from "./RegisterComponent.vue";
import {
    Collapse,
    Carousel,
    initTWE,
    Modal,
    Ripple,
    Dropdown,
    Input,
    Tab,
} from "tw-elements";
import ForgotPassword from "./ForgotPassword.vue";

export default {
    name: "LoginRegister",
    components: {
        LoginComponent,
        RegisterComponent,
        ForgotPassword,
    },
    data() {
        return {
            forgot_password: false,
            error_box: {
                error: true,
                message: "",
            },

            isLogin: true,
        };
    },
    mixins: [fcmMixin],

    methods: {
        changeForgotPassword(value) {
            this.forgot_password = value;
        },
        setErrorBox(error, message) {
            console.log(error, message);
            this.error_box = {
                error: false,
                message: "",
            };
            this.error_box.error = error;
            this.error_box.message = message;
            this.modalOpen();
        },
        modalOpen() {
            const button = document.getElementById("error_modal_btn");
            if (button) {
                button.click();
            }
            setTimeout(() => {
                this.modalClose();
            }, 2000);
        },
        modalClose() {
            const button = document.getElementById("close_modal");
            if (button) {
                button.click();
            }
        },
    },

    mounted() {
        initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });
    },
};
</script>
