<template>
    <notifications position="top center" />

    <div
        class="frame-container min-h-[100vh]"
    >
        <Navbar title="ထီပေါက်သူ" :back-btn="backBtn"></Navbar>

        <div
            class="flex w-full rounded-xl bg-transparent pt-4 pb-2 px-4 mb-4"
        >
            <p
                class="font-semibold px-1 mr-4 hover:isolate focus:isolate cursor-pointer text-lg"
                :class="game_id == 1 ? 'text-white border-b border-gray-700' : ' text-gray-500'"
                @click="changeGame(1)"
            >
                2D
            </p>
            <p
                class="font-semibold px-1 mr-4 hover:isolate focus:isolate cursor-pointer text-lg"
                :class="game_id == 2 ? 'text-white border-b border-gray-700' : ' text-gray-500'"
                @click="changeGame(2)"
            >
                3D
            </p>
        </div>
        <div class="mb-0">
            <table class="table-auto w-full bg-white">
                <thead class="w-full">
                    <tr class="w-full rounded-xl border-b bg-white">
                        <th class="py-3 px-1 rounded-tl-lg rounded-bl-lg text-sm">No</th>
                        <th class="py-3 px-1 text-sm">Name</th>
                        <th class="py-3 px-1 text-sm">Wining No</th>
                        <th class="py-3 px-1 text-sm">Phone Number</th>
                        <th class="py-3 px-1 rounded-tr-lg rounded-br-lg text-smx`">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="w-fulll "
                        v-for="(winner, index) in winners"
                        :key="index"
                    >
                        <td class="py-3 text-center text-sm rounded-tl-lg rounded-bl-lg !border-gray-300">{{ ++index }}</td>
                        <td class="py-3 text-center text-sm">{{ winner.name }}</td>
                        <td class="py-3 text-center text-sm">{{ winner.number }}</td>
                        <td class="py-3 text-center text-sm">
                            {{ winner.phone_number }}
                        </td>
                        <td class="py-3 text-center text-sm rounded-tr-lg rounded-br-lg">
                            {{ winner.total_amount?.toLocaleString() }}
                        </td>
                    </tr>
                </tbody>
            </table>
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
