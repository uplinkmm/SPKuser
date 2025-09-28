<template>
    <main
        class="w-full h-full min-h-screen mx-auto px-0 pb-2 flex justify-center flex-row relative"
    >
        
        <div class=" w-full">
            <div class="mb-[10vh] text-center pt-24">
                <img src="../../../../public/img/SPK Logo.png" class="bg-black p-4 rounded-full w-20 lg:w-28 h-20 lg:h-28 mb-4 mx-auto" alt="" />
                <p class=" mb-2">
                            ရွှေပေါက်ကံမှ ကြိုဆိုပါတယ်
                </p>
                <p class="text-2xl font-semibold">
                            အကောင့်ဝင်ရန်
                </p>
            </div>
            <div class="" @keyup.enter="login">
                <div class="mb-4">
                    <label class="mb-6 rounded-xl shadow-md bg-white block">
                        <p class="text-xs px-4 pt-4 text-gray-700">
                            {{ $t('Phone Number') }}
                        </p>
                        <input
                            type="text"
                            id="phone_number_login"
                            v-model="phone_number"
                            :placeholder="$t('Phone Number')"
                            class="w-full px-4 pt-2 pb-3 rounded-xl text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </label>

                    
                </div>
                <div class="mb-8 relative">
                    <label class="mb-6 rounded-xl shadow-md bg-white block relative">
                        <p class="text-xs px-4 pt-4 text-gray-700">
                            Password
                        </p>
                        <input
                            :type="show_password ? 'text' : 'password'"
                            id="password_login"
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
                    <button
                        :disabled="loading"
                        @click="login"
                        class="block w-full py-3 px-2 text-sm rounded-full bg-[#000] border border-[#E4BD1B] text-white focus:ring-0 focus:shadow-none focus:outline-none"
                    >
                        {{ loading ? "Loading..." : "Login" }}
                    </button>
                </div>
                <button
                    class="text-sm w-full text-center text-black hover:underline"
                    @click="changeForgotPassword(true)"
                >
                    Forgot password?
                </button>
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
    },
    // mixins: [fcmMixin],

    methods: {
        ...mapMutations(["setUser", "setToken", "setCsrfToken"]),

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
                this.$refs.signinForm.submit();

                return true;
            } else {
                this.setErrorBox(
                    true,
                    response.message ||
                        response.message.phone_number ||
                        response.message.password
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
