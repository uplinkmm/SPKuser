<template>
    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 bg-img pb-24 min-h-[100vh]"
    >
        <Navbar
            title="History"
            :back-btn="backBtn"
            class="!px-8 !mb-0"
            :need-auth="false"
        ></Navbar>

        <div class="">
            <ul
                class="flex list-none flex-row justify-center flex-wrap border-b-0 ps-0 px-4 py-0 mb-4 bg-transparent sticky top-0 z-10"
                role="tablist"
            >
                <li role="presentation">
                    <button
                        :class="[
                            'my-2 block px-4 pb-3.5 pt-2 text-sm',
                            game_id === 1
                                ? 'text-white border-b-2 border-white'
                                : 'text-neutral-500 ',
                        ]"
                        @click="
                            game_id = 1;
                            getHistory();
                        "
                    >
                        2D
                    </button>
                </li>

                <li role="presentation">
                    <button
                        :class="[
                            'my-2 block px-4 pb-3.5 pt-2 text-sm',
                            game_id === 2
                                ? 'text-white border-b-2 border-white'
                                : 'text-neutral-500 ',
                        ]"
                        @click="
                            game_id = 2;
                            getHistory();
                        "
                    >
                        3D
                    </button>
                </li>
            </ul>

            <div class="mb-6">
                <div
                    v-show="game_id === 1"
                    class="opacity-100 transition-opacity duration-150 ease-linear"
                >
                    <div class="mx-0 pb-8">
                        <div
                           
                            v-for="(list, index) in data" :key="index"
                            class="pb-4 mb-4 bg-white relative group"
                        >
                            <div
                                class="flex justify-start mb-1 bg-[#FDC652] py-4 px-8 text-white"
                            >
                                <p class="text-base font-semibold">
                                    {{ formatDate(list.date_time) }}
                                </p>
                            </div>
                            <div
                                class="border-b last:border-none pb-6 border-gray-300 bg-white"
                            >
                                <div class="px-8 py-2">
                                    <div class="mb-4 pt-2">
                                        <p>{{ formatTime(list.lottery_time) }}</p>
                                    </div>
                                    <div
                                        class="grid grid-cols-3 gap-x-3 gap-y-6"
                                    >
                                        <div>
                                            <p
                                                class="font-semibold text-neutral-600 mb-2"
                                            >
                                                Set
                                            </p>
                                            <p class="text-gray-500">
                                                {{ list.set }}
                                            </p>
                                        </div>
                                        <div>
                                            <p
                                                class="font-semibold text-neutral-600 mb-2"
                                            >
                                                Value
                                            </p>
                                            <p class="text-gray-500">
                                                {{ list.value }}
                                            </p>
                                        </div>
                                        <div>
                                            <p
                                                class="font-semibold text-neutral-600 mb-2"
                                            >
                                                2D
                                            </p>
                                            <p class="text-gray-500">{{ list.two_d }}</p>
                                        </div>

                                        <div>
                                            <p
                                                class="font-semibold text-neutral-600 mb-2"
                                            >
                                                Modern
                                            </p>
                                            <p class="text-gray-500">{{ list.modern }}</p>
                                        </div>
                                        <div>
                                            <p
                                                class="font-semibold text-neutral-600 mb-2"
                                            >
                                                Internet
                                            </p>
                                            <p class="text-gray-500">{{ list.internet }}</p>
                                        </div>
                                        <div>
                                            <p
                                                class="font-semibold text-neutral-600 mb-2"
                                            >
                                                TW
                                            </p>
                                            <p class="text-gray-500">{{ list.tw }}</p>
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
                                <tr class="bg-[#FDC652] text-white">
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
                                    <td colspan="2" class="text-center py-4 px-8">
                                        No 3D History Found
                                    </td>
                                </tr>

                                <tr
                                    v-for="num in data"
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
            game_id: 2,
            data: null,
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
            return moment(date, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD");
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
