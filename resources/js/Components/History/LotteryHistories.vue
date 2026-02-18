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
                        <div
                            v-if="!data?.length"
                            class="text-center text-black/80 py-10"
                        >
                            No 3D History Found
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="num in data"
                                :key="num.date_time + '-' + num.number"
                                class="rounded-xl bg-[#0C7A18] text-white shadow-md overflow-hidden"
                            >
                                <div
                                    class="grid grid-cols-3 items-center px-4 py-3 border-b border-white/40"
                                >
                                    <div
                                        class="text-left text-base font-semibold"
                                    >
                                        {{ formatDate(num.date_time) }}
                                    </div>
                                    <div
                                        class="text-center text-xl font-extrabold text-[#FFC529]"
                                    >
                                        {{ num.number }}
                                    </div>
                                    <div
                                        class="text-right text-base font-semibold"
                                    >
                                        {{ formatDayDiff(num.date_time) }}
                                    </div>
                                </div>

                                <div
                                    class="grid grid-cols-2 items-center px-4 py-3"
                                >
                                    <div
                                        class="text-left text-lg font-semibold"
                                    >
                                        တွတ်
                                    </div>
                                    <div
                                        class="text-right text-lg font-semibold"
                                    >
                                        {{ num.number }}
                                    </div>
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
                this.data = response.data;
            }
        },
        formatDate(date) {
            if (!date) return "";

            let d = moment(date, "YYYY-MM-DD HH:mm:ss", true);
            if (!d.isValid()) d = moment(date, "YYYY-MM-DD HH:mm", true);
            if (!d.isValid()) d = moment(date);
            if (!d.isValid()) return "";

            return d.format("YYYY-MM-DD");
        },
        formatDateWithDay(date) {
            return moment(date, "YYYY-MM-DD").format("YYYY-MM-DD dddd");
        },
        formatDayDiff(dateTime) {
            if (!dateTime) return "";

            // Extract the day number from the date string
            const date = new Date(dateTime);
            if (isNaN(date.getTime())) return "";

            const day = date.getDate();
            return `${day} ရက်နေ့`;
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
