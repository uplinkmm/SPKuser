<template lang="">
    <notifications position="top center" />

    <div
        v-if="step == 7"
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4">
            <Navbar title="ထီပေါက်သူ" :back-btn="backBtn"></Navbar>
        </div>
        <!-- <div class="mb-3 flex justify-end px-4">
            <select
                v-model="setting_value"
                @change="
                    winners = [];
                    getBetWinners();
                "
                class="block appearance-none bg-[#FDC652] text-white px-4 py-2 pr-8 rounded-md shadow leading-tight focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <option
                    :value="setting.id"
                    v-for="(setting, index) in settings"
                    :key="index"
                >
                    {{ setting.name }}
                </option>
            </select>
        </div> -->
        <div class="flex justify-center px-4 mb-6">
            <button
                v-for="(setting, index) in settings"
                @click="
                    setting_value = setting.id;
                    winners = [];
                    getBetWinners();
                "
                class="mx-0 text-sm px-3 py-3 primary-text"
                :class="
                    setting_value == setting.id
                        ? 'after:!block underline-border relative'
                        : ''
                "
            >
                {{ setting.name }}
            </button>
        </div>
        <div class="relative mb-0 w-full rounded-lg bg-white pt-4 pb-14 px-4">
            <table class="table-auto w-full">
                <thead class="bg-white text-black">
                    <tr>
                        <th class="py-4">No</th>
                        <th class="py-4">Name</th>
                        <!-- <th class="py-4">Date</th> -->
                        <th class="py-4">Phone Number</th>
                        <!-- <th class="py-4">Time</th> -->
                        <th class="py-4">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(winner, index) in winners"
                        :key="index"
                        class="border-b !border-gray-400"
                    >
                        <td class="text-center text-sm py-4">{{ ++index }}</td>
                        <td class="text-center text-sm py-4">
                            {{ winner.name }}
                        </td>
                        <!-- <td class="text-center text-sm py-4">
                            {{ formatDate(winner.date_time) }}
                        </td> -->
                        <td class="text-center text-sm py-4">
                            <span class="font-bold mt-4">*****</span>
                            {{ winner.phone_number }}
                        </td>
                        <!-- <td class="text-center text-sm py-4">
                            {{ formatTime(winner.lottery_time) }}
                        </td> -->
                        <td class="text-center text-sm py-4">
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
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4">
            <Navbar title="ထိုးမည်" :back-btn="backBtn"></Navbar>
        </div>
        <!-- Error page -->
        <div :class="step == 6 ? 'block' : 'hidden'">
            <div class="relative mb-0 w-full bg-transparent pb-14 px-4">
                <div class="bg-transparent items-center justify-center mb-8">
                    <div
                        class="bg-white rounded-lg cursor-pointer shadow-md px-8 py-16 flex justify-center"
                    >
                        <i
                            class="fas fa-exclamation text-red-700"
                            style="font-size: 24px"
                        ></i>
                        <span class="pl-16">2D ခေတ္တ ပိတ်ထားပါသည် </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- choose time -->
        <div :class="step == 5 ? 'block' : 'hidden'">
            <div class="relative mb-0 w-full bg-transparent pb-14 px-0">
                <!-- <div class="grid grid-cols-2 gap-x-4 mb-8">
                    <a
                        href="history?game_id=1"
                        class="bg-[#29261D] rounded-lg shadow-md text-center text-white py-8"
                    >
                        <a>
                            <i class="fal fa-file text-3xl pb-1"></i>
                            <p>မှတ်တမ်း</p>
                        </a>
                    </a>
                    <div
                        @click="step = 7"
                        class="bg-[#FDC652] rounded-lg shadow-md text-center text-white py-8"
                    >
                        <a>
                            <i class="fal fa-users text-3xl pb-1"></i>
                            <p>ထီပေါက်သူ</p>
                        </a>
                    </div>
                </div> -->
                <div
                    v-if="twod_settings.length && main_game_active"
                    class="items-center justify-center px-4 bg-[#FFC529] rounded-t-3xl shadow-lg"
                >
                    <h1 class="text-center text-xl font-bold mb-3">
                        2D ထိုးမည်
                    </h1>

                    <div
                        class="w-full max-w-md bg-[#06000040] rounded-3xl px-6 py-6 shadow-lg"
                    >
                        <div class="text-center">
                            <p class="text-sm font-medium">
                                ထိုးမည့်အချိန် ရွေးချယ်ပါ
                            </p>
                        </div>

                        <div
                            class="flex mt-6 justify-center items-end space-x-8"
                        >
                            <div
                                v-for="(twod_setting, index) in twod_settings"
                                :key="index"
                                @click="pendingGameSetting = twod_setting"
                                :class="[
                                    'flex flex-col items-center cursor-pointer transition',
                                    pendingGameSetting &&
                                    pendingGameSetting.id === twod_setting.id
                                        ? 'opacity-100'
                                        : 'opacity-100',
                                ]"
                            >
                                <div
                                    :class="[
                                        'w-28 h-28 rounded-2xl border-2',
                                        pendingGameSetting &&
                                        pendingGameSetting.id ===
                                            twod_setting.id
                                            ? 'border-[#1d4ed8] bg-[#e5e7eb]'
                                            : 'border-[#9A6C1F] bg-[#D9A63A]',
                                    ]"
                                ></div>
                                <p class="mt-3 text-base font-semibold">
                                    {{ formatTime(twod_setting.lottery_time) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button
                            type="button"
                            class="w-full bg-[#5271FF] text-white font-semibold py-3 rounded-xl hover:bg-[#5271FF]/90 active:bg-[#5271FF]/80 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!pendingGameSetting"
                            @click="confirmTimeSelection"
                        >
                            ရှေ့ဆက်ရန်
                        </button>
                    </div>
                </div>

                <div v-else class="items-center justify-center">
                    <div
                        class="flex-grow py-0 bg-[#FFC529] rounded-t-3xl shadow-lg"
                    >
                        <p class="text-center text-lg">2D ထိုးမည်</p>

                        <div class="text-center">
                            <h1 class="text-4xl text-red-600 font-bold py-20">
                                 ထီ ပိတ်ပါသည်
                            </h1>
                            <!-- <div class="w-full flex justify-center mb-4">
                                <img
                                    src="../../../../public/img/apologize 1.png"
                                />
                            </div> -->
                            <!-- <p class="text-lg">ယနေ့ 2D ပိတ်ပါသည်</p> -->
                        </div>
                    </div>

                    <!-- <div
                        class="bg-white rounded-lg cursor-pointer shadow-md px-8 py-16 flex justify-center"
                    >
                        <i
                            class="fas fa-exclamation text-red-700"
                            style="font-size: 24px"
                        ></i>
                        <span class="pl-16">2D ခေတ္တ ပိတ်ထားပါသည် </span>
                    </div> -->
                </div>

                <div
                    class="overflow-hidde bg-[#FFC529] min-h-[calc(100vh-100px)] pt-6"
                >
                    <div class="bg-white text-center py-2">
                        <span class="text-base font-semibold"
                            >မှတ်တမ်းများ</span
                        >
                    </div>

                    <div class="bg-[#FFC529] px-4 divide-y divide-black/10">
                        <a
                            href="/2d/live"
                            class="flex items-center justify-between px-4 py-4 cursor-pointer"
                        >
                            <div class="flex items-center space-x-4">
                                <i
                                    class="fas fa-broadcast-tower pt-1 w-6 h-6 text-gray-800"
                                ></i>
                                <span class="text-base font-semibold">
                                    2D Live
                                </span>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 text-gray-900"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>

                        <a
                            href="/history?game_id=1"
                            class="flex items-center justify-between px-4 py-4 cursor-pointer"
                        >
                            <div class="flex items-center space-x-4">
                                <i
                                    class="fas pt-1 fa-file-alt w-6 h-6 text-gray-800"
                                ></i>
                                <span class="text-base font-semibold">
                                    2D မှတ်တမ်း
                                </span>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 text-gray-900"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </a>

                        <a
                            href="/winner_lists/1"
                            class="flex items-center justify-between px-4 py-4 cursor-pointer"
                        >
                            <div class="flex items-center space-x-4">
                                <i
                                    class="fas pt-1 fa-trophy w-6 h-6 text-gray-800"
                                ></i>
                                <span class="text-base font-semibold">
                                    ထီပေါက်သူများ
                                </span>
                            </div>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5 text-gray-900"
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

        <div
            :class="step == 1 ? 'block' : 'hidden'"
            class="pb-16 rounded-3xl bg-[#FFC529]"
        >
            <div class="mb-4 px-4">
                <p class="text-lg text-center font-bold">2D ထိုးမည်</p>

                <div class="flex justify-between items-center">
                    <p class="text-lg font-bold text-[#FF9900]">
                        {{ formatTime(selectedGameSetting?.lottery_time) }}
                    </p>
                    <div class="w-10"></div>
                </div>

                <p class="mt-2 text-base font-semibold">
                    ငွေပမာဏ
                    <span class="text-red-600"> ( ၁၀၀ ကျပ်မှစထိုးပါ )</span>
                </p>

                <div class="mt-3 flex items-center">
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
                        @click="reverseBetNumbers"
                        class="w-12 h-14 bg-[#d9d9d9] text-black text-lg font-semibold rounded-lg ml-4"
                    >
                        R
                    </button>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <button
                        @click="roundBet"
                        class="bg-[#0C7A18] text-white text-lg font-semibold rounded-lg h-14 py-3 hover:bg-[#0C7A18]/90 active:bg-[#0C7A18]/80 transition duration-150"
                    >
                        {{ $t("Round Bet") }}
                    </button>
                    <button
                        @click="quickBettingBtn"
                        class="bg-[#0C7A18] text-white text-lg font-semibold rounded-lg h-14 py-3 hover:bg-[#0C7A18]/90 active:bg-[#0C7A18]/80 transition duration-150"
                    >
                        {{ $t("Quick Bet") }}
                    </button>
                </div>
            </div>

            <!-- old version -->
            <!-- <div
                class="relative block mb-6 w-full rounded-lg shadow-xl bg-white py-4"
            >
                <div class="flex gap-x-0 lg:gap-x-4">
                    <div class="w-6/12 lg:w-4/12 px-4">
                        <ul>
                            <li>
                                <button
                                    @click="reverseBetNumbers"
                                    class="px-4 py-2 lg:py-3 bg-[#DDA33F] text-white text-sm rounded-lg w-full mb-3"
                                >
                                    {{ $t("R") }}
                                </button>
                            </li>
                            <li>
                                <button
                                    @click="roundBet"
                                    class="px-4 py-2 lg:py-3 bg-[#DDA33F] text-white text-sm rounded-lg w-full mb-3"
                                >
                                    {{ $t("Round Bet") }}
                                </button>
                            </li>
                            <li>
                                <button
                                    @click="quickBettingBtn"
                                    class="px-4 py-2 lg:py-3 bg-[#DDA33F] text-white text-sm rounded-lg w-full mb-3"
                                >
                                    {{ $t("Quick Bet") }}
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div
                        class="w-6/12 lg:w-8/12 flex justify-between flex-col pt-4 pr-8"
                    >
                        <div>
                            <div class="mb-4">
                                <div class="w-full flex justify-between">
                                    <label
                                        for="amount"
                                        class="text-sm mb-3 relative block"
                                        >Amount</label
                                    >
                                    <p class="text-xs">
                                        {{ $t("Closing Time") }} :
                                        {{ closingTimeFormat }}
                                    </p>
                                </div>
                                <input
                                    type="number"
                                    id="amount"
                                    placeholder="Amount"
                                    v-model="each_amount"
                                    @input="validateNumber($event, 'amount')"
                                    ref="amount"
                                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                                />
                            </div>
                            <div class="mb-4">
                                <button
                                    class="bg-[#000] text-white px-4 py-2 lg:py-2 w-full rounded-lg text-base"
                                    @click="changeToStep2(1)"
                                >
                                    ထိုးမည်
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between px-4">
                    <div>
                        <p class="text-sm">
                            {{ $t("Balance") }}
                        </p>
                        <p class="text-sm">
                            {{ wallet_balance?.toLocaleString() }} MMK
                        </p>
                    </div>
                    <div>
                        <p class="text-sm">
                            {{ $t("Closing Time") }}
                        </p>
                        <p class="text-sm text-right">
                            {{ closingTimeFormat }}
                        </p>
                    </div>
                </div>
            </div> -->

            <div class="px-2 mb-16">
                <div class="flex justify-end mb-4">
                    <button
                        class="bg-[#b23434] text-white px-4 py-2 rounded-lg text-sm"
                        @click="
                            bet_numbers = [];
                            no_more_bet = false;
                        "
                    >
                        {{ $t("Clear") }}
                    </button>
                </div>
                <div class="grid grid-cols-10 gap-x-1 gap-y-2">
                    <div
                        class="contents"
                        v-for="(num, index) in numbers"
                        :key="index"
                    >
                        <!-- <div v-if="index == '96'" class="opacity-0"></div> -->

                        <div
                            :class="[
                                num.is_active == 0
                                    ? 'bg-[#cfcfcf] text-white'
                                    : isBetNumber(num.number)
                                      ? 'bg-[#5271FF] text-white'
                                      : 'bg-[#FF9900] text-white',
                                'rounded-lg pt-3 shadow-md aspect-square flex flex-col items-center justify-center border border-white',
                            ]"
                            @click="
                                no_more_bet == false && num.is_active == 1
                                    ? addBetNumber(num)
                                    : ''
                            "
                        >
                            <p class="text-xl font-bold leading-none">
                                {{ num.number }}
                            </p>

                            <div
                                class="mt-2 w-11 h-4 bg-[#d9d9d9] rounded-full flex items-center border border-white shadow-sm overflow-hidden"
                            >
                                <div
                                    class="h-3 rounded-full"
                                    :class="
                                        progressBarClass(
                                            num.total_bet_percentage,
                                        )
                                    "
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
        <!-- Result Page-->
        <div
            class="relative mb-12 w-full px-4 pb-14 bg-[#FFC529] rounded-t-xl min-h-[calc(100vh-100px)]"
            :class="step == 2 ? 'block' : 'hidden'"
        >
            <div class="w-full rounded-3xl bg-[#FFC529] pt-4 pb-2">
                <p class="text-center mb-3 text-lg font-bold">2D ထိုးမည်</p>

                <div class="rounded-xl bg-[#C58A1F] py-3 px-2">
                    <div
                        class="rounded-xl bg-white border-2 border-gray-700 overflow-hidden"
                    >
                        <div
                            class="flex justify-between items-center px-4 py-2 bg-[#F4F4F4] text-lg"
                        >
                            <p>{{ getCurrentDate() }}</p>
                            <p>{{ getCurrentTime() }}</p>
                            <p class="text-[#FF9900] font-semibold">
                                {{
                                    formatTime(selectedGameSetting.lottery_time)
                                }}
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
                                        <!-- <th class="py-2">{{ $t("Multiplier") }}</th> -->
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
                                        <!-- <td
                                :class="
                                    checkAvailableAmount(bet_number)
                                        ? ''
                                        : 'text-red-600'
                                "
                                class="text-center py-2"
                            >
                                {{ bet_multiplier }}
                            </td> -->
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
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                data-twe-toggle="modal"
                                                data-twe-target="#delete_modal"
                                                @click="
                                                    delete_bet_number =
                                                        bet_number.number
                                                "
                                                class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out"
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
                                                totalBetAmount.toLocaleString()
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

        <!-- quick betting -->
        <div :class="step == 3 ? 'block' : 'hidden'">
            <div
                class="relative mb-0 w-full bg-[#FFC529] rounded-t-xl pb-14 px-4"
            >
                <div class="bg-transparent items-center justify-center mb-8">
                    <div class="text-left mb-4">
                        <h1 class="text-black text-lg font-semibold">
                            ရိုးရိုး
                        </h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="simpleBet('sone_sone')"
                            class="border border-gray-400 text-md rounded-lg py-3 px-1 bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            စုံစုံ
                        </button>
                        <button
                            @click="simpleBet('ma_ma')"
                            class="border border-gray-400 text-md rounded-lg py-3 px-1 bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            မမ
                        </button>
                        <button
                            @click="simpleBet('sone_ma')"
                            class="border border-gray-400 text-md rounded-lg py-3 px-1 bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            စုံမ
                        </button>
                        <button
                            @click="simpleBet('ma_sone')"
                            class="border border-gray-400 text-md rounded-lg py-3 px-1 bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            မစုံ
                        </button>
                        <button
                            @click="simpleBet('sone_puu')"
                            class="border border-gray-400 text-md rounded-lg py-3 px-1 bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            စုံပူး
                        </button>
                        <button
                            @click="simpleBet('ma_puu')"
                            class="border border-gray-400 text-md rounded-lg py-3 px-1 bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            မပူး
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1
                            class="text-lg text-black font-semibold primary-text"
                        >
                            နက္ခတ်ပါဝါ
                        </h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="natKhatPower('nat')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            နက္ခတ်
                        </button>
                        <button
                            @click="natKhatPower('power')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            ပါ၀ါ
                        </button>
                        <button
                            @click="natKhatPower('a_puu')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            အပူး
                        </button>
                        <button
                            @click="natKhatPower('nyi_naung')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            ညီအကို
                        </button>
                    </div>
                </div>

                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-black text-lg font-semibold">ပါတ်</h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="patNumberBet('0')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            0
                        </button>
                        <button
                            @click="patNumberBet('1')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            1
                        </button>
                        <button
                            @click="patNumberBet('2')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            2
                        </button>
                        <button
                            @click="patNumberBet('3')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            3
                        </button>
                        <button
                            @click="patNumberBet('4')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            4
                        </button>
                        <button
                            @click="patNumberBet('5')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            5
                        </button>
                        <button
                            @click="patNumberBet('6')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            6
                        </button>
                        <button
                            @click="patNumberBet('7')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            7
                        </button>
                        <button
                            @click="patNumberBet('8')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            8
                        </button>
                        <button
                            @click="patNumberBet('9')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            9
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-black text-lg font-semibold">ထိပ်</h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="numbersStartingWith('0')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            0
                        </button>
                        <button
                            @click="numbersStartingWith('1')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            1
                        </button>
                        <button
                            @click="numbersStartingWith('2')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            2
                        </button>
                        <button
                            @click="numbersStartingWith('3')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            3
                        </button>
                        <button
                            @click="numbersStartingWith('4')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            4
                        </button>
                        <button
                            @click="numbersStartingWith('5')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            5
                        </button>
                        <button
                            @click="numbersStartingWith('6')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            6
                        </button>
                        <button
                            @click="numbersStartingWith('7')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            7
                        </button>
                        <button
                            @click="numbersStartingWith('8')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            8
                        </button>
                        <button
                            @click="numbersStartingWith('9')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            9
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-black text-lg font-semibold">နောက်</h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="numbersEndingWith('0')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            0
                        </button>
                        <button
                            @click="numbersEndingWith('1')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            1
                        </button>
                        <button
                            @click="numbersEndingWith('2')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            2
                        </button>
                        <button
                            @click="numbersEndingWith('3')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            3
                        </button>
                        <button
                            @click="numbersEndingWith('4')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            4
                        </button>
                        <button
                            @click="numbersEndingWith('5')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            5
                        </button>
                        <button
                            @click="numbersEndingWith('6')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            6
                        </button>
                        <button
                            @click="numbersEndingWith('7')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            7
                        </button>
                        <button
                            @click="numbersEndingWith('8')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            8
                        </button>
                        <button
                            @click="numbersEndingWith('9')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            9
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-black text-lg font-semibold">ဘရိတ်</h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="breakNumbers(0, 10)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            0
                        </button>
                        <button
                            @click="breakNumbers(1, 11)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            1
                        </button>
                        <button
                            @click="breakNumbers(2, 12)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            2
                        </button>
                        <button
                            @click="breakNumbers(3, 13)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            3
                        </button>
                        <button
                            @click="breakNumbers(4, 14)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            4
                        </button>
                        <button
                            @click="breakNumbers(5, 15)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            5
                        </button>
                        <button
                            @click="breakNumbers(6, 16)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            6
                        </button>
                        <button
                            @click="breakNumbers(7, 17)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            7
                        </button>
                        <button
                            @click="breakNumbers(8, 18)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            8
                        </button>
                        <button
                            @click="breakNumbers(9, 19)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-md bg-white shadow-sm hover:shadow-md hover:bg-gray-50 active:bg-gray-100 transition duration-150"
                        >
                            9
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ခွေထိုးမည် -->
        <!-- ခွေထိုးမည် -->
        <div
            :class="step == 4 ? 'block' : 'hidden'"
            style="min-height: calc(100vh - 168px)"
            class="bg-[#FFC529] rounded-t-xl mb-20"
        >
            <div
                class="relative mb-4 w-full rounded-2xl shadow-md bg-[#F3F4F6] pt-4 pb-4 px-4"
            >
                <div class="grid grid-cols-2 gap-x-4">
                    <div class="flex justify-between flex-col pt-4 pb-3">
                        <div>
                            <div class="mb-4">
                                <label
                                    for="round_digits"
                                    class="text-lg mb-2 relative block font-semibold"
                                    >3/4 Numbers</label
                                >
                                <input
                                    type="text"
                                    id="round_digits"
                                    placeholder=""
                                    v-model="round_digits"
                                    @input="
                                        validateNumber($event, 'round_digits')
                                    "
                                    ref="round_digits"
                                    class="block w-full h-12 px-3 border border-black text-base rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#FF9900] focus:ring-opacity-70"
                                />
                            </div>
                            <div class="mb-4">
                                <button
                                    class="bg-[#FFC529] text-black px-4 h-14 w-full rounded-lg text-base font-semibold hover:bg-[#FFC529]/90 active:bg-[#FFC529]/80 transition duration-150"
                                    @click="getTwoDigitCombinations(false)"
                                >
                                    အပူးမပါ
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between flex-col pt-4 pb-3">
                        <div>
                            <div class="mb-4">
                                <label
                                    for="amount"
                                    class="text-lg mb-2 relative block font-semibold"
                                    >Amount</label
                                >
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    id="amount"
                                    placeholder="Amount"
                                    v-model="each_amount"
                                    @input="
                                        validateNumber(
                                            $event,
                                            'round_bet_amount',
                                        )
                                    "
                                    ref="round_bet_amount"
                                    class="block w-full h-12 px-3 border border-black text-base rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-[#FF9900] focus:ring-opacity-70"
                                />
                            </div>
                            <div class="mb-4">
                                <button
                                    class="bg-[#FFC529] text-black px-4 h-14 w-full rounded-lg text-base font-semibold hover:bg-[#FFC529]/90 active:bg-[#FFC529]/80 transition duration-150"
                                    @click="getTwoDigitCombinations(true)"
                                >
                                    အပူးပါ
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between col-span-2 mb-8">
                        <p class="text-lg font-semibold">
                            လက်ကျန်ငွေ :
                            {{ wallet_balance?.toLocaleString() }} MMK
                        </p>
                        <p class="text-lg font-semibold">
                            {{ $t("Closing Time") }} :
                            {{ closingTimeFormat }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl bg-[#C58A1F] py-3 px-2">
                <div
                    class="rounded-xl bg-white border-2 border-gray-700 overflow-hidden"
                >
                    <div
                        class="px-4 pt-2 overflow-y-auto small-scrollbar"
                        style="max-height: calc(100vh - 320px)"
                    >
                        <table class="table-fixed w-full text-lg mb-16">
                            <thead>
                                <tr>
                                    <th class="py-3 w-3/12 text-center">
                                        {{ $t("No") }}
                                    </th>
                                    <th class="py-3 w-2/12 text-center">
                                        {{ $t("Multiplier") }}
                                    </th>
                                    <th class="py-3 w-5/12 text-right pr-2">
                                        {{ $t("Betting Amount") }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(bet_number, index) in bet_numbers"
                                    :key="index"
                                    class="border-b last:border-0"
                                >
                                    <td
                                        :class="
                                            checkAvailableAmount(bet_number)
                                                ? ''
                                                : 'text-red-600'
                                        "
                                        class="text-center py-2"
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
                                        class="text-right py-2 pr-2 space-x-1"
                                    >
                                        <span
                                            v-show="
                                                bet_number.number !=
                                                edit_bet_number.number
                                            "
                                            class="font-semibold"
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
                                            class="w-24 h-10 bg-white px-2 text-base rounded-lg border border-black focus:outline-none focus:ring-2 focus:ring-[#FF9900] focus:ring-opacity-70"
                                            v-model="edit_bet_number.amount"
                                            placeholder=""
                                        />
                                        <button
                                            v-show="
                                                bet_number.number ==
                                                edit_bet_number.number
                                            "
                                            @click="editBetAmount"
                                            class="w-10 h-10 rounded-lg bg-[#0C7A18] text-white inline-flex items-center justify-center"
                                        >
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button
                                            v-show="
                                                bet_number.number !=
                                                edit_bet_number.number
                                            "
                                            @click="
                                                edit_bet_number = bet_number
                                            "
                                            class="w-10 h-10 bg-white text-[#5271FF] inline-flex items-center justify-center"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            data-twe-toggle="modal"
                                            data-twe-target="#delete_modal"
                                            @click="
                                                delete_bet_number =
                                                    bet_number.number
                                            "
                                            class="w-10 h-10 bg-white text-red-500 inline-flex items-center justify-center"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr
                                    v-if="bet_numbers.length"
                                    class="border-t font-semibold"
                                >
                                    <td class="text-right pr-4" colspan="2">
                                        {{ $t("Total Betting Amount") }}
                                    </td>
                                    <td class="text-right pr-2">
                                        {{ totalBetAmount.toLocaleString() }}
                                        MMK
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="w-full flex justify-center">
                            <button
                                :disabled="calling_api"
                                class="bg-[#5271FF] text-white w-full mb-12 px-16 h-12 rounded-lg text-base font-semibold hover:bg-[#5271FF]/90 active:bg-[#5271FF]/80 transition duration-150 disabled:bg-[#9CA3AF] disabled:text-white disabled:opacity-70 disabled:cursor-not-allowed"
                                @click="sendBetting"
                            >
                                {{ calling_api ? "ထိုးနေသည်" : "ထိုးမည်" }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div
        data-twe-modal-init
        class="fixed inset-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none bg-black/70 flex items-center justify-center p-4"
        id="delete_modal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
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
                        id="exampleModalLabel"
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

    <button
        hidden
        disabled
        type="button"
        class="hidden rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong"
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

                <!-- Modal body -->
                <div class="relative flex-auto p-4" data-twe-modal-body-ref>
                    Modal body text goes here.
                </div>

                <!-- Modal footer -->
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
import { Modal, Ripple, Dropdown, initTWE } from "tw-elements";
import { postApiData, getApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import { mapGetters } from "vuex";
import moment from "moment";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";
import { checkNumber } from "../../utilities/common";

export default {
    name: "2Dbetting",
    components: {
        Navbar,
    },
    data() {
        return {
            step: "", // 1 betting page , 2 - result page , 3 quick betting , 4 -ခွေထိုးမယ်, 5 - change time ,6-error page , 7 -ထီပေါက်သူ
            each_amount: "",
            bet_numbers: [],
            round_digits: "",
            currentDate: moment().format("YYYY-MM-DD"),

            numbers: [],
            no_more_bet: false,
            bet_multiplier: 75,
            opening_time: "",
            closing_time: "",
            wallet_balance: 0,

            edit_bet_number: {
                number: "",
                amount: "",
            },
            min: "",
            max: "",
            game_setting_id: "",
            twod_settings: [],
            settings: [],
            setting_value: "",
            main_game_active: 1,
            calling_api: false,
            bet_limit: "",
            winner_page: 1,
            winner_last_page: 0,
            showSpinner: false,
            winners: [],
            selectedGameSetting: "",
            pendingGameSetting: null,
            delete_bet_number: "",
            error_modal_text: "",
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
        errorText() {
            var errorText = "";
            this.bet_numbers.forEach((bet) => {
                if (bet.is_active == 0) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
                if (
                    bet.closing_amount <
                    parseInt(bet.amount) + parseInt(bet.total_bet_amount)
                ) {
                    errorText = `${bet.number} has reached limit.`;
                    return;
                }
            });
            return errorText;
        },
        checkUserEachLimitError() {
            var errorText = "";
            this.bet_numbers.forEach((bet) => {
                if (
                    this.bet_limit <
                    parseInt(bet.amount) + parseInt(bet.total_amount)
                ) {
                    errorText = `${bet.number} has reached your limit.`;
                    return;
                }
            });
            return errorText;
        },
        closingTimeFormat() {
            return moment(this.closing_time, "HH:mm").format("hh:mm A");
        },
    },
    mixins: [CheckAuthMixin],

    methods: {
        isBetNumber(number) {
            return this.bet_numbers.some((bet) => bet.number === number);
        },
        backBtn() {
            if (this.step == 5 || this.step == 6) {
                // window.location.href = "/home";
                window.history.back();
            } else if (this.step == 1) {
                this.step = 5;
            } else if (this.step == 7) {
                this.step = 5;
            } else {
                this.step = 1;
            }
        },
        addBetNumber(num) {
            const available_for_bet = this.checkOpenCloseTime();
            if (available_for_bet == false) {
                return;
            }
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
        changeToStep2(from) {
            if (from == 1) {
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
                if (
                    this.each_amount >= this.min &&
                    this.each_amount <= this.max
                ) {
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
                    var errorText = `Your limit is  ${this.bet_limit}`;
                    this.$notify({
                        text: errorText,
                        type: "error",
                    });
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
            }
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
        sortBetNumbers() {
            this.bet_numbers.sort(
                (a, b) => parseInt(a.number) - parseInt(b.number),
            );
        },
        reverseBetNumbers() {
            const existingNumbers = this.bet_numbers.map((bet) => bet.number);
            const reversedNumbers = this.bet_numbers
                .map((bet) => {
                    const reversedNumber = bet.number
                        .split("")
                        .reverse()
                        .join("");
                    // Only add if the reversed number is different from the original number and does not already exist
                    if (
                        reversedNumber !== bet.number &&
                        !existingNumbers.includes(reversedNumber)
                    ) {
                        const temp = this.numbers.find(
                            (n) =>
                                n.number == reversedNumber && n.is_active == 1,
                        );
                        if (temp) {
                            return temp;
                        }
                        // return { number: reversedNumber, amount: "" };
                    }
                    return null;
                })
                .filter((bet) => bet !== null);

            this.bet_numbers = [...this.bet_numbers, ...reversedNumbers];
        },
        async sendBetting() {
            if (this.edit_bet_number.number) {
                this.$notify({
                    text: "Please confirm edit amount first!",
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
                //check closing amount
                this.error_modal_text = this.errorText;
                this.showErrorModal();
                return;
            }
            if (this.checkUserEachLimitError) {
                //check closing amount
                this.error_modal_text = this.checkUserEachLimitError;
                this.showErrorModal();
                return;
            }
            if (this.bet_numbers.length == 0) {
                this.error_modal_text = "Invalid or empty betting numbers";
                this.showErrorModal();
            }
            this.calling_api = true;
            let formData = new FormData();
            formData.append("numbers", JSON.stringify(this.bet_numbers));
            formData.append("betting_multiplier", this.bet_multiplier);
            formData.append("total_amount", this.totalBetAmount);
            formData.append("game_id", 1);
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
                this.no_more_bet = false;
                this.round_digits = "";
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
        checkOpenTime() {
            const currentTime = moment();
            const f_opening_time = moment(this.opening_time, "HH:mm");
            var alreadyOpen = currentTime.isAfter(f_opening_time);
            return alreadyOpen;
        },
        checkCloseTime() {
            const currentTime = moment();
            const f_closing_time = moment(this.closing_time, "HH:mm");
            var alreadyClose = currentTime.isAfter(f_closing_time);
            return alreadyClose;
        },

        getTwoDigitCombinations(includeSameDigit = true) {
            const digits = this.round_digits.toString().split("");
            const uniqueDigitsSet = new Set(digits);
            //check
            if (digits.length != uniqueDigitsSet.size) {
                this.$notify({
                    text: "Please enter bet numbers and amount",
                    type: "error",
                });
                return;
            }
            if (digits.length > 4 || digits.length < 3) {
                this.$notify({
                    text: "Please enter numbers 3 or 4 digits.",
                    type: "error",
                });
                return;
            }
            if (this.each_amount == "" || this.each_amount <= 0) {
                this.$notify({
                    text: "Please enter amount",
                    type: "error",
                });
                return;
            }
            if (this.each_amount >= this.min && this.each_amount <= this.max) {
            } else {
                this.error_modal_text = `Amount must be between ${this.min} and ${this.max}`;
                this.showErrorModal();
                return;
            }
            const result = [];
            for (let i = 0; i < digits.length; i++) {
                for (let j = 0; j < digits.length; j++) {
                    if (i !== j || (i === j && includeSameDigit)) {
                        result.push(digits[i] + digits[j]);
                    }
                }
            }
            this.bet_numbers = this.numbers
                .filter((n) => result.includes(n.number) && n.is_active == 1)
                .map((n) => ({ ...n, amount: this.each_amount }));

            const check_balanced = this.checkBalanced();
        },
        simpleBet(type) {
            if (type == "sone_sone") {
                var digits = [
                    "00",
                    "02",
                    "04",
                    "06",
                    "08",
                    "20",
                    "22",
                    "24",
                    "26",
                    "28",
                    "40",
                    "42",
                    "44",
                    "46",
                    "48",
                    "60",
                    "62",
                    "64",
                    "66",
                    "68",
                    "80",
                    "82",
                    "84",
                    "86",
                    "88",
                ];
            }
            if (type == "ma_ma") {
                var digits = [
                    "11",
                    "13",
                    "15",
                    "17",
                    "19",
                    "31",
                    "33",
                    "35",
                    "37",
                    "39",
                    "51",
                    "53",
                    "55",
                    "57",
                    "59",
                    "71",
                    "73",
                    "75",
                    "77",
                    "79",
                    "91",
                    "93",
                    "95",
                    "97",
                    "99",
                ];
            }
            if (type == "sone_ma") {
                var digits = [
                    "01",
                    "03",
                    "05",
                    "07",
                    "09",
                    "21",
                    "23",
                    "25",
                    "27",
                    "29",
                    "41",
                    "43",
                    "45",
                    "47",
                    "49",
                    "61",
                    "63",
                    "65",
                    "67",
                    "69",
                    "81",
                    "83",
                    "85",
                    "87",
                    "89",
                ];
            }
            if (type == "ma_sone") {
                var digits = [
                    "10",
                    "12",
                    "14",
                    "16",
                    "18",
                    "30",
                    "32",
                    "34",
                    "36",
                    "38",
                    "50",
                    "52",
                    "54",
                    "56",
                    "58",
                    "70",
                    "72",
                    "74",
                    "76",
                    "78",
                    "90",
                    "92",
                    "94",
                    "96",
                    "98",
                ];
            }
            if (type == "sone_puu") {
                var digits = ["00", "22", "44", "66", "88"];
            }
            if (type == "ma_puu") {
                var digits = ["11", "33", "55", "77", "99"];
            }
            this.quickBetting(digits);
        },
        natKhatPower(type) {
            if (type == "nat") {
                var digits = [
                    "18",
                    "24",
                    "35",
                    "69",
                    "70",
                    "81",
                    "42",
                    "53",
                    "96",
                    "07",
                ];
            }
            if (type == "power") {
                var digits = [
                    "05",
                    "16",
                    "27",
                    "38",
                    "49",
                    "50",
                    "61",
                    "72",
                    "83",
                    "94",
                ];
            }
            if (type == "a_puu") {
                var digits = [
                    "00",
                    "11",
                    "22",
                    "33",
                    "44",
                    "55",
                    "66",
                    "77",
                    "88",
                    "99",
                ];
            }
            if (type == "nyi_naung") {
                var digits = [
                    "01",
                    "10",
                    "12",
                    "21",
                    "23",
                    "32",
                    "34",
                    "43",
                    "45",
                    "54",
                    "56",
                    "65",
                    "67",
                    "76",
                    "78",
                    "87",
                    "89",
                    "98",
                    "90",
                    "09",
                ];
            }
            this.quickBetting(digits);
        },
        patNumberBet(num) {
            const digits = [];
            for (let i = 0; i < 100; i++) {
                if (String(i).includes(num)) {
                    digits.push(String(i).padStart(2, "0"));
                }
            }
            this.quickBetting(digits);
        },
        numbersStartingWith(num) {
            const digits = [];
            const start = parseInt(num + "0"); // Get the starting number based on 'num'
            for (let i = start; i < start + 10; i++) {
                // Loop through numbers starting from 'start' to 'start + 10'
                digits.push(String(i).padStart(2, "0"));
            }
            this.quickBetting(digits);
        },
        numbersEndingWith(num) {
            const digits = [];
            for (let i = 0; i < 100; i++) {
                if (String(i).endsWith(num)) {
                    digits.push(String(i).padStart(2, "0"));
                }
            }
            this.quickBetting(digits);
        },
        breakNumbers(sum1, sum2) {
            const digits = [];
            for (let i = 0; i < 100; i++) {
                const digitsSum = String(i)
                    .split("")
                    .reduce((acc, curr) => acc + parseInt(curr), 0);
                if (digitsSum === sum1 || digitsSum === sum2) {
                    digits.push(String(i).padStart(2, "0"));
                }
            }
            this.quickBetting(digits);
        },

        quickBetting(digits) {
            this.bet_numbers = this.numbers
                .filter((n) => digits.includes(n.number) && n.is_active == 1)
                .map((n) => ({ ...n, amount: "" }));

            this.no_more_bet = true;
            this.step = 1;
        },
        quickBettingBtn() {
            //အမြန်ထိုးမယ်

            const available_for_bet = this.checkOpenCloseTime();
            if (this.no_more_bet || available_for_bet == false) {
                return;
            } else {
                this.step = 3;
            }
        },
        roundBet() {
            const available_for_bet = this.checkOpenCloseTime();
            if (this.no_more_bet || available_for_bet == false) {
                return;
            } else {
                this.step = 4;
                this.bet_numbers = [];
                this.round_digits = "";
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
                url: `api/bet_number_list?game_id=1&game_setting_id=${this.game_setting_id}`,
                token: this.getToken,
            });
            this.numbers = response.data.bet_list_numbers;

            this.wallet_balance = response.data.balance;
            this.bet_limit = response.data.bet_limit;

            let twoDGame = response.data.game;
            this.bet_multiplier = twoDGame.bet_multiplier;
            this.opening_time = moment(twoDGame.opening_time, "HH:mm");
            this.closing_time = moment(twoDGame.closing_time, "HH:mm");
            this.min = twoDGame.min;
            this.max = twoDGame.max;
        },
        computedWidth(percentage) {
            return percentage + "%";
        },
        // checkActive(number) {
        //     if (
        //         number.is_active &&
        //         number.amount >= number.min &&
        //         number.amount <= number.max
        //     ) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // },
        checkAvailableAmount(number) {
            if (
                number.closing_amount >=
                parseInt(number.amount) + parseInt(number.total_bet_amount)
            ) {
                return true;
            } else {
                return false;
            }
        },
        progressBarClass(percentage) {
            if (percentage === 100) {
                return "bg-[#c7080e]";
            } else if (percentage > 70 && percentage < 100) {
                return "bg-[#f7db07]";
            } else if (percentage < 70) {
                return "bg-[#17b509]";
            } else {
                return "bg-[#7a2985]"; // Default color
            }
        },
        chooseTime(type) {
            // keep shared logic here if needed elsewhere
            this.bet_numbers = [];
            this.game_setting_id = type.id;
            this.selectedGameSetting = type;
            this.getBetNumbers();
        },
        confirmTimeSelection() {
            if (!this.pendingGameSetting) {
                return;
            }
            this.chooseTime(this.pendingGameSetting);
            this.step = 1;
        },
        async checkGameActive() {
            let response = await getApiData({
                url: `api/game_list?game_id=1`,
                token: this.getToken,
            });
            if (response.data) {
                this.settings = response.data.settings;
                this.setting_value = response.data.settings[0].id;

                if (response.data.twod_settings.length) {
                    this.twod_settings = response.data.twod_settings;
                    this.main_game_active = response.data.is_active;
                    this.step = 5;
                } else {
                    this.step = 5; //error page
                }
            } else {
                this.step = 5; //error page
            }
        },
        async getBetWinners() {
            this.showSpinner = true;
            let response = await getApiData({
                url: `api/winning_list?game_setting_id=${this.setting_value}&page=${this.winner_page}`,
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
        formatTime(time) {
            return moment(time, "HH:mm").format("hh:mm A");
        },
        showErrorModal() {
            const button = document.getElementById("error_modal_btn");
            if (button) {
                button.click();
            }
        },
        getCurrentDate() {
            return moment().format("DD-MM-YYYY");
        },
        getCurrentTime() {
            return moment().format("hh:mm A");
        },

        validateNumber(event, refName) {
            const tempValue = checkNumber(event.target.value);
            this.$refs[refName].value = tempValue;
        },
    },
    watch: {
        step(newValue, oldValue) {
            this.winners = [];
            if (this.step == 7) {
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
    },
    // destroyed() {},
};
</script>
<style lang=""></style>
