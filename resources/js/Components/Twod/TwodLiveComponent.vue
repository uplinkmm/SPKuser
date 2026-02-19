<template>
    <div class="frame-container bg-black min-h-[100vh] pb-20">
        <div class="px-4 mb-20">
            <Navbar title="" :need-auth="false" :back-btn="backBtn"></Navbar>
        </div>

        <!-- <div
            class="primary-bg flex justify-center mt-2 rounded-lg gap-2 items-center text-sm lg:text-base"
        >
            <a href="/history?game_id=1" class="text-center p-8">
                <i class="fal fa-file text-3xl pb-2 text-white"></i>
                <p class="text-white">မှတ်တမ်း</p>
            </a>
            <a href="/2D_betting" class="text-center p-8">
                <img
                    src="../../../../public/img/billiard_white.png"
                    class="h-10 pb-1"
                    alt=""
                />
                <p class="text-white">ထိုးမည်</p>
            </a>
            <div class="text-center p-8">
                <a href="/winner_lists/1">
                    <i class="fal fa-users text-3xl pb-2 text-white"></i>
                    <p class="text-white">ထီပေါက်သူ</p>
                </a>
            </div>
        </div> -->
        <div class="bg-white rounded-t-2xl shadow-lg p-4">
            <p class="text-center text-black font-semibold text-base mb-3">
                2D Live
            </p>

            <div class="flex justify-center">
                <p
                    class="text-[160px] leading-none w-fit text-green-700 font-extrabold drop-shadow-sm animate-pulse"
                >
                    {{ twoDList?.twod }}
                </p>
            </div>

            <div class="flex justify-center mt-2 mb-3">
                <div class="flex items-center gap-x-2 text-black">
                    <div
                        class="w-5 h-5 rounded-full bg-green-700 flex items-center justify-center"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            class="w-4 h-4 text-white"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M16.704 5.29a1 1 0 010 1.42l-7.5 7.5a1 1 0 01-1.415 0l-3.5-3.5a1 1 0 011.414-1.414l2.793 2.793 6.793-6.793a1 1 0 011.415-.006z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <p class="text-base font-semibold mb-0">
                        Updated
                        <span v-if="twoDList && twoDList.time">
                            {{ twoDList.time }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-x-4 mb-4">
                <div
                    v-for="(twoD, index) in twoDList?.results || []"
                    :key="index"
                    class="bg-[#D20000] text-white px-6 py-4 rounded-lg mb-4 shadow-md"
                >
                    <div class="text-center">
                        <p class="font-semibold mb-2">
                            {{ formatOpenTime(twoD.open_time) }}
                        </p>
                        <hr class="border-white/60" />
                    </div>

                    <div class="grid grid-cols-3 text-center mt-4">
                        <div>
                            <p class="opacity-95 mb-1">Set</p>
                            <p class="mb-0">
                                {{ twoD.set == "--" ? twoDList.set : twoD.set }}
                            </p>
                        </div>
                        <div>
                            <p class="opacity-95 mb-1">Value</p>
                            <p class="mb-0">
                                {{
                                    twoD.value == "--"
                                        ? twoDList.value
                                        : twoD.value
                                }}
                            </p>
                        </div>
                        <div>
                            <p class="opacity-95 mb-1">2D</p>
                            <p class="text-[#F6E271] font-semibold mb-0">
                                {{ twoD.twod }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-y-4 mt-1">
                <div
                    v-for="(row, index) in twoDList?.modern_internet?.numbers ||
                    []"
                    :key="index"
                    class="bg-[#D20000] text-white px-6 py-4 rounded-lg shadow-md"
                >
                    <div class="grid grid-cols-4 gap-x-2 items-center">
                        <div class="text-left">
                            <p class="text-lg font-semibold mb-1 leading-none">
                                {{ formatMiTime(row.time).time }}
                            </p>
                            <p class="text-base font-semibold mb-0">
                                {{ formatMiTime(row.time).meridiem }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="opacity-95 mb-1">Modern</p>
                            <p class="text-[#F6E271] font-semibold mb-0">
                                {{ row.Modern }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="opacity-95 mb-1">Internet</p>
                            <p class="text-[#F6E271] font-semibold mb-0">
                                {{ row.Internet }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="opacity-95 mb-1">TW</p>
                            <p class="text-[#F6E271] font-semibold mb-0">
                                {{ row.TW }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal, Ripple, initTWE, Input } from "tw-elements";
import {
    getApiData,
    postApiData,
    deleteApiData,
} from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            twoDList: [],
            // two_d:null,
            intervalId: null,
            showSpinner: false,
        };
    },
    methods: {
        // async get2DLive() {
        //     const response = await getApiData({ url: '/api/2d/live' });
        //     if (response.data) {
        //         this.two_d = response.data;
        //     }
        //     console.log('live api called');
        // },
        backBtn() {
            window.history.back();
        },
        async get2DList() {
            if (this.showSpinner == false) {
                this.showSpinner = true;
                const response = await getApiData({
                    url: "https://admin.shwepaukkan.com/api/2d/live",
                    // url: "http://localhost:4100/api/2d/live",
                });
                if (response.data) {
                    this.twoDList = response.data;
                    this.showSpinner = false;
                } else {
                    this.showSpinner = false;
                }
            }
        },

        convertTo12HourFormat(timeStr) {
            const [hour, minute, second] = timeStr.split(":").map(Number);
            const hour12 = hour % 12 === 0 ? 12 : hour % 12;
            return `${String(hour12).padStart(2, "0")}:${String(
                minute,
            ).padStart(2, "0")}:${String(second).padStart(2, "0")}`;
        },

        formatOpenTime(timeStr) {
            if (!timeStr || timeStr === "--") return "--";
            const [hour, minute] = timeStr.split(":").slice(0, 2).map(Number);
            const ampm = hour >= 12 ? "PM" : "AM";
            const hour12 = hour % 12 === 0 ? 12 : hour % 12;
            return `${hour12}:${String(minute).padStart(2, "0")} ${ampm}`;
        },

        formatMiTime(timeStr) {
            if (!timeStr || timeStr === "--") {
                return { time: "--", meridiem: "" };
            }

            const [timePart, meridiemPart] = String(timeStr).split(" ");
            if (meridiemPart) {
                const [h, m] = timePart.split(":");
                return {
                    time: `${Number(h)}:${String(m).padStart(2, "0")}`,
                    meridiem: meridiemPart.toUpperCase(),
                };
            }

            const parts = String(timeStr).split(":");
            if (parts.length < 2) return { time: timeStr, meridiem: "" };
            const [hour, minute] = parts.map(Number);
            const ampm = hour >= 12 ? "PM" : "AM";
            const hour12 = hour % 12 === 0 ? 12 : hour % 12;
            return {
                time: `${hour12}:${String(minute).padStart(2, "0")}`,
                meridiem: ampm,
            };
        },

        convertDatetimeToLongDate12Hour(datetimeStr) {
            if (datetimeStr == "--") {
                return "-- -- --";
            }
            const monthNames = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];

            const [datePart, timePart] = datetimeStr.split(" ");
            const [year, month, day] = datePart.split("-").map(Number);
            const [hour, minute, second] = timePart.split(":").map(Number);

            const ampm = hour >= 12 ? "PM" : "AM";
            const hour12 = hour % 12 === 0 ? 12 : hour % 12;

            const monthName = monthNames[month - 1];
            const formattedDate = `${monthName} ${day}, ${year}`;
            const formattedTime = `${String(hour12).padStart(2, "0")}:${String(
                minute,
            ).padStart(2, "0")}:${String(second).padStart(2, "0")} ${ampm}`;

            return `${formattedDate} ${formattedTime}`;
        },

        isOffHours() {
            const now = new Date();
            const currentHours = now.getHours();
            const currentMinutes = now.getMinutes();

            // Convert current time to a single comparable minute value for easier comparison
            const currentTimeInMinutes = currentHours * 60 + currentMinutes;

            // Define off-hour start and end times in minutes from midnight
            const offHoursStartInMinutes = 16 * 60 + 31; // 4:31 PM
            const offHoursEndInMinutes = 8 * 60 + 50; // 8:50 AM

            // Case 1: Off-hours start in the evening and end the next morning (e.g., 4:31 PM to 11:59 PM OR 12:00 AM to 8:50 AM)
            if (offHoursStartInMinutes < offHoursEndInMinutes) {
                // This scenario is not directly applicable for a range that crosses midnight
                // If it were, it would be a simple `currentTimeInMinutes >= start && currentTimeInMinutes <= end`
                // However, our range (4:31 PM to 8:50 AM) crosses midnight.
                // So, we handle it as two separate ranges.
            }

            // Case 2: Off-hours start in the evening and end the next morning (crosses midnight)
            // This is the correct logic for 4:31 PM to 8:50 AM
            return (
                currentTimeInMinutes >= offHoursStartInMinutes ||
                currentTimeInMinutes <= offHoursEndInMinutes
            );
        },
    },

    created() {
        if (!this.isOffHours()) {
            this.intervalId = setInterval(() => this.get2DList(), 3000);
        }
    },

    mounted() {
        this.get2DList();
        // this.get2DLive();
        initTWE({ Modal, Ripple });
    },

    beforeDestroy() {
        clearInterval(this.intervalId);
    },
};
</script>
