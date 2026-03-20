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
            <Navbar :title="$t('Withdrawal')" :back-btn="backBtn"></Navbar>
        </div>

        <!-- 1st  -->
        <div class="bg-[#FDC652] rounded-t-2xl">
            <div class="pt-4">
                <div class="px-4 pt-5 pb-6">
                    <p
                        class="text-center text-black font-semibold text-2xl mb-4"
                    >
                        ငွေထုတ်မည်
                    </p>

                    <WalletBalancesCard
                        :main-balance="mainMoneyBalance"
                        :game-balance="gameMoneyBalance"
                    />
                </div>
            </div>
            <div v-show="step == 1" class="contents">
                <div class="-mt-2 pb-24">
                    <div class="bg-[#FDC652] px-4 pb-6 shadow-lg">
                        <div
                            class="rounded-2xl border border-black/30 bg-[#C89A1E] px-4 pt-4 pb-6"
                        >
                            <p
                                class="text-center text-black font-semibold text-xl mb-4"
                            >
                                ငွေထုတ်မည် အကောင့် ရွေးချယ်ပါ
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
                                                payment_provider == 'kpay',
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
                                                payment_provider == 'wave',
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
                                                payment_provider == 'aya_pay',
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
                                ငွေထုတ်မည့်ပမာဏ
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
                            ဖော်ပြပါ ငွေထုတ်အကောင့်များကို <br />
                            သေချာစွာ စစ်ဆေးပေးပါ
                        </p>
                    </div>
                </div>
            </div>
            <div v-show="step == 2" class="contents">
                <div class="pb-24">
                    <div class="px-4 pb-6">
                        <div
                            class="rounded-2xl border border-black/30 bg-[#C89A1E] px-4 py-4 mt-4"
                        >
                            <div
                                class="grid grid-cols-3 gap-x-3 text-black font-semibold"
                            >
                                <p class="text-left">
                                    {{
                                        payment_provider == "kpay"
                                            ? "KBZ PAY"
                                            : payment_provider == "wave"
                                              ? "WAVE PAY"
                                              : "AYA PAY"
                                    }}
                                </p>
                                <p class="text-center">ပမာဏ</p>
                                <p class="text-right">
                                    {{ amount?.toLocaleString() }} ကျပ်
                                </p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <p
                                class="text-left text-black font-semibold text-xl mb-3"
                            >
                                ဘဏ်အကောင့်နံပါတ် (သို့) ဖုန်းနံပါတ်
                            </p>
                            <label
                                class="block rounded-xl bg-[#E5E7EB] overflow-hidden"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="w-16 h-14 flex items-center justify-center bg-[#D1D5DB]"
                                    >
                                        <div
                                            class="w-9 h-9 rounded-full bg-gray-500 flex items-center justify-center"
                                        >
                                            <i
                                                class="fas fa-university text-white"
                                            ></i>
                                        </div>
                                    </div>
                                    <input
                                        type="text"
                                        placeholder="ဘဏ်အကောင့်နံပါတ်(သို့)ဖုန်းနံပါတ်ထည့်ပါ"
                                        v-model="phoneNumber"
                                        class="w-full h-14 bg-transparent px-4 text-lg text-black placeholder-gray-400 focus:outline-none focus:ring-0"
                                    />
                                </div>
                            </label>
                        </div>

                        <div class="mt-6">
                            <p
                                class="text-left text-black font-semibold text-xl mb-3"
                            >
                                ဘဏ်အကောင့်အမည်
                            </p>
                            <label
                                class="block rounded-xl bg-[#E5E7EB] overflow-hidden"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="w-16 h-14 flex items-center justify-center bg-[#D1D5DB]"
                                    >
                                        <div
                                            class="w-9 h-9 rounded-full bg-gray-500 flex items-center justify-center"
                                        >
                                            <i
                                                class="fas fa-user text-white"
                                            ></i>
                                        </div>
                                    </div>
                                    <input
                                        type="text"
                                        placeholder="ဘဏ်အကောင့်အမည်ထည့်ပါ"
                                        v-model="accountName"
                                        class="w-full h-14 bg-transparent px-4 text-lg text-black placeholder-gray-400 focus:outline-none focus:ring-0"
                                    />
                                </div>
                            </label>
                        </div>

                        <div class="mt-6">
                            <p
                                class="text-left text-black font-semibold text-xl mb-3"
                            >
                                ရွှေပေါက်ကံအကောင့်၏ စကားဝှက်
                            </p>
                            <label
                                class="block rounded-xl bg-[#E5E7EB] overflow-hidden"
                            >
                                <div class="flex items-center">
                                    <div
                                        class="w-16 h-14 flex items-center justify-center bg-[#D1D5DB]"
                                    >
                                        <div
                                            class="w-9 h-9 rounded-full bg-gray-500 flex items-center justify-center"
                                        >
                                            <i
                                                class="fas fa-lock text-white"
                                            ></i>
                                        </div>
                                    </div>
                                    <input
                                        type="password"
                                        placeholder="စကားဝှက်ထည့်ပါ"
                                        v-model="password"
                                        class="w-full h-14 bg-transparent px-4 text-lg text-black placeholder-gray-400 focus:outline-none focus:ring-0"
                                    />
                                </div>
                            </label>
                        </div>

                        <button
                            @click="makeCashWithdrawBtnClicked"
                            :disabled="loading"
                            class="w-full bg-[#5271FF] disabled:bg-[#5271FF] disabled:text-gray-300 text-white font-semibold py-4 rounded-xl text-xl mt-8"
                        >
                            {{ loading ? "Loading..." : "အတည်ပြုပါ" }}
                        </button>

                        <p
                            class="text-center mt-8 text-red-600 text-xl font-semibold leading-relaxed"
                        >
                            ငွေသွင်း ငွေထုတ် မြန်ဆန်စေရန်အတွက် <br />
                            မိမိထည့်သွင်းမည့် ဘဏ်အကောင့်ကို <br />
                            သေချာစွာ စစ်ဆေးပေးပါ
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="px-12 py-16 shadow-lg rounded-2xl mb-8 bg-white">
            <div class="flex flex-col gap-y-4">
                <a href="/history" class="flex items-center">
                    <i class="fal fa-wallet mr-4 w-4"></i>
                    <p>{{ $t("History") }}</p>
                </a>
                <a href="#" class="flex items-center">
                    <i class="fal fa-wallet mr-4 w-4"></i>
                    <p>ငွေဖြည့်နည်း ကြည့်ရန်</p>
                </a>
                <a href="#" class="flex items-center">
                    <i class="fal fa-wallet mr-4 w-4"></i>
                    <p>ငွေသွင်းနည်း ကြည့်ရန်</p>
                </a>
                <a href="#" class="flex">
                    <i class="fal fa-wallet mr-4 w-4 pt-1"></i>
                    <p>
                        ပင်မ ပိုက်ဆံအိတ်မှ ဂိမ်း ပိုက်ဆံအိတ်သို့ လွှဲနည်း
                        ကြည့်ရန်
                    </p>
                </a>
                <a href="#" class="flex items-center">
                    <i class="fal fa-wallet mr-4 w-4"></i>
                    <p>Contacts</p>
                </a>
            </div>
        </div> -->
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";
import Navbar from "../Nav/Navbar.vue";
import WalletBalancesCard from "../Wallet/WalletBalancesCard.vue";

