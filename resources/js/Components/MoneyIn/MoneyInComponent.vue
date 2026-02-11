<template>
    <notifications position="top center" />
    <div
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4">
            <Navbar title="ငွေသွင်းမည်" :back-btn="backBtn"></Navbar>
        </div>

        <!-- 1st  -->
        <div class="min-h-[100vh]">
            <div class="pt-4">
                <div
                    class="bg-[#FDC652] rounded-t-2xl px-4 pt-5 pb-6 shadow-lg"
                >
                    <p
                        class="text-center text-black font-semibold text-2xl mb-4"
                    >
                        ငွေသွင်းမည်
                    </p>

                    <div
                        class="rounded-2xl border border-black/30 bg-[#C89A1E] px-4 py-4"
                    >
                        <div class="space-y-4 text-black">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-x-3 min-w-0">
                                    <img
                                        src="../../../../public/icons/Wallet.png"
                                        class="w-11 pl-1"
                                    />
                                    <p class="font-semibold truncate">
                                        <!-- <i class="fal fa-wallet"></i> -->
                                        ပင်မပိုက်ဆံအိတ်
                                    </p>
                                    <div
                                        class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white text-2xl font-bold"
                                    >
                                        ?
                                    </div>
                                </div>
                                <p class="font-semibold text-xl">
                                    {{ mainMoneyBalance.toLocaleString() }} ကျပ်
                                </p>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-x-3 min-w-0">
                                    <div class="relative w-12 h-9 shrink-0">
                                        <img
                                            src="../../../../public/icons/Wallet.png"
                                            class="w-full h-full object-contain"
                                        />
                                        <img
                                            src="../../../../public/icons/joystick.png"
                                            class="absolute left-0 top-3/4 -translate-y-1/2 w-7 h-7 object-contain"
                                        />
                                    </div>
                                    <p class="font-semibold truncate">
                                        <!-- <i class="fal fa-wallet"></i> -->
                                        ဂိမ်းပိုက်ဆံအိတ်
                                    </p>
                                    <div
                                        class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white text-2xl font-bold"
                                    >
                                        ?
                                    </div>
                                </div>
                                <p class="font-semibold text-xl">
                                    {{ gameMoneyBalance.toLocaleString() }} ကျပ်
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-show="step == 1" class="contents">
                <div class="-mt-2 pb-24">
                    <div class="bg-[#FDC652] rounded-b-2xl px-4 pb-6 shadow-lg">
                        <div
                            class="rounded-2xl border border-black/30 bg-[#C89A1E] px-4 pt-4 pb-6"
                        >
                            <p
                                class="text-center text-black font-semibold text-xl mb-4"
                            >
                                ငွေသွင်းမည် အကောင့် ရွေးချယ်ပါ
                            </p>

                            <div class="grid grid-cols-3 gap-x-4">
                                <button
                                    type="button"
                                    @click="paymentProviderBtnClicked('kpay')"
                                    class="text-center"
                                >
                                    <div
                                        class="h-28 rounded-xl border border-black/30 flex items-center justify-center overflow-hidden"
                                        :class="{
                                            'ring-2 ring-black':
                                                paymentProvider == 'kpay',
                                        }"
                                    >
                                        <img
                                            src="../../../../public/img/kpay.png"
                                            class="w-full mx-auto"
                                        />
                                    </div>
                                    <p class="mt-3 font-semibold text-black">
                                        KBZ PAY
                                    </p>
                                </button>

                                <button
                                    type="button"
                                    @click="paymentProviderBtnClicked('wave')"
                                    class="text-center"
                                >
                                    <div
                                        class="h-28 rounded-xl border border-black/30 flex items-center justify-center overflow-hidden"
                                        :class="{
                                            'ring-2 ring-black':
                                                paymentProvider == 'wave',
                                        }"
                                    >
                                        <img
                                            src="../../../../public/img/wave.png"
                                            class="w-full mx-auto"
                                        />
                                    </div>
                                    <p class="mt-3 font-semibold text-black">
                                        WAVE PAY
                                    </p>
                                </button>

                                <button
                                    type="button"
                                    @click="
                                        paymentProviderBtnClicked('aya_pay')
                                    "
                                    class="text-center"
                                >
                                    <div
                                        class="h-28 rounded-xl border border-black/30 flex items-center justify-center overflow-hidden"
                                        :class="{
                                            'ring-2 ring-black':
                                                paymentProvider == 'aya_pay',
                                        }"
                                    >
                                        <img
                                            src="../../../../public/img/aya_pay.png"
                                            class="w-full mx-auto"
                                        />
                                    </div>
                                    <p class="mt-3 font-semibold text-black">
                                        AYA PAY
                                    </p>
                                </button>
                            </div>
                        </div>

                        <div class="mt-6">
                            <p
                                class="text-left text-black font-semibold text-xl mb-3"
                            >
                                ငွေဖြည့်မည့်ပမာဏ
                            </p>

                            <label
                                class="block rounded-xl bg-[#E5E7EB] overflow-hidden"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="w-14 h-14 flex items-center justify-center bg-[#D1D5DB]"
                                    >
                                        <span class="text-3xl text-white/80"
                                            >$</span
                                        >
                                    </div>
                                    <input
                                        type="number"
                                        placeholder="ငွေပမာဏထည့်ပါ"
                                        v-model="amount"
                                        class="w-full h-14 bg-transparent px-4 text-lg text-black placeholder-gray-400 focus:outline-none focus:ring-0"
                                    />
                                </div>
                            </label>
                        </div>

                        <button
                            @click="changeStepTwo"
                            class="w-full bg-[#5271FF] text-white font-semibold py-4 rounded-xl text-xl mt-6"
                        >
                            ရှေ့ဆက်ရန်
                        </button>

                        <p
                            class="text-center mt-8 text-red-600 text-xl font-semibold leading-relaxed"
                        >
                            ငွေသွင်း ငွေထုတ် မြန်ဆန်စေရန်အတွက် <br />
                            ဖော်ပြပါ ငွေသွင်းအကောင့်များကိုသာ <br />
                            ငွေလွှဲပေးပါရန်
                        </p>
                    </div>
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
                    <h2
                        class="text-base lg:text-xl font-bold mb-6 text-gray-800 text-left"
                    >
                        လုပ်ဆောင်မှု အမှတ် နောက်ဆုံး ဂဏန်း ၆ လုံး
                    </h2>

                    <label class="mb-6 rounded-xl shadow-md bg-white block">
                        <p class="text-xs px-4 pt-4 text-gray-700">
                            Transaction Number
                        </p>
                        <input
                            type="text"
                            v-model="paymentTrId"
                            pattern="\\d*"
                            @input="
                                paymentTrId = $event.target.value.replace(
                                    /[^0-9]/g,
                                    '',
                                )
                            "
                            placeholder="Transaction Number"
                            class="w-full p-4 rounded-xl text-sm lg:text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </label>

                    <button
                        @click="makeTopupTransactionBtnClicked"
                        :disabled="loading"
                        class="w-full bg-blue-500 disabled:bg-blue-500 disabled:text-gray-300 hover:bg-blue-600 text-white font-bold py-3 rounded-full shadow-md text-sm lg:text-xl transition-colors duration-300"
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
                (n) => n.account_type == type && n.deposit.is_active == 1,
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
                (n) => n.account_type == this.paymentProvider,
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
