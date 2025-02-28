<template lang="">
    <notifications position="top center" />

    
    <div
        v-if="step == 4"
        class="frame-container min-h-[100vh]"
    >
        <Navbar title="ထီပေါက်သူ" :back-btn="backBtn" class="!px-8"></Navbar>

        <div
            class="relative mb-0 w-full rounded-lg bg-white pt-0 lg:pt-4 pb-14 px-0 lg:px-0"
        >
            <table class="table-auto w-full">
                <thead class="bg-[#FDC652] text-white">
                    <tr>
                        <th class="py-4 pl-8 text-left">No</th>
                        <th class="py-4">Name</th>
                        <th class="py-4">Date</th>
                        <th class="py-4">Phone</th>
                        <th class="py-4 pr-8">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(winner, index) in winners" :key="index">
                        <td class="text-left pl-8 py-4">{{ ++index }}</td>
                        <td class="text-center py-4">{{ winner.name }}</td>
                        <td class="text-center py-4">
                            {{ formatDate(winner.lottery_date_time) }}
                        </td>
                        <td class="text-center py-4">
                            <span class="font-bold mt-4">*****</span>
                            {{ winner.phone_number }}
                        </td>
                        <td class="text-center pr-8 py-4">
                            {{ winner.total_amount?.toLocaleString() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div
        v-else
        class="frame-container min-h-[100vh]"
    >
        <!-- <div
        class="frame-container min-h-[100vh]"
    > -->
        <Navbar title="ထိုးမည်" :back-btn="backBtn"></Navbar>

        <!-- choose time -->
        <div :class="step == 0 ? 'block' : 'hidden'">
            <div class="relative mb-0 w-full bg-transparent pt-4 pb-14 px-0 lg:px-4">
                <div class="grid grid-cols-2 gap-x-4 mb-8">
                    <a
                        href="history?game_id=2"
                        class="bg-[#FDC652] rounded-xl shadow-md text-center text-white py-8"
                    >
                        <a>
                            <i class="fal fa-file text-3xl pb-1"></i>
                            <p>မှတ်တမ်း</p>
                        </a>
                    </a>
                    <div
                        @click="step = 4"
                        class="bg-[#29261D] rounded-xl shadow-md text-center text-white py-8"
                    >
                        <a>
                            <i class="fal fa-users text-3xl pb-1"></i>
                            <p>ထီပေါက်သူ</p>
                        </a>
                    </div>
                </div>
                <div class="contents" v-if="!showSpinner">
          
                <div
                  v-if="settings.length > 0 && main_game_active && settings[0]?.is_active"
                 
                    class="bg-transparent items-center justify-center mb-8"
                >
                    <div
                        @click="step = 1"
                        class="bg-green-400 text-white rounded-xl cursor-pointer shadow-md pt-10 pb-8 px-6 flex justify-between items-end mb-5"
                    >
                        <div class="block">
                            <p v-if="game" class="mb-3">
                                {{
                                    formatDateTime(
                                        game.game_setting?.lottery_date_time
                                    )
                                }}
                            </p>

                            <i
                                class="fal fa-check-circle"
                                style="font-size: 24px"
                            ></i>
                        </div>

                        <div class="block">
                            <p class="text-right mb-3">3D</p>
                            <p class="text-xl font-semibold">ထိုးမည်</p>
                        </div>
                        <!-- <i
                            class="far fa-angle-right"
                            style="font-size: 24px"
                        ></i> -->
                    </div>
                </div>
                <div
                v-else
                    class="bg-transparent items-center justify-center mb-8"
                >
                    <div
                        class="bg-white rounded-xl cursor-pointer shadow-md py-20 px-12 flex"
                    >
                        <i
                            class="fas fa-exclamation text-red-700"
                            style="font-size: 24px"
                        ></i>
                        <span class="pl-8">3D ခေတ္တ ပိတ်ထားပါသည် </span>
                    </div>
                </div>
            </div>

                <div class="bg-transparent items-center justify-center mb-8">
                    <div
                        v-for="(winning, index) in winning_numbers"
                        :key="index"
                        :style="{ backgroundColor: winning.color }"
                        class="text-white rounded-xl cursor-pointer shadow-md px-8 py-10 flex justify-between mb-5"
                    >
                        <div>
                            <i
                                class="far fa-flame mr-3"
                                style="font-size: 24px"
                            ></i>
                            <span> {{ winning.number }}</span>
                        </div>
                        <span>{{
                            formatDate2(winning.lottery_date_time)
                        }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Error page -->
        <div :class="step == 3 ? 'block' : 'hidden'">
            <div class="relative mb-0 w-full bg-transparent pt-4 pb-14 px-4">
                <div class="bg-transparent items-center justify-center mb-8">
                    <div
                        class="bg-white rounded-xl cursor-pointer shadow-md px-32 py-32 flex"
                    >
                        <i
                            class="fas fa-exclamation text-red-700"
                            style="font-size: 24px"
                        ></i>
                        <span class="pl-32">3D ခေတ္တ ပိတ်ထားပါသည် </span>
                    </div>
                </div>
            </div>
        </div>
        <div :class="step == 1 ? 'block' : 'hidden'">
            <div
                class="relative block mb-6 w-full rounded-xl shadow-xl bg-white"
            >
                <div class="">
                    <div class="w-full py-4 px-4">
                        <div>
                            <div class="mb-4">
                                <label
                                    for="amount"
                                    class="text-sm mb-3 relative block"
                                    >Amount</label
                                >
                                <input
                                    type="number"
                                    id="amount"
                                    placeholder="Amount"
                                    v-model="each_amount"
                                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                                />
                            </div>
                        </div>
                        <div class="flex justify-between gap-x-4">
                            <button
                                @click="reverseFun"
                                class="px-4 py-2 lg:py-3 bg-[#15862E] text-white text-base rounded-lg w-80 mb-3"
                            >
                                {{ $t("R") }}
                            </button>
                            <button
                                class="px-4 py-2 lg:py-3 bg-[#FDC652] text-white text-base rounded-lg w-80 mb-3"
                                @click="changeToStep2(1)"
                            >
                                ထိုးမည်
                            </button>
                        </div>
                        <div class="block lg:flex justify-between">
                            <p class="text-sm mb-1">
                                {{ $t("Balance") }} : {{ wallet_balance?.toLocaleString() }} MMK
                            </p>
                            <p class="text-sm">
                                {{ $t("Closing Time") }} :
                                {{ closingDateTimeFormat }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-between bg-transparent mb-3">
                    <div class="relative inline-block w-32">
                        <select
                            class="block appearance-none w-full bg-blue-500 text-white px-4 py-2 pr-8 rounded-md shadow leading-tight focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            v-model="from_to_value"
                        >
                            <option
                                v-for="(from_to, index) in from_to_numbers"
                                :key="index"
                                :value="from_to"
                            >
                                {{ from_to.name }}
                            </option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white"
                        >
                            <svg
                                class="fill-current h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path d="M7 10l5 5 5-5H7z" />
                            </svg>
                        </div>
                    </div>
                    <!-- <div class="flex justify-end mb-4">
                        <button
                            @click="step = 4"
                            class="bg-[#8b5656] text-white px-4 py-2 rounded-lg text-sm"
                        >
                            Winners
                        </button>
                    </div> -->
                    <div class="flex justify-end mb-4">
                        <button
                            class="bg-[#b23434] text-white px-4 py-2 rounded-lg text-sm"
                            @click="bet_numbers = []"
                        >
                            {{ $t("Clear") }}
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-6 gap-x-1 lg:gap-x-4 gap-y-4">
                    <div
                        class="contents"
                        v-for="(num, index) in numbers100"
                        :key="index"
                    >
                        <div v-if="index == '96'" class="opacity-0"></div>

                        <div
                            :class="[
                                num.is_active == 0
                                    ? 'bg-gray-300'
                                    : isBetNumber(num.number)
                                    ? 'bg-[#FDC652] text-white'
                                    : 'bg-white',
                                'py-2 px-1 lg:px-2 text-center shadow-xl aspect-square flex items-center justify-center border border-gray-200 rounded-md',
                            ]"
                            @click="num.is_active == 1 ? addBetNumber(num) : ''"
                        >
                            <div class="w-full">
                                <p class="text-xs lg:text-base mb-2 font-inter">
                                    {{ num.number }}
                                </p>
                                <div
                                    class="w-8 lg:w-8 mx-auto bg-[#9C9C9C] h-1.5"
                                >
                                    <div
                                        :class="
                                            progressBarClass(
                                                num.total_bet_percentage
                                            )
                                        "
                                        class="bg-[#17b509] h-1.5"
                                        :style="{
                                            width: computedWidth(
                                                num.total_bet_percentage
                                            ),
                                        }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Result Page-->
        <div
            class="relative mb-0 w-full rounded-xl shadow-xl bg-white pt-4 pb-6 px-4"
            :class="step == 2 ? 'block' : 'hidden'"
            style="min-height: calc(100vh - 168px)"
        >
            <div class="mb-3">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="py-2">{{ $t("No") }}</th>
                            <th class="py-2">{{ $t("Multiplier") }}</th>
                            <th class="py-2">{{ $t("Betting Amount") }}</th>
                            <th class="py-2">{{ $t("Edit Delete") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(bet_number, index) in bet_numbers"
                            :key="index"
                        >
                            <td
                                class="text-center py-2"
                                :class="
                                    checkAvailableAmount(bet_number)
                                        ? ''
                                        : 'text-red-600'
                                "
                            >
                                {{ bet_number.number }}
                            </td>
                            <td
                                :class="
                                    checkAvailableAmount(bet_number)
                                        ? ''
                                        : 'text-red-600'
                                "
                                class="text-center py-2"
                            >
                                {{ bet_multiplier }}
                            </td>
                            <td
                                :class="
                                    checkAvailableAmount(bet_number)
                                        ? ''
                                        : 'text-red-600'
                                "
                                class="text-center py-2"
                            >
                                <span
                                    v-show="
                                        bet_number.number !=
                                        edit_bet_number.number
                                    "
                                >
                                    {{ bet_number.amount?.toLocaleString() }}
                                </span>
                                <!-- <input
                                    v-show="
                                        bet_number.number ==
                                        edit_bet_number.number
                                    "
                                    type="number"
                                    class="px-4 py-2 text-black"
                                    v-model="edit_bet_number.amount"
                                /> -->
                                <input
                                    v-show="
                                        bet_number.number ==
                                        edit_bet_number.number
                                    "
                                    v-model="edit_bet_number.amount"
                                    class="shadow appearance-none border border-gray-500 rounded py-2 px-3 text-gray-700 leading-tight focus:outline focus:shadow-outline"
                                    type="number"
                                    placeholder="Amount"
                                />
                            </td>
                            <td class="text-center py-2">
                                <button
                                    v-show="
                                        bet_number.number ==
                                        edit_bet_number.number
                                    "
                                    @click="editBetAmount"
                                >
                                    <i class="fas fa-check mr-2"></i>
                                </button>
                                <button
                                    v-show="
                                        bet_number.number !=
                                        edit_bet_number.number
                                    "
                                    @click="edit_bet_number = bet_number"
                                >
                                    <i class="fal fa-edit mr-2"></i>
                                </button>
                                <!-- <button
                                    @click="deleteBetNumber(bet_number.number)"
                                >
                                    <i class="fal fa-trash"></i>
                                </button> -->

                                <button
                                    data-twe-toggle="modal"
                                    data-twe-target="#delete_modal"
                                    @click="
                                        delete_bet_number = bet_number.number
                                    "
                                >
                                    <i class="fal fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="pt-2 mb-0 w-full block">
                <p class="text-sm pt-2  text-right pr-2 mb-4">
                    {{ $t("Total Betting Amount") }} : {{ totalBetAmount?.toLocaleString() }} MMK
                </p>
                <div class=" w-full flex justify-center">
                    <button
                        @click="sendBetting"
                        class="bg-[#FDC652] text-white px-12 py-2 rounded-lg text-sm font-semibold"
                    >
                        ထိုးမည်
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal -->
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
    </div>

    <button
        data-twe-toggle="modal"
        data-twe-target="#error_modal"
        id="error_modal_btn"
    >
        <!-- <i class="fal fa-trash"></i> -->
    </button>
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
                    <!-- <button
                        type="button"
                        id="modalClose"
                        class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs text-black focus:outline-none focus:ring-00"
                        data-twe-modal-dismiss
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                    >
                        Close
                    </button> -->
                    <button
                        data-twe-modal-dismiss
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                        type="button"
                        class="rounded bg-red-600 px-8 pb-2 pt-2.5 text-xs text-white focus:outline-none focus:ring-0"
                    >
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
    <button
        hidden
        disabled
        type="button"
        class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
        data-twe-toggle="modal"
        data-twe-target="#exampleModal"
        data-twe-ripple-init
        data-twe-ripple-color="light"
    >
        Launch demo modal
    </button>

    <div
        data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div
            data-twe-modal-dialog-ref
            class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:max-w-[500px]"
        >
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark"
            >
                <div
                    class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10"
                >
                    <h5
                        class="text-xl font-medium leading-normal text-surface dark:text-white"
                        id="exampleModalLabel"
                    >
                        Modal title
                    </h5>
                    <button
                        type="button"
                        class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
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

                <div class="relative flex-auto p-4" data-twe-modal-body-ref>
                    Modal body text goes here.
                </div>

                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4 dark:border-white/10"
                >
                    <button
                        type="button"
                        class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-200 focus:bg-primary-accent-200 focus:outline-none focus:ring-0 active:bg-primary-accent-200 dark:bg-primary-300 dark:hover:bg-primary-400 dark:focus:bg-primary-400 dark:active:bg-primary-400"
                        data-twe-modal-dismiss
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="ms-1 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { initTWE, Modal, Ripple, Dropdown } from "tw-elements";
import { postApiData, getApiData } from "../../utilities/ajax-helpers";
import { mapGetters } from "vuex";
import moment from "moment";
import Navbar from "../Nav/Navbar.vue";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

export default {
    name: "3Dcomponent",
    components: {
        Navbar,
    },
    data() {
        return {
            step: "", // 0 - before bettingpage time, 1 betting page , 2 - result page , 3 -error page (no use any more), 4 - winner lists ,
            numbers: [],
            each_amount: "",
            bet_numbers: [],
            currentDate: moment().format("YYYY-MM-DD"),

            bet_multiplier: "",
            opening_date_time: "",
            closing_date_time: "",
            wallet_balance: 0,
            time_status: "",
            current_time_status: "",
            edit_bet_number: {
                number: "",
                amount: "",
            },
            min: "",
            max: "",
            game_setting_id: "",
            game: "",
            calling_api: false,
            bet_limit: "",
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
            winner_page: 1,
            winner_last_page: 0,
            showSpinner: false,
            winners: [],
            settings: [],
            setting_value: "",
            winning_numbers: [],
            delete_bet_number: "",
            error_modal_text: "",
            main_game_active: 1,
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
        numbers100() {
            return this.numbers.slice(
                this.from_to_value.value - 100,
                this.from_to_value.value
            );
        },
        errorText() {
            var errorText = "";
            this.bet_numbers.forEach((bet) => {
                if (bet.is_active == 0) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
                if (bet.closing_amount < bet.amount + bet.total_bet_amount) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
            });
            return errorText;
        },
        closingDateTimeFormat() {
            return moment(this.closing_date_time, "YYYY-MM-DD HH:mm").format(
                "YYYY-MM-DD hh:mm A"
            );
        },
        checkUserEachLimitError() {
            var errorText = "";
            this.bet_numbers.forEach((bet) => {
                if (this.bet_limit < bet.amount + bet.total_amount) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
            });
            return errorText;
        },
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            if (this.step == 0 || this.step == 3) {
                // window.location.href = "/home";
                window.history.back();
            } else {
                this.step = 0;
            }
        },
        changeToStep2(from) {
            if (
                this.each_amount == "" ||
                this.each_amount == 0 ||
                this.bet_numbers.length == 0
            ) {
                this.$notify({
                    text: "Please enter bet numbers and amount",
                    type: "error",
                });
                return;
            }
            if (this.each_amount >= this.min && this.each_amount <= this.max) {
            } else {
                this.error_modal_text = `Amount must be between ${this.min} and ${this.max}`;
                this.showErrorModal();
                // this.$notify({
                //     text: errorText,
                //     type: "error",
                // });
                return;
            }
            if (this.each_amount > this.bet_limit) {
                this.error_modal_text = `Your limit is  ${this.bet_limit}`;
                this.showErrorModal();
                // this.$notify({
                //     text: errorText,
                //     type: "error",
                // });
                return;
            }
            this.bet_numbers.forEach((number) => {
                number.amount = this.each_amount;
            });
            this.sortBetNumbers();
            const check_balanced = this.checkBalanced();
            if (!check_balanced) {
                return;
            } else {
                this.step = 2;
            }
        },
        isBetNumber(number) {
            return this.bet_numbers.some((bet) => bet.number === number);
        },
        progressBarClass(percentage) {
            if (percentage === 100) {
                return "bg-[#c7080e] h-1-5";
            } else if (percentage > 70 && percentage < 100) {
                return "bg-[#f7db07] h-1-5";
            } else if (percentage < 70) {
                return "bg-[#17b509] h-1-5";
            } else {
                return "bg-[#7a2985] h-1-5"; // Default color
            }
        },
        computedWidth(percentage) {
            return percentage + "%";
        },
        checkAvailableAmount(number) {
            if (
                number.closing_amount >=
                number.amount + number.total_bet_amount
            ) {
                return true;
            } else {
                return false;
            }
        },
        addBetNumber(num) {
            // const available_for_bet = this.checkOpenCloseTime();
            // if (available_for_bet == false) {
            //     return;
            // }
            const index = this.bet_numbers.findIndex(
                (bet) => bet.number === num.number
            );
            if (index === -1) {
                num.amount = "";
                this.bet_numbers.push(num);
            } else {
                this.bet_numbers.splice(index, 1);
            }
        },
        deleteBetNumber(num) {
            const index = this.bet_numbers.findIndex(
                (bet) => bet.number === this.delete_bet_number
            );
            this.bet_numbers.splice(index, 1);
            const button = document.getElementById("modalClose");
            if (button) {
                button.click();
            }
        },
        editBetAmount() {
            const index = this.bet_numbers.find(
                (bet) => bet.number == this.edit_bet_number.number
            );
            if (
                this.edit_bet_number.amount >= this.min &&
                this.edit_bet_number.amount <= this.max
            ) {
                index.amount = this.edit_bet_number.amount;
                this.edit_bet_number = "";
            } else {
                this.error_modal_text = `Amount must be between ${this.min} and ${this.max}`;
                this.showErrorModal();
                // this.$notify({
                //     text: errorText,
                //     type: "error",
                // });
                return;
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
                            (bet) => bet.number === newPermutation
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
                    (n) => removeItself.includes(n.number) && n.is_active == 1
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
                (a, b) => parseInt(a.number) - parseInt(b.number)
            );
        },
        checkBalanced() {
            if (this.wallet_balance < this.totalBetAmount) {
                this.error_modal_text = "Not enough money!";
                this.showErrorModal();
                // this.$notify({
                //     text: "Not enough money!",
                //     type: "error",
                // });
                return false;
            } else {
                return true;
            }
        },
        async getBetNumbers() {
            let response = await getApiData({
                url: `api/bet_number_list?game_id=2`,
                token: this.getToken,
            });
            this.numbers = response.data.bet_list_numbers;

            this.wallet_balance = response.data.balance;
            this.bet_limit = response.data.bet_limit;

            let threeDgame = response.data.game;
            this.game = threeDgame;
            this.bet_multiplier = threeDgame.game_setting.bet_multiplier;
            this.game_setting_id = threeDgame.game_setting.id;
            this.current_time_status = threeDgame.game_setting.time_status;
            this.opening_date_time = moment(
                threeDgame.game_setting.opening_date_time,
                "YYYY-MM-DD HH:mm"
            );
            this.closing_date_time = moment(
                threeDgame.game_setting.closing_date_time,
                "YYYY-MM-DD HH:mm"
            );
            this.min = threeDgame.game_setting.min;
            this.max = threeDgame.game_setting.max;
        },
        async sendBetting() {
            if (this.edit_bet_number.number) {
                this.$notify({
                    text: "Please confirm edit number first!",
                    type: "error",
                });
                return;
            }
            if (this.calling_api) {
                return;
            }
            const available_for_bet = this.checkOpenCloseTime();
            if (available_for_bet == false) {
                return;
            }
            const check_balanced = this.checkBalanced();
            if (!check_balanced) {
                return;
            }
            if (this.errorText) {
                this.error_modal_text = this.errorText;
                this.showErrorModal();
                // this.$notify({
                //     text: this.errorText,
                //     type: "error",
                // });
                return;
            }
            if (this.checkUserEachLimitError) {
                //check closing amount
                this.error_modal_text = this.checkUserEachLimitError;
                this.showErrorModal();
                // this.$notify({
                //     text: this.checkUserEachLimitError,
                //     type: "error",
                // });
                return;
            }
            this.calling_api = true;
            let formData = new FormData();
            formData.append("numbers", JSON.stringify(this.bet_numbers));
            formData.append("betting_multiplier", this.bet_multiplier);
            formData.append("total_amount", this.totalBetAmount);
            formData.append("game_id", 2);
            // formData.append("time_status", this.time_status);
            formData.append("game_setting_id", this.game_setting_id);
            let response = await postApiData({
                url: "api/betting",
                form_data: formData,
                token: this.getToken,
            });
            if (response.success) {
                this.calling_api = false;
                this.$notify({
                    text: "Success betting.",
                    type: "info",
                });
                this.step = 1;
                this.bet_numbers = [];
                this.each_amount = "";
                this.time_status = "";
                this.getBetNumbers();
            } else {
                this.calling_api = false;

                this.error_modal_text = response.message;
                this.showErrorModal();
                // this.$notify({
                //     text: response.message,
                //     type: "error",
                // });
            }
        },
        checkOpenCloseTime() {
            const alreadyOpen = this.checkOpenTime();
            const alreadyClose = this.checkCloseTime();
            if (!alreadyOpen) {
                this.error_modal_text = "Wait for open time!";
                this.showErrorModal();
                // this.$notify({
                //     text: "Wait for open time!",
                //     type: "error",
                // });
                return false;
            }
            if (alreadyClose) {
                this.error_modal_text = "Close for a while!";
                this.showErrorModal();
                // this.$notify({
                //     text: "Close for a while!",
                //     type: "error",
                // });
                return false;
            }
            if (alreadyOpen && !alreadyClose) {
                return true;
            }
        },
        checkOpenTime() {
            const currentTime = moment();
            const f_opening_time = moment(
                this.opening_date_time,
                "YYYY-MM-DD HH:mm"
            );
            var alreadyOpen = currentTime.isAfter(f_opening_time);
            return alreadyOpen;
        },
        checkCloseTime() {
            const currentTime = moment();
            const f_closing_time = moment(
                this.closing_date_time,
                "YYYY-MM-DD HH:mm"
            );
            var alreadyClose = currentTime.isAfter(f_closing_time);
            return alreadyClose;
        },
        generateNumberArray() {
            const numbers = [];
            const closingAmount = 200000;
            const minBet = 100;
            const maxBet = 100000;

            for (let i = 0; i <= 999; i++) {
                const numberString = i.toString().padStart(3, "0");
                const numberObject = {
                    number: numberString,
                    total_bet_amount: 200000,
                    closing_amount: closingAmount,
                    min: minBet,
                    max: maxBet,
                    is_active: 1,
                    total_bet_percentage: 80,
                };
                numbers.push(numberObject);
            }
            this.wallet_balance = 100000;
            this.bet_multiplier = 700;
            this.game_setting_id = 3;
            this.current_time_status = "morning";
            this.opening_date_time = moment(
                "2024-06-18 00:00:00",
                "YYYY-MM-DD HH:mm"
            ).format("YYYY-MM-DD HH:mm A");
            this.closing_date_time = moment(
                "2024-07-01 03:00:00",
                "YYYY-MM-DD HH:mm"
            ).format("YYYY-MM-DD hh:mm A");
            this.min = 100;
            this.max = 10000;

            return numbers;
        },
        async checkGameActive() {
            this.showSpinner = true;
            let response = await getApiData({
                url: `api/game_list?game_id=2`,
                token: this.getToken,
            });
            this.showSpinner = false;

            this.step = 0;
            this.settings = response.data.settings;
            var colors = ["#c9cb50", "#4ade80", "#69abc5", "#8d3f5f"];
            this.winning_numbers = response.data.winning_numbers.map(
                (win, index) => {
                    const color = colors[index % colors.length];
                    return { ...win, color };
                }
            );
            // this.settings = [];
            this.main_game_active = response.data.is_active;
            if (response.data.is_active && response.data.settings.length) {
                this.getBetNumbers();
                if (response.data.settings.length) {
                    this.setting_value = response.data.settings[0].id;
                }
            }

            //  else {
            //     this.step = 3; //error page
            // }
        },
        async getBetWinners() {
            if (!this.setting_value) {
                this.$notify({
                    text: "There is no bet winners lists!",
                    type: "error",
                });
                return;
            }
            this.showSpinner = true;
            let response = await getApiData({
                url: `api/winning_list?game_setting_id=${this.game.game_setting.id}&page=${this.winner_page}`,
                token: this.getToken,
            });
            this.showSpinner = false;
            this.winner_last_page = response.data.last_page;
            this.winners = [...this.winners, ...response.data.data];
        },
        handleScroll() {
            const bottomOfWindow =
                document.documentElement.scrollTop + window.innerHeight;
            const scrollHeight = document.documentElement.scrollHeight;
            const nearEndThreshold = 450;
            var endlessScroll =
                scrollHeight - bottomOfWindow < nearEndThreshold;
            if (
                endlessScroll &&
                this.winner_page >= 1 &&
                this.winner_page < this.winner_last_page &&
                !this.showSpinner
            ) {
                this.winner_page += 1;
                this.getBetWinners();
            }
        },
        formatDate(date) {
            return moment(date, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD");
        },
        formatDate2(date) {
            return moment(date).format("MMMM D, YYYY");
        },
        formatDateTime(date) {
            return moment(date).format("MMM D, YYYY hh:mm A");
        },
        showErrorModal() {
            const button = document.getElementById("error_modal_btn");
            if (button) {
                button.click();
            }
        },
    },
    watch: {
        step(newValue, oldValue) {
            this.winners = [];
            if (this.step == 4) {
                window.addEventListener("scroll", this.handleScroll);
                this.getBetWinners();
            } else {
                window.removeEventListener("scroll", this.handleScroll);
            }
        },
    },
    mounted() {
        this.checkGameActive();
        initTWE({ Modal, Ripple, Dropdown });

        // this.numbers = this.generateNumberArray();
    },
};
</script>
<style lang=""></style>
