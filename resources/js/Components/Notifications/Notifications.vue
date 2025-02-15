<template>
    <div
        class="frame-container pb-20 min-h-[100vh] flex flex-col"
    >
        <Navbar title="Notifications" :back-btn="backBtn"></Navbar>
        <div class=" bg-[#fff] px-4 rounded-xl flex-grow">
            <!--Tabs navigation-->
            <ul
                class="flex list-none flex-row flex-wrap border-b-0  px-2 pt-2 mb-2 bg-transparent"
                role="tablist"
                data-twe-nav-ref
            >
                <li role="presentation">
                    <a
                        href="#tabs-winning"
                        class="my-2 block relative px-4 pb-3.5 mb-1 pt-4 text-sm text-neutral-500 hover:isolate focus:isolate data-[twe-nav-active]:text-black data-[twe-nav-active]:dash-under hover:dash-under hover:text-gray-700"
                        data-twe-toggle="pill"
                        data-twe-target="#tabs-winning"
                        data-twe-nav-active
                        role="tab"
                        aria-controls="tabs-winning"
                        aria-selected="true"
                        @click="
                            type = 'betting_win';
                            page = 1;
                            getNotis();
                        "
                        >Winning</a
                    >
                </li>
                <li role="presentation">
                    <a
                        href="#tabs-payment"
                        class="my-2 block relative px-4 pb-3.5 mb-1 pt-4 text-sm text-neutral-500 hover:isolate focus:isolate data-[twe-nav-active]:text-black data-[twe-nav-active]:dash-under hover:dash-under hover:text-gray-700"
                        data-twe-toggle="pill"
                        data-twe-target="#tabs-payment"
                        role="tab"
                        aria-controls="tabs-payment"
                        aria-selected="false"
                        @click="
                            type = 'topup_transaction';
                            page = 1;
                            getNotis();
                        "
                        >Payment</a
                    >
                </li>
                <li role="presentation">
                    <a
                        href="#tabs-promotion"
                        class="my-2 block relative px-4 pb-3.5 mb-1 pt-4 text-sm text-neutral-500 hover:isolate focus:isolate data-[twe-nav-active]:text-black data-[twe-nav-active]:dash-under hover:dash-under hover:text-gray-700"
                        data-twe-toggle="pill"
                        data-twe-target="#tabs-promotion"
                        role="tab"
                        aria-controls="tabs-promotion"
                        aria-selected="false"
                        @click="
                            type = 'ads';
                            page = 1;

                            getNotis();
                        "
                        >Promotion</a
                    >
                </li>
            </ul>

            <div class="mb-6">
                <div
                    class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-winning"
                    role="tabpanel"
                    aria-labelledby="tabs-winning-tab"
                    data-twe-tab-active
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-for="(bet_win, index) in betting_win"
                            :key="index"
                            class="pl-4 lg:pl-4 pr-4 py-6  mb-2 bg-white relative border-b border-gray-300 rounded-md"
                        >
                            <div
                                v-if="bet_win.is_read == 0"
                                class="w-2 h-2 bg-red-600 rounded-full absolute top-6 right-4"
                            ></div>
                            <p class="text-base text-black mb-3 font-semibold">
                                {{ bet_win.preview }}
                            </p>
                            <p class="text-xs font-inter mb-1">
                                {{ dateFormat(bet_win.date_time) }}
                            </p>
                        </div>
                    </div>
                    <div v-if="showSpinner">
                        Loading...
                        <!-- <circle2 background="#000" color="#fff"></circle2> -->
                    </div>
                </div>
                <div
                    class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-payment"
                    role="tabpanel"
                    aria-labelledby="tabs-payment-tab"
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-for="(transcation, index) in topup_transaction"
                            :key="index"
                            class="pl-6 lg:pl-8 pr-8 py-6  mb-2 bg-white relative border-b border-gray-300 rounded-lg"
                        >
                            <div class="flex justify-between">
                                <p class="text-sm  mb-1">
                                    {{ dateFormat(transcation.date_time) }}
                                </p>
                                <p  v-if="transcation.status=='confirmed'" class="text-sm text-green-600 mb-1 capitalize">
                                    {{ transcation.status }}
                                </p>
                                <p v-else class="text-sm text-red-600 mb-1 capitalize">
                                    {{ transcation.status }}
                                </p>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between">
                                <p class="text-xs text-green-600 mb-1 font-semibold">
                                     {{ transcation.notificationable_type == "topup_transaction" ? 'ငွေသွင်း' : 'ငွေထုတ်' }}
                                </p>
                                <p class="text-sm mb-1">
                                    {{ transcation.amount?.toLocaleString() }} ကျပ်
                                </p>
                            </div>
                            <hr class="mt-2 mb-4">
                            <div class="flex justify-between">
                                <p class="text-base font-inter mb-1">
                                    {{ transcation.provider_name }}
                                </p>
                                <p class="text-base font-inter mb-1">
                                    လုပ်ငန်းစဥ်နပါတ်-{{ transcation.payment_transaction_id }}
                                </p>
                            </div>

                            <!-- <div
                                v-if="transcation.is_read == 0"
                                class="w-2 h-2 bg-red-600 rounded-full absolute top-6 right-4"
                            ></div>
                            <p class="text-base text-black mb-3">
                                {{ transcation.preview }}
                            </p>
                            <p class="text-xs font-inter">
                                {{ dateFormat(transcation.date_time) }}
                            </p> -->
                        </div>
                    </div>
                </div>
                <div
                    class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-promotion"
                    role="tabpanel"
                    aria-labelledby="tabs-promotion-tab"
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-for="(promo, index) in promotion"
                            :key="index"
                            class="pl-6 lg:pl-8 pr-8 py-6 mb-0 bg-white relative border-b border-gray-300 flex items-start"
                        >
                            <!-- Image in front -->
                            <img
                                :src="`${img_prefix}${promo.photo}`"
                                class="w-12 h-12 rounded-full mr-4"
                            />

                            <!-- Promotion Content -->
                            <div class="flex-1">
                                <div
                                    class="w-2 h-2 bg-red-600 rounded-full absolute top-6 right-4"
                                ></div>
                                <p class="text-base text-black mb-3">
                                    {{ promo.title }}
                                </p>
                                <p class="text-sm text-black mb-3">
                                    {{ promo.preview }}
                                </p>
                                <p class="text-xs font-inter">
                                    {{ dateFormat(promo.date_time) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-if="showSpinner">
                        Loading...
                        <!-- <circle2 background="#000" color="#fff"></circle2> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations } from "vuex";
import { getApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import moment from "moment";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

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

export default {
    data() {
        return {
            type: "betting_win", // betting_win,topup_transaction,promotion
            betting_win: [],
            topup_transaction: [],
            promotion: [],
            showSpinner: false,
            page: 1,
            last_page: 0,
            img_prefix:""
        };
    },
    components: {
        Navbar,
    },
    computed: {
        ...mapGetters(["getToken", "notiCount", "incomingNewNoti"]),
    },
    mixins: [CheckAuthMixin],

    methods: {
        ...mapMutations(["setNotiCount"]),
        backBtn() {
            // window.location.href = "/home";
            window.history.back();
        },
        async getNotis() {
            this.showSpinner = true;

            let response = await getApiData({
                url: `api/notification_list?type=${this.type}&page=${this.page}&is_count=1`,
                token: this.getToken,
            });
            this.showSpinner = false;
            if (this.page == 1) {
                this.setNotiCount(response.data.count);
            }

            if (this.type == "betting_win") {
                if (this.page == 1) {
                    this.betting_win = response.data.notification_list.data;
                } else {
                    this.betting_win = [
                        ...this.betting_win,
                        ...response.data.notification_list.data,
                    ];
                }
                this.last_page = response.data.last_page;
            }
            if (this.type == "topup_transaction") {
                if (this.page == 1) {
                    this.betting_win = response.data.notification_list.data;
                    this.topup_transaction =
                        response.data.notification_list.data;
                } else {
                    this.topup_transaction = [
                        ...this.topup_transaction,
                        ...response.data.notification_list.data,
                    ];
                }

                this.last_page = response.data.last_page;
            }
            if (this.type == "ads") {
                if (this.page == 1) {
                    this.promotion = response.data.notification_list.data;
                } else {
                    this.promotion = [
                        ...this.promotion,
                        ...response.data.notification_list.data,
                    ];
                }
                this.last_page = response.data.last_page;
            }
        },
        dateFormat(date_time) {
            return moment(date_time).format("YYYY-MM-DD hh:mm A");
        },
        handleScroll() {
            const bottomOfWindow =
                document.documentElement.scrollTop + window.innerHeight;
            const scrollHeight = document.documentElement.scrollHeight;
            const nearEndThreshold = 450;
            var endlessScroll =
                scrollHeight - bottomOfWindow < nearEndThreshold;
            if (
                endlessScroll &&
                this.page >= 1 &&
                this.page < this.last_page &&
                !this.showSpinner
            ) {
                this.page += 1;
                this.getNotis();
            }
        },
    },
    watch: {
        incomingNewNoti(newValue, oldValue) {
            this.page = 1;
            this.type = "betting_win";
            this.betting_win = [];
            this.getNotis();
        },
    },

    created() {},

    mounted() {
        if (window.location.href.includes("shweshankan")) {
            this.img_prefix = "https://admin.shweshankan.com";
        } else {
            this.img_prefix = "http://localhost:8001";
        }
        this.getNotis();
        window.addEventListener("scroll", this.handleScroll);

        initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
};
</script>
