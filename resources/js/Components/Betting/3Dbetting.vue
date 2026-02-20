<template lang="">
    <notifications position="top center" />

    <div
        v-if="step == 4"
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4 mb-24">
            <Navbar title="ထီပေါက်သူ" :back-btn="backBtn"></Navbar>
        </div>

        <div class="mt-4 pb-14">
            <div
                class="bg-[#FFC529] rounded-t-3xl shadow-lg px-4 pt-4 pb-6 min-h-[calc(100vh-100px)]"
            >
                <p class="text-center text-xl font-bold mb-4">ထီပေါက်သူ</p>

                <div class="rounded-2xl bg-[#C58A1F] px-3 pt-3 pb-4">
                    <div
                        class="rounded-xl bg-white border-2 border-gray-700 overflow-hidden"
                    >
                        <table class="table-auto w-full">
                            <thead class="bg-[#F4F4F4] text-black">
                                <tr>
                                    <th class="py-3">No</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Phone</th>
                                    <th class="py-3">Number</th>
                                    <th class="py-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!winners.length">
                                    <td
                                        colspan="5"
                                        class="text-center py-10 text-black font-semibold"
                                    >
                                        No winners found
                                    </td>
                                </tr>
                                <tr
                                    v-for="(winner, index) in winners"
                                    :key="index"
                                    class="border-b last:border-0 border-black/10"
                                >
                                    <td class="text-center text-sm py-3">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="text-center text-sm py-3">
                                        {{ winner.name }}
                                    </td>
                                    <td class="text-center text-sm py-3">
                                        {{
                                            formatDate(winner.lottery_date_time)
                                        }}
                                    </td>
                                    <td class="text-center text-sm py-3">
                                        <span class="font-bold mt-4"
                                            >*****</span
                                        >
                                        {{ winner.phone_number }}
                                    </td>
                                    <td class="text-center text-sm py-3">
                                        {{ winner.number }}
                                    </td>
                                    <td class="text-center text-sm py-3">
                                        {{
                                            winner.total_amount?.toLocaleString()
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        v-else
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4 mb-24">
            <Navbar title="ထိုးမည်" :back-btn="backBtn"></Navbar>
        </div>
        <!-- choose time -->
        <div :class="step == 0 ? 'block' : 'hidden'" class="mt-4 pb-14">
            <div
                class="items-center justify-center bg-[#FFC529] rounded-t-3xl shadow-lg"
            >
                <div class="pt-4 pb-4">
                    <div class="grid px-4 grid-cols-2 gap-x-4 mb-6">
                        <a
                            href="history?game_id=2"
                            class="bg-[#29261D] rounded-xl shadow-md text-center text-white py-6"
                        >
                            <div>
                                <i class="fal fa-file text-3xl pb-1"></i>
                                <p>မှတ်တမ်း</p>
                            </div>
                        </a>
                        <div
                            @click="step = 4"
                            class="bg-[#FDC652] rounded-xl shadow-md text-center text-black py-6 cursor-pointer"
                        >
                            <div>
                                <i class="fal fa-users text-3xl pb-1"></i>
                                <p>ထီပေါက်သူ</p>
                            </div>
                        </div>
                    </div>

                    <h1 class="text-center text-xl font-bold mb-3">
                        3D ထိုးမည်
                    </h1>

                    <div
                        class="w-full max-w-md mx-auto bg-[#06000040] rounded-3xl px-6 py-6 shadow-lg"
                    >
                        <div class="contents" v-if="!showSpinner">
                            <div
                                v-if="
                                    settings.length > 0 &&
                                    main_game_active &&
                                    settings[0]?.is_active
                                "
                                class="items-center justify-center mb-4"
                            >
                                <div
                                    @click="step = 1"
                                    class="bg-white/95 text-black rounded-2xl cursor-pointer shadow-md pt-6 pb-5 px-5 flex justify-between items-center transition duration-150 ease-out hover:shadow-lg hover:-translate-y-1 hover:bg-white"
                                >
                                    <div class="block text-left">
                                        <p v-if="game" class="mb-3 text-sm">
                                            {{
                                                formatDateTime(
                                                    game.game_setting
                                                        ?.lottery_date_time,
                                                )
                                            }}
                                        </p>

                                        <i
                                            class="fas fa-check-circle text-[#15862E]"
                                            style="font-size: 24px"
                                        ></i>
                                    </div>

                                    <div class="block text-right">
                                        <p class="mb-1 text-xl font-semibold">
                                            3D
                                        </p>
                                        <p class="text-xl font-semibold">
                                            ထိုးမည်
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                v-else
                                class="items-center justify-center mb-4"
                            >
                                <div
                                    class="bg-white rounded-2xl cursor-pointer shadow-md py-8 px-6 flex items-center"
                                >
                                    <i
                                        class="fas fa-exclamation text-red-700 mr-4"
                                        style="font-size: 24px"
                                    ></i>
                                    <span class="text-sm">
                                        3D ခေတ္တ ပိတ်ထားပါသည်
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center text-white py-4">
                            Loading...
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="bg-white text-center py-2">
                            <span class="text-base font-semibold">
                                ပေါက်နံပါတ်များ
                            </span>
                        </div>
                        <div class="px-4 pb-6 pt-4">
                            <div
                                v-for="(winning, index) in winning_numbers"
                                :key="index"
                                :style="{ backgroundColor: winning.color }"
                                class="text-black rounded-xl cursor-pointer shadow-md px-6 py-6 mb-4"
                            >
                                <div class="flex justify-between w-full">
                                    <div class="flex items-center">
                                        <i
                                            class="far fa-flame mr-3"
                                            style="font-size: 24px"
                                        ></i>
                                        <span class="text-lg font-semibold">
                                            {{ winning.number }}
                                        </span>
                                    </div>
                                    <span class="text-sm font-medium">
                                        {{
                                            formatDate2(
                                                winning.lottery_date_time,
                                            )
                                        }}
                                    </span>
                                </div>
                                <div
                                    v-if="winning.twist && winning.twist.length"
                                    class="mt-1 text-sm font-medium"
                                >
                                    တွတ်:
                                    {{
                                        winning.twist
                                            .map((t) => t.number)
                                            .join(", ")
                                    }}
                                </div>
                            </div>
                            <div
                                v-if="!winning_numbers.length"
                                class="text-center text-white/90 py-6 text-sm"
                            >
                                ထီပေါက်နံပါတ် မရှိသေးပါ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Error page -->
        <div :class="step == 3 ? 'block' : 'hidden'" class="mt-4 px-4 pb-14">
            <div class="bg-[#FFC529] rounded-t-3xl shadow-lg px-4 pt-4 pb-6">
                <p class="text-center text-xl font-bold mb-3">3D ထိုးမည်</p>
                <div class="rounded-2xl bg-[#C58A1F] px-4 pt-4 pb-5">
                    <div
                        class="bg-white rounded-2xl shadow-md py-10 px-6 flex items-center justify-center"
                    >
                        <i
                            class="fas fa-exclamation text-red-700 mr-4"
                            style="font-size: 24px"
                        ></i>
                        <span class="text-sm font-semibold">
                            3D ခေတ္တ ပိတ်ထားပါသည်
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div :class="step == 1 ? 'block' : 'hidden'" class="mt-4 pb-14">
            <div class="bg-[#FFC529] rounded-t-3xl shadow-lg px-4 pt-4 pb-6">
                <p class="text-center text-xl font-bold mb-3">3D ထိုးမည်</p>

                <div class="pt-4 pb-5">
                    <p class="mt-2 text-base font-semibold mb-3">
                        ငွေပမာဏ
                        <span class="text-red-600"> ( ၁၀၀ ကျပ်မှစထိုးပါ )</span>
                    </p>
                    <div class="flex items-center">
                        <div class="flex-grow">
                            <div
                                class="flex items-center bg-white rounded-l-lg overflow-hidden border border-black focus-within:ring-2 focus-within:ring-[#FF9900] focus-within:ring-opacity-70"
                            >
                                <div
                                    class="w-14 h-12 flex items-center justify-center text-[#7a7a7a]"
                                >
                                    <i class="fas fa-dollar-sign text-2xl"></i>
                                </div>
                                <input
                                    type="number"
                                    id="amount"
                                    placeholder="အနည်းဆုံး ၁၀၀"
                                    v-model="each_amount"
                                    @input="validateNumber($event, 'amount')"
                                    ref="amount"
                                    class="block w-full h-14 bg-transparent px-2 text-lg focus:ring-0 focus:shadow-none outline-none"
                                />
                            </div>
                        </div>

                        <button
                            class="bg-[#5271FF] text-white px-8 h-14 rounded-r-lg text-base font-semibold whitespace-nowrap hover:bg-[#5271FF]/90 active:bg-[#5271FF]/80 transition duration-150"
                            @click="changeToStep2(1)"
                        >
                            ထိုးမည်
                        </button>

                        <button
                            @click="reverseFun"
                            class="w-12 h-14 bg-[#d9d9d9] text-black text-lg font-semibold rounded-lg ml-4"
                        >
                            R
                        </button>
                    </div>

                    <div
                        class="mt-4 flex justify-between text-sm text-black font-semibold"
                    >
                        <p>
                            {{ $t("Closing Time") }} :
                            {{ closingDateTimeFormat }}
                        </p>
                    </div>
                </div>

                <div class="mb-0 mt-6">
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
                    <div class="grid grid-cols-10 gap-x-1 gap-y-3">
                        <div
                            class="contents"
                            v-for="(num, index) in numbers100"
                            :key="index"
                        >
                            <!-- <div v-if="index == '96'" class="opacity-0"></div> -->

                            <div
                                :class="[
                                    num.is_active == 0
                                        ? 'bg-[#d4d4d4] text-gray-400 cursor-not-allowed'
                                        : isBetNumber(num.number)
                                          ? 'bg-[#D9A63A] text-white'
                                          : 'bg-[#e5e7eb] text-black',
                                    'rounded-lg pt-3 shadow-md aspect-square flex flex-col items-center justify-center border border-white transition duration-150',
                                ]"
                                @click="
                                    num.is_active == 1 ? addBetNumber(num) : ''
                                "
                            >
                                <div class="w-full">
                                    <p
                                        class="text-lg font-bold leading-none text-center"
                                    >
                                        {{ num.number }}
                                    </p>
                                    <div
                                        class="mt-2 w-10 h-4 bg-[#d9d9d9] rounded-full flex items-center border border-white shadow-sm overflow-hidden mx-auto"
                                    >
                                        <div
                                            :class="
                                                progressBarClass(
                                                    num.total_bet_percentage,
                                                )
                                            "
                                            class="h-3 rounded-full"
                                            :style="{
                                                width: computedWidth(
                                                    num.total_bet_percentage,
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
        </div>
        <!-- Result Page-->
        <div
            class="relative mb-12 w-full rounded-t-xl px-4 pb-14 bg-[#FFC529] min-h-[calc(100vh-100px)]"
            :class="step == 2 ? 'block' : 'hidden'"
        >
            <div class="w-full rounded-3xl bg-[#FFC529] pt-4 pb-2">
                <p class="text-center mb-3 text-lg font-bold">3D ထိုးမည်</p>

                <div class="rounded-xl bg-[#C58A1F] py-3 px-2">
                    <div
                        class="rounded-xl bg-white border-2 border-gray-700 overflow-hidden"
                    >
                        <div
                            class="flex justify-between items-center px-4 py-2 bg-[#F4F4F4] text-lg"
                        >
                            <p>{{ currentDate }}</p>
                            <p>{{ getCurrentTime() }}</p>
                            <p class="text-[#FF9900] font-semibold">
                                {{ closingDateTimeFormat }}
                            </p>
                        </div>

                        <div
                            class="px-4 pb-3 pt-2 overflow-y-auto small-scrollbar"
                            style="max-height: calc(100vh - 260px)"
                        >
                            <table class="table-auto w-full text-lg">
                                <thead>
                                    <tr>
                                        <th class="py-3">စဉ်</th>
                                        <th class="py-3">{{ $t("No") }}</th>
                                        <th class="py-3">
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
                                        <td
                                            class="text-center py-2"
                                            :class="
                                                checkAvailableAmount(bet_number)
                                                    ? ''
                                                    : 'text-red-600'
                                            "
                                        >
                                            {{ index + 1 }}
                                        </td>
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
                                            class="text-center py-2 space-x-1"
                                        >
                                            <span
                                                v-show="
                                                    bet_number.number !=
                                                    edit_bet_number.number
                                                "
                                            >
                                                {{
                                                    bet_number.amount?.toLocaleString()
                                                }}
                                            </span>
                                            <input
                                                v-show="
                                                    bet_number.number ==
                                                    edit_bet_number.number
                                                "
                                                type="number"
                                                class="w-24 shadow appearance-none border border-gray-300 rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-150 ease-in-out"
                                                v-model="edit_bet_number.amount"
                                                placeholder="Enter amount"
                                            />
                                            <button
                                                v-show="
                                                    bet_number.number ==
                                                    edit_bet_number.number
                                                "
                                                @click="editBetAmount"
                                                class="text-green-600 hover:text-green-800 transition duration-150 ease-in-out"
                                            >
                                                <i
                                                    class="fas fa-check mr-2"
                                                ></i>
                                            </button>
                                            <button
                                                v-show="
                                                    bet_number.number !=
                                                    edit_bet_number.number
                                                "
                                                @click="
                                                    edit_bet_number = bet_number
                                                "
                                                class="text-[#5271FF] hover:text-[#5271FF]/80 transition duration-150 ease-in-out"
                                            >
                                                <i class="fas fa-edit mr-2"></i>
                                            </button>
                                            <button
                                                data-twe-toggle="modal"
                                                data-twe-target="#delete_modal"
                                                @click="
                                                    delete_bet_number =
                                                        bet_number.number
                                                "
                                                class="text-red-600 hover:text-red-800 transition duration-150 ease-in-out"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr
                                        v-if="bet_numbers.length"
                                        class="border-b last:border-0"
                                    >
                                        <td class="text-right pr-4" colspan="2">
                                            {{ $t("Total Betting Amount") }}
                                        </td>
                                        <td class="text-center">
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
                </div>

                <div class="mt-6">
                    <button
                        :disabled="calling_api"
                        class="w-full bg-[#5271FF] text-white py-4 rounded-lg text-lg font-semibold hover:bg-[#5271FF]/90 active:bg-[#5271FF]/80 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                        @click="sendBetting"
                    >
                        {{ calling_api ? "ထိုးနေသည်" : "ထိုးမည်" }}
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div
            data-twe-modal-init
            class="fixed inset-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none bg-black/80 flex items-center justify-center p-4"
            id="delete_modal"
            tabindex="-1"
            aria-labelledby="deleteModalLabel"
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
                            class="text-xl font-semibold leading-normal text-black"
                            id="deleteModalLabel"
                        >
                            Confirm Delete
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
                        <p class="text-lg font-semibold text-black text-center">
                            Are You Sure ?
                        </p>
                    </div>

                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end px-6 pb-6 gap-x-3"
                    >
                        <button
                            type="button"
                            id="modalClose"
                            class="inline-block rounded-2xl bg-white/70 px-6 py-4 text-sm text-black font-semibold focus:outline-none focus:ring-0"
                            data-twe-modal-dismiss
                            data-twe-ripple-init
                            data-twe-ripple-color="light"
                        >
                            Close
                        </button>
                        <button
                            @click="deleteBetNumber"
                            type="button"
                            class="rounded-2xl bg-red-600 px-8 py-4 text-sm text-white font-semibold focus:outline-none focus:ring-0"
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
                        class="text-xl font-semibold leading-normal text-black"
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
                    <p class="text-lg font-semibold text-black text-center">
                        {{ error_modal_text }}
                    </p>
                </div>

                <div
                    class="flex flex-shrink-0 flex-wrap items-center justify-end px-6 pb-6 gap-x-3"
                >
                    <button
                        type="button"
                        id="modalClose"
                        class="inline-block rounded-2xl bg-white/70 px-6 py-4 text-sm text-black font-semibold focus:outline-none focus:ring-0"
                        data-twe-modal-dismiss
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                    >
                        Close
                    </button>
                    <button
                        data-twe-modal-dismiss
                        data-twe-ripple-init
                        data-twe-ripple-color="light"
                        type="button"
                        class="rounded-2xl bg-red-600 px-8 py-4 text-sm text-white font-semibold focus:outline-none focus:ring-0"
                    >
                        OK
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

import { checkNumber } from "../../utilities/common";
export default {
    name: "3Dbetting",
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
                this.from_to_value.value,
            );
        },
        errorText() {
            var errorText = "";
            this.bet_numbers.forEach((bet) => {
                if (bet.is_active == 0) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
                if (
                    bet.closing_amount <
                    parseInt(bet.amount) + bet.total_bet_amount
                ) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
            });
            return errorText;
        },
        closingDateTimeFormat() {
            return moment(this.closing_date_time, "YYYY-MM-DD HH:mm").format(
                "YYYY-MM-DD hh:mm A",
            );
        },
        checkUserEachLimitError() {
            var errorText = "";
            this.bet_numbers.forEach((bet) => {
                if (this.bet_limit < parseInt(bet.amount) + bet.total_amount) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
            });
            return errorText;
        },
    },
    mixins: [CheckAuthMixin],

    methods: {
        getCurrentTime() {
            return moment().format("hh:mm A");
        },
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
                return "bg-[#c7080e] h-1-5"; //red
            } else if (percentage >= 70 && percentage < 100) {
                return "bg-[#f7db07] h-1-5"; //yellow
            } else if (percentage < 70) {
                return "bg-[#17b509] h-1-5"; //green
            } else {
                return "bg-[#7a2985] h-1-5"; //purple
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
            if (num.total_bet_percentage == 100) {
                return;
            }
            const index = this.bet_numbers.findIndex(
                (bet) => bet.number === num.number,
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
                (bet) => bet.number === this.delete_bet_number,
            );
            this.bet_numbers.splice(index, 1);
            const button = document.getElementById("modalClose");
            if (button) {
                button.click();
            }
        },
        editBetAmount() {
            const index = this.bet_numbers.find(
                (bet) => bet.number == this.edit_bet_number.number,
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
                "YYYY-MM-DD HH:mm",
            );
            this.closing_date_time = moment(
                threeDgame.game_setting.closing_date_time,
                "YYYY-MM-DD HH:mm",
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
            this.calling_api = false;

            if (response.success) {
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
                "YYYY-MM-DD HH:mm",
            );
            var alreadyOpen = currentTime.isAfter(f_opening_time);
            return alreadyOpen;
        },
        checkCloseTime() {
            const currentTime = moment();
            const f_closing_time = moment(
                this.closing_date_time,
                "YYYY-MM-DD HH:mm",
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
                "YYYY-MM-DD HH:mm",
            ).format("YYYY-MM-DD HH:mm A");
            this.closing_date_time = moment(
                "2024-07-01 03:00:00",
                "YYYY-MM-DD HH:mm",
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
                },
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
        validateNumber(event, refName) {
            const tempValue = checkNumber(event.target.value);
            this.$refs[refName].value = tempValue;
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
