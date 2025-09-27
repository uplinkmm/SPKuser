<template>
    <notifications position="top center" />
    <div class="frame-container min-h-[100vh]">
        <Navbar :title="$t('Withdrawal')" :back-btn="backBtn"></Navbar>

        <!-- 1st  -->
        <div>
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
                                    payment_provider == 'kpay',
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
                                    payment_provider == 'wave',
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
                                    payment_provider == 'aya_pay',
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
                        ငွေထုတ်မည့် ပမာဏ
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
                <p class="text-left text-xl text-black py-3 px-4">
                    ငွေထုတ်မည့် ပမာဏ : {{ amount?.toLocaleString() }} Kyats
                </p>

                <div class="w-full max-w-md px-4">
                    <label class="mb-6 rounded-xl shadow-md bg-white block">
                        <p class="text-xs px-4 pt-4 text-gray-700">
                            Account Name
                        </p>
                        <input
                            type="text"
                            placeholder="Account Name"
                            v-model="accountName"
                            class="w-full p-4 rounded-xl text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </label>
                    <label class="mb-6 rounded-xl shadow-md bg-white block">
                        <p class="text-xs px-4 pt-4 text-gray-700">
                            Phone Number
                        </p>
                        <input
                            type="text"
                            placeholder="Phone Number"
                            v-model="phoneNumber"
                            class="w-full p-4 rounded-xl text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </label>
                    <label class="mb-6 rounded-xl shadow-md bg-white block">
                        <p class="text-xs px-4 pt-4 text-gray-700">Password</p>
                        <input
                            type="password"
                            placeholder="Password"
                            v-model="password"
                            class="w-full p-4 rounded-xl text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0"
                        />
                    </label>

                    <button
                        @click="makeCashWithdrawBtnClicked"
                        :disabled="loading"
                        class="w-full bg-blue-500 hover:bg-blue-600 disabled:bg-blue-400 disabled:cursor-not-allowed disabled:text-gray-300 text-white font-bold py-3 rounded-full shadow-md text-xl transition-colors duration-300"
                    >
                        {{ loading ? "Loading..." : "ငွေထုတ်မည်" }}
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

export default {
    name: "MoneyOut",
    components: {
        Navbar,
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
                (n) => n.account_type == this.payment_provider
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
                (n) => n.account_type == type && n.withdrawal.is_active == 1
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
