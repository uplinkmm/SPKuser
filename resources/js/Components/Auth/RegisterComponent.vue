<template>
    <main
        class="w-full h-full mx-auto px-0 pb-2 flex flex-row justify-center relative"
    >
        <div class="w-full">
            <div class="mb-[5vh] pt-16 text-center">
                <p class="text-base mb-3 font-semibold">အကောင့်ဖွင့်ရန်</p>
                <img
                    src="../../../../public/img/SPK Logo.png"
                    class="bg-black p-4 rounded-full w-20 lg:w-28 h-20 lg:h-28 mb-6 mx-auto"
                    alt=""
                />
                <p class="text-sm mb-4">
                    OTP ကျမလာပါ Customer Service သို့ ဆက်သွယ်နိုင်ပါသည်
                </p>

                <button
                    class="w-fit px-8 bg-black disabled:bg-black disabled:text-gray-300 hover:bg-black text-white font-bold py-3 rounded-md shadow-md text-sm transition-colors duration-300"
                >
                    <i class="fal fa-phone mr-4 w-4"></i>Call Customer Service
                </button>
            </div>
            <div class="mb-4">
                <label class="mb-6 rounded-xl shadow-md bg-white block">
                    <p class="text-xs px-4 pt-4 text-gray-700">
                        {{ $t("Name") }}
                    </p>
                    <input
                        type="text"
                        id="user_name"
                        v-model="user_name"
                        :placeholder="$t('Name')"
                        class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                    />
                </label>
            </div>
            <div class="mb-4">
                <label class="mb-6 rounded-xl shadow-md bg-white block">
                    <p class="text-xs px-4 pt-4 text-gray-700">
                        {{ $t("Phone Number") }}
                    </p>
                    <div class="relative">
                        <input
                            type="text"
                            id="phone_number"
                            v-model="phone_number"
                            :placeholder="$t('Phone Number')"
                            pattern="\\d*"
                            @input="
                                phone_number = $event.target.value.replace(
                                    /[^0-9]/g,
                                    ''
                                )
                            "
                            class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </div>
                </label>
            </div>

            <div class="mb-4 relative">
                <label
                    class="mb-6 rounded-xl shadow-md bg-white block relative"
                >
                    <p class="text-xs px-4 pt-4 text-gray-700">Password</p>
                    <input
                        :type="show_password ? 'text' : 'password'"
                        id="password"
                        v-model="password"
                        placeholder="Password"
                        class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                    />
                    <i
                        v-if="!show_password"
                        @click="show_password = !show_password"
                        class="far fa-eye text-lg absolute right-3 bottom-6 transform translate-y-4 cursor-pointer"
                    ></i>
                    <i
                        v-if="show_password"
                        @click="show_password = !show_password"
                        class="far fa-eye-slash text-lg absolute right-3 bottom-6 transform translate-y-4 cursor-pointer"
                    ></i>
                </label>
            </div>

            <div class="mb-4">
                <label class="mb-6 rounded-xl shadow-md bg-white block">
                    <p class="text-xs px-4 pt-4 text-gray-700">
                        Confirm Password
                    </p>
                    <input
                        :type="show_password ? 'text' : 'password'"
                        id="confirm_password"
                        v-model="confirm_password"
                        placeholder="Confirm Password"
                        class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                    />
                </label>
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
            <div class="mb-8">
                <label
                    class="mb-6 rounded-xl shadow-md bg-white block relative"
                >
                    <p class="text-xs px-4 pt-4 text-gray-700">
                        Referral Phone Number
                    </p>
                    <div class="relative">
                        <button
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 text-xs border-r border-gray-400 pr-2 py-1"
                        >
                            <p class="text-[14px]">09</p>
                        </button>
                        <input
                            type="text"
                            id="referral_phone_number"
                            v-model="referral_phone_number"
                            placeholder="xxxxxxx"
                            pattern="\\d*"
                            @input="
                                referral_phone_number =
                                    $event.target.value.replace(/[^0-9]/g, '')
                            "
                            class="w-full px-4 pt-2 pb-3 pl-12 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </div>
                </label>
            </div>
            <div>
                <button
                    @click="register"
                    :disabled="register_loading"
                    class="block w-full py-3 px-2 text-sm rounded-full border border-[#E4BD1B] bg-black text-white focus:ring-0 focus:shadow-none"
                >
                    <p v-if="register_loading">
                        <i class="fal fa-spinner animate-spin"></i>
                    </p>
                    <p v-else>Sign Up</p>
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
            password: null,
            confirm_password: null,
            referral_phone_number: null,

            // code: null,
            remember: true,
            show_password: false,
            register_loading: false,
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

        async register() {
            if (!this.user_name || !this.phone_number) {
                this.setErrorBox(
                    true,
                    "You forgot to enter name and phone number"
                );
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
            // formData.append("code", this.code);
            formData.append(
                "referral_phone_number",
                this.referral_phone_number
            );
            formData.append("fcm_token", this.fcmToken); //from mixin
            this.register_loading = true;
            let response = await postApiData({ url: url, form_data: formData });
            this.register_loading = false;
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
                        response.message.referral_phone_number ||
                        response.message
                );
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
