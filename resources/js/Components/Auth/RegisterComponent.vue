<template>
    <main
        class="w-full h-full min-h-[60vh] mx-auto px-8  pb-2 flex flex-row justify-center relative"
    >
        <div class="">
            <div class="mb-4">
                <input
                    type="text"
                    id="user_name"
                    v-model="user_name"
                    :placeholder="$t('Name')"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                />
            </div>
            <div class="mb-4">
                <label
                    class="block w-full py-2 px-2 border bg-white border-gray-400 text-sm rounded-md"
                >
                    <input
                        type="text"
                        id="phone_number"
                        v-model="phone_number"
                        :placeholder="$t('Phone Number')"
                        class="focus:ring-0 focus:shadow-none"
                    />
                    <button
                        class="text-xs border-l border-gray-400 pl-1 py-1"
                        @click="initialRegister"
                    >
                        Get OTP
                    </button>
                </label>
            </div>
            <div class="mb-4">
                <input
                    type="text"
                    id="otp"
                    v-model="otp"
                    placeholder="OTP"
                    :disabled="!otpRequested"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                />
            </div>

            <div class="mb-4">
                <input
                    type="password"
                    id="password"
                    v-model="password"
                    placeholder="Password"
                    :disabled="!otpRequested"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                />
            </div>

            <div class="mb-4">
                <input
                    type="password"
                    id="confirm_password"
                    v-model="confirm_password"
                    placeholder="Confirm Password"
                    :disabled="!otpRequested"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                />
            </div>
            <div class="mb-8">
                <input
                    type="text"
                    id="agent_code"
                    v-model="code"
                    placeholder="Agent Code(Optional)"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                />
            </div>

            <div>
                <button
                    @click="register"
                    :disabled="!otpRequested"
                    class="block w-full py-2 px-2 text-sm rounded-md border border-[#E4BD1B] bg-black text-white focus:ring-0 focus:shadow-none"
                >
                    Sign Up
                </button>
            </div>
        </div>
        <form method="POST" id="signin-form" ref="signinForm" action="/login">
            <input type="hidden" v-model="csrfToken" name="_token" />
            <input type="hidden" v-model="phone_number" name="phone_number" />
            <input type="hidden" v-model="password" name="password" />
            <input type="hidden" name="remember" value="true" />
        </form>
    </main>
    <div class="contents">
        <div
            class="flex items-center my-4 before:flex-1 before:border-t before:border-gray-300 before:mt-0.5 after:flex-1 after:border-t after:border-gray-300 after:mt-0.5"
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
            style="background-color: #3b5998"
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
    </div>
</template>

<script>
import { mapMutations } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import fcmMixin from "../../mixins/fcmMixin";

export default {
    name: "RegisterComponent",
    data() {
        return {
            token: null,
            csrfToken: null,

            user_name: null,
            phone_number: null,
            otp: null,
            password: null,
            confirm_password: null,
            code:null,
            remember: true,
            otpRequested: false,
        };
    },
    props: {
        props: {
            fcmToken: {},
        },
    },
    // mixins: [fcmMixin],

    methods: {
        ...mapMutations(["setUser", "setToken", "setCsrfToken"]),

        async initialRegister() {
            if (!this.user_name || !this.phone_number) {
                this.$notify({
                    text: "You forgot to enter name and phone number",
                    type: "warn",
                });

                return 1;
            }
            let formData = new FormData();
            formData.append("phone_number", this.phone_number);
            formData.append("name", this.user_name);
            let url = `/api/initial_register`;
            let response = await postApiData({ url: url, form_data: formData });
            if (response.success) {
                this.otpRequested = true;
                this.$notify({
                    text: response.message,
                    type: "info",
                });
            } else {
                this.$notify({
                    text: response.message,
                    type: "error",
                });
            }
        },

        async register() {
            if (!this.otp) {
                this.$notify({
                    text: "OTP code must be entered",
                    type: "warn",
                });
                return 1;
            }

            if (!this.password || !this.confirm_password) {
                this.$notify({
                    text: "Password and confirm password must be entered",
                    type: "warn",
                });
                return 1;
            }
            if (this.password != this.confirm_password) {
                this.$notify({
                    text: "Confirm password not match",
                    type: "warn",
                });
                return 1;
            }
            if (this.password.length < 6 || this.confirm_password.length < 6) {
                this.$notify({
                    text: "Password must be at least 6 characters long.",
                    type: "info",
                });
                return;
            }
            let url = "/api/register";
            let formData = new FormData();
            formData.append("name", this.user_name);
            formData.append("phone_number", this.phone_number);
            formData.append("password", this.password);
            formData.append("otp", this.otp);
            formData.append("code", this.code);
            formData.append("fcm_token", this.fcmToken); //from mixin

            let response = await postApiData({ url: url, form_data: formData });

            if (response.success) {
                this.$notify({
                    text: response.message,
                    type: "info",
                });
                this.token = response.data.token;
                this.setToken(this.token);
                let user = response.data.user;
                this.setUser(user);
                this.$refs.signinForm.submit();

                return true;
            } else {
                this.$notify({
                    text: response.message,
                    type: "error",
                });
                return false;
            }
        },
    },

    created() {
        this.csrfToken = $('meta[name="csrf-token"]').attr("content");
        this.setCsrfToken(this.csrfToken);
    },
};
</script>
