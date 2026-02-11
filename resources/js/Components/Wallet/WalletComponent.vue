<template>
    <div
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="pt-0 pb-6">
            <div class="px-4">
                <Navbar
                    :title="$t('Wallet')"
                    :textColor="'text-white font-semibold'"
                    :back-btn="backBtn"
                ></Navbar>
            </div>

            <div class="mt-3 px-4 py-6">
                <div class="flex items-center gap-x-4">
                    <div class="shrink-0">
                        <div
                            class="w-[96px] h-[96px] rounded-full bg-white/90 flex items-center justify-center"
                        >
                            <img
                                src="../../../../public/img/profile.png"
                                alt="Profile Picture"
                                class="w-[86px] h-[86px] rounded-full object-cover"
                            />
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-x-3">
                            <p
                                class="text-white font-semibold text-xl truncate"
                            >
                                နာမည်
                            </p>
                            <p
                                class="text-white font-semibold text-xl truncate"
                            >
                                {{ getUser.name }}
                            </p>
                        </div>
                        <div
                            class="mt-3 flex items-center justify-between gap-x-3"
                        >
                            <p
                                class="text-white/90 font-semibold text-xl truncate"
                            >
                                ဖုန်းနံပါတ်
                            </p>
                            <p
                                class="text-white/90 font-semibold text-xl truncate"
                            >
                                {{ getUser.phone_number }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="-mt-6 mb-16 bg-black">
            <div class="">
                <div
                    class="bg-[#FDC652] rounded-t-2xl px-4 pt-5 pb-4 shadow-lg"
                >
                    <p
                        class="text-center text-black font-semibold text-lg mb-4"
                    >
                        ပိုက်ဆံအိတ်
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
                                        ပင်မပိုက်ဆံအိတ်
                                    </p>
                                    <div
                                        class="w-6 h-6 rounded-full bg-black flex items-center justify-center text-white text-sm font-bold"
                                    >
                                        ?
                                    </div>
                                </div>
                                <p class="font-semibold">
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
                                            class="absolute left-[-0px] top-3/4 -translate-y-1/2 w-7 h-7 object-contain"
                                        />
                                    </div>
                                    <p class="font-semibold truncate">
                                        ဂိမ်းပိုက်ဆံအိတ်
                                    </p>
                                    <div
                                        class="w-6 h-6 rounded-full bg-black flex items-center justify-center text-white text-sm font-bold"
                                    >
                                        ?
                                    </div>
                                </div>
                                <p class="font-semibold">
                                    {{ gameMoneyBalance.toLocaleString() }} ကျပ်
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-4 rounded-2xl border border-black/30 bg-[#C89A1E] p-4"
                    >
                        <div class="grid grid-cols-3 gap-x-4">
                            <a href="/topup" class="block text-center">
                                <div class="relative mx-auto w-[96px]">
                                    <div class="py-5">
                                        <img
                                            src="../../../../public/icons/Wallet.png"
                                            class="w-24 mx-auto"
                                        />
                                    </div>
                                    <div
                                        class="absolute -left-2 top-3/4 -translate-y-1/2 w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                    >
                                        <span
                                            class="text-white text-3xl leading-none"
                                            >+</span
                                        >
                                    </div>
                                </div>
                                <p
                                    class="mt-3 text-black font-semibold text-sm"
                                >
                                    {{ $t("Deposit") }}
                                </p>
                            </a>

                            <button
                                @click="wallet_transfer.amount = ''"
                                class="block text-center"
                                data-twe-toggle="modal"
                                data-twe-target="#add_main_money_model"
                                type="button"
                            >
                                <div class="relative mx-auto w-[96px]">
                                    <div class="py-5">
                                        <img
                                            src="../../../../public/icons/Wallet.png"
                                            class="w-24 mx-auto"
                                        />
                                    </div>
                                    <div
                                        class="absolute -left-2 top-3/4 -translate-y-1/2 w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                    >
                                        <i
                                            class="fas fa-sync-alt text-white text-lg"
                                        ></i>
                                    </div>
                                </div>
                                <p
                                    class="mt-3 text-black font-semibold text-sm"
                                >
                                    ငွေလဲမည်
                                </p>
                            </button>
                            <a href="/cash_withdraw" class="block text-center">
                                <div class="relative mx-auto w-[96px]">
                                    <div class="py-5">
                                        <img
                                            src="../../../../public/icons/Wallet.png"
                                            class="w-24 mx-auto"
                                        />
                                    </div>
                                    <div
                                        class="absolute -left-2 top-3/4 -translate-y-1/2 w-10 h-10 rounded-full bg-black flex items-center justify-center"
                                    >
                                        <i
                                            class="fas fa-arrow-up text-white text-lg"
                                        ></i>
                                    </div>
                                </div>
                                <p
                                    class="mt-3 text-black font-semibold text-sm"
                                >
                                    {{ $t("Withdrawal") }}
                                </p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 bg-white pb-16">
                <p class="text-center text-black font-semibold text-lg mb-3">
                    မှတ်တမ်းများ
                </p>

                <a
                    href="/deposit_withdrawal_histories"
                    class="flex items-center justify-between bg-[#FDC652] py-4"
                >
                    <div class="flex items-center gap-x-3 px-4">
                        <div
                            class="w-8 h-8 rounded-lg border border-black flex items-center justify-center"
                        >
                            <i class="fas fa-receipt text-black"></i>
                        </div>
                        <p class="font-semibold text-black">
                            ငွေသွင်း ငွေထုတ်မှတ်တမ်းများ:
                        </p>
                    </div>
                    <i class="fas fa-chevron-right mr-4 text-black"></i>
                </a>

                <p
                    class="text-center text-black font-semibold text-lg mt-5 mb-3"
                >
                    အကူအညီ
                </p>

                <div class="bg-[#FDC652] overflow-hidden">
                    <a
                        href="https://www.youtube.com/shorts/4jtKqT-Jm3E"
                        target="_blank"
                        class="flex items-center justify-between px-4 py-4"
                    >
                        <div class="flex items-center gap-x-3">
                            <div
                                class="w-10 h-10 bg-black flex items-center justify-center"
                            >
                                <i class="fas fa-play text-white"></i>
                            </div>
                            <p class="font-semibold text-black">
                                ငွေဖြည့်နည်း ကြည့်ရန်
                            </p>
                        </div>
                        <i class="fas fa-chevron-right text-black"></i>
                    </a>
                    <div class="h-[1px] bg-black/20"></div>
                    <a
                        href="https://www.youtube.com/shorts/cFvmsnfVNF0?si=UmA6F83Rhm5lnzpT"
                        target="_blank"
                        class="flex items-center justify-between px-4 py-4"
                    >
                        <div class="flex items-center gap-x-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-black flex items-center justify-center"
                            >
                                <i class="fas fa-play text-white"></i>
                            </div>
                            <p class="font-semibold text-black">
                                ငွေထုတ်နည်း ကြည့်ရန်
                            </p>
                        </div>
                        <i class="fas fa-chevron-right text-black"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- exchange money modal -->
        <div
            data-twe-modal-init
            class="fixed inset-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none bg-black/80 flex items-center justify-center p-4"
            id="add_main_money_model"
            tabindex="-1"
            aria-labelledby="addMainMoneyLabel"
            aria-hidden="true"
        >
            <div
                data-twe-modal-dialog-ref
                class="pointer-events-none w-full h-full opacity-0 transition-all duration-300 ease-in-out"
            >
                <div
                    class="pointer-events-auto fixed left-1/2 top-1/3 w-full max-w-[420px] -translate-x-1/2 -translate-y-1/2 flex flex-col rounded-3xl border-none bg-[#FFC529] text-current shadow-4 outline-none overflow-hidden"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between py-5 px-6"
                    >
                        <h4
                            class="text-xl font-semibold leading-normal text-black text-center w-full"
                            id="addMainMoneyLabel"
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
                            class="w-10 h-10 flex items-center justify-center rounded-full border border-black/10 bg-white/60 text-black/70 hover:text-black focus:text-black focus:opacity-100 focus:shadow-none focus:outline-none"
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
                        class="relative flex-auto pb-6 px-8"
                        data-twe-modal-body-ref
                    >
                        <div
                            class="flex justify-between text-3xl mb-10 px-2 items-center"
                        >
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
                                width="28"
                                height="28"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-arrow-left-right-icon lucide-arrow-left-right hover:text-red-700"
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

                        <div class="mb-6">
                            <label
                                for="amount"
                                class="text-sm mb-2 relative block font-semibold text-black"
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
                                class="block w-full py-3 px-3 border border-gray-300 text-sm rounded-xl bg-white focus:ring-0 focus:shadow-none focus:outline-none"
                            />
                        </div>

                        <div class="mb-4">
                            <button
                                :disabled="loading"
                                @click="transferWallet"
                                class="w-full px-4 py-3 bg-[#5271FF] disabled:bg-[#9CA3AF] disabled:text-white disabled:opacity-70 disabled:cursor-not-allowed hover:bg-[#5271FF]/90 text-white text-sm font-semibold rounded-2xl"
                            >
                                {{ loading ? "Loading.." : "Transfer" }}
                            </button>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-black/80">
                                Minimum Amount : 100 MMK
                            </p>
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
                this.wallet_transfer.transfer_type,
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
