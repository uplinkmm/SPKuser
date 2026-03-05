<template lang="">
    <notifications position="top center" />

    <div
        class="bg-black w-full sm:w-3/12 sm:min-w-[480px] mx-auto pb-24 min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4 mb-20">
            <Navbar title="Buffalo Rooms" :back-btn="backBtn"></Navbar>
        </div>
        <LoadingProgressBar :loading="loading"></LoadingProgressBar>
        <div
            class="mt-4 pt-4 px-4 bg-[#FFC529] rounded-t-3xl min-h-[calc(100vh-10px)]"
        >
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
                            <div v-if="selectedRoom" class="mb-4">
                                <button
                                    @click="selectedRoom = null"
                                    class="text-black font-semibold text-lg"
                                >
                                    ← Back to Rooms
                                </button>
                            </div>
                            <div
                                class="w-full grid grid-cols-2 gap-x-4 gap-y-6"
                            >
                                <template v-if="!selectedRoom">
                                    <div
                                        v-for="(room, index) in rooms"
                                        :key="index"
                                        class="relative"
                                    >
                                        <a
                                            @click="selectRoom(room)"
                                            class="cursor-pointer block"
                                            :class="{
                                                'pointer-events-none opacity-60':
                                                    !checkAvailableRooms(
                                                        room.room_id,
                                                    ),
                                            }"
                                        >
                                            <img
                                                class="w-full aspect-square rounded-2xl object-cover"
                                                :src="
                                                    '/img/buffalo/' + room.image
                                                "
                                                alt=""
                                            />
                                            <p
                                                class="text-black font-semibold text-center pt-2 text-lg leading-tight truncate"
                                            >
                                                {{ room.name }}
                                            </p>
                                        </a>
                                        <div
                                            v-if="
                                                !checkAvailableRooms(
                                                    room.room_id,
                                                )
                                            "
                                            class="absolute inset-0 bg-black/60 rounded-2xl flex items-center justify-center"
                                        >
                                            <span
                                                class="text-white text-sm font-medium"
                                                >Insufficient Balance</span
                                            >
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div
                                        v-for="item in selectedRoom.games"
                                        :key="item.id"
                                        class="relative"
                                    >
                                        <a
                                            @click="getGameUrl(item)"
                                            class="cursor-pointer block"
                                        >
                                            <img
                                                class="w-full aspect-square rounded-2xl object-cover"
                                                :src="item.image"
                                                alt=""
                                            />
                                            <p
                                                class="text-black font-semibold text-center pt-2 text-lg leading-tight truncate"
                                            >
                                                {{ item.name }}
                                            </p>
                                        </a>
                                    </div>
                                </template>
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
            roomsData: [],
            selectedRoom: null,
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
        selectRoom(room) {
            this.selectedRoom = this.roomsData.find(
                (r) => r.roomId == room.room_id,
            );
        },
        checkAvailableRooms(room_id) {
            //return true false
            let room = this.roomsData.find((room) => {
                return room.roomId == room_id;
            });
            if (!room) return false; // room not found, assume not available
            return room.room_info.min_bet <= this.current_balance;
        },
        async getGameUrl(game) {
            console.log(game.id);
            this.loading = true;
            let url = `/api/buffalo/launch-game`;
            let formData = new FormData();
            // formData.append("type_id", API_CONFIG.BUFFALO_TYPE_ID);
            // formData.append("provider_id", API_CONFIG.BUFFALO_PROVIDER_ID);
            // formData.append("game_id", API_CONFIG.BUFFALO_GAME_ID);
            formData.append("room_id", this.selectedRoom.roomId);
            formData.append("type_id", BUFFALO_TYPE_ID);
            formData.append("provider_id", BUFFALO_PROVIDER_ID);
            formData.append("game_id", game.gameId);

            let response = await postApiDataSlot({
                url: url,
                form_data: {
                    room_id: this.selectedRoom.roomId,
                    type_id: BUFFALO_TYPE_ID,
                    provider_id: BUFFALO_PROVIDER_ID,
                    game_id: game.gameId,
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

        this.loading = true;
        getApiData({
            url: "/api/buffalo/providers/grouped-by-room",
            token: this.getToken,
        })
            .then((response) => {
                this.loading = false;
                if (response.status == 200 && response.data.code == 1) {
                    this.roomsData = response.data.data.rooms;
                } else {
                    this.$notify({
                        text: response.data?.msg || "Failed to load rooms",
                        type: "error",
                    });
                }
            })
            .catch((error) => {
                this.loading = false;
                this.$notify({
                    text: "Network error",
                    type: "error",
                });
            });
    },
};
</script>
