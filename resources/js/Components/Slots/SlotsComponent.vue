<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 bg-img pb-24 min-h-[100vh]"
        :style="{
            backgroundImage: `url(/icons/bgfour.png)`,
            backgroundRepeat: 'repeat',
        }"
    >
        <div class="mb-20">
            <Navbar title="Games" :back-btn="backBtn"></Navbar>
        </div>

        <div class="mb-4">
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
            <ul
                class="flex items-center justify-start overflow-auto w-full mb-1 hidden-scrollbar py-8"
                role="tablist"
                data-twe-nav-ref
            >
                <li
                    v-for="(type, index) in gameTypes"
                    :key="index"
                    class="tab-list-item"
                    :class="type == selectedGameType ? 'active-tabs' : ''"
                >
                    <a
                        @click="
                            selectedGameType = type;
                            getProviders();
                        "
                        class="tab-list-item-text"
                    >
                        {{ type.name }}
                    </a>
                </li>
            </ul>

            <!-- <ul
                class="mb-0 flex gap-x-3 list-none flex-row flex-wrap border-b-0"
                role="tablist"
                data-twe-nav-ref
            >
                <li v-for="(type, index) in gameTypes" :key="index">
                    <a
                        @click="
                            selectedGameType = type;
                            getProviders();
                        "
                        :class="
                            type?.name == selectedGameType?.name
                                ? 'text-md'
                                : 'text-xs'
                        "
                        class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent text-white font-normal uppercase leading-tight hover:isolate hover:border-transparent focus:isolate focus:border-transparent data-[twe-nav-active]:border-none data-[twe-nav-active]:text-white data-[twe-nav-active]:font-semibold"
                        >{{ type.name }}</a
                    >
                </li>
            </ul> -->

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
                                class="w-full grid grid-cols-3 gap-x-4 gap-y-6"
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
                                                image: providerLocalImage(
                                                    product,
                                                ),
                                            },
                                        )}&game_type=${JSON.stringify({
                                            id: selectedGameType.id,
                                            name: selectedGameType.name,
                                        })}`"
                                        class="block"
                                    >
                                        <div
                                            :class="[
                                                'w-full aspect-square rounded-xl p-3 flex items-center justify-center overflow-hidden shadow-sm',
                                                providerLogoNeedsDarkBackground(
                                                    product,
                                                )
                                                    ? 'bg-[#101828]'
                                                    : 'bg-[radial-gradient(circle_at_top,_#FFFDF8_0%,_#FFF2DA_54%,_#E9CF92_100%)] shadow-[inset_0_1px_0_rgba(255,255,255,0.55)]',
                                            ]"
                                        >
                                            <img
                                                class="h-full w-full object-contain"
                                                :src="
                                                    providerLocalImage(product)
                                                "
                                                :alt="product.name"
                                            />
                                        </div>
                                        <p
                                            class="text-white text-center pt-2 text-md leading-tight truncate"
                                        >
                                            {{ product.name }}
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
import {
    getProviderLocalImage,
    providerLogoNeedsDarkBackground as shouldUseDarkProviderLogoBackground,
} from "../../utilities/provider-logos";
import Navbar from "../Nav/Navbar.vue";
import { mapGetters } from "vuex";
import moment from "moment";
import CheckAuthMixin from "../../mixins/CheckAuthMixin";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            gameTypes: [],
            selectedGameType: "",
            selectedProvider: "",
            providers: [],
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
        async getGameTypes() {
            let url = `/api/gameType`;

            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.gameTypes = response.data;
            this.selectedGameType = response.data[0];
            this.getProviders();
            console.log(response.data);
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
        providerLocalImage(product) {
            return getProviderLocalImage(product);
        },
        providerLogoNeedsDarkBackground(product) {
            return shouldUseDarkProviderLogoBackground(product);
        },
    },
    mounted() {
        this.getGameTypes();
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
<style lang=""></style>
