<template>
    <notifications position="top center" />
    <div class="w-full h-full bg-gray-200">
        <main
            class="frame-container flex flex-row justify-center items-center relative"
        >
            <div v-if="forgot_password" class="flex justify-center items-center flex-col min-h-screen">
                

                <div class="tab-content w-full">
                    
                    <div>
                        <forgot-password
                            :fcm-token="fcmToken" :change-forgot-password="changeForgotPassword" 
                        ></forgot-password>
                    </div>
                </div>
            </div>
            <div v-if="!forgot_password" class="flex justify-center items-center flex-col min-h-screen">
                <img src="../../../../public/img/ssk 1.png" alt="">
                <ul class="flex space-x-4 mb-6" role="tablist" data-twe-nav-ref>
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
                            :fcm-token="fcmToken" :change-forgot-password="changeForgotPassword"
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
                        ></register-component>
                    </div>
                </div>
            </div>
        </main>
    </div>
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
        };
    },
    mixins: [fcmMixin],

    methods: {
        changeForgotPassword(value){
            this.forgot_password = value;
        }
    },

    mounted() {
        initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });
    },
};
</script>
