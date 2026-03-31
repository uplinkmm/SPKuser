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
                            <div class="w-full">
                                <div
                                    v-if="!selectedRoom"
                                    class="grid grid-cols-2 gap-x-4 gap-y-6"
                                >
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
                                                    '/img/buffalo/' +
                                                    getRoomImage(room.room_id)
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
                                                >{{
                                                    getRoomUnavailableMessage(
                                                        room.room_id,
                                                    )
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                                <template v-else>
                                    <div
                                        class="w-full grid grid-cols-3 gap-x-4 gap-y-6"
                                    >
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
                                                    :src="
                                                        '../../../img/buffalo/' +
                                                        getRoomImage(
                                                            selectedRoom.roomId,
                                                        )
                                                    "
                                                    alt=""
                                                />
                                                <p
                                                    class="text-white text-left pt-2 text-md leading-tight truncate"
                                                >
                                                    {{ item.name }}
                                                </p>
                                            </a>
                                        </div>
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
            if (this.selectedRoom) {
                this.selectedRoom = null;
            } else {
                window.history.back();
            }
        },
        delay(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        },
        selectRoom(room) {
            this.selectedRoom = this.roomsData.find(
                (r) => r.roomId == room.room_id,
            );
        },
        getRoomImage(roomId) {
            const map = {
                1: "50-200x200.png",
                2: "500-200x200.png",
                3: "5000-200x200.png",
                4: "10000-200x200.png",
            };
            return map[roomId] || "50-200x200.png";
        },
        checkAvailableRooms(room_id) {
            return this.getRoomAvailabilityStatus(room_id) === "available";
        },
        getRoomAvailabilityStatus(room_id) {
            let room = this.roomsData.find((room) => {
                return room.roomId == room_id;
            });
            if (!room) return "missing";

            return room.room_info.min_bet <= this.current_balance
                ? "available"
                : "insufficient_balance";
        },
        getRoomUnavailableMessage(room_id) {
            return this.getRoomAvailabilityStatus(room_id) === "missing"
                ? "Room not available"
                : "Insufficient Balance";
        },
        async getGameUrl(game) {
            console.log(game.id);
            this.loading = true;
            let url = `/api/buffalo/launch-game`;
            let formData = new FormData();
            formData.append("room_id", this.selectedRoom.roomId);
            formData.append("provider_id", game.id);
            formData.append("type_id", BUFFALO_TYPE_ID);
            formData.append("game_id", game.gameId);

            let response = await postApiDataSlot({
                url: url,
                form_data: {
                    room_id: this.selectedRoom.roomId,
                    type_id: BUFFALO_TYPE_ID,
                    provider_id: game.id,
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
        this.current_balance = this.userBalance.game_money_balance;
        initTWE({ Modal, Ripple, Dropdown });
        this.loading = true;
        getApiData({
            url: "/api/buffalo/providers/grouped-by-room",
            token: this.getToken,
        })
            .then((response) => {
                this.loading = false;
                console.log("groud", response.data);
                if (response.data) {
                    this.roomsData = response.data.rooms;
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
        // For testing, set static data
        // this.roomsData = [
        //     {
        //         roomId: 1,
        //         room_info: {
        //             min_bet: 50,
        //             name: "African Buffalo (50)",
        //             level: "Low",
        //         },
        //         games: [
        //             {
        //                 id: 1,
        //                 name: "African Buffalo (50)",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/50",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 23,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 5,
        //                 name: "African Buffalo Scatter (50)",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/50",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 42,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: true,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 15,
        //                 name: "Grand Dragons",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/gd",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 119,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 7,
        //                 name: "Fortune Cat",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/FC",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 122,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 8,
        //                 name: "Autumn Moon",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/AM",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 123,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 9,
        //                 name: "Golden Century",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/GC",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 124,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 10,
        //                 name: "Autumn Moon 88",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/am",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 125,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 11,
        //                 name: "Golden Century 88",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/gc&",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 126,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 12,
        //                 name: "LuxuryLine Buffalo",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/llb",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 128,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 13,
        //                 name: "Peace LongLife",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/pll",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 134,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 14,
        //                 name: "Happy Prosperous",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/hp",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 158,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 16,
        //                 name: "African Buffalo Megaways",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/mg",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 204,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //         ],
        //     },
        //     {
        //         roomId: 2,
        //         room_info: {
        //             min_bet: 500,
        //             name: "African Buffalo (500)",
        //             level: "Medium",
        //         },
        //         games: [
        //             {
        //                 id: 2,
        //                 name: "African Buffalo (500)",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/50",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 23,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //             {
        //                 id: 6,
        //                 name: "African Buffalo Scatter (500)",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/50",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 42,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: true,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //         ],
        //     },
        //     {
        //         roomId: 3,
        //         room_info: {
        //             min_bet: 5000,
        //             name: "African Buffalo (5000)",
        //             level: "High",
        //         },
        //         games: [
        //             {
        //                 id: 3,
        //                 name: "African Buffalo (5000)",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/50",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 23,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //         ],
        //     },
        //     {
        //         roomId: 4,
        //         room_info: {
        //             min_bet: 10000,
        //             name: "African Buffalo (10000)",
        //             level: "VIP",
        //         },
        //         games: [
        //             {
        //                 id: 4,
        //                 name: "African Buffalo (10000)",
        //                 image: "https://buffalo-555.s3.ap-southeast-1.amazonaws.com/50",
        //                 type: "slot",
        //                 provider: "African Buffalo",
        //                 gameId: 23,
        //                 jackpot: true,
        //                 rtp: 95,
        //                 BuyFreeSpin: false,
        //                 transfer_wallet: true,
        //                 seamless: true,
        //             },
        //         ],
        //     },
        // ];
    },
};
</script>
