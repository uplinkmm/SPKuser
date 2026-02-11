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
            <Navbar title="ထီပေါက်သူ" :back-btn="backBtn"></Navbar>
        </div>

        <div class="mt-4 pb-14">
            <div
                class="bg-[#FFC529] rounded-t-3xl shadow-lg px-4 pt-4 pb-6 min-h-[calc(100vh-100px)]"
            >
                <p class="text-center text-xl font-bold mb-4">ထီပေါက်သူ</p>

                <div class="flex w-full rounded-xl bg-transparent pb-2 mb-2">
                    <button
                        type="button"
                        class="my-1 block px-2 pb-2 font-semibold pt-3 text-md underline-border relative"
                        :class="
                            game_id == 1
                                ? 'after:!block text-black'
                                : 'text-gray-500'
                        "
                        @click="changeGame(1)"
                    >
                        2D ပေါက်သူများ
                    </button>
                    <button
                        type="button"
                        class="my-1 block px-2 pb-2 font-semibold pt-3 text-md underline-border relative"
                        :class="
                            game_id == 2
                                ? 'after:!block text-black'
                                : 'text-gray-500'
                        "
                        @click="changeGame(2)"
                    >
                        3D ပေါက်သူများ
                    </button>
                </div>

                <div class="rounded-2xl bg-[#C58A1F] px-3 pt-3 pb-4">
                    <div
                        class="rounded-xl bg-white border-2 border-gray-700 overflow-hidden"
                    >
                        <table class="table-auto w-full">
                            <thead class="bg-[#F4F4F4] text-black">
                                <tr>
                                    <th class="py-3">No</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3">Wining No</th>
                                    <th class="py-3">Phone</th>
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
                                        {{ winner.number }}
                                    </td>
                                    <td class="text-center text-sm py-3">
                                        {{ winner.phone_number }}
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
            game_id: "",
            winner_last_page: 0,
            winner_page: 1,
            winners: [],
            showSpinner: false,
        };
    },
    components: {
        Navbar,
    },
    props: {
        gameType: {},
    },
    computed: {
        ...mapGetters(["getToken"]),
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            window.history.back();
        },
        async getBetWinners() {
            this.showSpinner = true;
            let response = await getApiData({
                url: `/api/winning_list?game_id=${this.game_id}&page=${this.winner_page}`,
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
        dateFormat(date_time) {
            return moment(date_time).format("YYYY-MM-DD hh:mm A");
        },
        changeGame(id) {
            this.game_id = id;
            this.winners = [];
            this.winner_page = 1;
            this.winner_last_page = 0;
            this.getBetWinners();
        },
    },

    mounted() {
        this.game_id = this.gameType;
        this.getBetWinners();
        window.addEventListener("scroll", this.handleScroll);
        initTWE({ Collapse, Carousel, Modal, Ripple, Dropdown, Input, Tab });
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
};
</script>
