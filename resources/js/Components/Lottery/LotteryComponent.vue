<template>
    <notifications position="top center" />
    <div
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4">
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
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-7 h-7 text-black"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18.364 5.636 5.636 18.364M5.636 5.636l12.728 12.728"
                                    />
                                </svg>
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
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-7 h-7 text-black"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18.364 5.636 5.636 18.364M5.636 5.636l12.728 12.728"
                                    />
                                </svg>
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
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-7 h-7 text-black"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18.364 5.636 5.636 18.364M5.636 5.636l12.728 12.728"
                                    />
                                </svg>
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
                                            class="block appearance-none w-full h-full bg-transparent text-black text-xl font-medium text-center pr-20 pl-2 focus:outline-none focus:ring-0"
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
                                    num.is_active == 1 ? addBetNumber(num) : ''
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

            <!-- Result Page-->
            <div
                class="relative mb-12 w-full pb-14"
                :class="step == 3 ? 'block' : 'hidden'"
                style="min-height: calc(100vh - 168px)"
            >
                <p class="text-center py-4">{{ game?.name }}</p>
                <div class="flex justify-between p-6 bg-[#fff] text-black">
                    <div>
                        <p class="pr-8 py-2">
                            {{ getCurrentDate() }}
                        </p>
                        <!-- <p class="pr-8">
                        {{ getCurrentTime() }}
                    </p> -->
                    </div>
                    <div>
                        <p class="pr-8 py-2">
                            {{ formatTime(game?.lottery_date_time) }}
                        </p>
                        <!-- <p class="pr-8">
                        {{ totalBetAmount?.toLocaleString() }} MMK
                    </p> -->
                    </div>
                </div>
                <div class="mb-5 px-4 bg-white pb-12">
                    <div class="flex justify-end mb-4"></div>
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="py-2">စဉ်</th>
                                <th class="py-2">{{ $t("No") }}</th>
                                <th class="py-2 text-right">
                                    {{ $t("Betting Amount") }}
                                </th>
                                <!-- <th class="py-2">{{ $t("Delete") }}</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(bet_number, index) in bet_numbers"
                                :key="index"
                                class="border-b border-gray-400"
                            >
                                <td class="text-center py-2">
                                    {{ index + 1 }}
                                </td>
                                <td class="text-center py-2">
                                    {{ bet_number.number }}
                                </td>

                                <td class="text-right py-2">
                                    <span>
                                        {{
                                            bet_number.amount?.toLocaleString()
                                        }}
                                    </span>
                                </td>
                                <!-- <td class="text-center py-2">
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
                            </td> -->
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center">စုစုပေါင်း</td>
                                <td class="py-2 text-right">
                                    {{ totalBetAmount?.toLocaleString() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="absolute bottom-0 mb-4 w-full flex justify-center">
                    <!-- <button
                    class="bg-[#e2e5e9] text-black px-12 py-2 rounded-lg text-sm font-semibold"
                    @click="
                        step = 2;
                        resetPromotion();
                    "
                >
                    Cancel
                </button> -->
                    <button
                        class="bg-[#0978D3] px-4 py-3 rounded-3xl text-white w-full mb-8 mx-8"
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
                        class="pt-4 pb-8 pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none"
                    >
                        <div
                            class="flex flex-shrink-0 items-center justify-between rounded-t-md border-neutral-100 py-8 px-6"
                        >
                            <h4
                                class="text-xl font-medium leading-normal text-surface text-center w-full"
                                id="exampleModalLabel"
                            ></h4>
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
                            class="relative flex-auto pt-2 pb-6 px-16"
                            data-twe-modal-body-ref
                        >
                            <div class="mb-8">
                                <svg
                                    class="w-16 h-16 mx-auto mb-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 640 640"
                                >
                                    <path
                                        d="M528 320C528 434.9 434.9 528 320 528C205.1 528 112 434.9 112 320C112 205.1 205.1 112 320 112C434.9 112 528 205.1 528 320zM64 320C64 461.4 178.6 576 320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320zM296 184L296 320C296 328 300 335.5 306.7 340L402.7 404C413.7 411.4 428.6 408.4 436 397.3C443.4 386.2 440.4 371.4 429.3 364L344 307.2L344 184C344 170.7 333.3 160 320 160C306.7 160 296 170.7 296 184z"
                                    />
                                </svg>
                                <p class="pb-10 mb-4">
                                    ကံစမ်းမဲ {{ bet_numbers.length }} စောင်
                                    ဝယ်သည့်အတွက် Free
                                    {{ freeTicketCount }} စောင် ရရှိမည်ဖြစ်သည်
                                </p>
                                <p class="text-sm">
                                    Free {{ freeTicketCount }} စောင်
                                    ရွေးချယ်ပေးပါရန်
                                </p>
                            </div>
                            <div class="mb-4">
                                <button
                                    class="px-4 py-2 lg:py-3 bg-[#0978D3] text-white text-sm rounded-3xl w-full"
                                    data-twe-modal-dismiss
                                    aria-label="Close"
                                >
                                    ရှေ့ဆက်မည်
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
                if (this.getFreeTicketCount()) {
                    console.log(this.getFreeTicketCount());
                    if (this.promotion_mode && !this.promotion_ticket_counts) {
                        //after choose promotions
                        this.step = 3;
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
