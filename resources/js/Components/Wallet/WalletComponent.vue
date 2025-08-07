<template>
    <div class="frame-container min-h-[100vh]">
        <Navbar
            :title="$t('Wallet')"
            :textColor="'text-white font-semibold'"
            :back-btn="backBtn"
        ></Navbar>

        <div class="px-4">
            <div class="px-12 py-8 shadow-lg rounded-3xl mb-6 lg:mb-8 bg-white">
                <div>
                    <div class="flex justify-between gap-x-4 mb-4">
                        <p class="flex-grow-0 w-36">
                            <!-- <i class="fal fa-wallet"></i> -->
                            ပင်မ ပိုက်ဆံအိတ်
                        </p>
                        <p class="flex-grow">
                            {{ mainMoneyBalance.toLocaleString() }} MMK
                        </p>
                        <button
                            @click="
                                wallet_transfer.transfer_type = 'to_wallet';
                                wallet_transfer.amount = '';
                            "
                            class="flex-grow-0"
                            data-twe-toggle="modal"
                            data-twe-target="#add_game_money_model"
                        >
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                    <div class="flex justify-between gap-x-4">
                        <p class="flex-grow-0 w-36">
                            <!-- <i class="fal fa-wallet"></i> -->
                            Game ပိုက်ဆံအိတ်
                        </p>
                        <p class="flex-grow">
                            {{ gameMoneyBalance.toLocaleString() }} MMK
                        </p>
                        <button
                            @click="
                                wallet_transfer.transfer_type = 'to_game';
                                wallet_transfer.amount = '';
                            "
                            class="flex-grow-0"
                            data-twe-toggle="modal"
                            data-twe-target="#add_main_money_model"
                        >
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="text-center px-8 py-8 mb-6 lg:mb-8 shadow-lg rounded-3xl bg-white"
            >
                <div>
                    <div>
                        <p class="text-2xl font-semibold mb-8">
                            {{ $t("Withdrawal Deposit") }}
                        </p>
                    </div>
                    <div class="flex justify-between w-9/12 mx-auto">
                        <div>
                            <a href="/topup">
                                <img
                                    src="../../../../public/img/forward-dynamic-color.png"
                                    class="w-14 mx-auto"
                                />
                                <p>{{ $t("Deposit") }}</p>
                            </a>
                        </div>

                        <div class="">
                            <a href="/cash_withdraw">
                                <img
                                    src="../../../../public/img/backward-dynamic-color.png"
                                    class="w-14 mx-auto"
                                />
                                <p>{{ $t("Withdrawal") }}</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-12 py-16 shadow-lg rounded-2xl mb-16 bg-white">
                <div class="flex flex-col gap-y-4">
                    <a
                        href="/deposit_withdrawal_histories"
                        class="flex items-center"
                    >
                        <i class="fal fa-money-check-alt mr-4 w-4"></i>
                        <p>{{ $t("Deposit Withdrawal History") }}</p>
                    </a>
                    <a
                        target="_blank"
                        href="https://youtube.com/shorts/cFvmsnfVNF0?si=UmA6F83Rhm5lnzpT"
                        class="flex items-center"
                    >
                        <i class="fal fa-wallet mr-4 w-4"></i>
                        <p>ငွေထုတ်နည်း ကြည့်ရန်</p>
                    </a>
                    <a
                        target="_blank"
                        href="https://youtube.com/shorts/4jtKqT-Jm3E?si=F4mBf4h0mrcM7VgY"
                        class="flex items-center"
                    >
                        <i class="fal fa-wallet mr-4 w-4"></i>
                        <p>ငွေသွင်းနည်း ကြည့်ရန်</p>
                    </a>
                    <!-- <a href="#" class="flex">
                        <i class="fal fa-wallet mr-4 w-4 pt-1"></i>
                        <p class="text-base leading-7">
                            ပင်မ ပိုက်ဆံအိတ်မှ ဂိမ်း ပိုက်ဆံအိတ်သို့ လွှဲနည်း
                            ကြည့်ရန်
                        </p>
                    </a> -->
                    <a href="tel:+959955511333" class="flex items-center">
                        <i class="fal fa-wallet mr-4 w-4"></i>
                        <p>
                            {{ $t("Contacts") }}
                        </p>
                    </a>
                </div>

                <p class="text-black mt-12 w-full text-center text-sm">
                    ငွေသွင်း / ငွေထုတ် ဝန်ဆောင်မှုကို ၂၄ နာရီ ပိတ်ရက်မရှိ
                    ဝန်ဆောင်မှုပေးနေပါသည်။
                </p>
            </div>
        </div>

        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="add_main_money_model"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                data-twe-modal-dialog-ref
                class="pointer-events-none relative w-[400px] mx-auto mt-[15%] translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[400px]"
            >
                <div
                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-neutral-100 py-8 px-6"
                    >
                        <h4
                            class="text-xl font-medium leading-normal text-surface text-center w-full"
                            id="exampleModalLabel"
                        >
                            Transfer Wallet
                        </h4>
                        <button
                            type="button"
                            id="close_main_money_model"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div
                        class="relative flex-auto py-6 px-16"
                        data-twe-modal-body-ref
                    >
                        <div class="flex justify-between text-3xl mb-12 px-4">
                            <i class="far fa-wallet"></i>
                            <i class="fal fa-angle-double-right"></i>
                            <i class="far fa-gamepad"></i>
                        </div>

                        <div class="mb-8">
                            <label
                                for="amount"
                                class="text-sm mb-3 relative block"
                                >Amount ({{ mainMoneyBalance }} MMK)</label
                            >
                            <input
                                type="number"
                                v-model="wallet_transfer.amount"
                                id="amount"
                                :placeholder="$t('Amount')"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
                            />
                        </div>

                        <div class="mb-4">
                            <button
                                :disabled="loading"
                                @click="transferWallet"
                                class="px-4 py-2 lg:py-3 bg-[#FFBF33] text-white text-sm rounded-lg w-full"
                            >
                                {{ loading ? "Loading.." : "Transfer" }}
                            </button>
                        </div>
                        <div class="mb-12">
                            <p class="text-sm">Minimum Amount : 100 MMK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- add game money modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="add_game_money_model"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                data-twe-modal-dialog-ref
                class="pointer-events-none relative w-[400px] mx-auto mt-[15%] translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[400px]"
            >
                <div
                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-neutral-100 py-8 px-6"
                    >
                        <h4
                            class="text-xl font-medium leading-normal text-surface text-center w-full"
                            id="exampleModalLabel"
                        >
                            Transfer Wallet
                        </h4>
                        <button
                            type="button"
                            id="close_game_money_model"
                            class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none"
                            data-twe-modal-dismiss
                            aria-label="Close"
                        >
                            <span class="[&>svg]:h-6 [&>svg]:w-6">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div
                        class="relative flex-auto py-6 px-16"
                        data-twe-modal-body-ref
                    >
                        <div class="flex justify-between text-3xl mb-12 px-4">
                            <i class="far fa-gamepad"></i>
                            <i class="fal fa-angle-double-right"></i>
                            <i class="far fa-wallet"></i>
                        </div>

                        <div class="mb-8">
                            <label
                                for="amount"
                                class="text-sm mb-3 relative block"
                                >Amount ({{ gameMoneyBalance }} MMK)</label
                            >
                            <input
                                type="number"
                                v-model="wallet_transfer.amount"
                                id="amount"
                                :placeholder="$t('Amount')"
                                class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none focus:outline-none"
                            />
                        </div>

                        <div class="mb-4">
                            <button
                                :disabled="loading"
                                @click="transferWallet"
                                class="px-4 py-2 lg:py-3 bg-[#FFBF33] text-white text-sm rounded-lg w-full"
                            >
                                {{ loading ? "Loading.." : "Transfer" }}
                            </button>
                        </div>
                        <div class="mb-12">
                            <p class="text-sm">Minimum Amount : 100 MMK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal, Ripple, Dropdown, initTWE } from "tw-elements";
