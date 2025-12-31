<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 bg-img pb-24 min-h-[100vh]"
    >
        <Navbar title="Buffalo Rooms" :back-btn="backBtn"></Navbar>

        <div class="">
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
                                        class="cursor-pointer"
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
                                            {{
                                                checkAvailableRooms(
                                                    room.room_id
                                                )
                                                    ? ""
                                                    : "(Not Available)"
                                            }}
                                        </p>
                                    </a>
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
import { ROOM_CONFIG } from "../../utilities/common";
export default {
    components: {
        Navbar,
    },
    data() {
        return {
            rooms: ROOM_CONFIG,
            current_balance: 400,
        };
    },
    computed: {
        ...mapGetters(["getToken"]),
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
            let url = `/api/operators/launch_game`;
            let formData = new FormData();
            formData.append("product_code", game.product_code);
            formData.append("game_type", game.game_type);
            formData.append("game_code", game.code);

            let response = await postApiDataSlot({
                url: url,
                form_data: formData,
                token: this.getToken,
            });
            if (response.status == 200) {
                this.$notify({
                    text: "Loading....",
                    type: "info",
                });
                window.location.href = response.data.url;
            } else {
                this.$notify({
                    text: "Something went wrong.Try again!",
                    type: "error",
                });
            }
        },
    },
    mounted() {
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
<style lang=""></style>
