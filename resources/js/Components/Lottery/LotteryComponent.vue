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
            <Navbar title="Lottery" :back-btn="backBtn"></Navbar>
        </div>

        <div class="bg-[#FDC652] rounded-t-2xl">
            <div :class="step == 1 ? 'block' : 'hidden'" class="pt-6 pb-10">
                <p class="text-center text-black font-semibold text-xl mb-4">
                    ကံစမ်းမဲ
                </p>

                <div
                    class="rounded-2xl bg-black overflow-hidden shadow-lg mb-6 px-4 mx-4"
                >
                    <div class="w-full h-44 overflow-hidden">
                        <img
                            :src="img_prefix + game?.photo"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div class="px-4 py-4 text-center">
                        <p class="text-white text-lg font-medium mb-0">
                            {{ game?.name }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-center mb-6 px-4">
                    <button
                        class="bg-[#5271FF] w-full py-3 rounded-xl text-white text-xl"
                        @click="step = 2"
                    >
                        ရှေ့ဆက်ရန်
                    </button>
                </div>

                <div v-if="sub_step == 1" class="pb-2 mb-16">
                    <div class="bg-white py-2 mb-2">
                        <p
                            class="text-black text-lg text-center font-semibold mb-0"
                        >
                            ကံစမ်းမဲ နှင့် ပတ်သတ်သော အကြောင်းအရာများ
                        </p>
                    </div>

                    <div class="space-y-0 mx-4">
                        <a
                            @click="sub_step = 2"
                            class="flex items-center justify-between py-4 cursor-pointer border-b border-black/20"
                        >
                            <div class="flex items-center gap-x-4">
                                <img
                                    src="../../../../public/icons/cross.png"
                                    alt=""
                                    class="w-7"
                                />
                                <span class="text-lg text-black font-semibold"
                                    >ကံစမ်းမဲ အကြောင်း</span
                                >
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6 text-black"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>

                        <a
                            @click="sub_step = 3"
                            class="flex items-center justify-between py-4 cursor-pointer border-b border-black/20"
                        >
                            <div class="flex items-center gap-x-4">
                                <img
                                    src="../../../../public/icons/cross.png"
                                    alt=""
                                    class="w-7"
                                />
                                <span class="text-lg text-black font-semibold"
                                    >ကံစမ်းမဲ ပရိုမိုးရှင်းများ:</span
                                >
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6 text-black"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>

                        <a
                            @click="sub_step = 4"
                            class="flex items-center justify-between py-4 cursor-pointer"
                        >
                            <div class="flex items-center gap-x-4">
                                <img
                                    src="../../../../public/icons/cross.png"
                                    alt=""
                                    class="w-7"
                                />
                                <span class="text-lg text-black font-semibold"
                                    >ကံစမ်းမဲ စည်းကမ်းသတ်မှတ်ချက်များ:</span
                                >
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6 text-black"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>
                    </div>

                    <p
                        class="text-center text-red-600 font-semibold text-lg mt-6 mx-4"
                    >
                        ကံစမ်းမဲ နှင့် ပတ်သတ်သော အကြောင်းအရာများကို
                        သေချာစွာဖတ်ရှုပေးပါရန်
                    </p>
                </div>

                <div v-if="sub_step == 2" class="px-8 pb-4 mb-8">
                    <h2
                        class="text-xl font-bold mb-4 dash-under after:!-bottom-1 relative after:!left-0 inline-block pb-3"
                    >
                        ကံစမ်းမဲအကြောင်း
                    </h2>
                    <div class="mb-0 mt-4">
                        <p>
                            {{ game.description }}
                        </p>
                    </div>
                </div>
                <div v-if="sub_step == 3" class="px-8 pb-4 mb-8">
                    <h2
                        class="text-xl font-bold mb-4 dash-under after:!-bottom-1 relative after:!left-0 inline-block pb-3"
                    >
                        ကံစမ်းမဲ Promotion အကြောင်း
                    </h2>
                    <div class="mb-0 mt-4">
                        <div v-if="lottery_promotion_tickets.length > 0">
                            <p
                                v-for="(
                                    promotion, index
                                ) in lottery_promotion_tickets"
                                :key="index"
                                class="mb-2 text-lg"
                            >
                                {{ promotion.qty }} စောင်၀ယ်လျှင်
                                {{ promotion.additional_qty }} စောင်
                                အပိုရရှိပါမည်
                            </p>
                        </div>
                        <div v-else>
                            <p class="text-lg">Prmotion မရှိပါ</p>
                        </div>
                    </div>
                </div>
                <div v-if="sub_step == 4" class="px-8 pb-4 mb-8">
                    <h2
                        class="text-xl font-bold mb-4 dash-under after:!-bottom-1 relative after:!left-0 inline-block pb-3"
                    >
                        စည်းကမ်းသတ်မှတ်ချက်များ
                    </h2>
                    <div class="mb-0 mt-4">
                        <p>
                            {{ game.terms_and_condition }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- select number -->
            <div
                :class="step == 2 ? 'block' : 'hidden'"
                class="pb-16 rounded-3xl bg-[#FFC529]"
            >
                <div class="px-4 pt-6">
                    <p class="font-semibold text-center text-xl mb-1">
                        ကံစမ်းမဲ
                    </p>

                    <p class="text-lg mb-1 text-center">
                        {{ game?.name }}
                    </p>
                    <div
                        class="rounded-2xl border border-black/30 bg-[#C89A1E] px-4 py-4"
                    >
                        <div class="text-center text-black">
                            <p class="text-lg mb-0 flex justify-between">
                                <span> ကံစမ်းမဲ တစ်စောင် </span>
                                <span> {{ game?.price }} ကျပ် </span>
                            </p>
                        </div>
                    </div>

                    <div v-if="promotion_notice_shown" class="mt-6">
                        <div
                            class="px-4 pt-4 pb-5 rounded-2xl border border-black/30 bg-[#C89A1E]"
                        >
                            <div
                                class="rounded-2xl bg-[#E5E7EB] border-2 border-black/60 px-4 pt-5 pb-6 text-center"
                            >
                                <p
                                    class="text-black text-lg font-semibold mb-2"
                                >
                                    ကံစမ်းမဲ
                                    {{ ticket_counts_without_promoiton }}
                                    စောင်ဝယ်ယူတိုင်း
                                </p>
                                <p
                                    class="text-black text-lg font-semibold mb-3"
                                >
                                    Free Ticket {{ freeTicketCount }} ခုရရှိမည်
                                </p>
                                <p
                                    class="text-red-600 text-lg font-semibold mb-5"
                                >
                                    Free Ticket
                                    {{ freeTicketCount }} ခုရွေးခြယ်ပေးပါရန်
                                </p>
                            </div>
                        </div>
                        <button
                            type="button"
                            class="bg-[#5271FF] mt-4 w-full py-4 rounded-xl text-white text-xl font-semibold"
                            @click="promotion_notice_shown = false"
                        >
                            ရှေ့ဆက်ရန်
                        </button>
                    </div>

                    <div v-if="!promotion_notice_shown" class="contents">
                        <div class="mt-6">
                            <button
                                class="bg-[#5271FF] w-full py-4 rounded-xl text-white text-xl font-semibold"
                                @click="chooseNumber"
                            >
                                ရှေ့ဆက်မည်
                            </button>
                        </div>

                        <div class="mt-6">
                            <p
                                class="text-left text-black font-semibold text-xl mb-3"
                            >
                                ထိပ်စီး နံပါတ်ရွေးပါ
                            </p>
                            <div class="flex items-center gap-x-4">
                                <div class="flex-grow relative">
                                    <div
                                        class="flex items-center bg-[#E5E7EB] rounded-2xl overflow-hidden border-2 border-black"
                                        style="height: 60px"
                                    >
                                        <div
                                            class="shrink-0 px-6 items-center gap-x-4 text-black"
                                        >
                                            <p
                                                class="block text-xl font-bold leading-none"
                                            >
                                                123
                                            </p>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="w-8 h-8"
                                            >
                                                <path
                                                    d="M3 12a1 1 0 0 1 1-1h11.586l-3.293-3.293a1 1 0 1 1 1.414-1.414l5 5a1 1 0 0 1 0 1.414l-5 5a1 1 0 1 1-1.414-1.414L15.586 13H4a1 1 0 0 1-1-1z"
                                                />
                                            </svg>
                                        </div>

                                        <div class="relative flex-grow h-full">
                                            <select
                                                class="block appearance-none w-full h-full bg-transparent text-black text-xl font-medium text-center pr-16 pl-2 focus:outline-none focus:ring-0"
                                                v-model="from_to_value"
                                            >
                                                <option
                                                    v-for="(
                                                        from_to, index
                                                    ) in from_to_numbers"
                                                    :key="index"
                                                    :value="from_to"
                                                >
                                                    {{ from_to.name }}
                                                </option>
                                            </select>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-8 text-black"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    fill="currentColor"
                                                    class="w-8 h-8"
                                                >
                                                    <path
                                                        d="M6.707 9.293a1 1 0 0 1 1.414 0L12 13.172l3.879-3.879a1 1 0 1 1 1.414 1.414l-4.586 4.586a1 1 0 0 1-1.414 0L6.707 10.707a1 1 0 0 1 0-1.414z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button
                                    @click="reverseFun"
                                    class="w-14 h-14 bg-[#d9d9d9] text-black text-xl font-semibold rounded-xl border border-black/20"
                                >
                                    R
                                </button>

                                <button
                                    class="bg-[#b23434] text-white px-4 h-14 rounded-xl text-sm font-semibold"
                                    @click="bet_numbers = []"
                                >
                                    {{ $t("Clear") }}
                                </button>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-10 gap-x-2 gap-y-3">
                            <div
                                class="contents"
                                v-for="(num, index) in numbers100"
                                :key="index"
                            >
                                <div
                                    :class="[
                                        num.is_active == 0
                                            ? 'bg-[#cfcfcf] text-white'
                                            : isBetNumber(num.number)
                                              ? 'bg-[#5271FF] text-white'
                                              : 'bg-[#FF9900] text-white',
                                        'rounded-lg py-5 shadow-lg aspect-square flex flex-col items-center justify-center border border-white',
                                    ]"
                                    @click="
                                        num.is_active == 1
                                            ? addBetNumber(num)
                                            : ''
                                    "
                                >
                                    <div class="w-full">
                                        <p
                                            class="text-base font-bold text-center leading-none"
                                        >
                                            {{ num.number }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Page-->
            <div
                class="relative mb-12 w-full pb-14"
                :class="step == 3 ? 'block' : 'hidden'"
                style="min-height: calc(100vh - 168px)"
            >
                <div class="px-4 pt-4 pb-16 bg-[#FFC529] rounded-t-3xl">
                    <p class="text-center text-xl font-semibold mb-2">
                        ကံစမ်းမဲ
                    </p>
                    <p class="text-center text-lg mb-4">
                        {{ game?.name }}
                    </p>

                    <div
                        class="rounded-2xl bg-[#C89A1E] px-3 pt-3 pb-4 border border-black/40"
                    >
                        <div
                            class="rounded-xl bg-white border-2 border-gray-700 overflow-hidden"
                        >
                            <div
                                class="flex justify-between items-center px-4 py-2 bg-[#F4F4F4] text-base md:text-lg"
                            >
                                <p>{{ getCurrentDate() }}</p>
                                <p>
                                    {{ getCurrentTime() }}
                                </p>
                            </div>

                            <div class="px-4 pb-3 pt-2 overflow-y-auto">
                                <table class="table-auto w-full text-base">
                                    <thead>
                                        <tr class="border-b !border-gray-300">
                                            <th class="py-3 text-left">စဉ်</th>
                                            <th class="py-3 text-center">
                                                {{ $t("No") }}
                                            </th>
                                            <th class="py-3 text-right">
                                                {{ $t("Betting Amount") }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                bet_number, index
                                            ) in bet_numbers"
                                            :key="index"
                                            class="border-b last:border-0"
                                        >
                                            <td class="py-3 text-left">
                                                {{ index + 1 }}
                                            </td>
                                            <td class="py-3 text-center">
                                                {{ bet_number.number }}
                                            </td>
                                            <td class="py-3 text-right">
                                                {{
                                                    bet_number.amount?.toLocaleString()
                                                }}
                                                ကျပ်
                                            </td>
                                        </tr>
                                        <tr
                                            class="border-t !border-gray-300"
                                            v-if="bet_numbers.length"
                                        >
                                            <td></td>
                                            <td
                                                class="text-center text-base font-semibold py-3 pb-2"
                                            >
                                                စုစုပေါင်း
                                            </td>
                                            <td
                                                class="text-right text-base font-semibold py-3"
                                            >
                                                {{
                                                    totalBetAmount?.toLocaleString()
                                                }}
                                                ကျပ်
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <p
                            v-if="
                                bet_numbers.length -
                                    ticket_counts_without_promoiton >
                                0
                            "
                            class="mt-4 text-right text-base font-semibold text-black"
                        >
                            Free Ticket
                            {{
                                bet_numbers.length -
                                ticket_counts_without_promoiton
                            }}
                            စောင် ရရှိပါသည်
                        </p>
                    </div>

                    <div class="mt-6">
                        <button
                            class="bg-[#5271FF] w-full py-4 rounded-xl text-white text-xl font-semibold"
                            @click="sendBetting"
                            :disabled="calling_api"
                        >
                            <span v-if="!calling_api"> အတည်ပြုမည် </span>
                            <i v-else class="fas fa-spinner fa-spin px-4"></i>
                        </button>
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
                class="fixed inset-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none bg-black/80 flex items-center justify-center p-4"
                id="error_modal"
                tabindex="-1"
                aria-labelledby="errorModalLabel"
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
                                class="text-xl font-semibold leading-normal text-red-600"
                                id="errorModalLabel"
                            >
                                Error
                            </h4>
                            <button
                                type="button"
                                id="close"
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
                            class="relative flex-auto pb-6 px-6"
                            data-twe-modal-body-ref
                        >
                            <p
                                class="text-lg font-semibold text-red-600 text-center"
                            >
                                {{ error_modal_text }}
                            </p>
                        </div>

                        <div
                            class="flex flex-shrink-0 flex-wrap items-center justify-end px-6 pb-6 gap-x-3"
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
                                class="rounded-2xl bg-red-600/80 px-6 py-4 text-sm text-white font-semibold focus:outline-none focus:ring-0"
                            >
                                Reset Promotions
                            </button>
                            <button
                                data-twe-modal-dismiss
                                data-twe-ripple-init
                                data-twe-ripple-color="light"
                                type="button"
                                class="rounded-2xl bg-white/70 px-6 py-4 text-sm text-black font-semibold focus:outline-none focus:ring-0"
                            >
                                Close
                            </button>
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
            step: 1, //1= main page , 2 select number ,3 = total amount
            delete_bet_number: null,
            error_modal_text: "",
            calling_api: false,
            ticket_counts_without_promoiton: 0,
            promotion_ticket_counts: 0,
            lottery_promotion_tickets: [],
            promotion_ticket_ids: [],
            promotion_mode: false,
            promotion_notice_shown: false,
            img_prefix: "",
            sub_step: 1, //1,2,3,4
            from_to_numbers: [
                {
                    name: "000 - 099",
                    value: 100,
                },
                {
                    name: "100 - 199",
                    value: 200,
                },
                {
                    name: "200 - 299",
                    value: 300,
                },
                {
                    name: "300 - 399",
                    value: 400,
                },
                {
                    name: "400 - 499",
                    value: 500,
                },
                {
                    name: "500 - 599",
                    value: 600,
                },
                {
                    name: "600 - 699",
                    value: 700,
                },
                {
                    name: "700 - 700",
                    value: 800,
                },
                {
                    name: "800 - 899",
                    value: 900,
                },
                {
                    name: "900 - 999",
                    value: 1000,
                },
            ],
            from_to_value: {
                name: "000 - 099",
                value: 100,
            },
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
        numbers100() {
            return this.numbers.slice(
                this.from_to_value.value - 100,
                this.from_to_value.value,
            );
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
            let temp = this.from_to_numbers.filter(
                (num) => num.value <= this.numbers.length,
            );
            this.from_to_numbers = temp;
            this.lottery_promotion_tickets =
                response.data.promotion.lottery_promotion_tickets.sort(
                    (a, b) => b.qty - a.qty,
                );
        },
        addBetNumber(num) {
            const index = this.bet_numbers.findIndex(
                (bet) => bet.number === num.number,
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
        iterativePermutations(str) {
            let results = [str[0]];

            for (let i = 1; i < str.length; i++) {
                let currentChar = str[i];
                let newResults = [];

                results.forEach((permutation) => {
                    for (let j = 0; j <= permutation.length; j++) {
                        let newPermutation =
                            permutation.slice(0, j) +
                            currentChar +
                            permutation.slice(j);
                        const index = this.bet_numbers.findIndex(
                            (bet) => bet.number === newPermutation,
                        );
                        if (index === -1) {
                            newResults.push(newPermutation);
                        }
                    }
                });

                results = newResults;
            }
            const removeItself = results.filter((r) => r != str);
            var temp = this.numbers
                .filter(
                    (n) => removeItself.includes(n.number) && n.is_active == 1,
                )
                .map((n) => ({ ...n, amount: "" }));
            return temp;
        },
        reverseFun() {
            let result = [];
            this.bet_numbers.forEach((bet) => {
                let temp = this.iterativePermutations(bet.number);
                result = [...result, ...temp];
            });
            this.bet_numbers = [...this.bet_numbers, ...result];
            this.sortBetNumbers();
            this.$notify({
                text: "R ပြီးပါပြီ.",
                type: "info",
            });
        },
        sortBetNumbers() {
            this.bet_numbers.sort(
                (a, b) => parseInt(a.number) - parseInt(b.number),
            );
        },
        deleteBetNumber() {
            const index = this.bet_numbers.findIndex(
                (bet) => bet.number === this.delete_bet_number,
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
            this.promotion_notice_shown = false;
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
                    [...new Set(this.promotion_ticket_ids)].map(String),
                ),
            );
            formData.append(
                "lottery_quantity",
                this.ticket_counts_without_promoiton,
            );
            formData.append(
                "promotion_ticket_quantity",
                this.bet_numbers.length - this.ticket_counts_without_promoiton,
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
                this.step = 2;
                this.bet_numbers = [];
                this.getBetNumbers();
            } else {
                this.showErrorModal(response.message);
            }
        },
        chooseNumber() {
            if (this.bet_numbers.length > 0) {
                const freeCount = this.getFreeTicketCount();
                if (freeCount) {
                    if (this.promotion_mode && !this.promotion_ticket_counts) {
                        //after choose promotions
                        this.step = 3;
                    } else {
                        // show promotion notice (no modal)
                        this.ticket_counts_without_promoiton =
                            this.bet_numbers.length; // 30

                        this.promotion_ticket_counts = freeCount; //9
                        this.promotion_mode = true;
                        this.promotion_notice_shown = true;
                    }
                } else {
                    //no free tickets
                    this.resetPromotion();
                    this.step = 3;
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
            if (this.step == 3) {
                this.step = 2;
                return;
            }
            if (this.step == 2) {
                this.step = 1;
                return;
            }
            if (this.step == 1) {
                if (this.sub_step > 1) {
                    this.sub_step = 1;
                    return;
                } else {
                    window.history.back();
                }
            }
        },
        getFreeTicketCount() {
            let freeTicketCount = 0;
            let betNumbersCount = this.ticket_counts_without_promoiton
                ? this.ticket_counts_without_promoiton
                : this.bet_numbers.length;
            console.log(
                "ticket_counts_without_promoiton",
                this.ticket_counts_without_promoiton,
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
        if (window.location.href.includes("shwepaukkan")) {
            this.img_prefix = "https://admin.shwepaukkan.com";
        } else if (window.location.href.includes("test")) {
            this.img_prefix = "https://spkadmin.test";
        }
        const urlParams = new URLSearchParams(window.location.search);
        this.game_setting_id = urlParams.get("id");
        this.getBetNumbers();
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
