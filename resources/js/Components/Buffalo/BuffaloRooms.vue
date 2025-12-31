<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 bg-img pb-24 min-h-[100vh]"
    >
        <Navbar title="Buffalo Rooms" :back-btn="backBtn"></Navbar>
        <LoadingProgressBar :loading="loading"></LoadingProgressBar>
        <div class="mt-4">
            <div class="mb-6">
                <div
                    class="transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-home"
                    role="tabpanel"
                    aria-labelledby="tabs-home-tab"
                    data-twe-tab-active
                >
                    <div class="mb-8">
                        <div class="w-full">
                            <div
                                class="w-full grid grid-cols-2 gap-x-4 lg:gap-x-6 gap-y-4"
                            >
                                <div
                                    v-for="(room, index) in rooms"
                                    :key="index"
                                    class="relative"
                                >
                                    <a
                                        @click="getGameUrl(room)"
                                        class="cursor-pointer block"
                                        :class="{
                                            'pointer-events-none opacity-60':
                                                !checkAvailableRooms(
                                                    room.room_id
                                                ),
                                        }"
                                    >
                                        <img
                                            class="w-full aspect-[3/2] rounded-lg"
                                            :src="'/img/buffalo/' + room.image"
                                            alt=""
                                        />
                                        <p
                                            class="text-white text-center pt-1 text-sm"
                                        >
                                            {{ room.name }}
                                        </p>
                                    </a>
                                    <div
                                        v-if="
                                            !checkAvailableRooms(room.room_id)
                                        "
                                        class="absolute inset-0 bg-black/60 rounded-lg flex items-center justify-center"
                                    >
                                        <span
                                            class="text-white text-sm font-medium"
                                            >Insufficient Balance</span
                                        >
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
import { Modal, Ripple, Dropdown, initTWE } from "tw-elements";
import {
    postApiData,
    getApiData,
    postApiDataSlot,
} from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";
import { mapGetters } from "vuex";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";
import {
    ROOM_CONFIG,
    BUFFALO_GAME_ID,
    BUFFALO_PROVIDER_ID,
    BUFFALO_TYPE_ID,
} from "../../utilities/common";
import LoadingProgressBar from "../Common/LoadingProgressBar.vue";

export default {
    components: {
        Navbar,
        LoadingProgressBar,
    },
    data() {
        return {
            rooms: ROOM_CONFIG,
            current_balance: 0,
            loading: false,
        };
    },
    computed: {
        ...mapGetters(["getToken", "getUser", "userBalance"]),
        available_rooms() {
            return this.rooms.filter((room) => {
                return room.min_bet <= this.current_balance;
            });
        },
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            window.history.back();
        },
        delay(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        },
        checkAvailableRooms(room_id) {
            //return true false
            let room = this.rooms.find((room) => {
                return room.room_id == room_id;
            });
            return room.min_bet <= this.current_balance;
        },
        async getGameUrl(game) {
            console.log(game.room_id);
            this.loading = true;
            let url = `/api/buffalo/launch-game`;
            let formData = new FormData();
            // formData.append("type_id", API_CONFIG.BUFFALO_TYPE_ID);
            // formData.append("provider_id", API_CONFIG.BUFFALO_PROVIDER_ID);
            // formData.append("game_id", API_CONFIG.BUFFALO_GAME_ID);
            formData.append("room_id", game.room_id);
            formData.append("type_id", BUFFALO_TYPE_ID);
            formData.append("provider_id", BUFFALO_PROVIDER_ID);
            formData.append("game_id", BUFFALO_GAME_ID);

            let response = await postApiDataSlot({
                url: url,
                form_data: {
                    room_id: game.room_id,
                    type_id: BUFFALO_TYPE_ID,
                    provider_id: BUFFALO_PROVIDER_ID,
                    game_id: BUFFALO_GAME_ID,
                },
                token: this.getToken,
            });
            this.loading = false;

            if (response.status == 200 && response.data.code != 0) {
                const gameUrl =
                    response.game_url ||
                    response.data?.game_url ||
                    response.Url;

                this.loading = true;
                // console.log("gameUrl", gameUrl);
                window.location.href = gameUrl;
            } else {
                this.$notify({
                    text:
                        response.data.msg || "Something went wrong.Try again!",
                    type: "error",
                });
            }
        },
    },
    mounted() {
        console.log("BUFFALO_PROVIDER_ID", BUFFALO_PROVIDER_ID);
        this.current_balance = this.userBalance.game_money_balance;
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
