<template>
    <div
        class="bg-black w-full sm:w-3/12 sm:min-w-[480px] mx-auto bg-img pb-24 min-h-[100vh]"
    >
        <div class="mx-4">
            <Navbar
                title="History"
                :back-btn="backBtn"
                class="!px-8 !mb-0"
                :need-auth="false"
            ></Navbar>
        </div>

        <div class="bg-white min-h-[calc(100vh)] rounded-t-xl">
            <ul
                class="flex list-none flex-row justify-center border-b-0 ps-0 px-2 py-2 mb-4 rounded-2xl top-0 z-10 mx-4"
                role="tablist"
            >
                <li role="presentation" class="flex-1">
                    <button
                        :class="[
                            'w-full text-center px-3 py-3 text-md font-semibold transition',
                            game_id === 1
                                ? 'text-black border-b-2 border-[#1D4ED8]'
                                : 'text-neutral-500 border-b-2 border-transparent',
                        ]"
                        @click="
                            game_id = 1;
                            getHistory();
                        "
                    >
                        2D ထီပေါက်စဉ်
                    </button>
                </li>

                <li role="presentation" class="flex-1">
                    <button
                        :class="[
                            'w-full text-center px-3 py-3 text-md font-semibold transition',
                            game_id === 2
                                ? 'text-black border-b-2 border-[#1D4ED8]'
                                : 'text-neutral-500 border-b-2 border-transparent',
                        ]"
                        @click="
                            game_id = 2;
                            getHistory();
                        "
                    >
                        3D ထီပေါက်စဉ်
                    </button>
                </li>
            </ul>

            <div class="mb-6 mx-4">
                <div
                    v-show="game_id === 1"
                    class="opacity-100 transition-opacity duration-150 ease-linear"
                >
                    <div class="mx-0 pb-8">
                        <div
                            v-if="!grouped2d?.length"
                            class="text-center text-black/80 py-10"
                        >
                            No 2D History Found
                        </div>

                        <div
                            v-else
                            v-for="group in grouped2d"
                            :key="group.date"
                        >
                            <div class="flex justify-center mb-4">
                                <div
                                    class="bg-[#0C7A18] text-white px-8 py-2 rounded-xl text-base font-semibold"
                                >
                                    {{ formatDateWithDay(group.date) }}
                                </div>
                            </div>

                            <div class="space-y-4 mb-6">
                                <div
                                    v-for="item in group.items"
                                    :key="item.id"
                                    class="rounded-xl bg-[#D10A0A] text-white shadow-md overflow-hidden"
                                >
                                    <div
                                        class="text-center text-xl font-semibold py-3 border-b border-white/50"
                                    >
                                        {{ formatTime(item.open_time) }}
                                    </div>
                                    <div
                                        class="grid grid-cols-3 text-center py-4"
                                    >
                                        <div>
                                            <p class="text-base font-semibold">
                                                Set
                                            </p>
                                            <p class="mt-2 text-base">
                                                {{ item.set }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-base font-semibold">
                                                Value
                                            </p>
                                            <p class="mt-2 text-base">
                                                {{ item.value }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-base font-semibold">
                                                2D
                                            </p>
                                            <p
                                                class="mt-2 text-lg font-bold text-[#FFC529]"
                                            >
                                                {{ item.twod }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3D History Section -->
                <div
                    v-show="game_id === 2"
                    class="opacity-100 transition-opacity duration-150 ease-linear"
                >
                    <div class="mx-0 pb-8">
                        <table class="table-auto w-full bg-white">
                            <thead>
                                <tr class="bg-[#FFC529] text-white">
                                    <th
                                        class="py-4 text-left font-semibold px-8"
                                    >
                                        Date
                                    </th>
                                    <th class="py-4 font-semibold px-8">3D</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!data?.length">
                                    <td
                                        colspan="2"
                                        class="text-center py-4 px-8"
                                    >
                                        No 3D History Found
                                    </td>
                                </tr>

                                <tr
                                    v-for="num in data"
                                    :key="num.id"
                                    class="border-b !border-gray-300"
                                >
                                    <td class="text-left py-4 px-8">
                                        {{ formatDate(num.date_time) }}
                                    </td>
                                    <td class="text-center py-4 px-8">
                                        {{ num.number }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
            game_id: 1,
            data: null,
        };
    },
    components: {
        Navbar,
    },
    computed: {
        ...mapGetters(["getToken"]),
        grouped2d() {
            if (!this.data?.length) return [];

            let map = new Map();

            for (let item of this.data) {
                let date =
                    item.stock_date || this.formatDate(item.stock_datetime);
                if (!map.has(date)) map.set(date, []);
                map.get(date).push(item);
            }

            return Array.from(map.entries())
                .map(([date, items]) => ({ date, items }))
                .sort((a, b) => (a.date < b.date ? 1 : -1));
        },
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            window.history.back();
        },
        async getHistory() {
            let url = `/api/winning_number_list?game_id=${this.game_id}`;
            let response = await getApiData({
                url: url,
            });
            if (response.data) {
                // this.data = response.data;
                this.data = [
                    {
                        id: 659,
                        history_id: 2435189,
                        stock_datetime: "2026-02-05 12:01:00",
                        stock_date: "2026-02-05",
                        open_time: "12:01:00",
                        day_part: "pm",
                        set: "1338.91",
                        value: "32345.64",
                        twod: "15",
                        created_at: "2026-02-05T05:32:03.000000Z",
                        updated_at: "2026-02-05T17:30:00.000000Z",
                    },
                    {
                        id: 661,
                        history_id: 2436633,
                        stock_datetime: "2026-02-05 16:30:09",
                        stock_date: "2026-02-05",
                        open_time: "16:30:00",
                        day_part: "pm",
                        set: "1346.23",
                        value: "57388.58",
                        twod: "38",
                        created_at: "2026-02-05T10:01:03.000000Z",
                        updated_at: "2026-02-05T17:30:00.000000Z",
                    },
                    {
                        id: 663,
                        history_id: 2437709,
                        stock_datetime: "2026-02-06 12:01:02",
                        stock_date: "2026-02-06",
                        open_time: "12:01:00",
                        day_part: "pm",
                        set: "1356.44",
                        value: "25149.99",
                        twod: "49",
                        created_at: "2026-02-06T05:32:04.000000Z",
                        updated_at: "2026-02-06T17:30:01.000000Z",
                    },
                    {
                        id: 665,
                        history_id: 2439110,
                        stock_datetime: "2026-02-06 16:30:04",
                        stock_date: "2026-02-06",
                        open_time: "16:30:00",
                        day_part: "pm",
                        set: "1354.01",
                        value: "47476.09",
                        twod: "16",
                        created_at: "2026-02-06T10:01:02.000000Z",
                        updated_at: "2026-02-06T17:30:01.000000Z",
                    },
                    {
                        id: 667,
                        history_id: 2440206,
                        stock_datetime: "2026-02-09 12:01:03",
                        stock_date: "2026-02-09",
                        open_time: "12:01:00",
                        day_part: "pm",
                        set: "1398.96",
                        value: "66811.98",
                        twod: "61",
                        created_at: "2026-02-09T05:32:03.000000Z",
                        updated_at: "2026-02-09T17:30:01.000000Z",
                    },
                    {
                        id: 669,
                        history_id: 2441621,
                        stock_datetime: "2026-02-09 16:30:03",
                        stock_date: "2026-02-09",
                        open_time: "16:30:00",
                        day_part: "pm",
                        set: "1400.89",
                        value: "102112.04",
                        twod: "92",
                        created_at: "2026-02-09T10:01:03.000000Z",
                        updated_at: "2026-02-09T17:30:01.000000Z",
                    },
                    {
                        id: 671,
                        history_id: 2442675,
                        stock_datetime: "2026-02-10 12:01:05",
                        stock_date: "2026-02-10",
                        open_time: "12:01:00",
                        day_part: "pm",
                        set: "1405.75",
                        value: "40230.85",
                        twod: "50",
                        created_at: "2026-02-10T08:32:03.000000Z",
                        updated_at: "2026-02-10T17:30:01.000000Z",
                    },
                    {
                        id: 673,
                        history_id: 2444097,
                        stock_datetime: "2026-02-10 16:30:10",
                        stock_date: "2026-02-10",
                        open_time: "16:30:00",
                        day_part: "pm",
                        set: "1410.44",
                        value: "72261.36",
                        twod: "41",
                        created_at: "2026-02-10T10:01:02.000000Z",
                        updated_at: "2026-02-10T17:30:01.000000Z",
                    },
                    {
                        id: 675,
                        history_id: 2445176,
                        stock_datetime: "2026-02-11 12:01:00",
                        stock_date: "2026-02-11",
                        open_time: "12:01:00",
                        day_part: "pm",
                        set: "1,415.04",
                        value: "35,232.30",
                        twod: "42",
                        created_at: "2026-02-11T05:32:06.000000Z",
                        updated_at: "2026-02-11T05:32:06.000000Z",
                    },
                ];
            }
        },
        formatDate(date) {
            return moment(date, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD");
        },
        formatDateWithDay(date) {
            return moment(date, "YYYY-MM-DD").format("YYYY-MM-DD dddd");
        },
        formatTime(time) {
            return moment(time, "HH:mm").format("hh:mm A");
        },
    },
    mounted() {
        this.getHistory();
        initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });
    },
};
</script>
