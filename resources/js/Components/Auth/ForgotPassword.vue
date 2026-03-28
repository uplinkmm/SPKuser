<template>
    <main
        class="w-full h-full min-h-screen px-0 flex justify-center flex-row relative bg-black"
    >
        <div class="w-full">
            <div
                class="flex items-center justify-between text-center pt-8 pb-6 px-10 md:px-20"
            >
                <img
                    src="../../../../public/img/SPK Logo.png"
                    class="bg-slate-800 p-4 rounded-full w-25 h-25 mb-4"
                    alt=""
                />
                <h3 class="mb-2 text-white text-4xl font-semibold">
                    မင်္ဂလာပါ
                </h3>
            </div>

            <div class="bg-[#FFC529] rounded-3xl px-6 py-6">
                <div class="relative mb-6">
                    <p
                        class="text-center text-black text-xl font-semibold mb-0"
                    >
                        Forgot Password?
                    </p>
                </div>

                <div class="mb-5">
                    <p class="text-black font-semibold mb-2">
                        {{ $t("Phone Number") }}
                    </p>
                    <div class="relative">
                        <i
                            class="fas fa-phone-alt text-gray-500 absolute left-4 top-1/2 -translate-y-1/2"
                        ></i>
                        <input
                            type="text"
                            id="phone_number"
                            v-model="phone_number"
                            :placeholder="$t('Phone Number')"
                            pattern="\\d*"
                            @input="
                                phone_number = $event.target.value.replace(
                                    /[^0-9]/g,
                                    '',
                                )
                            "
                            class="w-full bg-[#D9D9D9] pl-12 pr-28 py-4 rounded-xl text-base text-black placeholder-gray-500 border border-black/30 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                        />
                        <button
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm px-3 py-2 rounded-lg bg-black text-white disabled:bg-gray-600"
                            @click="getOtp"
                            :disabled="countdown != 0"
                        >
                            Get OTP
                        </button>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="text-black font-semibold mb-2">OTP</p>
                    <div class="relative">
                        <i
                            class="fas fa-key text-gray-500 absolute left-4 top-1/2 -translate-y-1/2"
                        ></i>
                        <input
                            type="text"
                            id="otp"
                            v-model="otp"
                            placeholder="OTP"
                            :disabled="!otpRequested"
                            pattern="\\d*"
                            @input="
                                otp = $event.target.value.replace(/[^0-9]/g, '')
                            "
                            class="w-full bg-[#D9D9D9] pl-12 pr-24 py-4 rounded-xl text-base text-black placeholder-gray-500 border border-black/30 focus:outline-none focus:ring-1 focus:ring-black focus:border-black disabled:bg-gray-300"
                        />
                        <div
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-700"
                        >
                            {{
                                countdown > 0
                                    ? countdown.toString().padStart(2, "0") +
                                      " s"
                                    : "00 s"
                            }}
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <p class="text-black font-semibold mb-2">Password</p>
                    <div class="relative">
                        <i
                            class="fas fa-lock text-gray-500 absolute left-4 top-1/2 -translate-y-1/2"
                        ></i>
                        <input
                            :type="show_password ? 'text' : 'password'"
                            id="password"
                            v-model="password"
                            :disabled="!otpRequested"
                            placeholder="Password"
                            class="w-full bg-[#D9D9D9] pl-12 pr-12 py-4 rounded-xl text-base text-black placeholder-gray-500 border border-black/30 focus:outline-none focus:ring-1 focus:ring-black focus:border-black disabled:bg-gray-300"
                        />
                        <button
                            type="button"
                            @click="show_password = !show_password"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-600"
                        >
                            <i
                                v-if="!show_password"
                                class="far fa-eye text-lg"
                            ></i>
                            <i v-else class="far fa-eye-slash text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-10">
                    <p class="text-black font-semibold mb-2">
                        Confirm Password
                    </p>
                    <div class="relative">
                        <i
                            class="fas fa-lock text-gray-500 absolute left-4 top-1/2 -translate-y-1/2"
                        ></i>
                        <input
                            :type="show_password ? 'text' : 'password'"
                            id="password_confirmation"
                            v-model="password_confirmation"
                            placeholder="Confirm Password"
                            :disabled="!otpRequested"
                            class="w-full bg-[#D9D9D9] pl-12 pr-4 py-4 rounded-xl text-base text-black placeholder-gray-500 border border-black/30 focus:outline-none focus:ring-1 focus:ring-black focus:border-black disabled:bg-gray-300"
                        />
                    </div>
                </div>

                <div>
                    <button
                        @click="forgotPassword"
                        :disabled="!otpRequested"
                        class="block disabled:bg-gray-600 w-full py-4 px-2 text-base rounded-xl bg-[#5271FF] text-white font-semibold focus:ring-0 focus:shadow-none focus:outline-none"
                    >
                        Confirm
                    </button>
                </div>
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
                    "Password must be at least 6 characters long.",
                );

                return;
            }

            let url = "/api/forget_password";
            let formData = new FormData();
            formData.append("phone_number", this.phone_number);
            formData.append("password", this.password);
            formData.append(
                "password_confirmation",
                this.password_confirmation,
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
