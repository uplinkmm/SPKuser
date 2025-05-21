<template>
    <div class="frame-container bg-white min-h-[100vh]">
        <Navbar title="2D" :need-auth="false" :back-btn="backBtn"></Navbar>

        <div class="bg-[#FDC652] flex justify-center mt-2 rounded-lg gap-2 items-center">
            <a
                href="/history?game_id=1"
                class=" text-center p-8"
            >
                <i class="fal fa-file text-3xl pb-1 text-white"></i>
                <p class="text-black">မှတ်တမ်း</p>
            </a>
            <a
                href="/2D_betting"
                class=" text-center p-8"
            >
                <img src="../../../../public/img/billiard_2377303.png" class="w-10" alt="">
                <p class="text-black">ထိုးမည်</p>
            </a>
            <div class=" text-center p-8">
                <a href="/winner_lists/1">
                    <i class="fal fa-users text-3xl pb-1 text-white"></i>
                    <p class="text-black">ထီပေါက်သူ</p>
                </a>
            </div>
        </div>
        <div class="flex justify-center mt-2">
            <p class="text-[96px] w-fit text-green-600 font-semibold">
                {{ twoDList?.twod }}
            </p>
        </div>
        <div class="flex justify-center mt-2 mb-4">
            <p class="text-base text-white">Updated : {{ twoDList?.time }}</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-4 mb-0 lg:mb-4">
            <div
                v-for="(twoD, index) in twoDList.results"
                class="twod-bg text-white px-6 py-4 rounded-md mb-3"
            >
                <div class="text-center">
                    <p class="inline-block pr-2">
                        {{ twoD.open_time }}
                    </p>
                    <span class="inline-block uppercase">
                        {{ twoD.day_part }}
                    </span>
                    <hr class="mt-2 mb-4" />
                </div>
                <div class="grid grid-cols-5">
                    <div class="col-span-2">
                        <p>Set</p>
                        <p v-if="twoD.set == '--'">
                            {{ twoDList.set }}
                        </p>
                        <p v-else>
                            {{ twoD.set }}
                        </p>
                    </div>
                    <div class="col-span-2">
                        <p>Value</p>
                        <p v-if="twoD.value == '--'">
                            {{ twoDList.value }}
                        </p>
                        <p v-else>
                            {{ twoD.value }}
                        </p>
                    </div>
                    <div class="col-span-1">
                        <p>2D</p>
                        <p class="text-[#F6E271] font-semibold">
                            {{ twoD.twod }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mb-4 block lg:hidden" />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-4 mb-0 lg:mb-1">
            <div
                v-for="(twoD, index) in twoDList?.modern_internet?.numbers"
                class="twod-bg text-white px-6 py-4 rounded-md mb-3"
            >
                <div class="text-center">
                    <p class="inline-block pr-2">
                        {{ twoD.time }}
                    </p>
                    <hr class="mt-2 mb-4" />
                </div>
                <div class="grid grid-cols-5">
                    <div class="col-span-3">
                        <p>Morden</p>
                        <p>
                            {{ twoD.Modern }}
                        </p>
                    </div>
                    <div class="col-span-2">
                        <p>Internet</p>
                        <p>
                            {{ twoD.Internet }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div
            class="grid grid-cols-1 lg:grid-cols-[repeat(auto-fit,_31.5%)] justify-center mx-auto gap-x-4"
        >
            <div class="twod-bg text-white px-6 py-4 rounded-md mb-3">
                <div class="grid grid-cols-7">
                    <div class="col-span-2">
                        <p>12:03</p>
                        <p>PM</p>
                    </div>
                    <div class="col-span-2">
                        <p>Modern</p>
                        <p class="text-[#F6E271] font-semibold">25</p>
                    </div>
                    <div class="col-span-2">
                        <p>Internet</p>
                        <p class="text-[#F6E271] font-semibold">25</p>
                    </div>
                    <div class="col-span-1">
                        <p>TW</p>
                        <p class="text-[#F6E271] font-semibold">25</p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</template>

<script>
import { Modal, Ripple, initTWE, Input } from "tw-elements";
import {
    getApiData,
    postApiData,
    deleteApiData,
} from "../../utilities/ajax-helpers";
import Navbar from "../Nav/Navbar.vue";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            twoDList: [],
            // two_d:null,
            intervalId: null,
        };
    },

    methods: {
        // async get2DLive() {
        //     const response = await getApiData({ url: '/api/2d/live' });
        //     if (response.data) {
        //         this.two_d = response.data;
        //     }
        //     console.log('live api called');
        // },
        backBtn() {
            window.history.back();
        },
        async get2DList() {
            const response = await getApiData({
                url: "https://admin.shwepaukkan.com/api/2d/live",
            });
            if (response.data) {
                this.twoDList = response.data;
            } else {
                // console.log("some errors occur");
            }
        },
    },

    created() {
        this.intervalId = setInterval(this.get2DList, 3000);
    },

    mounted() {
        this.get2DList();
        // this.get2DLive();
        initTWE({ Modal, Ripple });
    },

    beforeDestroy() {
        clearInterval(this.intervalId);
    },
};
</script>