import { mapGetters } from "vuex";
import { getApiData, postApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            mainMoneyBalance: 0,
            gameMoneyBalance: 0,
            wallet_transfer: {
                amount: "",
                transfer_type: "", //to_game ,to_wallet
            },
            loading: false,
        };
    },
    computed: {
        ...mapGetters(["getToken", "getUser"]),
    },
    methods: {
        async getBalances() {
            let url = `/api/money_balances`;
            let response = await postApiData({
                url: url,
                token: this.getToken,
            });
            if (response.data) {
                this.mainMoneyBalance = response.data.main_money.balance;
                this.gameMoneyBalance = response.data.game_money.balance;
            }
        },
        async transferWallet() {
            if (
                !this.wallet_transfer.amount ||
                this.wallet_transfer.amount < 100
            ) {
                this.$notify({
                    text: !this.wallet_transfer.amount
                        ? "Amount is required!"
                        : "Minium amount is 100 MMK!",
                    type: "error",
                });
                return;
            }
            if (this.wallet_transfer.transfer_type == "to_game") {
                if (
                    this.mainMoneyBalance == 0 ||
                    this.wallet_transfer.amount > this.mainMoneyBalance
                ) {
                    this.$notify({
                        text: "Amount is insufficient",
                        type: "error",
                    });
                    return;
                }
            } else {
                //to_wallet
                if (
                    this.gameMoneyBalance == 0 ||
                    this.wallet_transfer.amount > this.gameMoneyBalance
                ) {
                    this.$notify({
                        text: "Amount is insufficient",
                        type: "error",
                    });
                    return;
                }
            }
            let url = `/api/create_wallet_transfer`;
            let formData = new FormData();
            formData.append("customer_id", this.getUser.id);
            formData.append("amount", this.wallet_transfer.amount);
            formData.append(
                "transfer_type",
                this.wallet_transfer.transfer_type
            );
            this.loading = true;
            let response = await postApiData({
                url: url,
                token: this.getToken,
                form_data: formData,
            });
            this.loading = false;
            if (response.success) {
                this.$notify({
                    text: "Success transfer.",
                    type: "info",
                });
                this.getBalances();
                this.modalClose();
            } else {
                this.$notify({
                    text: response.message,
                    type: "error",
                });
            }
        },
        modalClose() {
            var id =
                this.wallet_transfer.transfer_type == "to_wallet"
                    ? "close_game_money_model"
                    : "close_main_money_model";
            const button = document.getElementById(id);
            if (button) {
                button.click();
            }
        },
        backBtn() {
            window.location.href = "/home";
        },
    },

    created() {
        this.getBalances();
    },

    mounted() {
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
