<template>
    <main
        class="w-full h-full min-h-[60vh] mx-auto px-8 pb-2 flex flex-row justify-center items-center relative"
    >
        <div class="">
            <div class="relative mb-8">
                <div
                    @click="changeForgotPassword(false)"
                    class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full border border-white cursor-pointer mb-3"
                >
                    <i class="fas fa-chevron-left primary-text"></i>
                </div>

                <p class="text-center font-semibold primary-text">
                    Forgot Password?
                </p>
            </div>

            <div class="mb-4">
                <label
                    class="flex w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white"
                >
                    <input
                        type="text"
                        id="phone_number"
                        v-model="phone_number"
                        :placeholder="$t('Phone Number')"
                        class="focus:ring-0 focus:shadow-none focus:outline-none w-full"
                    />
                    <button
                        class="text-xs border-l border-gray-400 pl-1 py-1 flex-shrink-0"
                        @click="getOtp"
                        :disabled="countdown != 0"
                    >
                        Get OTP
                    </button>
                </label>
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

            <div class="mb-8">
                <input
                    :type="show_password ? 'text' : 'password'"
                    id="password_confirmation"
                    v-model="password_confirmation"
                    placeholder="Confirm Password"
                    :disabled="!otpRequested"
                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
                />
            </div>

            <div>
                <button
                    @click="forgotPassword"
                    :disabled="!otpRequested"
                    class="block w-full py-2.5 px-2 text-sm rounded-md bg-[#000] border border-[#E4BD1B] text-white focus:ring-0 focus:shadow-none focus:outline-none"
                >
                    Confirm
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
            password_confirmation: null,
            code: null,
            remember: true,
            otpRequested: false,
            countdown: 0,
            show_password: false,
        };
    },
    props: {
        fcmToken: {},
        changeForgotPassword: {
            type: Function,
        },
        setErrorBox: {
            type: Function,
        },
    },
    // mixins: [fcmMixin],

    methods: {
        ...mapMutations(["setUser", "setToken", "setCsrfToken"]),

        async getOtp() {
            if (!this.phone_number) {
                this.setErrorBox(true, "You forgot to phone number");

                return 1;
            }
            let formData = new FormData();
            formData.append("phone_number", this.phone_number);
            let url = `/api/get_code`;
            let response = await postApiData({ url: url, form_data: formData });
            if (response.success) {
                this.otpRequested = true;
                this.setErrorBox(false, response.message);
                this.startCountdown();
            } else {
                this.setErrorBox(true, response.message.phone_number);
            }
        },

        async forgotPassword() {
            if (this.countdown == 0) {
                this.setErrorBox(true, "OTP code is expired!");

                return 1;
            }
            if (!this.otp || !this.password || !this.password_confirmation) {
                this.setErrorBox(true, "All field must be entered");

                return 1;
            }
            if (this.countdown == 0) {
                this.setErrorBox(true, "OTP code is expired!");

                return 1;
            }

            if (this.password != this.password_confirmation) {
                this.setErrorBox(true, "Confirm password not match");

                return 1;
            }
            if (
                this.password.length < 6 ||
                this.password_confirmation.length < 6
            ) {
                this.setErrorBox(
                    true,
                    "Password must be at least 6 characters long."
                );

                return;
            }

            let url = "/api/forget_password";
            let formData = new FormData();
            formData.append("phone_number", this.phone_number);
            formData.append("password", this.password);
            formData.append(
                "password_confirmation",
                this.password_confirmation
            );
            formData.append("otp", this.otp);
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
                this.setErrorBox(true, response.message);
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
