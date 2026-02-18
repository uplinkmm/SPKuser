<template>
    <div
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="px-4">
            <Navbar title="Payment History" :back-btn="backBtn"></Navbar>
        </div>

        <div
            class="bg-[#FDC652] rounded-t-3xl shadow-lg px-4 pt-4 pb-6 mt-4 min-h-[calc(100vh-120px)]"
        >
            <p class="text-center mb-3 font-semibold text-2xl text-black">
                ငွေသွင်း ငွေထုတ်မှတ်တမ်း
            </p>

            <div
                class="rounded-2xl border border-black/30 bg-[#C89A1E] px-3 pt-3 pb-4"
            >
                <ul
                    class="flex list-none flex-row flex-wrap border-b-0 ps-0 px-2 pb-2 mb-2 text-back justify-center"
                    role="tablist"
                    data-twe-nav-ref
                >
                    <li role="presentation">
                        <a
                            href="#tabs-twoD"
                            class="my-2 block px-2 pb-3.5 pt-4 text-sm text-black hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-green-600 font-semibold ml-3"
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
                        >
                            ငွေသွင်း
                        </a>
                    </li>
                    <li role="presentation">
                        <a
                            href="#tabs-threeD"
                            class="my-2 block px-2 pb-3.5 pt-4 text-sm text-black hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-green-600 font-semibold"
                            data-twe-toggle="pill"
                            data-twe-target="#tabs-threeD"
                            role="tab"
                            aria-controls="tabs-threeD"
                            aria-selected="false"
                            @click="
                                type = 'cash_withdrawal_transaction';
                                getHistories();
                            "
                        >
                            ငွေထုတ်
                        </a>
                    </li>
                    <li role="presentation">
                        <a
                            href="#tabs-transfer"
                            class="my-2 block px-2 pb-3.5 pt-4 text-sm text-black hover:isolate focus:isolate data-[twe-nav-active]:border-b-2 border-green-600 font-semibold"
                            data-twe-toggle="pill"
                            data-twe-target="#tabs-transfer"
                            role="tab"
                            aria-controls="tabs-transfer"
                            aria-selected="false"
                            @click="
                                type = 'wallet_transfer';
                                getHistories();
                            "
                        >
                            ငွေချိန်း
                        </a>
                    </li>
                </ul>

                <div class="mb-2">
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
                                class="rounded-xl bg-[#d9d9d9] border border-black/40 overflow-hidden mb-4"
                            >
                                <div
                                    class="flex items-center justify-between px-4 py-2 border-b border-black/40"
                                >
                                    <p class="text-sm font-medium">
                                        {{ dateTimeDisplay(history.date) }}
                                    </p>
                                    <p
                                        class="text-sm font-semibold"
                                        :class="statusTextClass(history.status)"
                                    >
                                        {{ statusLabel(history.status) }}
                                    </p>
                                </div>

                                <div
                                    class="grid grid-cols-3 items-center px-4 py-3 border-b border-black/40"
                                >
                                    <p class="text-sm font-semibold">
                                        ငွေသွင်း:
                                    </p>
                                    <p
                                        class="text-sm font-semibold text-center"
                                    >
                                        ငွေပမာဏ
                                    </p>
                                    <p class="text-sm font-semibold text-right">
                                        {{ history.amount?.toLocaleString() }}
                                        ကျပ်
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 px-4 py-3">
                                    <p class="text-sm">
                                        {{
                                            history.account?.account_type || "-"
                                        }}
                                    </p>
                                    <p class="text-sm text-right">
                                        {{
                                            history.account?.phone_number || "-"
                                        }}
                                    </p>
                                </div>
                            </div>

                            <div
                                v-if="!topup_transaction?.length"
                                class="rounded-xl bg-[#d9d9d9] border border-black/40 px-4 py-10 text-center text-gray-700"
                            >
                                No deposit history.
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
                                class="rounded-xl bg-[#d9d9d9] border border-black/40 overflow-hidden mb-4"
                            >
                                <div
                                    class="flex items-center justify-between px-4 py-2 border-b border-black/40"
                                >
                                    <p class="text-sm font-medium">
                                        {{ dateTimeDisplay(history.date) }}
                                    </p>
                                    <p
                                        class="text-sm font-semibold"
                                        :class="statusTextClass(history.status)"
                                    >
                                        {{ statusLabel(history.status) }}
                                    </p>
                                </div>

                                <div
                                    class="grid grid-cols-3 items-center px-4 py-3 border-b border-black/40"
                                >
                                    <p class="text-sm font-semibold">ငွေထုတ်</p>
                                    <p
                                        class="text-sm font-semibold text-center"
                                    >
                                        ငွေပမာဏ
                                    </p>
                                    <p class="text-sm font-semibold text-right">
                                        {{ history.amount?.toLocaleString() }}
                                        ကျပ်
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 px-4 py-3">
                                    <p class="text-sm">
                                        {{
                                            history.account?.account_type || "-"
                                        }}
                                    </p>
                                </div>

                                <!-- <div class="flex justify-between mb-3">
                                <p class="text-base font-semibold">ငွေထုတ်</p>
                                <p class="text-base font-semibold">
                                    {{ history.amount?.toLocaleString() }} ကျပ်
                                </p>
                            </div>
                            <div class="flex justify-between mb-3">
                                <p class="text-base">
                                    {{ history.account.account_type }}
                                </p>
                            </div> -->
                                <!-- <div class="flex justify-between mb-3">
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
                            </div> -->
                            </div>

                            <div
                                v-if="!cash_withdrawal_transaction?.length"
                                class="rounded-xl bg-[#d9d9d9] border border-black/40 px-4 py-10 text-center text-gray-700"
                            >
                                No withdrawal history.
                            </div>
                        </div>
                    </div>

                    <div
                        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                        id="tabs-transfer"
                        role="tabpanel"
                        aria-labelledby="tabs-transfer-tab"
                    >
                        <div class="mx-0 pb-8">
                            <div
                                v-for="(history, index) in wallet_transfer"
                                :key="index"
                                class="rounded-xl bg-[#d9d9d9] border border-black/40 overflow-hidden mb-4"
                            >
                                <div
                                    class="flex items-center justify-between px-4 py-2 border-b border-black/40"
                                >
                                    <p class="text-sm font-medium">
                                        {{ dateTimeDisplay(history.date) }}
                                    </p>
                                    <p
                                        class="text-sm font-semibold"
                                        :class="statusTextClass(history.status)"
                                    >
                                        {{ statusLabel(history.status) }}
                                    </p>
                                </div>

                                <div
                                    class="grid grid-cols-3 items-center px-4 py-3 border-b border-black/40"
                                >
                                    <p class="text-sm font-semibold">
                                        ငွေချိန်း
                                    </p>
                                    <p
                                        class="text-sm font-semibold text-center"
                                    >
                                        ငွေပမာဏ
                                    </p>
                                    <p class="text-sm font-semibold text-right">
                                        {{ history.amount?.toLocaleString() }}
                                        ကျပ်
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 px-4 py-3">
                                    <p class="text-sm">
                                        {{ history.transfer_type }}
                                    </p>
                                </div>
                            </div>

                            <div
                                v-if="!wallet_transfer?.length"
                                class="rounded-xl bg-[#d9d9d9] border border-black/40 px-4 py-10 text-center text-gray-700"
                            >
                                No transfer history.
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
            wallet_transfer: [],
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
            if (this.type == "wallet_transfer") {
                this.wallet_transfer = response.data;
            }
        },
        dateTimeDisplay(date_time) {
            return moment(date_time).format("D.M.YYYY, hh:mm:ss A");
        },
        statusLabel(status) {
            if (status === "confirmed") return "Approved";
            if (status === "completed") return "Completed";
            if (status === "rejected") return "Rejected";
            if (status === "pending") return "Pending";
            return status;
        },
        statusTextClass(status) {
            if (status === "confirmed" || status === "completed")
                return "text-green-700";
            if (status === "rejected") return "text-red-600";
            if (status === "pending") return "text-orange-500";
            return "text-black";
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
