<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 bg-img pb-24 min-h-[100vh]"
    >
        <Navbar title="Games" :back-btn="backBtn"></Navbar>

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
                                        <p
                                            class="text-white text-center pt-1 text-sm"
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
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.providers = response.data;
            this.selectedProvider = response.data.game_type.products[0];
        },
    },
    mounted() {
        this.getGameTypes();
        initTWE({ Modal, Ripple, Dropdown });
    },
};
</script>
<style lang=""></style>
