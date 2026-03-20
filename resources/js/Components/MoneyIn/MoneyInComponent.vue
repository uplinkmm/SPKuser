<template>
    <notifications position="top center" />
    <div
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4 mb-20">
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

                    <WalletBalancesCard
                        :main-balance="mainMoneyBalance"
                        :game-balance="gameMoneyBalance"
                    />
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
                <div class="-mt-2 pb-24">
                    <div class="bg-[#FDC652] rounded-b-2xl px-4 pb-6 shadow-lg">
                        <div
                            class="rounded-2xl border border-black/30 bg-[#C89A1E] px-4 pt-4 pb-6"
                        >
                            <p
                                class="text-left text-black font-semibold text-xl mb-4"
                            >
                                ဘဏ်အကောင့်အား သေချာစွာစစ်ဆေးပါ
                            </p>

                            <div class="px-4 py-4">
                                <div
                                    v-if="paymentProvider == 'kpay'"
                                    class="flex items-center justify-between gap-x-4"
                                >
                                    <div
                                        class="flex items-center gap-x-4 min-w-0"
                                    >
                                        <div
                                            class="w-24 h-24 rounded-xl bg-[#7A5D10] border border-black/40 overflow-hidden flex items-center justify-center"
                                        >
                                            <img
                                                src="../../../../public/img/kpay.png"
                                                class="w-full h-full object-cover"
                                            />
                                        </div>
                                        <div class="min-w-0">
                                            <p
                                                class="text-black font-semibold text-lg truncate"
                                            >
                                                {{ kpayAccount.name }}
                                            </p>
                                            <p
                                                class="text-black font-semibold text-lg truncate"
                                            >
                                                {{ kpayAccount.phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        @click="
                                            copyPhoneNumber(
                                                kpayAccount.phone_number,
                                            )
                                        "
                                        class="shrink-0 bg-[#5271FF] text-white font-semibold px-5 py-3 rounded-lg"
                                    >
                                        ကူးယူမည်
                                    </button>
                                </div>

                                <div
                                    v-if="paymentProvider == 'wave'"
                                    class="flex items-center justify-between gap-x-4"
                                >
                                    <div
                                        class="flex items-center gap-x-4 min-w-0"
                                    >
                                        <div
                                            class="w-24 h-24 rounded-xl bg-[#7A5D10] border border-black/40 overflow-hidden flex items-center justify-center"
                                        >
                                            <img
                                                src="../../../../public/img/wave.png"
                                                class="w-full h-full object-cover"
                                            />
                                        </div>
                                        <div class="min-w-0">
                                            <p
                                                class="text-black font-semibold text-lg truncate"
                                            >
                                                {{ waveAccount.name }}
                                            </p>
                                            <p
                                                class="text-black font-semibold text-lg truncate"
                                            >
                                                {{ waveAccount.phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        @click="
                                            copyPhoneNumber(
                                                waveAccount.phone_number,
                                            )
                                        "
                                        class="shrink-0 bg-[#5271FF] text-white font-semibold px-5 py-3 rounded-xl"
                                    >
                                        ကူးယူမည်
                                    </button>
                                </div>

                                <div
                                    v-if="paymentProvider == 'aya_pay'"
                                    class="flex items-center justify-between gap-x-4"
                                >
                                    <div
                                        class="flex items-center gap-x-4 min-w-0"
                                    >
                                        <div
                                            class="w-24 h-24 rounded-xl bg-[#7A5D10] border border-black/40 overflow-hidden flex items-center justify-center"
                                        >
                                            <img
                                                src="../../../../public/img/aya_pay.png"
                                                class="w-full h-full object-cover"
                                            />
                                        </div>
                                        <div class="min-w-0">
                                            <p
                                                class="text-black font-semibold text-lg truncate"
                                            >
                                                {{ ayaAccount.name }}
                                            </p>
                                            <p
                                                class="text-black font-semibold text-lg truncate"
                                            >
                                                {{ ayaAccount.phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        @click="
                                            copyPhoneNumber(
                                                ayaAccount.phone_number,
                                            )
                                        "
                                        class="shrink-0 bg-[#5271FF] text-white font-semibold px-5 py-3 rounded-xl"
                                    >
                                        ကူးယူမည်
                                    </button>
                                </div>

                                <div
                                    class="grid grid-cols-3 gap-x-3 mt-4 text-black font-semibold"
                                >
                                    <p class="text-left pl-4">
                                        {{
                                            paymentProvider == "kpay"
                                                ? "KBZ PAY"
                                                : paymentProvider == "wave"
                                                  ? "WAVE PAY"
                                                  : "AYA PAY"
                                        }}
                                    </p>
                                    <p class="text-center">ငွေပမာဏ</p>
                                    <p class="text-right">
                                        {{ amount?.toLocaleString() }} ကျပ်
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <p
                                class="text-center text-black font-semibold text-xl mb-3"
                            >
                                လုပ်ဆောင်မှုအမှတ်၏ နောက်ဆုံးဂဏန်း ၆ လုံး
                            </p>

                            <label
                                class="block rounded-xl bg-[#E5E7EB] overflow-hidden"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="w-14 h-14 flex items-center justify-center bg-[#D1D5DB]"
                                    >
                                        <div
                                            class="w-9 h-9 rounded-full bg-gray-600 flex items-center justify-center"
                                        >
                                            <i
                                                class="fas fa-check text-white"
                                            ></i>
                                        </div>
                                    </div>
                                    <input
                                        type="text"
                                        v-model="paymentTrId"
                                        pattern="\\d*"
                                        @input="
                                            paymentTrId =
                                                $event.target.value.replace(
                                                    /[^0-9]/g,
                                                    '',
                                                )
                                        "
                                        placeholder="နောက်ဆုံး:လက်ကျန် ၆ လုံး ထည့်ပါ"
                                        class="w-full h-14 bg-transparent px-4 text-lg text-black placeholder-gray-400 focus:outline-none focus:ring-0"
                                    />
                                </div>
                            </label>
                        </div>

                        <button
                            @click="makeTopupTransactionBtnClicked"
                            :disabled="loading"
                            class="w-full bg-[#5271FF] disabled:bg-[#5271FF] disabled:text-gray-300 text-white font-semibold py-4 rounded-xl text-xl mt-6"
                        >
                            {{ loading ? "Loading..." : "အတည်ပြုပါ" }}
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
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import WalletBalancesCard from "../Wallet/WalletBalancesCard.vue";
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
        WalletBalancesCard,
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
        ayaAccount() {
            var temp = this.accounts.find((n) => n.account_type == "aya_pay");
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
