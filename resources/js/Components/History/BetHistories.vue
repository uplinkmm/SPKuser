<template>
    <div
        class="frame-container min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4">
            <Navbar title="Bet History" :back-btn="backBtn"></Navbar>
        </div>

        <div class="bg-[#FFC529] rounded-t-xl min-h-[calc(100vh-120px)]">
            <div class="mb-6">
                <!-- 2D History Section -->
                <div
                    v-if="game_id === 1"
                    class="opacity-100 transition-opacity duration-150 ease-linear"
                    id="tabs-twoD"
                    role="tabpanel"
                >
                    <div class="text-center text-black pt-4 pb-2 font-bold">
                        <p class="text-xl">2D မှတ်တမ်း</p>
                        <div class="flex justify-center gap-x-10 mt-3">
                            <button
                                type="button"
                                class="text-lg font-semibold pb-2"
                                :class="
                                    selectedTwoDTab == 'morning'
                                        ? 'border-b-4 border-[#5271FF]'
                                        : 'border-b-4 border-transparent'
                                "
                                @click="selectedTwoDTab = 'morning'"
                            >
                                12:01 PM
                            </button>
                            <button
                                type="button"
                                class="text-lg font-semibold pb-2"
                                :class="
                                    selectedTwoDTab == 'evening'
                                        ? 'border-b-4 border-[#5271FF]'
                                        : 'border-b-4 border-transparent'
                                "
                                @click="selectedTwoDTab = 'evening'"
                            >
                                4:30 PM
                            </button>
                        </div>
                    </div>
                    <div class="mx-0 pb-8 pt-4">
                        <div
                            v-if="filteredTwoDHistories.length === 0"
                            class="text-center text-white py-8"
                        >
                            No history found
                        </div>

                        <div
                            v-for="(history, index) in filteredTwoDHistories"
                            :key="index"
                            class="mb-6"
                        >
                            <div class="rounded-xl bg-[#C58A1F] py-3 px-2">
                                <div
                                    class="rounded-xl bg-white border-2 border-gray-700 overflow-hidden"
                                >
                                    <div
                                        class="flex justify-between items-center px-4 py-2 bg-[#F4F4F4] text-lg"
                                    >
                                        <p>{{ dateOnly(history.date_time) }}</p>
                                        <p>
                                            {{
                                                timeFromDateTime(
                                                    history.date_time,
                                                )
                                            }}
                                        </p>
                                        <p class="text-[#FF9900] font-semibold">
                                            {{
                                                timeFormat(history.lottery_time)
                                            }}
                                        </p>
                                    </div>

                                    <div
                                        class="px-4 pb-3 pt-2 overflow-y-auto small-scrollbar"
                                    >
                                        <table
                                            class="table-auto w-full text-base"
                                        >
                                            <thead>
                                                <tr
                                                    class="border-b !border-gray-300"
                                                >
                                                    <th class="py-3 text-left">
                                                        စဉ်
                                                    </th>
                                                    <th
                                                        class="py-3 text-center"
                                                    >
                                                        ဂဏန်း
                                                    </th>
                                                    <th class="py-3 text-right">
                                                        ငွေပမာဏ
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        bet_number, index
                                                    ) in history.betting_numbers"
                                                    :key="index"
                                                    class="border-b last:border-0"
                                                >
                                                    <td class="py-3 text-left">
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td
                                                        class="py-3 text-center"
                                                    >
                                                        {{ bet_number.number }}
                                                    </td>
                                                    <td class="py-3 text-right">
                                                        {{
                                                            bet_number.amount?.toLocaleString()
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-t !border-gray-300"
                                                    v-if="
                                                        history.betting_numbers
                                                            ?.length
                                                    "
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
                                                            history.total_amount?.toLocaleString()
                                                        }}
                                                        ကျပ်
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3D History Section -->
                <div
                    v-if="game_id === 2"
                    class="opacity-100 transition-opacity duration-150 ease-linear"
                    id="tabs-threeD"
                    role="tabpanel"
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-if="three_d_histories.length === 0"
                            class="text-center text-white py-8"
                        >
                            No history found
                        </div>
                        <div
                            v-for="(history, index) in three_d_histories"
                            :key="index"
                            class="pb-4 rounded-2xl mb-8 bg-white relative"
                        >
                            <div
                                class="flex justify-between mb-0 bg-[#FFC529] py-4 px-4 text-white"
                            >
                                <p class="text-base font-semibold">
                                    {{ dateFormat(history.date_time) }}
                                </p>
                                <p class="text-base font-semibold">
                                    {{
                                        dateFormat(
                                            history.game_setting
                                                .lottery_date_time,
                                        )
                                    }}
                                </p>
                            </div>
                            <hr />
                            <div class="pt-2">
                                <div>
                                    <table class="table-auto w-full">
                                        <thead>
                                            <tr
                                                class="border-b !border-gray-300"
                                            >
                                                <th
                                                    class="py-4 text-left font-normal pr-4 pl-12"
                                                >
                                                    ID
                                                </th>
                                                <th
                                                    class="py-4 font-normal px-4"
                                                >
                                                    Number
                                                </th>
                                                <th
                                                    class="py-4 text-right font-normal pl-4 pr-12"
                                                >
                                                    Amount
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="(
                                                    bet_number, index
                                                ) in history.betting_numbers"
                                                :key="index"
                                            >
                                                <td
                                                    class="text-left py-4 pr-4 pl-12"
                                                >
                                                    {{ ++index }}
                                                </td>
                                                <td
                                                    class="text-center py-4 px-4"
                                                >
                                                    {{ bet_number.number }}
                                                </td>
                                                <td
                                                    class="py-4 pl-4 text-right pr-12"
                                                >
                                                    {{
                                                        bet_number.amount?.toLocaleString()
                                                    }}
                                                </td>
                                            </tr>
                                            <tr
                                                class="border-t !border-gray-300"
                                            >
                                                <td></td>
                                                <td
                                                    class="text-center text-base font-semibold py-3 pb-2"
                                                >
                                                    Total
                                                </td>
                                                <td
                                                    class="text-right text-base font-semibold py-3 pr-12"
                                                >
                                                    {{
                                                        history.total_amount?.toLocaleString()
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
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import { getApiData } from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import moment from "moment";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

import {
    Collapse,
    Carousel,
    initTWE,
    Modal,
    Ripple,
    Dropdown,
    Input,
    Tab,
} from "tw-elements";

export default {
    data() {
        return {
            game_id: 1, // Default to 2D
            two_d_histories: [],
            three_d_histories: [],
            selectedTwoDTab: "morning",
        };
    },
    components: {
        Navbar,
    },
    computed: {
        ...mapGetters(["getToken"]),
        filteredTwoDHistories() {
            const morningTime = "12:01:00";
            const eveningTime = "16:30:00";

            return (this.two_d_histories || []).filter((h) => {
                const t = h?.lottery_time;
                if (this.selectedTwoDTab === "morning") {
                    return t === morningTime || h?.time_status === "morning";
                }
                return t === eveningTime || h?.time_status === "evening";
            });
        },
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            window.history.back();
        },
        async getHistories() {
            let response = await getApiData({
                url: `api/betting_history?game_id=${this.game_id}`,
                token: this.getToken,
            });
            const histories = Array.isArray(response?.data?.data)
                ? response.data.data
                : response?.data?.data?.data || [];
            if (this.game_id === 1) {
                this.two_d_histories = histories;
            } else if (this.game_id === 2) {
                this.three_d_histories = histories;
            }
            this.scrollToTop();
        },
        dateFormat(date_time) {
            return moment(date_time).format("YYYY-MM-DD hh:mm A");
        },
        dateOnly(date_time) {
            return moment(date_time).format("DD-MM-YYYY");
        },
        timeFromDateTime(date_time) {
            return moment(date_time).format("hh:mm A");
        },
        timeFormat(time) {
            return moment(time, "HH:mm:ss").format("hh:mm A");
        },
        updateURLAndFetch() {
            this.scrollToTop();
            const url = new URL(window.location);
            url.searchParams.set("game_id", this.game_id);
            window.history.pushState({}, "", url); // Update the URL without reloading
            this.getHistories();
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" }); // Scroll to top with smooth animation
        },
        checkURLForGameId() {
            const urlParams = new URLSearchParams(window.location.search);
            const gameIdFromURL = parseInt(urlParams.get("game_id"));
            if (gameIdFromURL === 1 || gameIdFromURL === 2) {
                this.game_id = gameIdFromURL;
            }
            this.getHistories();
        },
    },
    mounted() {
        this.checkURLForGameId(); // Check the URL for game_id on page load
        initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });
    },
};
</script>
