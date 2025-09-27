<template>
    <main
        class="w-full h-full min-h-[60vh] mx-auto px-8 pb-2 flex flex-row justify-center relative"
    >
        <div class="">
            <div class="mb-[10vh] text-center">
                <p class="text-base mb-3 font-semibold">
                    အကောင့်ဖွင့်ရန်
                </p>
                <img src="../../../../public/img/SPK Logo.png" class="bg-black p-4 rounded-full w-28 h-28 mb-6 mx-auto" alt="" />
                <p class=" text-sm mb-4">
                    OTP ကျမလာပါ Customer Service သို့ ဆက်သွယ်နိုင်ပါသည်
                </p>
                
                <button
                        class="w-full bg-black disabled:bg-black disabled:text-gray-300 hover:bg-black text-[#FED428] font-bold py-3 rounded-full shadow-md text-sm transition-colors duration-300"
                    >
                    <i class="fal fa-phone mr-4 w-4"></i>Customer Service သို့ ဖုန်းခေါ်ရန်
                    </button>
            </div>
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
                <div class="relative">
                    <input
                        type="text"
                        id="phone_number"
                        v-model="phone_number"
                        :placeholder="$t('Phone Number')"
                        class="block w-full py-2 px-2 pr-16 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-black"
                    />
                    <button
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-xs border-l border-gray-400 pl-2 py-1"
                        @click="initialRegister"
                        :disabled="countdown != 0"
                    >
                        Get OTP
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <div class="relative">
                    <input
                        type="text"
                        id="otp"
                        v-model="otp"
                        placeholder="OTP"
                        :disabled="!otpRequested"
                        class="block w-full py-2 px-2 pr-16 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-black"
                    />
                    <button
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-xs border-l border-gray-400 pl-8 py-1"
                    >
                        <p>
                            {{
                                countdown > 0
                                    ? countdown.toString().padStart(2, "0") +
                                      " s"
                                    : "00 s"
                            }}
                        </p>
                    </button>
                </div>
            </div>

            <div class="mb-4 relative">
                <input
                    :type="show_password ? 'text' : 'password'"
                    id="password"
                    v-model="password"
                    :disabled="!otpRequested"
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
                <input
                    :type="show_password ? 'text' : 'password'"
                    id="confirm_password"
                    v-model="confirm_password"
                    placeholder="Confirm Password"
                    :disabled="!otpRequested"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                />
            </div>
            <!-- <div class="mb-8">
                <input
                    type="text"
                    id="agent_code"
                    v-model="code"
                    placeholder="Agent Code(Optional)"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                />
            </div> -->

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
    <!-- <div class="contents">
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
                />
            </svg>
            Continue with Facebook
        </a>
    </div> -->
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
           // code: null,
            remember: true,
            otpRequested: false,
            show_password: false,
            countdown: 0,
        };
    },
    props: {
        fcmToken: {},
        setErrorBox: {
            type: Function,
        },
    },
    // mixins: [fcmMixin],

    methods: {
        ...mapMutations(["setUser", "setToken", "setCsrfToken"]),

        async initialRegister() {
            if (!this.user_name || !this.phone_number) {
                this.setErrorBox(
                    true,
                    "You forgot to enter name and phone number"
                );
                return 1;
            }
            let formData = new FormData();
            formData.append("phone_number", this.phone_number);
            formData.append("name", this.user_name);
            let url = `/api/initial_register`;
            let response = await postApiData({ url: url, form_data: formData });
            if (response.success) {
                this.otpRequested = true;
                this.setErrorBox(false, response.message);
                this.startCountdown();
            } else {
                this.setErrorBox(true, response.message.phone_number);
            }
        },

        async register() {
            if (!this.otp) {
                this.setErrorBox(true, "OTP code must be entered");

                return 1;
            }
            if (!this.countdown) {
                this.setErrorBox(true, "OTP code is expired!");

                return 1;
            }

            if (!this.password || !this.confirm_password) {
                this.setErrorBox(
                    true,
                    "Password and confirm password must be entered"
                );
                return 1;
            }
            if (this.password != this.confirm_password) {
                this.setErrorBox(true, "Confirm password not match");
                return 1;
            }
            if (this.password.length < 6 || this.confirm_password.length < 6) {
                this.setErrorBox(
                    true,
                    "Password must be at least 6 characters long."
                );

                return;
            }
            let url = "/api/register";
            let formData = new FormData();
            formData.append("name", this.user_name);
            formData.append("phone_number", this.phone_number);
            formData.append("password", this.password);
            formData.append("password_confirmation", this.confirm_password);
            formData.append("otp", this.otp);
            // formData.append("code", this.code);
            formData.append("fcm_token", this.fcmToken); //from mixin

            let response = await postApiData({ url: url, form_data: formData });

            if (response.success) {
                this.setErrorBox(false, response.message);
                this.token = response.data.token;
                this.setToken(this.token);
                let user = response.data.user;
                this.setUser(user);
                this.$refs.signinForm.submit();

                return true;
            } else {
                this.setErrorBox(
                    true,
                    response.message.phone_number ||
                        response.message.password ||
                        response.message.password_confirmation ||
                        response.message.otp ||
                        response.message
                );
                return false;
            }
        },
        startCountdown() {
            if (this.countdown === 0) {
                this.countdown = 60; // Set countdown to 60 seconds

                let interval = setInterval(() => {
                    if (this.countdown > 0) {
                        this.countdown--;
                    } else {
                        clearInterval(interval);
                    }
                }, 1000);
            }
        },
    },

    created() {
        this.csrfToken = $('meta[name="csrf-token"]').attr("content");
        this.setCsrfToken(this.csrfToken);
    },
};
</script>
