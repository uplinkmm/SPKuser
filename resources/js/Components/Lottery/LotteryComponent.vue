<template>
    <notifications position="top center" />
    <div class="frame-container min-h-[100vh]">
        <Navbar title="Lottery" :back-btn="backBtn"></Navbar>

        <div :class="step == 1 ? 'block' : 'hidden'" class="px-2 mb-12">
            <div class="px-2 mb-6">
                <img :src="img_prefix + game?.photo" class="w-full mb-6" />
            </div>
            <div class="px-2">
                <p class="px-8 py-8 mb-4 bg-[#FEDC23] text-sm">
                    {{ game?.description }}
                </p>
            </div>
            <div class="px-4">
                <button
                    class="bg-black px-4 py-3 rounded-lg text-white w-full mb-8"
                    @click="chooseNumber"
                >
                    Choose Number & Click Here to Buy
                </button>

                <div class="grid grid-cols-6 gap-x-1 lg:gap-x-4 gap-y-4">
                    <div
                        class="contents"
                        v-for="(num, index) in numbers"
                        :key="index"
                    >
                        <div
                            :class="[
                                num.is_active == 0
                                    ? 'bg-gray-400'
                                    : isBetNumber(num.number)
                                    ? 'bg-[#FDC652] text-white'
                                    : 'bg-white',
                                'py-2 px-1 lg:px-2 text-center shadow-xl aspect-square flex items-center justify-center border border-gray-200 rounded-md',
                            ]"
                            @click="num.is_active == 1 ? addBetNumber(num) : ''"
                        >
                            <div class="w-full">
                                <p class="text-xs lg:text-base font-inter">
                                    {{ num.number }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Page-->
        <div
            class="relative mb-12 w-full rounded-lg shadow-xl bg-white pb-14"
            :class="step == 2 ? 'block' : 'hidden'"
            style="min-height: calc(100vh - 168px)"
        >
            <div
                class="flex justify-between p-6 bg-[#FDC652] text-white rounded-tr-lg rounded-tl-lg"
            >
                <div>
                    <p class="pr-8 py-2">
                        {{ getCurrentDate() }}
                    </p>
                    <p class="pr-8">
                        {{ getCurrentTime() }}
                    </p>
                </div>
                <div>
                    <p class="pr-8 py-2">
                        {{ formatTime(game?.lottery_date_time) }}
                    </p>
                    <p class="pr-8">
                        {{ totalBetAmount?.toLocaleString() }} MMK
                    </p>
                </div>
            </div>
            <div class="mb-5 px-4">
                <div class="flex justify-end mb-4"></div>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="py-2">{{ $t("No") }}</th>
                            <th class="py-2">{{ $t("Betting Amount") }}</th>
                            <th class="py-2">{{ $t("Delete") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(bet_number, index) in bet_numbers"
                            :key="index"
                        >
                            <td class="text-center py-2">
                                {{ bet_number.number }}
                            </td>

                            <td class="text-center py-2">
                                <span>
                                    {{ bet_number.amount?.toLocaleString() }}
                                </span>
                            </td>
                            <td class="text-center py-2">
                                <button
                                    data-twe-toggle="modal"
                                    data-twe-target="#delete_modal"
                                    @click="
                                        delete_bet_number = bet_number.number
                                    "
                                    class="text-red-600 hover:text-red-800 transition duration-150 ease-in-out"
                                >
                                    <i class="fal fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="absolute bottom-0 mb-4 w-full flex justify-center">
                <button
                    class="bg-[#e2e5e9] text-black px-12 py-2 rounded-lg text-sm font-semibold"
                    @click="
                        step = 1;
                        resetPromotion();
                    "
                >
                    Cancel
                </button>
                <button
                    class="bg-[#FDC652] ml-3 text-white px-12 py-2 rounded-lg text-sm font-semibold"
                    @click="sendBetting"
                    :disabled="calling_api"
                >
                    <span v-if="!calling_api"> ထိုးမည် </span>
                    <i v-else class="fas fa-spinner fa-spin px-4"></i>
                </button>
            </div>
        </div>

        <button
            data-twe-toggle="modal"
            class="hidden"
            data-twe-target="#promotion_modal"
            id="promotion_modal_btn"
        ></button>
        <!-- promotion modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="promotion_modal"
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
                            Choose One More
                        </h4>
                        <button
                            type="button"
                            id="close_promotion_modal"
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
                        <div class="mb-8">
                            <p class="text-sm mb-8 pb-20 px-6">
                                You bought {{ bet_numbers.length }} Tickets and
                                can choose
                                <span class="font-bold">{{
                                    freeTicketCount
                                }}</span>
                                more coz of promotion
                            </p>
                        </div>
                        <div class="mb-4">
                            <button
                                class="px-4 py-2 lg:py-3 bg-[#FFBF33] text-white text-sm rounded-lg w-full"
                                data-twe-modal-dismiss
                                aria-label="Close"
                            >
                                Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Delete Modal -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="delete_modal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                data-twe-modal-dialog-ref
                class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]"
            >
                <div
                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 py-4 px-6"
                    >
                        <h4
                            class="text-xl font-medium leading-normal text-surface"
                            id="exampleModalLabel"
                        >
                            Confirm Delete
                        </h4>
                        <button
                            type="button"
                            id="close"
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
                        class="relative flex-auto py-6 px-6"
                        data-twe-modal-body-ref
                    >
                        <p class="text-lg">Are You Sure ?</p>
                    </div>

                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end border-t-2 border-neutral-100 py-4 px-6 gap-x-4"
                    >
                        <button
                            type="button"
                            id="modalClose"
                            class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs text-black focus:outline-none focus:ring-00"
                            data-twe-modal-dismiss
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                        >
                            Close
                        </button>
                        <button
                            @click="deleteBetNumber"
                            type="button"
                            class="rounded bg-red-600 px-8 pb-2 pt-2.5 text-xs text-white focus:outline-none focus:ring-0"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <button
            data-twe-toggle="modal"
            class="hidden"
            data-twe-target="#error_modal"
            id="error_modal_btn"
        ></button>
        <!--Error Modal Box -->
        <div
            data-twe-modal-init
            class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="error_modal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                data-twe-modal-dialog-ref
                class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]"
            >
                <div
                    class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                >
                    <div
                        class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 py-4 px-6"
                    >
                        <h4
                            class="text-xl text-red-600 font-medium leading-normal text-surface"
                            id="exampleModalLabel"
                        >
                            Error
                        </h4>
                        <button
                            type="button"
                            id="close"
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
                        class="relative flex-auto py-6 px-6"
                        data-twe-modal-body-ref
                    >
                        <p class="text-lg">{{ error_modal_text }}</p>
                    </div>

                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end border-t-2 border-neutral-100 py-4 px-6 gap-x-4"
                    >
                        <button
                            v-if="
                                error_modal_text ==
                                'No more tickets for promotions.'
                            "
                            data-twe-modal-dismiss
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            type="button"
                            @click="resetPromotion"
                            class="rounded bg-red-600/50 px-8 pb-2 pt-2.5 text-xs text-white focus:outline-none focus:ring-0"
                        >
                            Reset Promotions
                        </button>
                        <button
                            data-twe-modal-dismiss
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                            type="button"
                            class="rounded bg-red-600 px-8 pb-2 pt-2.5 text-xs text-white focus:outline-none focus:ring-0"
                        >
                            OK
                        </button>
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
import CheckAuthMixin from "../../mixins/CheckAuthMixin";
import moment from "moment";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            numbers: [],
            game_setting_id: null,
            wallet_balance: null,
            game: null,
            bet_numbers: [],
            step: 1, //1 = main page , 2 totale amount
            delete_bet_number: null,
            error_modal_text: "",
            calling_api: false,
            ticket_counts_without_promoiton: 0,
            promotion_ticket_counts: 0,
            lottery_promotion_tickets: [],
            promotion_ticket_ids: [],
            promotion_mode: false,
            img_prefix: "",
        };
    },
    computed: {
        ...mapGetters(["getToken"]),
        totalBetAmount() {
            return this.bet_numbers.reduce((total, bet) => {
                const amount = parseFloat(bet.amount);
                return total + (isNaN(amount) ? 0 : amount);
            }, 0);
        },
        freeTicketCount() {
            let freeTicketCount = 0;
            let betNumbersCount = this.ticket_counts_without_promoiton
                ? this.ticket_counts_without_promoiton
                : this.bet_numbers.length;
            if (!this.lottery_promotion_tickets.length) {
                return 0;
            }
            this.lottery_promotion_tickets.forEach((rule) => {
                const divideResult = Math.floor(betNumbersCount / rule.qty);
                freeTicketCount += divideResult * rule.additional_qty;
                betNumbersCount = betNumbersCount % rule.qty;
            });
            return freeTicketCount;
        },
    },

    mixins: [CheckAuthMixin],
    methods: {
        alertValidationMessage(field) {
            this.$notify({
                title: `Input validation`,
                text: `You forgot to provide ${field}, please try again`,
                type: "warn",
            });
        },
        isBetNumber(number) {
            return this.bet_numbers.some((bet) => bet.number === number);
        },
        async getBetNumbers() {
            let response = await getApiData({
                url: `api/bet_number_list?game_id=3&game_setting_id=${this.game_setting_id}`,
                token: this.getToken,
            });
            this.numbers = response.data.bet_list_numbers;
            this.wallet_balance = response.data.balance;
            this.game = response.data.game;
            this.lottery_promotion_tickets =
                response.data.promotion.lottery_promotion_tickets.sort(
                    (a, b) => b.qty - a.qty
                );
        },
        addBetNumber(num) {
            const index = this.bet_numbers.findIndex(
                (bet) => bet.number === num.number
            );
            if (index === -1) {
                //add
                if (this.promotion_mode && this.promotion_ticket_counts != 0) {
                    //choosing for promotions
                    num.amount = 0;
                    this.bet_numbers.push(num);
                    this.promotion_ticket_counts = --this
                        .promotion_ticket_counts;
                } else if (
                    this.promotion_mode &&
                    this.promotion_ticket_counts == 0
                ) {
                    //run out of promotions tickets
                    this.showErrorModal("No more tickets for promotions.");
                    return;
                } else {
                    num.amount = this.game.price;
                    this.bet_numbers.push(num);
                }
            } else {
                //remove
                if (this.promotion_mode) {
                    this.promotion_ticket_counts = ++this
                        .promotion_ticket_counts;
                }
                this.bet_numbers.splice(index, 1);
            }
            if (!this.promotion_mode) {
                this.ticket_counts_without_promoiton = this.bet_numbers.length;
            }
        },
        deleteBetNumber() {
            const index = this.bet_numbers.findIndex(
                (bet) => bet.number === this.delete_bet_number
            );
            this.bet_numbers.splice(index, 1);
            const button = document.getElementById("modalClose");
            if (button) {
                button.click();
            }
        },
        resetPromotion() {
            this.bet_numbers.forEach((bet_number) => {
                bet_number.amount = this.game.price;
            });
            this.ticket_counts_without_promoiton = this.bet_numbers.length;
            this.promotion_ticket_counts = 0;
            this.promotion_ticket_ids = [];
            this.promotion_mode = false;
        },
        async sendBetting() {
            if (this.calling_api) {
                return;
            }
            if (!this.checkBalanced() || !this.checkCloseTime()) {
                return;
            }
            if (this.bet_numbers.length == 0) {
                this.showErrorModal("Invalid or empty betting numbers");
                return;
            }
            this.calling_api = true;
            let formData = new FormData();
            const data_to_send = this.bet_numbers.map((bet) => ({
                number: bet.number,
                amount: bet.amount,
            }));
            formData.append("numbers", JSON.stringify(data_to_send));
            formData.append("total_amount", this.totalBetAmount);
            formData.append("game_id", 3);
            formData.append("game_setting_id", this.game_setting_id);

            formData.append(
                "promotion_ticket_ids",
                JSON.stringify(
                    [...new Set(this.promotion_ticket_ids)].map(String)
                )
            );
            formData.append(
                "lottery_quantity",
                this.ticket_counts_without_promoiton
            );
            formData.append(
                "promotion_ticket_quantity",
                this.bet_numbers.length - this.ticket_counts_without_promoiton
            );
            formData.append("total_ticket_quantity", this.bet_numbers.length);

            let response = await postApiData({
                url: "api/create_lottery",
                form_data: formData,
                token: this.getToken,
            });
            this.calling_api = false;
            if (response.success) {
                this.$notify({
                    text: "Success betting.",
                    type: "info",
                });
                this.step = 1;
                this.bet_numbers = [];
                this.getBetNumbers();
            } else {
                this.showErrorModal(response.message);
            }
        },
        chooseNumber() {
            if (this.bet_numbers.length > 0) {
                if (this.getFreeTicketCount()) {
                    console.log(this.getFreeTicketCount());
                    if (this.promotion_mode && !this.promotion_ticket_counts) {
                        //after choose promotions
                        this.step = 2;
                    } else {
                        // show modal free tickets amount
                        this.ticket_counts_without_promoiton =
                            this.bet_numbers.length; // 30

                        this.promotion_ticket_counts =
                            this.getFreeTicketCount(); //9
                        this.promotion_mode = true;
                        this.clickModalHiddenBtn("promotion_modal_btn");
                    }
                } else {
                    //no free tickets
                    this.resetPromotion();
                    this.step = 2;
                }
            } else {
                this.showErrorModal("Choose lottery numbers first!");
            }
        },
        checkBalanced() {
            if (this.wallet_balance < this.totalBetAmount) {
                console.log(this.wallet_balance, this.totalBetAmount);
                this.showErrorModal("Not enough money!");
                return false;
            }
            return true;
        },
        showErrorModal(text) {
            this.error_modal_text = text;
            this.clickModalHiddenBtn("error_modal_btn");
        },
        clickModalHiddenBtn(id) {
            const button = document.getElementById(id);
            if (button) {
                button.click();
            }
        },
        checkCloseTime() {
            const currentTime = moment();
            const f_closing_time = moment(this.closing_time, "HH:mm");
            var alreadyClose = currentTime.isAfter(f_closing_time);
            if (alreadyClose) {
                this.showErrorModal("Close for a while!");
                return false;
            }
            return true;
        },

        getCurrentDate() {
            return moment().format("MMM DD, YYYY");
        },
        getCurrentTime() {
            return moment().format("hh:mm A");
        },
        formatTime(time) {
            return moment(time, "HH:mm").format("hh:mm A");
        },
        backBtn() {
            window.history.back();
        },
        getFreeTicketCount() {
            let freeTicketCount = 0;
            let betNumbersCount = this.ticket_counts_without_promoiton
                ? this.ticket_counts_without_promoiton
                : this.bet_numbers.length;
            console.log(
                "ticket_counts_without_promoiton",
                this.ticket_counts_without_promoiton
            );
            this.promotion_ticket_ids = [];
            this.lottery_promotion_tickets.forEach((rule) => {
                const divideResult = Math.floor(betNumbersCount / rule.qty);
                freeTicketCount += divideResult * rule.additional_qty;
                if (divideResult * rule.additional_qty) {
                    console.log("divideResult", divideResult);
                    console.log("additional_qty", rule.additional_qty);
                    console.log("count", divideResult * rule.additional_qty);
                    this.promotion_ticket_ids.push(rule.id);
                }
                betNumbersCount = betNumbersCount % rule.qty;
            });

            return freeTicketCount;
        },
    },

    mounted() {
        if (window.location.href.includes("shweshankan")) {
            this.img_prefix = "https://admin.shwepaukkan.com";
        } else if (window.location.href.includes("test")) {
            this.img_prefix = "http://spkadmin.test";
        } else {
            this.img_prefix = "http://localhost:8001";
        }
        const urlParams = new URLSearchParams(window.location.search);
        this.game_setting_id = urlParams.get("id");
        this.getBetNumbers();
        this.getFreeTicketCount();
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
