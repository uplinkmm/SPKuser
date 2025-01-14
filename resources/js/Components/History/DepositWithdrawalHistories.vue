<template>
    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto bg-img px-3 pb-0 min-h-[100vh]"
    >
        <Navbar title="Payment History" :back-btn="backBtn"></Navbar>

        <div class="">
            <ul
                class="flex list-none flex-row flex-wrap border-b-0 ps-0 px-4 pb-2 mb-4 bg-[#FDC652] text-white"
                role="tablist"
                data-twe-nav-ref
            >
                <li role="presentation">
                    <a
                        href="#tabs-twoD"
                        class="my-2 block px-2 pb-3.5 pt-4 text-sm text-white hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-white font-semibold ml-3"
                        data-twe-toggle="pill"
                        data-twe-target="#tabs-twoD"
                        data-twe-nav-active
                        role="tab"
                        aria-controls="tabs-twoD"
                        aria-selected="true"
                        @click="
                            type = 'topup_transaction';
                            getHistories();
                        "
                        >ငွေသွင်းမှတ်တမ်း</a
                    >
                </li>
                <li role="presentation">
                    <a
                        href="#tabs-threeD"
                        class="my-2 block px-2 pb-3.5 pt-4 text-sm text-white hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-white font-semibold"
                        data-twe-toggle="pill"
                        data-twe-target="#tabs-threeD"
                        role="tab"
                        aria-controls="tabs-threeD"
                        aria-selected="false"
                        @click="
                            type = 'cash_withdrawal_transaction';
                            getHistories();
                        "
                        >ငွေထုတ်မှတ်တမ်း</a
                    >
                </li>
            </ul>

            <div class="mb-6">
                <div
                    class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-twoD"
                    role="tabpanel"
                    aria-labelledby="tabs-twoD-tab"
                    data-twe-tab-active
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-for="(history, index) in topup_transaction"
                            :key="index"
                            class="pl-6 lg:pl-8 pr-8 py-4 shadow-lg rounded-2xl mb-8 bg-white relative"
                        >
                            <div class="flex justify-between mb-3">
                                <p class="text-base font-semibold">ငွေသွင်း</p>
                                <p class="text-base font-semibold">
                                    {{ history.amount?.toLocaleString() }} ကျပ်
                                </p>
                            </div>
                            <div class="flex justify-between mb-3">
                                <p class="text-base">
                                    {{ history.account.account_type }}
                                </p>
                                <p class="text-base">
                                    {{ history.account.phone_number }}
                                </p>
                            </div>
                            <div class="flex justify-between mb-3">
                                <p class="text-base">
                                    {{ dateFormat(history.date) }}
                                </p>
                                <p
                                    class="text-base text-yellow-600"
                                    v-if="history.status == 'pending'"
                                >
                                    {{ history.status }}
                                </p>
                                <p
                                    class="text-base text-red-600"
                                    v-if="history.status == 'rejected'"
                                >
                                    {{ history.status }}
                                </p>
                                <p
                                    class="text-base text-green-600"
                                    v-if="history.status == 'confirmed'"
                                >
                                    {{ history.status }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-threeD"
                    role="tabpanel"
                    aria-labelledby="tabs-threeD-tab"
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-for="(
                                history, index
                            ) in cash_withdrawal_transaction"
                            :key="index"
                            class="pl-6 lg:pl-8 pr-8 py-4 shadow-lg rounded-2xl mb-8 bg-white relative"
                        >
                            <div class="flex justify-between mb-3">
                                <p class="text-base font-semibold">ငွေထုတ်</p>
                                <p class="text-base font-semibold">
                                    {{ history.amount?.toLocaleString() }} ကျပ်
                                </p>
                            </div>
                            <div class="flex justify-between mb-3">
                                <p class="text-base">
                                    {{ history.account.account_type }}
                                </p>
                                <!-- <p class="text-base">hihi</p> -->
                            </div>
                            <div class="flex justify-between mb-3">
                                <p class="text-base">
                                    {{ dateFormat(history.date) }}
                                </p>
                                <p
                                    class="text-base text-yellow-600"
                                    v-if="history.status == 'pending'"
                                >
                                    {{ history.status }}
                                </p>
                                <p
                                    class="text-base text-red-600"
                                    v-if="history.status == 'rejected'"
                                >
                                    {{ history.status }}
                                </p>
                                <p
                                    class="text-base text-green-600"
                                    v-if="history.status == 'confirmed'"
                                >
                                    {{ history.status }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
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
            type: "topup_transaction", //cash_withdrawal_transaction
            topup_transaction: [],
            cash_withdrawal_transaction: [],
        };
    },
    components: {
        Navbar,
    },
    computed: {
        ...mapGetters(["getToken"]),
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            // window.location.href = "/home";
            window.history.back();
        },
        async getHistories() {
            let response = await getApiData({
                url: `api/transaction_history?type=${this.type}`,
                token: this.getToken,
            });
            if (this.type == "topup_transaction") {
                this.topup_transaction = response.data;
            }
            if (this.type == "cash_withdrawal_transaction") {
                this.cash_withdrawal_transaction = response.data;
            }
        },
        dateFormat(date_time) {
            return moment(date_time).format("YYYY-MM-DD hh:mm A");
        },
    },

    mounted() {
        this.getHistories();
        initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });
    },
};
</script>
