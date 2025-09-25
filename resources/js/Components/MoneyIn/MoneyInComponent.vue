<template>
    <notifications position="top center" />
    <div class="frame-container min-h-[100vh]">
        <Navbar title="ငွေသွင်းမည်" :back-btn="backBtn"></Navbar>

        <!-- 1st  -->
        <div class="min-h-[100vh]">
            <div class="px-12 py-8 shadow-lg rounded-3xl mb-6 lg:mb-8 bg-white">
                <div>
                    <div class="flex justify-between gap-x-4 mb-4">
                        <p class="flex-grow-0 w-36">
                            <!-- <i class="fal fa-wallet"></i> -->
                            ပင်မ ပိုက်ဆံအိတ်
                        </p>
                        <p class="flex-grow text-right">
                            {{ mainMoneyBalance.toLocaleString() }} MMK
                        </p>
                    </div>
                    <div class="flex justify-between gap-x-4">
                        <p class="flex-grow-0 w-36">
                            <!-- <i class="fal fa-wallet"></i> -->
                            Game ပိုက်ဆံအိတ်
                        </p>
                        <p class="flex-grow text-right">
                            {{ gameMoneyBalance.toLocaleString() }} MMK
                        </p>
                    </div>
                </div>
            </div>

            <div v-show="step == 1" class="contents">
                <div
                    class="px-12 py-8 shadow-lg rounded-3xl mb-6 lg:mb-8 bg-white"
                >
                    <div class="grid grid-cols-3 gap-x-6">
                        <div
                            @click="paymentProviderBtnClicked('kpay')"
                            class="text-center pt-4"
                            :class="{
                                'bg-gray-200 shadow-md rounded-xl':
                                    paymentProvider == 'kpay',
                            }"
                        >
                            <img
                                src="../../../../public/img/kpay.png"
                                class="w-14 mx-auto"
                            />
                            <p>Kpay</p>
                        </div>

                        <div
                            @click="paymentProviderBtnClicked('wave')"
                            class="text-center pt-4"
                            :class="{
                                'bg-gray-200 shadow-md rounded-xl':
                                    paymentProvider == 'wave',
                            }"
                        >
                            <img
                                src="../../../../public/img/wave.png"
                                class="w-14 mx-auto"
                            />
                            <p>Wave</p>
                        </div>
                        <div
                            @click="paymentProviderBtnClicked('aya_pay')"
                            class="text-center pt-4"
                            :class="{
                                'bg-gray-200 shadow-md rounded-xl':
                                    paymentProvider == 'aya_pay',
                            }"
                        >
                            <img
                                src="../../../../public/img/aya_pay.png"
                                class="w-14 mx-auto"
                            />
                            <p>AYA Pay</p>
                        </div>
                    </div>
                </div>

                <div class="w-full max-w-md px-4">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 text-left">
                        ငွေသွင်းမည် ပမာဏ
                    </h2>

                    <label class="mb-6 rounded-xl shadow-md bg-white block">
                        <p class="text-xs px-4 pt-4 text-gray-700">Amount</p>
                        <input
                            type="number"
                            placeholder="Amount"
                            v-model="amount"
                            class="w-full p-4 rounded-xl text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </label>

                    <button
                        @click="changeStepTwo"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-full shadow-md text-xl transition-colors duration-300"
                    >
                        လုပ်ဆောင်မည်
                    </button>

                    <p
                        class="text-center text-gray-700 mt-8 text-base leading-relaxed font-semibold"
                    >
                        ငွေသွင်းငွေထုတ် မြန်ဆန်စေရန်အတွက် <br />ဖော်ပြပါ
                        အကောင့်များသို့သာ ငွေလွှဲရန်
                    </p>
                </div>
            </div>
            <div v-show="step == 2" class="contents">
                <div class="px-8 pt-8 pb-4 shadow-lg rounded-2xl mb-8 bg-white">
                    <div
                        v-if="paymentProvider == 'kpay'"
                        class="flex justify-between w-full items-center mb-2"
                    >
                        <div class="flex text-left">
                            <img
                                src="../../../../public/img/wave.png"
                                alt=""
                                class="w-14 h-14 aspect-square mr-4"
                            />
                            <div class="text-sm">
                                <p class="flex items-center">
                                    {{ kpayAccount.name }}
                                </p>
                                <p>{{ kpayAccount.phone_number }}</p>
                            </div>
                        </div>

                        <button
                            @click="copyPhoneNumber(kpayAccount.phone_number)"
                            class="text-xs"
                        >
                            <i class="fal fa-copy text-2xl"></i>
                            <p>ကူးယူမည်</p>
                        </button>
                    </div>
                    <div
                        v-if="paymentProvider == 'wave'"
                        class="flex justify-between w-full items-center mb-2"
                    >
                        <div class="flex text-left">
                            <img
                                src="../../../../public/img/wave.png"
                                alt=""
                                class="w-14 h-14 aspect-square mr-4"
                            />
                            <div class="text-sm">
                                <p class="flex items-center">
                                    {{ waveAccount.name }}
                                </p>
                                <p>{{ waveAccount.phone_number }}</p>
                            </div>
                        </div>

                        <button
                            @click="copyPhoneNumber(waveAccount.phone_number)"
                            class="text-xs"
                        >
                            <i class="fal fa-copy text-2xl"></i>
                            <p>ကူးယူမည်</p>
                        </button>
                    </div>

                    <p class="text-sm text-center">
                        ငွေသွင်းမည့် ပမာဏ : {{ amount }} Kyats
                    </p>
                </div>

                <div class="w-full max-w-md px-4">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 text-left">
                        လုပ်ဆောင်မှု အမှတ် နောက်ဆုံး ဂဏန်း ၆ လုံး
                    </h2>

                    <label class="mb-6 rounded-xl shadow-md bg-white block">
                        <p class="text-xs px-4 pt-4 text-gray-700">
                            Transaction Number
                        </p>
                        <input
                            type="number"
                            v-model="paymentTrId"
                            placeholder="Transaction Number"
                            class="w-full p-4 rounded-xl text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </label>

                    <button
                        @click="makeTopupTransactionBtnClicked"
                        :disabled="loading"
                        class="w-full bg-blue-500 disabled:bg-blue-500 disabled:text-gray-300 hover:bg-blue-600 text-white font-bold py-3 rounded-full shadow-md text-xl transition-colors duration-300"
                    >
                        {{ loading ? "Loading..." : "ငွေသွင်းမည်" }}
                    </button>

                    <p
                        class="text-center text-gray-700 mt-8 text-base leading-relaxed font-semibold"
                    >
                        ငွေသွင်းငွေထုတ် မြန်ဆန်စေရန်အတွက် <br />ဖော်ပြပါ
                        အကောင့်များသို့သာ ငွေလွှဲရန်
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

