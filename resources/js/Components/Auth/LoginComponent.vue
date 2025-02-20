<template>
    <main
        class="w-full h-full min-h-[30vh] mx-auto px-0 pb-2 flex flex-row justify-center relative"
    >
        <div class="" @keyup.enter="login">
            <div class="mb-4">
                <input
                    type="text"
                    id="phone_number"
                    v-model="phone_number"
                    :placeholder="$t('Phone Number')"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
                />
            </div>
            <div class="mb-8 relative">
                <input
                    :type="show_password ? 'text' : 'password'"
                    id="password"
                    v-model="password"
                    placeholder="Password"
                    class="block w-full py-2 px-2 pr-10 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
                />
                <i
                    v-if="!show_password"
                    @click="show_password = !show_password"
                    class="far fa-eye text-lg absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                ></i>
                <i
                    v-if="show_password"
                    @click="show_password = !show_password"
                    class="far fa-eye-slash text-lg absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                ></i>
            </div>

            <div class="mb-4">
                <button
                    @click="login"
                    class="block w-full py-2 px-2 text-sm rounded-md bg-[#000] border border-[#E4BD1B] text-white focus:ring-0 focus:shadow-none focus:outline-none"
                >
                    Login
                </button>
                <button
                    data-twe-toggle="modal"
                    data-twe-target="#contact_modal"
                    id="error_btn"
                ></button>
            </div>
            <button
                class="text-sm w-full text-center text-gray-300 hover:underline"
                @click="changeForgotPassword(true)"
            >
                Forgot password?
            </button>
        </div>
        <form method="POST" id="signin-form" ref="signinForm" action="/login">
            <input type="hidden" v-model="csrfToken" name="_token" />
            <input type="hidden" v-model="phone_number" name="phone_number" />
            <input type="hidden" v-model="password" name="password" />
            <input type="hidden" name="remember" value="true" />
        </form>
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none bg-black bg-opacity-50"
            id="contact_modal"
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
                                error_box.error
                                    ? 'text-red-600'
                                    : 'text-green-600'
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
                                    error_box.error
                                        ? 'bg-red-50'
                                        : 'bg-green-50'
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
    </main>
    <!-- <div class="contents">
        <div
            class="flex items-center my-4 before:flex-1 before:border-t before:border-gray-700 before:mt-0.5 after:flex-1 after:border-t after:border-gray-700 after:mt-0.5"
        >
            <p class="text-center font-semibold mx-4 mb-0 font-louis">OR</p>
        </div>

        <a
            class="px-7 py-2.5 text-black border font-louis border-black mb-4 font-medium text-sm leading-snug uppercase w-full flex justify-center items-center rounded-sm"
            style="background-color: white"
            href="/redirect/google"
            role="button"
        >
            Sign in with Google
        </a>

        <a
            class="rounded-sm px-7 py-2.5 font-louis text-white font-medium text-sm leading-snug uppercase focus:outline-none focus:ring-0 w-full flex justify-center items-center mb-3"
            style="background-color: #0c66da"
            href="/redirect/facebook"
            role="button"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 320 512"
                class="w-3.5 h-3.5 mr-2"
            >
                <path
                    fill="currentColor"
                    d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                /></svg
            >Continue with Facebook
        </a>
    </div> -->
</template>

<script>
import { mapMutations } from "vuex";
import { postApiData } from "../../utilities/ajax-helpers";
import fcmMixin from "../../mixins/fcmMixin";
export default {
    name: "LoginComponent",
    data() {
        return {
            token: null,
            csrfToken: null,
            name: null,
            phone_number: null,
            password: null,
            show_password: false,
            error_box: {
                error: true,
                message: "Your phone number is already exit!",
            },
        };
    },
    props: {
        fcmToken: {},
        changeForgotPassword: {
            type: Function,
        },
    },
    // mixins: [fcmMixin],

    methods: {
        ...mapMutations(["setUser", "setToken", "setCsrfToken"]),

        async login() {
            if (!this.password || !this.phone_number) {
                this.error_box.error = true;
                this.error_box.message = "Please fill all field!";
                this.modalOpen();
                // this.$notify({
                //     text: "Please fill all field!",
                //     type: "error",
                // });

                return;
            }
            if (this.password.length < 6) {
                // this.$notify({
                //     text: "Password must be at least 6 characters long.",
                //     type: "error",
                // });
                this.error_box.error = true;
                this.error_box.message = "Password must be at least 6 characters long.";
                this.modalOpen();
                return;
            }

            let url = "/api/login";
            let formData = new FormData();
            formData.append("phone_number", this.phone_number);
            formData.append("password", this.password);
            formData.append("fcm_token", this.fcmToken); //from mixin

            let response = await postApiData({ url: url, form_data: formData });
            if (response.data) {
                this.error_box.error = false;
                this.error_box.message = response.message;
                this.modalOpen();
                // this.$notify({
                //     text: response.message,
                //     type: "info",
                // });
                this.token = response.data.token;
                this.setToken(this.token);
                let user = response.data.user;
                this.setUser(user);
                this.$refs.signinForm.submit();

                return true;
            } else {
                this.error_box.error = true;
                this.error_box.message =response.message || response.message.phone_number || response.message.password;
                this.modalOpen();
                // this.$notify({
                //     text: response.message,
                //     type: "error",
                // });

                return false;
            }
        },
        modalOpen() {
            const button = document.getElementById("error_btn");
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

    created() {
        this.csrfToken = $('meta[name="csrf-token"]').attr("content");
        this.setCsrfToken(this.csrfToken);
    },
};
</script>
