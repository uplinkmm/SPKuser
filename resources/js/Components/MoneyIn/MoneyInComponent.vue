<template>
    <notifications position="top center" />
    <div class="frame-container min-h-[100vh]">
        <Navbar title="ငွေသွင်းမည်" :back-btn="backBtn"></Navbar>


        <!-- 1st  -->
        <div>
            <div class="w-full">
                <p class="w-full text-center primary-text mb-8">ငွေသွင်းမည်</p>
            </div>
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
            <div class="px-12 py-8 shadow-lg rounded-3xl mb-6 lg:mb-8 bg-white">
                <div class="grid grid-cols-3 gap-x-6">
                    <div class=" text-center">
                        <a href="/topup">
                            <img
                                src="../../../../public/img/kpay.png"
                                class="w-14 mx-auto"
                            />
                            <p>Kpay</p>
                        </a>
                    </div>

                    <div class=" text-center">
                        <a href="/cash_withdraw">
                            <img
                                src="../../../../public/img/wave.png"
                                class="w-14 mx-auto"
                            />
                            <p>Wave</p>
                        </a>
                    </div>
                    <div class=" text-center">
                        <a href="/cash_withdraw">
                            <img
                                src="../../../../public/img/money 1.png"
                                class="w-14 mx-auto"
                            />
                            <p>AYA Pay</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-md px-4">
                <h2 class="text-xl font-bold mb-6 text-gray-800 text-left">ငွေသွင်းမည် ပမာဏ</h2>
        
                <label class="mb-6 rounded-xl shadow-md bg-white block">
                    <p class=" text-xs px-4 pt-4 text-gray-700"> Amount</p>
                    <input 
                        type="text" 
                        placeholder="Amount" 
                        class="w-full p-4 rounded-xl text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0 "
                    >
                </label>
        
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-full shadow-md text-xl transition-colors duration-300">
                    လုပ်ဆောင်မည်
                </button>
        
                <p class="text-center text-gray-700 mt-8 text-base leading-relaxed font-semibold">
                    ငွေသွင်းငွေထုတ် မြန်ဆန်စေရန်အတွက် <br>ဖော်ပြပါ အကောင့်များသို့သာ ငွေလွှဲရန်
                </p>
            </div>
            
        </div>



        <!-- 2nd -->
        <div>
            <div class="w-full">
                <p class="w-full text-center primary-text mb-8">ငွေသွင်းမည်</p>
            </div>
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
            <div class="px-8 pt-8 pb-4 shadow-lg rounded-2xl mb-8 bg-white">
                <div class="flex justify-between w-full items-center mb-2">
                    <div class="flex text-left">
                        <img
                            src="../../../../public/img/wave.png"
                            alt=""
                            class="w-14 h-14 aspect-square mr-4"
                        />
                        <div class="text-sm">
                            <p class="flex items-center">
                                Wave in Flag
                            </p>
                            <p>911</p>
                        </div>
                    </div>

                    <button
                        @click="
                        copyPhoneNumber(waveAccount.phone_number)
                        "
                        class="text-xs"
                    >
                        <i class="fal fa-copy text-2xl"></i>
                        <p>ကူးယူမည်</p>
                    </button>
                </div>
                <p class=" text-sm text-center">
                    ငွေသွင်းမည့် ပမာဏ : 1,0000 Kyats
                </p>
            </div>

            
            <div class="w-full max-w-md px-4">
                <h2 class="text-xl font-bold mb-6 text-gray-800 text-left">လုပ်ဆောင်မှု အမှတ် နောက်ဆုံး ဂဏန်း ၆ လုံး</h2>
        
                <label class="mb-6 rounded-xl shadow-md bg-white block">
                    <p class=" text-xs px-4 pt-4 text-gray-700"> Transaction Number</p>
                    <input 
                        type="text" 
                        placeholder="Transaction Number" 
                        class="w-full p-4 rounded-xl text-lg text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-0 "
                    >
                </label>
        
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-full shadow-md text-xl transition-colors duration-300">
                    ငွေသွင်းမည်
                </button>
        
                <p class="text-center text-gray-700 mt-8 text-base leading-relaxed font-semibold">
                    ငွေသွင်းငွေထုတ် မြန်ဆန်စေရန်အတွက် <br>ဖော်ပြပါ အကောင့်များသို့သာ ငွေလွှဲရန်
                </p>
            </div>
        </div>







        <div class="px-4">
            <div class="w-full">
                <p class="w-full text-center primary-text mb-8">ငွေသွင်းမည်</p>
            </div>
            <!-- <div
                class="flex justify-center px-4 py-8 shadow-lg rounded-2xl mb-4 bg-white"
            >
                <div>
                    <div class="flex gap-x-4 mb-4">
                        <p>
                            <i class="fal fa-wallet mr-3"></i>
                            {{ $t("Main Money") }}
                        </p>
                        <p>{{ mainMoneyBalance?.toLocaleString() }} MMK</p>
                    </div>
                    <div class="flex gap-x-4">
                        <p>
                            <i class="fal fa-wallet mr-3"></i>
                            {{ $t("Game Money") }}
                        </p>
                        <p>{{ gameMoneyBalance?.toLocaleString() }} MMK</p>
                    </div>
                </div>
            </div> -->

            <div v-show="!isPaymentFormShown" class="mt-[40%]">
                <!-- <div>
                    <p class="text-white">{{ $t("Deposit") }}</p>
                </div> -->

                <div>
                    <div class="px-6 py-8 shadow-lg rounded-2xl mb-4 bg-white">
                        <button
                            @click="paymentProviderBtnClicked('kpay')"
                            class="flex justify-between w-full items-center"
                        >
                            <p class="flex items-center whitespace-nowrap">
                                <img
                                    src="../../../../public/img/kpay.png"
                                    alt=""
                                    class="w-14 aspect-square mr-4"
                                />
                                KBZ Pay ဖြင့် ငွေသွင်းမည်
                            </p>
                            <i class="fas fa-angle-right ml-4"></i>
                        </button>
                    </div>
                    <div class="px-6 py-8 shadow-lg rounded-2xl mb-4 bg-white">
                        <button
                            @click="paymentProviderBtnClicked('wave')"
                            class="flex justify-between w-full items-center"
                        >
                            <p class="flex items-center whitespace-nowrap">
                                <img
                                    src="../../../../public/img/wave.png"
                                    alt=""
                                    class="w-14 aspect-square mr-4"
                                />
                                wave ဖြင့် ငွေသွင်းမည်
                            </p>
                            <i class="fas fa-angle-right ml-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div v-show="isPaymentFormShown">
                <div>
                    <p class="primary-text pl-2 mb-4">Payment Information</p>
                </div>
                <div>
                    <div
                        class="px-8 py-8 shadow-lg rounded-2xl mb-6 bg-white"
                        v-if="paymentProvider == 'kpay'"
                    >
                        <div class="flex justify-between w-full items-center">
                            <div class="flex text-left">
                                <img
                                    src="../../../../public/img/kpay.png"
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
                                @click="
                                    copyPhoneNumber(kpayAccount.phone_number)
                                "
                                class="text-xs"
                            >
                                <i class="fal fa-copy text-2xl"></i>

                                <p>ကူးယူမည်</p>
                            </button>
                        </div>
                    </div>

                    <div
                        class="px-8 py-8 shadow-lg rounded-2xl mb-8 bg-white"
                        v-if="paymentProvider == 'wave'"
                    >
                        <div class="flex justify-between w-full items-center">
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
                                @click="
                                    copyPhoneNumber(waveAccount.phone_number)
                                "
                                class="text-xs"
                            >
                                <i class="fal fa-copy text-2xl"></i>

                                <p>ကူးယူမည်</p>
                            </button>
                        </div>
                    </div>

                    <div class="px-10 py-6 shadow-lg rounded-2xl mb-8 bg-white">
                        <p class="w-full text-center mb-6 text-lg">
                            Fill The Form
                        </p>
                        <div class="mb-8">
                            <label
                                for="amount"
                                class="text-sm mb-3 relative block"
                                >Amount</label
                            >
                            <input
                                type="number"
                                id="amount"
                                v-model="amount"
                                placeholder="Amount"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                            />
                        </div>
                        <div class="mb-12">
                            <label for="id" class="text-sm mb-3 relative block"
                                >Transaction id (Last 6 digits)</label
                            >
                            <input
                                type="text"
                                id="id"
                                v-model="paymentTrId"
                                placeholder="Transaction id"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                            />
                        </div>
                        <div class="mb-4">
                            <button
                                @click="makeTopupTransactionBtnClicked"
                                class="bg-black text-white px-4 py-2 w-full rounded-md"
                                :disabled="loading"
                            >
                                <span v-if="loading">Loading...</span>
                                <span v-else>Done</span>
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
import Navbar from "../Nav/Navbar.vue";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

export default {
    data() {
        return {
            isPaymentFormShown: false,
            isShow: true,
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
                this.isShow = false;
                this.isPaymentFormShown = true;
                this.paymentProvider = paymentProvider;
            } else {
                this.$notify({
                    text: `${paymentProvider} is temporary out of service!`,
                    type: "error",
                });
            }
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
                setTimeout(() => {
                    window.location.href = "/home";
                }, 1000);
            } else {
                this.$notify({
                    text: response.message.payment_transaction_id,
                    type: "error",
                });
            }
        },
        backBtn() {
            if (this.isPaymentFormShown) {
                this.isPaymentFormShown = false;
                return;
            } else {
                window.history.back();

                window.location.href = "/home";
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