export default {
    data() {
        return {
            isPaymentFormShown: false,
            step: 1, //1 ,2
            mainMoneyBalance: 0,
            gameMoneyBalance: 0,

            amount: null,
            paymentProvider: null,
            paymentTrId: null,
            accounts: null,
            loading: false,
        };
    },
    components: {
        Navbar,
    },
    mixins: [CheckAuthMixin],
    computed: {
        kpayAccount() {
            var temp = this.accounts.find((n) => n.account_type == "kpay");
            return temp;
        },
        waveAccount() {
            var temp = this.accounts.find((n) => n.account_type == "wave");
            return temp;
        },
    },
    methods: {
        alertValidationMessage(field) {
            this.$notify({
                title: `Input validation`,
                text: `You forgot to provide ${field}, please try again`,
                type: "warn",
            });
        },

        paymentProviderBtnClicked(paymentProvider) {
            if (this.checkAccount(paymentProvider)) {
                this.paymentProvider = paymentProvider;
            } else {
                this.$notify({
                    text: `${paymentProvider} is temporary out of service!`,
                    type: "error",
                });
            }
        },
        changeStepTwo() {
            if (!this.amount || !this.paymentProvider) {
                this.alertValidationMessage("amount or payment provider");
                return;
            }
            this.step = 2;
        },

        async getBalances() {
            let url = `/api/money_balances`;
            let response = await postApiData({
                url: url,
                token: this.getToken,
            });
            if (response.data) {
                this.mainMoneyBalance = response.data.main_money?.balance;
                this.gameMoneyBalance = response.data.game_money?.balance;
            }
        },
        async getAccounts() {
            let url = `/api/accounts`;
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            if (response.data) {
                this.accounts = response.data;
            }
        },
        checkAccount(type) {
            var temp = this.accounts.find(
                (n) => n.account_type == type && n.deposit.is_active == 1
            );
            if (temp) {
                return true;
            } else {
                return false;
            }
        },

        async makeTopupTransactionBtnClicked() {
            if (!this.amount) {
                this.alertValidationMessage(`cash amount`);
                return 1;
            }
            if (!this.paymentTrId) {
                this.alertValidationMessage(`transaction id`);
                return 1;
            }
            if (this.paymentTrId.toString().length != 6) {
                this.$notify({
                    title: `Input validation`,
                    text: `Transaction id must be 6 digits!`,
                    type: "warn",
                });
                return 1;
            }
            var temp = this.accounts.find(
                (n) => n.account_type == this.paymentProvider
            );
            if (
                this.amount < temp.deposit.min ||
                this.amount > temp.deposit.max
            ) {
                this.$notify({
                    text: `Deposit amount must be between ${temp.deposit.min} and ${temp.deposit.max}`,
                    type: "error",
                });
                return;
            }
            this.loading = true;
            let formData = new FormData();
            formData.append("amount", this.amount);
            formData.append("payment_provider", this.paymentProvider);

            formData.append("account_id", temp.id);
            formData.append("payment_transaction_id", this.paymentTrId);
            let url = `/api/topup_transactions/create`;
            let response = await postApiData({
                url: url,
                form_data: formData,
                token: this.getToken,
            });
            this.loading = false;
            if (response.success) {
                this.$notify({
                    text: response.message,
                    type: "info",
                });
                this.paymentTrId = "";
                setTimeout(() => {
                    window.location.href = "/home";
                }, 100);
            } else {
                this.$notify({
                    text: response.message.payment_transaction_id,
                    type: "error",
                });
            }
        },
        backBtn() {
            if (this.step == 2) {
                this.step = 1;
                return;
            } else {
                window.history.back();

                // window.location.href = "/home";
            }
        },
        copyPhoneNumber(phone_number) {
            const textarea = document.createElement("textarea");
            textarea.value = phone_number;
            document.body.appendChild(textarea);

            textarea.select();
            document.execCommand("copy");

            document.body.removeChild(textarea);

            this.$notify({
                title: `Copy`,
                text: `Copied this phone number!`,
                type: "info",
            });
        },
    },

    created() {
        this.getBalances();
        this.getAccounts();
    },

    mounted() {},
};
</script>
