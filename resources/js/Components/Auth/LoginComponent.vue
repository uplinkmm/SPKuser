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
            <div
                class="bg-[#FFC529] rounded-3xl px-6 py-6"
                @keyup.enter="login"
            >
                <p class="text-center text-black text-xl font-semibold mb-6">
                    အကောင့်ဝင်ပါ
                </p>

                <div class="mb-5">
                    <p class="text-black font-semibold mb-2">ဖုန်းနံပါတ်</p>
                    <div class="relative">
                        <i
                            class="fas fa-phone-alt text-gray-500 absolute left-4 top-1/2 -translate-y-1/2"
                        ></i>
                        <input
                            type="text"
                            id="phone_number_login"
                            v-model="phone_number"
                            pattern="\\d*"
                            @input="
                                phone_number = $event.target.value.replace(
                                    /[^0-9]/g,
                                    '',
                                )
                            "
                            placeholder="09 XXX XXX XXX"
                            class="w-full bg-[#D9D9D9] pl-12 pr-4 py-4 rounded-xl text-base text-black placeholder-gray-500 border border-black/30 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
                        />
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-black font-semibold mb-2">စကားဝှက်</p>
                    <div class="relative">
                        <i
                            class="fas fa-lock text-gray-500 absolute left-4 top-1/2 -translate-y-1/2"
                        ></i>
                        <input
                            :type="show_password ? 'text' : 'password'"
                            id="password_login"
                            v-model="password"
                            placeholder="စကားဝှက်ထည့်ပါ"
                            class="w-full bg-[#D9D9D9] pl-12 pr-12 py-4 rounded-xl text-base text-black placeholder-gray-500 border border-black/30 focus:outline-none focus:ring-1 focus:ring-black focus:border-black"
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
                    <button
                        :disabled="loading"
                        @click="login"
                        class="block disabled:bg-gray-600 w-full py-4 px-2 text-base rounded-xl bg-[#5271FF] text-white font-semibold focus:ring-0 focus:shadow-none focus:outline-none"
                    >
                        <span v-if="!loading">အကောင့်ဝင်ပါ</span>
                        <i v-else class="fal fa-spinner animate-spin w-10"></i>
                    </button>
                </div>

                <button
                    class="text-base w-full text-center mb-8 text-[#1d4ed8] font-medium"
                    @click="changeForgotPassword(true)"
                >
                    စကားဝှက်မေ့နေလား ?
                </button>
                <button
                    class="text-base w-full text-center text-[#1d4ed8] font-medium"
                    @click="setIsLogin(false)"
                >
                    အကောင့်အသစ်ဖွင့်မည်
                </button>

                <div class="mt-10 text-center">
                    <p class="text-black font-semibold mb-0">
                        www.shwepaukkan.com
                    </p>
                </div>
            </div>
        </div>
        <form
            method="POST"
            id="signin-form-login"
            ref="signinForm"
            action="/login"
        >
            <input type="hidden" v-model="csrfToken" name="_token" />
            <input type="hidden" v-model="phone_number" name="phone_number" />
            <input type="hidden" v-model="password" name="password" />
            <input type="hidden" name="remember" value="true" />
        </form>
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
            loading: false,
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
        setIsLogin: {
            type: Function,
        },
    },
    // mixins: [fcmMixin],

    methods: {
        ...mapMutations([
            "setUser",
            "setToken",
            "setCsrfToken",
            "setBuffaloAuth",
        ]),

        async login() {
            // if (!this.password || !this.phone_number) {
            //     this.setErrorBox(true, "Please fill all field!");
            //     return;
            // }
            // if (this.password.length < 6) {
            //     this.setErrorBox(
            //         true,
            //         "Password must be at least 6 characters long."
            //     );
            //     return;
            // }

            let url = "/api/login";
            let formData = new FormData();
            formData.append("phone_number", this.phone_number);
            formData.append("password", this.password);
            formData.append("fcm_token", this.fcmToken); //from mixin
            this.loading = true;
            let response = await postApiData({ url: url, form_data: formData });
            this.loading = false;
            if (response.data) {
                this.setErrorBox(false, response.message);
                this.token = response.data.token;
                this.setToken(this.token);
                let user = response.data.user;
                this.setUser(user);
                let buffaloAuth = response.data.auth;
                this.setBuffaloAuth(buffaloAuth);
                this.$refs.signinForm.submit();

                return true;
            } else {
                this.setErrorBox(
                    true,
                    response.message ||
                        response.message.phone_number ||
                        response.message.password,
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
