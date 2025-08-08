<template>
    <notifications position="top center" />
    <div class="frame-container min-h-[100vh]">
        <Navbar :title="$t('Withdrawal')" :back-btn="backBtn"></Navbar>

        <div class="px-4">
            <div class="w-full">
                <p class="w-full text-center primary-text mb-8">ငွေသွင်းမည်</p>
            </div>
            <!-- <div
                class="flex justify-center px-4 py-8 shadow-lg rounded-2xl mb-8 bg-white"
            >
                <div>
                    <div class="flex gap-x-4 mb-4">
                        <p>
                            <i class="fal fa-wallet mr-3"></i>
                            {{ $t("Game Money") }}
                        </p>
                        <p>{{ gameMoneyBalance?.toLocaleString() }} MMK</p>
                    </div>
                    <div class="flex gap-x-4">
                        <p>
                            <i class="fal fa-wallet mr-3"></i>
                            {{ $t("Main Money") }}
                        </p>
                        <p>{{ mainMoneyBalance?.toLocaleString() }} MMK</p>
                    </div>
                </div>
            </div> -->

            <div v-show="step == 1" class="relative pb-24 mt-[40%]">
                <!-- <div>
                    <p class="text-white">{{ $t("Deposit") }}</p>
                </div> -->

                <div class="mt-8">
                    <div
                        @click="paymentProviderBtnClicked('kpay')"
                        class="px-6 py-8 shadow-lg rounded-3xl mb-6 bg-white"
                    >
                        <button
                            class="flex justify-between w-full items-center"
                        >
                            <p class="flex items-center whitespace-nowrap">
                                <img
                                    src="../../../../public/img/kpay.png"
                                    alt=""
                                    class="w-10 aspect-square mr-4"
                                />
                                KBZ Pay ဖြင့် ငွေထုတ်မည်
                            </p>
                            <i class="fas fa-angle-right ml-4"></i>
                        </button>
                    </div>
                    <div
                        @click="paymentProviderBtnClicked('wave')"
                        class="px-6 py-8 shadow-lg rounded-3xl mb-6 bg-white"
                    >
                        <button
                            class="flex justify-between w-full items-center"
                        >
                            <p class="flex items-center whitespace-nowrap">
                                <img
                                    src="../../../../public/img/wave.png"
                                    alt=""
                                    class="w-10 aspect-square mr-4"
                                />
                                wave ဖြင့် ငွေထုတ်မည်
                            </p>
                            <i class="fas fa-angle-right ml-4"></i>
                        </button>
                    </div>
                </div>
                <p class="text-white font-semibold absolute bottom-[15%]">
                    ငွေသွင်း / ငွေထုတ် ဝန်ဆောင်မှုကို ၂၄ နာရီ ပိတ်ရက်မရှိ
                    ဝန်ဆောင်မှုပေးနေပါသည်။
                </p>
            </div>
            <div v-if="step == 2">
                <div>
                    <!-- <div
                        v-if="payment_provider == 'kpay'"
                        class="px-8 py-8 shadow-lg rounded-3xl mb-8 bg-white"
                    >
                        <div class="flex justify-between w-full items-center">
                            <div class="flex text-left">
                                <img
                                    src="../../../../public/img/kpay.png"
                                    alt=""
                                    class="w-10 aspect-square mr-4"
                                />
                                <div class="text-sm">
                                    <p class="flex items-center">
                                        Phyo Kyaw San
                                    </p>
                                    <p>092016892</p>
                                </div>
                            </div>

                            <button
                                @click="copyPhoneNumber('11111111')"
                                class="text-xs"
                            >
                                <i class="fal fa-copy"></i>

                                <p>ကူးယူမည်</p>
                            </button>
                        </div>
                    </div>
                    <div
                        class="px-8 py-8 shadow-lg rounded-3xl mb-8 bg-white"
                        v-if="payment_provider == 'wave'"
                    >
                        <div class="flex justify-between w-full items-center">
                            <div class="flex text-left">
                                <img
                                    src="../../../../public/img/wave.png"
                                    alt=""
                                    class="w-10 aspect-square mr-4"
                                />
                                <div class="text-sm">
                                    <p class="flex items-center">
                                        Phyo Kyaw San
                                    </p>
                                    <p>092016892</p>
                                </div>
                            </div>

                            <button
                                class="text-xs"
                                @click="copyPhoneNumber('0000000')"
                            >
                                <i class="fal fa-copy"></i>

                                <p>ကူးယူမည်</p>
                            </button>
                        </div>
                    </div> -->
                    <div class="px-12 py-8 shadow-lg rounded-3xl mb-8 bg-white">
                        <p class="mb-4">
                            Fill The Form ({{ payment_provider }})
                        </p>
                        <div class="mb-4">
                            <label
                                for="amount"
                                class="text-sm mb-3 relative block"
                                >{{ $t("Amount") }}</label
                            >
                            <input
                                type="number"
                                v-model="amount"
                                id="amount"
                                :placeholder="$t('Amount')"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                            />
                        </div>
                        <div class="mb-4">
                            <label
                                for="acc"
                                class="text-sm mb-3 relative block"
                                >{{ $t("Account Name") }}</label
                            >
                            <input
                                type="text"
                                v-model="accountName"
                                id="acc"
                                :placeholder="$t('Account Name')"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                            />
                        </div>
                        <div class="mb-4">
                            <label
                                for="ph"
                                class="text-sm mb-3 relative block"
                                >{{ $t("Phone Number") }}</label
                            >
                            <input
                                type="tel"
                                v-model="phoneNumber"
                                id="ph"
                                :placeholder="$t('Phone Number')"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                            />
                        </div>
                        <div class="mb-12">
                            <label
                                for="password"
                                class="text-sm mb-3 relative block"
                                >Password</label
                            >
                            <input
                                type="password"
                                v-model="password"
                                id="password"
                                placeholder="Password"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                            />
                        </div>
                        <div class="mb-4">
                            <button
                                :disabled="loading"
                                @click="makeCashWithdrawBtnClicked"
                                class="bg-[#FDC652] text-white px-4 py-2 w-full"
                            >
                                {{ loading ? "Loading" : "Done" }}
                            </button>
                        </div>
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

export default {
    name: "WalletComponent",
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
            }
            if (this.step == 1) {
                // window.location.href = "/home";
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
            this.loading = false;

            if (response.success) {
                this.$notify({
                    text: response.message,
                    type: "info",
                });
                setTimeout(() => {
                    window.location.href = "/home";
                }, 1000);
            } else {
                this.$notify({
                    text: response.message,
                    type: "error",
                });
            }
        },
        paymentProviderBtnClicked(type) {
            if (this.checkAccount(type)) {
                this.payment_provider = type;
                this.step = 2;
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
