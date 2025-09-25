<template lang="">
    <notifications position="top center" />

    <div v-if="step == 7" class="frame-container min-h-[100vh]">
        <Navbar title="ထီပေါက်သူ" :back-btn="backBtn"></Navbar>
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

    <div v-else class="frame-container min-h-[100vh]">
        <Navbar title="ထိုးမည်" :back-btn="backBtn"></Navbar>
        <!-- Error page -->
        <div :class="step == 6 ? 'block' : 'hidden'">
            <div class="relative mb-0 w-full bg-transparent pt-4 pb-14 px-4">
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
            <div class="relative mb-0 w-full bg-transparent pt-4 pb-14 px-0">
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
                    class="bg-transparent items-center justify-center mb-8"
                >
                    <div class="flex-grow py-6 ">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold mb-2">2D ထိုးမည်</h1>
                            <p class="text-lg">ထိုးမည့် အချိန်ကို ရွေးပါ</p>
                        </div>
                
                        <div class="flex justify-center items-center my-8 space-x-4">
                            <div v-for="(twod_setting, index) in twod_settings"
                                :key="index" @click="chooseTime(twod_setting)"
                                class="bg-white p-6 rounded-2xl shadow-lg w-48 text-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-2 text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p class="text-2xl font-semibold">{{ formatTime(twod_setting.lottery_time) }}</p>
                            </div>
                            <!-- <div class="bg-white p-6 rounded-2xl shadow-lg w-48 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 mx-auto mb-2 text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p class="text-2xl font-semibold">4:30 PM</p>
                            </div> -->
                        </div>
                    </div>

                    <div class=" rounded-lg  p-4">
                        <h2 class="text-xl font-bold mb-4 dash-under relative after:!left-0 inline-block pb-3">မှတ်တမ်းများ</h2>
                        
                        <div class="divide-y divide-gray-200">
                            <a href="/2d/live" class="flex items-center justify-between py-4 cursor-pointer ">
                                <div class="flex items-center space-x-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                    </svg>
                                    <span class="text-lg">2D Live</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                            
                            <a hreft="/history?game_id=1" class="flex items-center justify-between py-4 cursor-pointer ">
                                <div class="flex items-center space-x-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.25a.75.75 0 0 0-.75-.75H12a.75.75 0 0 0-.75.75v2.25a.75.75 0 0 0 .75.75h2.25a.75.75 0 0 0 .75-.75Z" />
                                    </svg>
                                    <span class="text-lg">2D မှတ်တမ်း</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                
                            <a href="/winner_lists/1" class="flex items-center justify-between py-4 cursor-pointer ">
                                <div class="flex items-center space-x-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                    </svg>
                                    <span class="text-lg">ထီပေါက်သူများ</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>






                    <div class="text-center mb-4">
                        <h1 class="text-white py-5 text-lg font-semibold">
                            ထိုးမည့်အချိန်ကို ရွေးပါ asdf
                        </h1>
                    </div>

                    <div>
                        <div
                            v-for="(twod_setting, index) in twod_settings"
                            :key="index"
                            @click="chooseTime(twod_setting)"
                            class="first:bg-[#40403E] last:bg-[#DDA33F] text-white rounded-lg cursor-pointer shadow-md px-8 py-10 flex justify-between mb-5"
                        >
                            <i
                                class="far fa-stopwatch"
                                style="font-size: 24px"
                            ></i>

                            <span>
                                {{ formatTime(twod_setting.lottery_time) }}
                            </span>
                            <i
                                class="far fa-angle-right"
                                style="font-size: 24px"
                            ></i>
                        </div>
                    </div>
                </div>
                <div
                    v-else
                    class="bg-transparent items-center justify-center mb-8"
                >
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

        <div :class="step == 1 ? 'block' : 'hidden'" class="pb-16">
            <div
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
                    <!-- <p class="text-sm">
                        {{ $t("Balance") }}  {{ wallet_balance }} MMK
                    </p> -->
                    <div>
                        <p class="text-sm">
                            {{ $t("Closing Time") }}
                        </p>
                        <p class="text-sm text-right">
                            {{ closingTimeFormat }}
                        </p>
                    </div>
                    <!-- <p class="text-sm">
                        {{ $t("Closing Time") }} :
                        {{ closingTimeFormat }}
                    </p> -->
                </div>
            </div>

            <div>
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
                <div class="grid grid-cols-6 gap-x-1 lg:gap-x-4 gap-y-4">
                    <div
                        class="contents"
                        v-for="(num, index) in numbers"
                        :key="index"
                    >
                        <div v-if="index == '96'" class="opacity-0"></div>

                        <div
                            :class="[
                                num.is_active == 0
                                    ? 'bg-gray-300'
                                    : isBetNumber(num.number)
                                    ? 'bg-[#FDC652] text-white font-semibold'
                                    : 'bg-white',
                                'py-2 px-1 lg:px-2 text-center shadow-xl aspect-square flex items-center justify-center border border-gray-200 rounded-md',
                            ]"
                            @click="
                                no_more_bet == false && num.is_active == 1
                                    ? addBetNumber(num)
                                    : ''
                            "
                        >
                            <div class="w-full">
                                <p class="text-xs lg:text-2xl mb-2 font-inter">
                                    {{ num.number }}
                                </p>
                                <div
                                    class="w-8 lg:w-8 mx-auto bg-[#9C9C9C] h-1.5"
                                >
                                    <!-- class="bg-[#7a2985] h-1.5" -->

                                    <div
                                        class="bg-[#17b509] h-1.5"
                                        :class="
                                            progressBarClass(
                                                num.total_bet_percentage
                                            )
                                        "
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
            class="relative mb-12 w-full rounded-lg  bg-white pb-14"
            :class="step == 2 ? 'block' : 'hidden'"
            style="min-height: calc(100vh - 168px)"
        >
            <div
                class="flex justify-between p-6 bg-[#ffc529] text-black rounded-tr-lg rounded-tl-lg"
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
                        {{ formatTime(selectedGameSetting.lottery_time) }}
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
                            </td>
                            <td class="text-center py-2">
                                <button
                                    v-show="
                                        bet_number.number ==
                                        edit_bet_number.number
                                    "
                                    @click="editBetAmount"
                                    class="text-green-600 hover:text-green-800 transition duration-150 ease-in-out"
                                >
                                    <i class="fas fa-check mr-2"></i>
                                </button>
                                <button
                                    v-show="
                                        bet_number.number !=
                                        edit_bet_number.number
                                    "
                                    @click="edit_bet_number = bet_number"
                                    class="text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out"
                                >
                                    <i class="fal fa-edit mr-2"></i>
                                </button>
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
                <!-- <p class="text-sm pt-2 pr-8">
                    {{ $t("Total Betting Amount") }} : {{ totalBetAmount }} MMK
                </p> -->
                <button
                    class="bg-[#e2e5e9] text-black px-12 py-2 rounded-lg text-sm font-semibold"
                    @click="step = 1"
                >
                    Cancel
                </button>
                <button
                    :disabled="calling_api"
                    class="bg-[#FDC652] ml-3 text-white px-12 py-2 rounded-lg text-sm font-semibold"
                    @click="sendBetting"
                >
                    {{ calling_api ? "ထိုးနေသည်" : "ထိုးမည်" }}
                </button>
            </div>
        </div>

        <!-- quick betting -->
        <div :class="step == 3 ? 'block' : 'hidden'">
            <div class="relative mb-0 w-full bg-transparent pt-4 pb-14 px-4">
                <div class="bg-transparent items-center justify-center mb-8">
                    <div class="text-left mb-4">
                        <h1 class="text-lg font-semibold primary-text">
                            ရိုးရိုး
                        </h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="simpleBet('sone_sone')"
                            class="border border-gray-400 text-sm rounded-lg py-3 px-1"
                        >
                            စုံစုံ
                        </button>
                        <button
                            @click="simpleBet('ma_ma')"
                            class="border border-gray-400 text-sm rounded-lg py-3 px-1"
                        >
                            မမ
                        </button>
                        <button
                            @click="simpleBet('sone_ma')"
                            class="border border-gray-400 text-sm rounded-lg py-3 px-1"
                        >
                            စုံမ
                        </button>
                        <button
                            @click="simpleBet('ma_sone')"
                            class="border border-gray-400 text-sm rounded-lg py-3 px-1"
                        >
                            မစုံ
                        </button>
                        <button
                            @click="simpleBet('sone_puu')"
                            class="border border-gray-400 text-sm rounded-lg py-3 px-1"
                        >
                            စုံပူး
                        </button>
                        <button
                            @click="simpleBet('ma_puu')"
                            class="border border-gray-400 text-sm rounded-lg py-3 px-1"
                        >
                            မပူး
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-lg font-semibold primary-text">
                            နက္ခတ်ပါဝါ
                        </h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="natKhatPower('nat')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            နက်
                        </button>
                        <button
                            @click="natKhatPower('power')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            ပါ၀ါ
                        </button>
                        <button
                            @click="natKhatPower('a_puu')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            အပူး
                        </button>
                        <button
                            @click="natKhatPower('nyi_naung')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            ညီအကို
                        </button>
                    </div>
                </div>

                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-lg font-semibold primary-text">ပါတ်</h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="patNumberBet('0')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            0
                        </button>
                        <button
                            @click="patNumberBet('1')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            1
                        </button>
                        <button
                            @click="patNumberBet('2')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            2
                        </button>
                        <button
                            @click="patNumberBet('3')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            3
                        </button>
                        <button
                            @click="patNumberBet('4')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            4
                        </button>
                        <button
                            @click="patNumberBet('5')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            5
                        </button>
                        <button
                            @click="patNumberBet('6')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            6
                        </button>
                        <button
                            @click="patNumberBet('7')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            7
                        </button>
                        <button
                            @click="patNumberBet('8')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            8
                        </button>
                        <button
                            @click="patNumberBet('9')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            9
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-lg font-semibold primary-text">ထိပ်</h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="numbersStartingWith('0')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            0
                        </button>
                        <button
                            @click="numbersStartingWith('1')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            1
                        </button>
                        <button
                            @click="numbersStartingWith('2')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            2
                        </button>
                        <button
                            @click="numbersStartingWith('3')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            3
                        </button>
                        <button
                            @click="numbersStartingWith('4')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            4
                        </button>
                        <button
                            @click="numbersStartingWith('5')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            5
                        </button>
                        <button
                            @click="numbersStartingWith('6')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            6
                        </button>
                        <button
                            @click="numbersStartingWith('7')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            7
                        </button>
                        <button
                            @click="numbersStartingWith('8')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            8
                        </button>
                        <button
                            @click="numbersStartingWith('9')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            9
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-lg font-semibold primary-text">
                            နောက်
                        </h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="numbersEndingWith('0')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            0
                        </button>
                        <button
                            @click="numbersEndingWith('1')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            1
                        </button>
                        <button
                            @click="numbersEndingWith('2')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            2
                        </button>
                        <button
                            @click="numbersEndingWith('3')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            3
                        </button>
                        <button
                            @click="numbersEndingWith('4')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            4
                        </button>
                        <button
                            @click="numbersEndingWith('5')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            5
                        </button>
                        <button
                            @click="numbersEndingWith('6')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            6
                        </button>
                        <button
                            @click="numbersEndingWith('7')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            7
                        </button>
                        <button
                            @click="numbersEndingWith('8')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            8
                        </button>
                        <button
                            @click="numbersEndingWith('9')"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            9
                        </button>
                    </div>
                </div>
                <div
                    class="bg-transparent items-center justify-center rounded-lg shadow-xl mb-8"
                >
                    <div class="text-left mb-4">
                        <h1 class="text-lg font-semibold primary-text">
                            ဘရိတ်
                        </h1>
                    </div>

                    <div
                        class="bg-white px-4 py-5 rounded-lg shadow-md grid grid-cols-5 gap-x-4 gap-y-2"
                    >
                        <button
                            @click="breakNumbers(0, 10)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            0
                        </button>
                        <button
                            @click="breakNumbers(1, 11)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            1
                        </button>
                        <button
                            @click="breakNumbers(2, 12)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            2
                        </button>
                        <button
                            @click="breakNumbers(3, 13)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            3
                        </button>
                        <button
                            @click="breakNumbers(4, 14)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            4
                        </button>
                        <button
                            @click="breakNumbers(5, 15)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            5
                        </button>
                        <button
                            @click="breakNumbers(6, 16)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            6
                        </button>
                        <button
                            @click="breakNumbers(1, 17)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            7
                        </button>
                        <button
                            @click="breakNumbers(8, 18)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            8
                        </button>
                        <button
                            @click="breakNumbers(9, 19)"
                            class="border border-gray-400 rounded-lg py-3 px-1 text-sm"
                        >
                            9
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ခွေထိုးမည် -->
        <div
            :class="step == 4 ? 'block' : 'hidden'"
            style="min-height: calc(100vh - 168px)"
        >
            <div
                class="relative mb-8 w-full rounded-lg shadow-xl bg-white pt-4 pb-0 px-8"
            >
                <div class="grid grid-cols-2 gap-x-4">
                    <div class="flex justify-between flex-col pt-4 pb-3">
                        <div>
                            <div class="mb-4">
                                <label
                                    for="round_digits"
                                    class="text-sm mb-3 relative block"
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
                                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                                />
                            </div>
                            <div class="mb-4">
                                <button
                                    class="bg-[#DDA33F] text-white px-4 py-2 w-full rounded-lg text-sm"
                                    @click="getTwoDigitCombinations(false)"
                                >
                                    အပူးမပါ
                                </button>
                            </div>
                        </div>
                        <p class="text-sm">
                            {{ $t("Total Betting Amount") }} :
                            {{ totalBetAmount?.toLocaleString() }} MMK
                        </p>
                    </div>

                    <div class="flex justify-between flex-col pt-4 pb-3">
                        <div>
                            <div class="mb-4">
                                <label
                                    for="amount"
                                    class="text-sm mb-3 relative block"
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
                                            'round_bet_amount'
                                        )
                                    "
                                    ref="round_bet_amount"
                                    class="block w-full py-2 px-2 border border-gray-400 text-sm rounded-md bg-white focus:ring-0 focus:shadow-none"
                                />
                            </div>
                            <div class="mb-4">
                                <button
                                    class="bg-[#C67D06] text-white px-4 py-2 w-full rounded-lg text-sm"
                                    @click="getTwoDigitCombinations(true)"
                                >
                                    အပူးပါ
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between col-span-2 mb-8">
                        <p class="text-sm">
                            လက်ကျန်ငွေ :
                            {{ wallet_balance?.toLocaleString() }} MMK
                        </p>
                        <p class="text-sm">
                            {{ $t("Closing Time") }} :
                            {{ closingTimeFormat }}
                        </p>
                    </div>
                </div>
            </div>
            <div
                class="relative mb-0 w-full rounded-lg shadow-xl bg-white pt-4 pb-14 px-4"
            >
                <div class="">
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
                                    class="text-center py-2"
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
                                </td>
                                <td class="text-center py-2">
                                    <button
                                        v-show="
                                            bet_number.number ==
                                            edit_bet_number.number
                                        "
                                        @click="editBetAmount"
                                        class="text-green-600 hover:text-green-800 transition duration-150 ease-in-out"
                                    >
                                        <i class="fas fa-check mr-2"></i>
                                    </button>
                                    <!-- Edit Button (Blue) -->
                                    <button
                                        v-show="
                                            bet_number.number !=
                                            edit_bet_number.number
                                        "
                                        @click="edit_bet_number = bet_number"
                                        class="text-blue-600 hover:text-blue-800 transition duration-150 ease-in-out"
                                    >
                                        <i class="fal fa-edit mr-2"></i>
                                    </button>
                                    <!-- Delete Button (Red) -->
                                    <button
                                        data-twe-toggle="modal"
                                        data-twe-target="#delete_modal"
                                        @click="
                                            delete_bet_number =
                                                bet_number.number
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
                <div class="absolute mb-6 w-full flex justify-center">
                    <button
                        :disabled="calling_api"
                        class="bg-[#FDC652] text-white px-12 py-2 rounded-lg text-sm font-semibold"
                        @click="sendBetting"
                    >
                        {{ calling_api ? "ထိုးနေသည်" : "ထိုးမည်" }}
                    </button>
                </div>
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
                (bet) => bet.number === num.number
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
        sortBetNumbers() {
            this.bet_numbers.sort(
                (a, b) => parseInt(a.number) - parseInt(b.number)
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
                                n.number == reversedNumber && n.is_active == 1
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
                return "bg-[#c7080e] h-1-5";
            } else if (percentage > 70 && percentage < 100) {
                return "bg-[#f7db07] h-1-5";
            } else if (percentage < 70) {
                return "bg-[#17b509] h-1-5";
            } else {
                return "bg-[#7a2985] h-1-5"; // Default color
            }
        },
        chooseTime(type) {
            this.bet_numbers = [];
            this.game_setting_id = type.id;
            this.selectedGameSetting = type;
            this.getBetNumbers();
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
            return moment().format("MMM DD, YYYY");
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
