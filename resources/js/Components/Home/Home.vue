<template lang="">
    <div class="frame-container min-h-[100vh]">
        <Navbar
            title=""
            :is-home-page="true"
            :hide-back-btn="true"
            :need-auth="false"
        ></Navbar>
        <div class="px-4 mb-16">
            <div class="-mx-3" id="ad_slick">
                <div class="w-full mx-3" v-for="(ads, index) in adses">
                    <img
                        :src="`${img_prefix}${ads.photo}`"
                        class="w-full mb-6"
                    />
                </div>
            </div>
            <div
                class="bg-[#C67D06] mb-6 rounded-2xl shadow-lg flex justify-center flex-col"
            >
                <a v-if="!getUser" href="/login_register">
                    <div
                        class="flex justify-start gap-x-4 w-10/12 mx-auto py-6"
                    >
                        <img
                            class="w-16"
                            src="../../../../public/img/Sign_in_squre_light.svg"
                        />
                        <div class="content-center">
                            <p class="text-white text-lg pb-1 pl-2">
                                Click Here to Login
                            </p>
                            <p class="text-white text-sm pb-0 pl-2">
                                Login ဝင်ရန် နှိပ်ပါ
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="grid grid-cols-2 gap-x-4 gap-y-6 mb-4">
                <a href="/2D_betting"
                    class="bg-[#C67D06] aspect-[1/0.8] rounded-2xl shadow-xl flex justify-center flex-col">
                    <div class="w-fit mx-auto flex">
                        <div>
                            <img
                                class="w-5/12 mb-4 pt-4 lg:pt-0 pl-4" 
                                src="../../../../public/img/2d.png"
                            />
                            <p
                                class="text-white text-xl self-end pb-6 pl-4"
                            >
                                2D ထိုးမည်
                            </p>
                        </div>
                    </div>
                </a>
                <a href="/3D_betting"
                    class="bg-[#fff] aspect-[1/0.8] rounded-2xl shadow-xl flex justify-center flex-col">
                    <div class="w-fit mx-auto flex">
                        <div>
                            <img
                                class="w-5/12 mb-4 pt-4 lg:pt-0 pl-4" 
                                src="../../../../public/img/3D.png"
                            />
                            <p
                                class="text-black text-xl self-end pb-6 pl-4"
                            >
                                3D ထိုးမည်
                            </p>
                        </div>
                    </div>
                </a>

                <div 
                    class="bg-white mb-0 rounded-2xl shadow-lg flex justify-center flex-col col-span-2"
                >
                    <a href="/winner_lists/1">
                        <div
                            class="flex justify-start gap-x-4 w-10/12 mx-auto py-4"
                        >
                            <img
                                class="w-16 my-4"
                                src="../../../../public/img/trophy_9109356.png"
                            />
                            <div class="flex justify-center flex-col">
                                <p class="text-black text-xl pb-0 pl-2 mb-1">
                                    ထီပေါက်သူများ
                                </p>
                                <p class="text-black text-sm pb-0 pl-2">
                                    ထီပေါက်သူများ
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div
                    class="bg-[#C67D06] mb-0 rounded-2xl shadow-lg flex justify-center flex-col col-span-2"
                >
                    <a href="/lottery_history">
                        <div
                            class="flex justify-start gap-x-4 w-10/12 mx-auto py-4"
                        >
                            <img
                                class="w-16 my-4"
                                src="../../../../public/img/numbers.png"
                            />
                            <div class="flex justify-center flex-col">
                                <p
                                    class="text-white text-xl pb-0 pl-2 font-semibold mb-1"
                                >
                                    ထီပေါက်စဉ်များ
                                </p>
                                <p class="text-white text-sm pb-0 pl-2">
                                    ထွက်ခဲ့သော နံပတ်များ
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="px-4 mb-6">
            <div class="flex justify-between px-4 mb-2">
                <p class="text-sm text-white font-bold mb-0"></p>
                <a href="/slots" class="text-xs text-white font-semibold mb-0">
                    See All
                </a>
            </div>

            <div class="">
                <ul class="flex items-center justify-start overflow-auto w-full mb-1 hidden-scrollbar py-8"
                    role="tablist"
                    data-twe-nav-ref>
                    <!-- <li class="tab-list-item-first active-tabs"  v-for="(type, index) in gameTypes" :key="index">
                        <span class="tab-list-item-text">All</span>
                    </li> -->

                    <li v-for="(type, index) in gameTypes" :key="index" class="tab-list-item"
                        :class="
                            type == selectedGameType
                                    ? 'active-tabs'
                                    : ''
                            ">
                        <a
                            @click="
                                selectedGameType = type;
                                getProviders();
                            "
                            class="tab-list-item-text"
                            >{{ type.name }}</a
                        >
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
                            class="my-2 block text-white border-x-0 border-b-2 border-t-0 border-transparent font-normal uppercase leading-tight hover:isolate hover:border-transparent focus:isolate focus:border-transparent data-[twe-nav-active]:border-none data-[twe-nav-active]:text-black data-[twe-nav-active]:font-semibold"
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
                                            <p class="text-white text-center pt-1 text-sm"> {{product.name}}</p>
                                        </a>
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
import { mapGetters } from "vuex/dist/vuex.cjs.js";
import Navbar from "../Nav/Navbar.vue";
import { Modal, Tab, Ripple, initTWE, Input } from "tw-elements";
import {
    getApiData,
    postApiData,
    postApiDataSlot,
} from "../../utilities/ajax-helpers";

export default {
    name: "Home",
    components: {
        Navbar,
    },
    data() {
        return {
            adses: [],
            img_prefix: "",
            twoDList: "",
            intervalId: null,
            slots: [],
            gameTypes: [],
            selectedGameType: "",
            selectedProvider: "",
            providers: [],
        };
    },
    computed: {
        ...mapGetters(["getUser", "getToken"]),
    },
    methods: {
        async getAds() {
            let url = `/api/get_ads`;
            let response = await getApiData({
                url: url,
            });
            if (response.data) {
                this.adses = response.data;
            }
        },
        async get2DList() {
            const response = await getApiData({
                url: "https://admin.2dmyanmarpro.com/api/2d/live",
            });
            if (response.data) {
                this.twoDList = response.data;
            } else {
            }
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
    watch: {
        adses(newVal) {
            if (newVal.length > 0) {
                this.$nextTick(() => {
                    if ($("#ad_slick").length) {
                        $("#ad_slick").slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            dots: false,
                            arrows: false,
                            responsive: [
                                {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: 4,
                                    },
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 3,
                                    },
                                },
                                {
                                    breakpoint: 640,
                                    settings: {
                                        slidesToShow: 3,
                                    },
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                    },
                                },
                            ],
                        });
                    }
                });
            }
        },
    },
    mounted() {
        // this.getGameLists();
        this.getGameTypes();

        if (window.location.href.includes("shweshankan")) {
            this.img_prefix = "https://admin.shweshankan.com";
        } else {
            this.img_prefix = "http://localhost:8001";
        }
        this.getAds();
        // this.intervalId = setInterval(this.get2DList, 3000);

        initTWE({ Modal, Tab, Ripple });
    },
};
</script>
<style lang=""></style>
