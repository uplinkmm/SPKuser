<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto pb-24 min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="bg-black px-4">
            <Navbar
                :title="`${this.selectedGameType?.name} - ${this.selectedProvider?.name}`"
                :back-btn="backBtn"
            ></Navbar>
        </div>
        <LoadingProgressBar :loading="loading"></LoadingProgressBar>
        <div class="mt-4 px-4">
            <div class="mb-6">
                <div
                    class="transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-home"
                    role="tabpanel"
                    aria-labelledby="tabs-home-tab"
                    data-twe-tab-active
                >
                    <div class="mb-4">
                        <p class="text-white text-lg font-semibold mb-2">
                            {{ selectedProvider?.name }}
                        </p>

                        <div class="rounded-2xl overflow-hidden bg-black/30">
                            <img
                                v-if="selectedProvider?.image"
                                :src="selectedProvider.image"
                                alt=""
                                class="w-full h-[140px] object-cover"
                            />
                            <div
                                v-else
                                class="w-full h-[140px] bg-black/40"
                            ></div>
                        </div>

                        <div class="mt-4 relative">
                            <input
                                v-model="search_input"
                                @input="onSearchInput"
                                type="text"
                                placeholder="ရှာမည်"
                                class="w-full bg-[#d9d9d9] text-black placeholder-gray-600 rounded-2xl px-5 py-4 pr-14 border border-black/30 focus:outline-none focus:ring-0"
                            />
                            <div
                                class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="w-10 h-10 text-blue-600"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m21 21-4.3-4.3m1.3-5.2a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

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
import LoadingProgressBar from "../Common/LoadingProgressBar.vue";

export default {
    components: {
        Navbar,
        LoadingProgressBar,
    },
    data() {
        return {
            slots: [],
            selectedGameType: "",
            selectedProvider: "",
            loading: false,
            search_input: "",
            _searchTimeoutId: null,
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
            if (this.search_input) {
                url += `?search_input=${encodeURIComponent(this.search_input)}`;
            }
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.slots = response.data;
        },
        onSearchInput() {
            if (this._searchTimeoutId) {
                clearTimeout(this._searchTimeoutId);
            }
            this._searchTimeoutId = setTimeout(() => {
                this.getGameLists();
            }, 400);
        },
        delay(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        },
        async getGameUrl(game) {
            this.loading = true;
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
            this.loading = false;
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
