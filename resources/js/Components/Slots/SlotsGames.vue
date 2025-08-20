<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 bg-img pb-24 min-h-[100vh]"
    >
        <Navbar
            :title="`${this.selectedGameType?.name} - ${this.selectedProvider?.name}`"
            :back-btn="backBtn"
        ></Navbar>

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
                                    v-for="(item, index) in slots"
                                    :key="index"
                                    class="relative"
                                >
                                    <a
                                        @click="getGameUrl(item)"
                                        class="cursor-pointer"
                                    >
                                        <img
                                            class="w-full aspect-[3/2] rounded-lg"
                                            :src="item.image_url"
                                            alt=""
                                        />
                                        <p
                                            class="text-white text-center pt-1 text-sm"
                                        >
                                            {{ item.name }}
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

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            slots: [],
            selectedGameType: "",
            selectedProvider: "",
        };
    },
    computed: {
        ...mapGetters(["getToken"]),
    },
    mixins: [CheckAuthMixin],

    methods: {
        backBtn() {
            window.history.back();
        },
        async getGameLists() {
            this.slots = [];
            let url = `/api/game/gamelist/${this.selectedProvider.id}/${this.selectedGameType.id}`;
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.slots = response.data;
        },
        delay(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
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
        const params = new URLSearchParams(window.location.search);
        console.log("provider", params.get("provider"));
        this.selectedProvider = JSON.parse(params.get("provider"));
        this.selectedGameType = JSON.parse(params.get("game_type"));
        this.getGameLists();
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
<style lang=""></style>
