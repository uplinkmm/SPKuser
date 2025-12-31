<template>
    <div class="frame-container min-h-[100vh]">
        <Navbar
            :title="$t('Wallet')"
            :textColor="'text-white font-semibold'"
            :back-btn="backBtn"
        ></Navbar>

        <div class="mb-16">
            <div class="px-2">
                <div class="mb-4">
                    <div
                        class="flex items-center justify-center p-4 bg-transparent"
                    >
                        <div class="flex-shrink-0 mr-4">
                            <img
                                src="../../../../public/img/profile.png"
                                alt="Profile Picture"
                                class="w-20 h-20 rounded-full object-cover border-2 border-white shadow-sm"
                            />
                        </div>

                        <div class="h-full">
                            <p class="text-xl font-semibold text-gray-800 mb-2">
                                {{ getUser.name }}
                            </p>
                            <p class="text-sm text-gray-700">
                                {{ getUser.phone_number }}
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <div
                        class="px-6 lg:px-12 py-8 shadow-lg rounded-3xl mb-6 lg:mb-8 bg-white"
                    >
                        <div class=" text-sm lg:text-base">
                            <div class="flex justify-between gap-x-4 mb-4">
                                <p class="flex-grow-0 w-36">
                                    <!-- <i class="fal fa-wallet"></i> -->
                                    ပင်မ ပိုက်ဆံအိတ်
                                </p>
                                <p class="flex-grow text-right flex-shrink-0">
                                    {{ mainMoneyBalance.toLocaleString() }} MMK
                                </p>
                            </div>
                            <div class="flex justify-between gap-x-4">
                                <p class="flex-grow-0 w-36">
                                    <!-- <i class="fal fa-wallet"></i> -->
                                    Game ပိုက်ဆံအိတ်
                                </p>
                                <p class="flex-grow text-right flex-shrink-0">
                                    {{ gameMoneyBalance.toLocaleString() }} MMK
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div
                        class="px-6 lg:px-12 py-8 shadow-lg rounded-3xl mb-6 lg:mb-8 bg-white"
                    >
                        <div class="grid grid-cols-3 gap-x-4">
                            <div>
                                <a href="/topup">
                                    <img
                                        src="../../../../public/img/money_receive.png"
                                        class="w-10 lg:w-14 mx-auto mb-2"
                                    />
                                    <p class="text-sm lg:text-base text-center">{{ $t("Deposit") }}</p>
                                </a>
                            </div>

                            <div class="">
                                <a href="/cash_withdraw">
                                    <img
                                        src="../../../../public/img/money_send.png"
                                        class="w-10 lg:w-14 mx-auto mb-2"
                                    />
                                    <p class="text-sm lg:text-base text-center">{{ $t("Withdrawal") }}</p>
                                </a>
                            </div>
                            <div class="">
                                <button
                                    @click="wallet_transfer.amount = ''"
                                    class=""
                                    data-twe-toggle="modal"
                                    data-twe-target="#add_main_money_model"
                                >
                                    <img
                                        src="../../../../public/img/exchange.png"
                                        class="w-10 lg:w-14 mx-auto mb-2"
                                    />
                                    <p class="text-sm lg:text-base text-center">ငွေလဲမည်</p>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-0 lg:px-6">
                <div class="rounded-lg p-4">
                    <h2
                        class="text-base lg:text-xl font-bold mb-4 dash-under relative after:!left-0 inline-block pb-3"
                    >
                        မှတ်တမ်းများ
                    </h2>

                    <div class="divide-y divide-gray-700">
                        <a
                            href="/deposit_withdrawal_histories"
                            class="flex items-center justify-between py-4 cursor-pointer"
                        >
                            <div class="flex items-center space-x-4">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-4 h-4 text-gray-700"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                                    />
                                </svg>
                                <span class=" text-sm lg:text-lg"
                                    >ငွေသွင်း ငွေထုတ် မှတ်တမ်းများ</span
                                >
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-4 h-4 text-gray-700"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>

                        <a
                            href="https://www.youtube.com/shorts/4jtKqT-Jm3E"
                            target="_blank"
                            class="flex items-center justify-between py-4 cursor-pointer"
                        >
                            <div class="flex items-center space-x-4">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-4 h-4 text-gray-700"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.5 14.25v-2.25a.75.75 0 0 0-.75-.75H12a.75.75 0 0 0-.75.75v2.25a.75.75 0 0 0 .75.75h2.25a.75.75 0 0 0 .75-.75Z"
                                    />
                                </svg>
                                <span class="text-sm lg:text-lg"
                                    >ငွေဖြည့်နည်း ကြည့်ရန်</span
                                >
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-4 h-4 text-gray-700"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>

                        <a
                            href="https://www.youtube.com/shorts/cFvmsnfVNF0?si=UmA6F83Rhm5lnzpT"
                            target="_blank"
                            class="flex items-center justify-between py-4 cursor-pointer"
                        >
                            <div class="flex items-center space-x-4">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-4 h-4 text-gray-700"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"
                                    />
                                </svg>
                                <span class="text-sm lg:text-lg"
                                    >ငွေထုတ်နည်း ကြည့်ရန်</span
                                >
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-4 h-4 text-gray-700"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- exchange money modal -->
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
                            {{
                                wallet_transfer.transfer_type == "to_wallet"
                                    ? "Game to Main"
                                    : "Main to Game"
                            }}
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
                            <i
                                v-if="
                                    wallet_transfer.transfer_type == 'to_wallet'
                                "
                                class="far fa-gamepad"
                            ></i>
                            <i v-else class="far fa-wallet"></i>
                            <svg
                                @click="changeTransferType"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-arrow-left-right-icon lucide-arrow-left-right hover:text-[#FED428]"
                            >
                                <path d="M8 3 4 7l4 4" />
                                <path d="M4 7h16" />
                                <path d="m16 21 4-4-4-4" />
                                <path d="M20 17H4" />
                            </svg>
                            <i
                                v-if="
                                    wallet_transfer.transfer_type == 'to_wallet'
                                "
                                class="far fa-wallet"
                            ></i>
                            <i v-else class="far fa-gamepad"></i>
                        </div>

                        <div class="mb-8">
                            <label
                                for="amount"
                                class="text-sm mb-3 relative block"
                                >Amount ({{
                                    wallet_transfer.transfer_type == "to_wallet"
                                        ? gameMoneyBalance
                                        : mainMoneyBalance
                                }}
                                MMK)</label
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
                                class="px-4 py-2 lg:py-3 bg-[#FFBF33] disabled:bg-yellow-100 disabled:text-gray-300 hover:bg-[#FFBF33] text-white text-sm rounded-lg w-full"
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
                transfer_type: "to_wallet", //to_game ,to_wallet
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
        changeTransferType() {
            if (this.wallet_transfer.transfer_type == "to_wallet") {
                this.wallet_transfer.transfer_type = "to_game";
            } else {
                this.wallet_transfer.transfer_type = "to_wallet";
            }
            this.wallet_transfer.amount = "";
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
            var id = "close_main_money_model";
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
