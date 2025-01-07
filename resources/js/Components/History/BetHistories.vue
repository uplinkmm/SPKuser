<template>
    <div
        class="frame-container px-0 pb-0 min-h-[100vh]"
    >
        <Navbar title="Bet History" :back-btn="backBtn"></Navbar>

        <div class="">
            <!-- <ul
                class="flex list-none flex-row flex-wrap border-b-0 ps-0 px-4 py-0 mb-8 bg-white sticky top-0 z-10"
                role="tablist"
            >
                <li role="presentation">
                    <a
                        href="#tabs-twoD"
                        :class="[
                            'my-2 block px-4 pb-3.5 pt-4 text-sm',
                            game_id === 1
                                ? 'text-black border-b-2 border-black'
                                : 'text-neutral-500 hover:bg-neutral-100',
                        ]"
                        role="tab"
                        aria-controls="tabs-twoD"
                        @click="
                            game_id = 1;
                            updateURLAndFetch();
                        "
                    >
                        2D
                    </a>
                </li>

                <li role="presentation">
                    <a
                        href="#tabs-threeD"
                        :class="[
                            'my-2 block px-4 pb-3.5 pt-4 text-sm',
                            game_id === 2
                                ? 'text-black border-b-2 border-black'
                                : 'text-neutral-500 hover:bg-neutral-100',
                        ]"
                        role="tab"
                        aria-controls="tabs-threeD"
                        @click="
                            game_id = 2;
                            updateURLAndFetch();
                        "
                    >
                        3D
                    </a>
                </li>
            </ul> -->

            <div class="mb-6">
                <!-- 2D History Section -->
                <div
                    v-if="game_id === 1"
                    class="opacity-100 transition-opacity duration-150 ease-linear"
                    id="tabs-twoD"
                    role="tabpanel"
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-for="(history, index) in two_d_histories"
                            :key="index"
                            class=" pb-4 rounded-lg mb-8 bg-white relative"
                        >
                            <div class="flex justify-between mb-0 bg-[#FDC652] py-4 px-4 text-white">
                                <p class="text-base font-semibold">
                                    {{ dateFormat(history.date_time) }}
                                </p>
                                <p class="text-base font-semibold">
                                    {{ timeFormat(history.lottery_time) }}
                                </p>
                            </div>
                            <hr />
                            <div class=" pt-2">
                                <div>
                                    <table class="table-auto w-full">
                                        <thead>
                                            <tr class="border-b !border-gray-300">
                                                <th
                                                    class="py-4 text-left font-normal pr-4 pl-12"
                                                >
                                                    ID
                                                </th>
                                                <th class="py-4 font-normal px-4">
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
                                                <td class="text-left py-4 pr-4 pl-12">
                                                    {{ ++index }}
                                                </td>
                                                <td class="text-center py-4 px-4">
                                                    {{ bet_number.number }}
                                                </td>
                                                <td class="py-4 text-right pl-4 pr-12">
                                                    {{ bet_number.amount?.toLocaleString() }}
                                                </td>
                                            </tr>
                                            <tr class="border-t !border-gray-300">
                                                <td></td>
                                                <td class="text-center text-base font-semibold py-3 pb-2">
                                                    Total
                                                </td>
                                                <td
                                                    class="text-right text-base font-semibold pl-4 pr-12 py-3"
                                                >
                                                    {{ history.total_amount?.toLocaleString() }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                            v-for="(history, index) in three_d_histories"
                            :key="index"
                            class=" pb-4 rounded-2xl mb-8 bg-white relative"
                        >
                            <div class="flex justify-between mb-0 bg-[#FDC652] py-4 px-4 text-white">
                                <p class="text-base font-semibold">
                                    {{ dateFormat(history.date_time) }}
                                </p>
                                <p class="text-base font-semibold">
                                    {{
                                        dateFormat(
                                            history.game_setting
                                                .lottery_date_time
                                        )
                                    }}
                                </p>
                            </div>
                            <hr />
                            <div class=" pt-2">
                                <div>
                                    <table class="table-auto w-full">
                                        <thead>
                                            <tr class="border-b !border-gray-300">
                                                <th
                                                    class="py-4 text-left font-normal pr-4 pl-12"
                                                >
                                                    ID
                                                </th>
                                                <th class="py-4 font-normal px-4">
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
                                                <td class="text-left py-4 pr-4 pl-12">
                                                    {{ ++index }}
                                                </td>
                                                <td class="text-center py-4 px-4">
                                                    {{ bet_number.number }}
                                                </td>
                                                <td class=" py-4 pl-4 text-right pr-12">
                                                    {{ bet_number.amount?.toLocaleString() }}
                                                </td>
                                            </tr>
                                            <tr class="border-t !border-gray-300">
                                                <td></td>
                                                <td class="text-center text-base font-semibold py-3 pb-2">
                                                    Total
                                                </td>
                                                <td
                                                    class="text-right text-base font-semibold py-3 pr-12"
                                                >
                                                    {{ history.total_amount?.toLocaleString() }}
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
        };
    },
    components: {
        Navbar,
    },
    computed: {
        ...mapGetters(["getToken"]),
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
            if (this.game_id === 1) {
                this.two_d_histories = response.data.data;
            } else if (this.game_id === 2) {
                this.three_d_histories = response.data.data;
            }
            this.scrollToTop();
        },
        dateFormat(date_time) {
            return moment(date_time).format("YYYY-MM-DD hh:mm A");
        },
        timeFormat(time) {
            return moment(time,"HH:mm:ss").format("hh:mm A");
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
