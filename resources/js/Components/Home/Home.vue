<template lang="">
    <div class="frame-container min-h-[100vh]">
        <Navbar
            title=""
            :is-home-page="true"
            :hide-back-btn="true"
            :need-auth="false"
        ></Navbar>
        <!-- <div
            class="flex justify-between pl-6 lg:pl-8 pr-8 py-4 shadow-lg rounded-2xl mb-8 bg-white relative">
            <a href="#" class="contents"
                ><div class="flex flex-col justify-end">
                    <p class="text-xl mb-1">Football</p>
                    <p class="text-sm mb-3">ဘောလုံးပွဲများကစားရန်</p>
                </div>
                <div class="flex px-4">
                    <img
                        
                        :key="index"
                        class="w-28 mx-2"
                        :src="`${img_prefix}${ads.photo}`"
                        alt=""
                    />
                </div>
            </a>
        </div> -->
        <div class="px-4 mb-16">
            <!-- <div class="w-full pt-4">
                <a class="contents">
                    <img
                        src="../../../../public/img/home_img.png"
                        class="w-full"
                    />
                </a>
            </div> -->
            <div class="-mx-3" id="ad_slick">
                <div class="w-full mx-3" v-for="(ads, index) in adses">
                    <img
                        :src="`${img_prefix}${ads.photo}`"
                        class="w-full mb-6"
                    />
                </div>
            </div>
            <div
                class="bg-[#C67D06] mb-4 rounded-2xl shadow-lg flex justify-center flex-col"
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
            <div class="grid grid-cols-2 gap-x-4 gap-y-4 mb-4">
                <!-- <a
                    href="/2d"
                    class="background-black rounded-2xl shadow-lg flex justify-center flex-col"
                >
                    <div
                        class="w-full mx-auto flex flex-col justify-between h-full py-16"
                    >
                        <div>
                            <p
                                class="text-white text-xl font-semibold text-center"
                            >
                                {{ twoDList.twod }}
                            </p>
                        </div>
                        <div class="flex justify-between w-full px-[8%]">
                            <div class="text-center">
                                <p class="text-white text-xs">
                                    {{ twoDList.set }}
                                </p>
                                <p class="text-white text-xs">Modern</p>
                            </div>
                            <div class="text-center">
                                <p class="text-white text-xs">
                                    {{ twoDList.value }}
                                </p>
                                <p class="text-white text-xs">Internet</p>
                            </div>
                        </div>
                        <div>
                            <p
                                class="text-white text-lg font-semibold text-center"
                            >
                                2D Live
                            </p>
                        </div>
                    </div>
                </a> -->
                <div class="col-span-2 mb-6">
                    <p class="text-white text-xl">
                        <i class="fas fa-flag primary-text pr-2"></i>
                        Games
                    </p>
                </div>
                <a
                    href="/2D_betting"
                    class="relative block bg-[#DDA33F] rounded-2xl px-4 pb-4"
                >
                    <p class="text-white font-semibold text-xl absolute top-3">
                        2D
                    </p>
                    <img
                        class="w-full aspect-square"
                        src="../../../../public/img/twod_card 1.png"
                    />
                </a>
                <a
                    href="/3D_betting"
                    class="relative block bg-[#DDA33F] rounded-2xl px-4 pb-4"
                >
                    <p class="text-white font-semibold text-xl absolute top-3">
                        3D
                    </p>
                    <img
                        class="w-full aspect-square"
                        src="../../../../public/img/threed_card 1.png"
                    />
                </a>
                <div
                    class="contents"
                    v-for="(type, index) in gameTypes"
                    :key="index"
                >
                    <a
                        :href="`/slots/providers?game_type=${JSON.stringify({
                            id: type.id,
                            name: type.name,
                        })}`"
                        class="relative block bg-[#DDA33F] rounded-2xl px-4 pb-4 w-full aspect-square"
                    >
                        <p
                            class="text-white font-semibold text-xl absolute top-3"
                        >
                            {{ type.name }}
                        </p>
                    </a>
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
        },
    },
    updated() {
        // $("#ad_slick").slick({
        $("#ad_slick").not(".slick-initialized").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: false,
            arrows: false,
            responsive: [
                // {
                //     breakpoint: 1024,
                //     settings: {
                //         slidesToShow: 4,
                //     },
                // },
                // {
                //     breakpoint: 768,
                //     settings: {
                //         slidesToShow: 3,
                //     },
                // },
                // {
                //     breakpoint: 640,
                //     settings: {
                //         slidesToShow: 3,
                //     },
                // },
                // {
                //     breakpoint: 480,
                //     settings: {
                //         slidesToShow: 1,
                //     },
                // },
            ],
        });
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

        // $("#ad_slick").slick({
        //     slidesToShow: 1,
        //     slidesToScroll: 1,
        //     autoplay: true,
        //     autoplaySpeed: 2000,
        //     dots: false,
        //     arrows: false,
        //     responsive: [
        //         // {
        //         //     breakpoint: 1024,
        //         //     settings: {
        //         //         slidesToShow: 4,
        //         //     },
        //         // },
        //         // {
        //         //     breakpoint: 768,
        //         //     settings: {
        //         //         slidesToShow: 3,
        //         //     },
        //         // },
        //         // {
        //         //     breakpoint: 640,
        //         //     settings: {
        //         //         slidesToShow: 3,
        //         //     },
        //         // },
        //         // {
        //         //     breakpoint: 480,
        //         //     settings: {
        //         //         slidesToShow: 1,
        //         //     },
        //         // },
        //     ],
        // });

        $("#twoD_carousel").slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: false,
            arrows: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        $("#threeD_carousel").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: false,
            arrows: false,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    },
};
</script>
<style lang=""></style>