export default {
    name: "MoneyOut",
    components: {
        Navbar,
        WalletBalancesCard,
    },
    data() {
        return {
            mainMoneyBalance: 0,
            gameMoneyBalance: 0,

            amount: null,
            accountName: null,
            phoneNumber: null,
            password: null,
            step: 1, //1-choose provider ,2 - payment
            payment_provider: "",
            accounts: "",
            loading: false,
        };
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            if (this.step == 2) {
                this.step = 1;
                return;
            } else {
                window.history.back();
                return;
            }
        },
        alertValidationMessage(field) {
            this.$notify({
                title: `Input validation`,
                text: `You forgot to provide ${field}, please try again`,
                type: "warn",
            });
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
        changeStepTwo() {
            if (!this.payment_provider || !this.amount) {
                this.alertValidationMessage(`payment provider or amount`);
                return;
            }
            this.step = 2;
        },
        async makeCashWithdrawBtnClicked() {
            if (!this.amount) {
                this.alertValidationMessage(`cash amount`);
                return 1;
            }
            if (!this.accountName) {
                this.alertValidationMessage(`account name`);
                return 1;
            }
            if (!this.phoneNumber) {
                this.alertValidationMessage(`phone number`);
                return 1;
            }
            if (!this.password) {
                this.alertValidationMessage(`password`);
                return 1;
            }
            var temp = this.accounts.find(
                (n) => n.account_type == this.payment_provider,
            );
            if (
                this.amount < temp.withdrawal.min ||
                this.amount > temp.withdrawal.max
            ) {
                this.$notify({
                    text: `Deposit amount must be between ${temp.withdrawal.min} and ${temp.withdrawal.max}`,
                    type: "error",
                });
                return;
            }
            let formData = new FormData();
            formData.append("amount", this.amount);
            formData.append("account_name", this.accountName);
            formData.append("phone_number", this.phoneNumber);
            formData.append("password", this.password);
            formData.append("payment_provider", this.payment_provider); //kpay , wave

            formData.append("account_id", temp.id);
            let url = `/api/cash_withdrawl_transactions/create`;
            this.loading = true;
            let response = await postApiData({
                url: url,
                form_data: formData,
                token: this.getToken,
            });

            if (response.success) {
                this.amount = "";
                this.accountName = "";
                this.phoneNumber = "";
                this.password = "";
                this.$notify({
                    text: response.message,
                    type: "info",
                });
                setTimeout(() => {
                    window.location.href = "/home";
                }, 100);
            } else {
                this.$notify({
                    text: response.message,
                    type: "error",
                });
            }
            this.loading = false;
        },
        paymentProviderBtnClicked(type) {
            if (this.checkAccount(type)) {
                this.payment_provider = type;
            } else {
                this.$notify({
                    text: `${type} is temporary out of service!`,
                    type: "error",
                });
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
                (n) => n.account_type == type && n.withdrawal.is_active == 1,
            );
            if (temp) {
                return true;
            } else {
                return false;
            }
        },
    },

    created() {
        this.getBalances();
        this.getAccounts();
    },

    mounted() {},
};
</script>
