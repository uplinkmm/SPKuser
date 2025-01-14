<template lang="">
    <notifications position="top center" />

    <div
        class="w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-8 bg-img pb-24 min-h-[100vh]"
    >
        <Navbar
            :title="`${this.selectedGameType?.name}`"
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
                                            }
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
            let response = await getApiData({
                url: url,
                token: this.getToken,
            });
            this.providers = response.data;
            this.selectedProvider = response.data.game_type.products[0];
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
