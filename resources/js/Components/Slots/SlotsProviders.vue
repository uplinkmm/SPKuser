<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-8 bg-img pb-24 min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="mb-20">
            <Navbar
                :title="`${this.selectedGameType?.name}`"
                :back-btn="backBtn"
            ></Navbar>
        </div>

        <div class="mb-4">
            <p class="text-white text-lg font-semibold mb-2">
                {{ selectedGameType?.name }}
            </p>

            <div class="rounded-2xl overflow-hidden bg-black/30">
                <img
                    src="../../../../public/icons/provider_cover.png"
                    alt=""
                    class="w-full h-[140px] object-cover"
                />
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
                                    v-for="(product, index) in providers
                                        ?.game_type?.products"
                                    :key="index"
                                    class="relative"
                                >
                                    <a
                                        :href="`/slots/game_lists?provider=${JSON.stringify(
                                            {
                                                id: product.id,
                                                name: product.name,
                                                code: product.code,
                                                image: product.pivot.image,
                                            },
                                        )}&game_type=${JSON.stringify({
                                            id: selectedGameType.id,
                                            name: selectedGameType.name,
                                        })}`"
                                        class="cursor-pointer"
                                    >
                                        <img
                                            class="w-full aspect-[3/2] rounded-lg"
                                            :src="product.imgUrl"
                                            alt=""
                                        />
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
            providers: [],
            selectedGameType: "",
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
        async getProviders() {
            let url = `/api/gameTypeProducts/${this.selectedGameType.id}`;
            if (this.search_input) {
                url += `?search_input=${encodeURIComponent(this.search_input)}`;
            }
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.providers = response.data;
            this.selectedProvider = response.data.game_type.products[0];
        },
        onSearchInput() {
            if (this._searchTimeoutId) {
                clearTimeout(this._searchTimeoutId);
            }
            this._searchTimeoutId = setTimeout(() => {
                this.getProviders();
            }, 400);
        },
    },
    mounted() {
        const params = new URLSearchParams(window.location.search);
        this.selectedGameType = JSON.parse(params.get("game_type"));
        this.getProviders();
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
<style lang=""></style>
