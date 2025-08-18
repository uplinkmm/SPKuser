<template>
    <div class="w-full lg:w-7/12 mx-auto px-4 bg-white pb-20 min-h-[100vh]">
        <div class="flex justify-between py-4 mb-4">
            <button>
                <a href="/home">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p class="text-black text-base">3D Analysis</p>
            <div class="flex gap-x-4">
                <button>
                    <i class="fal fa-search"></i>
                </button>
                <button>
                    <i class="fal fa-bell"></i>
                </button>
            </div>
        </div>

        <!--Tabs navigation-->
        <!-- <ul class="mb-5 flex list-none flex-row flex-wrap justify-center border-b-0 ps-0" role="tablist"
            data-twe-nav-ref>
            <li role="presentation">
                <a href="#tabs-one" class="my-2 block rounded-full border-0 px-5 pb-2.5 pt-2.5 text-xs font-medium leading-tight text-neutral-500
                    hover:isolate hover:threed-bg hover:text-white focus:isolate"
                    :class="active_tab == '1w' ? 'threed-bg text-white' : 'bg-white text-neutral-500'"
                    @click="get2DList('1w')">
                    တစ်ပတ်
                </a>
            </li>
            <li role="presentation">
                <a href="#tabs-two" class="my-2 block rounded-full border-0 px-5 pb-2.5 pt-2.5 text-xs font-medium leading-tight text-neutral-500
                    hover:isolate hover:threed-bg hover:text-white focus:isolate"
                    :class="active_tab == '1m' ? 'threed-bg text-white' : 'bg-white text-neutral-500'"
                    @click="get2DList('1m')">
                    တစ်လ
                </a>
            </li>
            <li role="presentation">
                <a href="#tabs-three" class="my-2 block rounded-full border-0 px-5 pb-2.5 pt-2.5 text-xs font-medium leading-tight text-neutral-500
                    hover:isolate hover:threed-bg hover:text-white focus:isolate"
                    :class="active_tab == '2m' ? 'threed-bg text-white' : 'bg-white text-neutral-500'"
                    @click="get2DList('2m')">
                    နှစ်လ
                </a>
            </li>
        </ul> -->

        <!--Tabs content-->
        <div class="mb-6">
            <div
                class="opacity-100 transition-opacity duration-150 ease-linear block"
            >
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table
                                class="min-w-full text-left text-sm font-light text-surface"
                            >
                                <thead
                                    class="border-b border-neutral-200 font-medium bg-[#fff] text-black"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-2 md:px-6 py-4 border-none text-xs lg:text-sm"
                                        >
                                            Date
                                        </th>
                                        <th
                                            scope="col"
                                            v-for="(count, index) in numCount"
                                            :key="index"
                                            class="px-2 py-4 border-none text-xs lg:text-sm"
                                        >
                                            <p class="relative">
                                                {{ index }}
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(threeD, index) in threeDList"
                                        :key="index"
                                        class="border-b border-neutral-200 text-xs lg:text-sm"
                                    >
                                        <td
                                            class="whitespace-nowrap px-2 md:px-6 py-4 font-medium"
                                        >
                                            {{ threeD.open_date }}
                                        </td>

                                        <td
                                            class="py-4"
                                            v-for="(count, index) in numCount"
                                            :key="index"
                                        >
                                            <div
                                                class="rounded-full w-fit px-1 lg:px-2 relative"
                                                :class="
                                                    threeD.threed_numbers[0] ==
                                                        index ||
                                                    threeD.threed_numbers[1] ==
                                                        index ||
                                                    threeD.threed_numbers[2] ==
                                                        index
                                                        ? 'threed-bg text-white'
                                                        : 'bg-transparent text-black'
                                                "
                                            >
                                                {{ index }}
                                                <span
                                                    class="absolute -top-3 -right-2 bg-red-600 text-white rounded-full px-1.5 text-xs"
                                                    v-show="
                                                        (threeD
                                                            .threed_numbers[0] ==
                                                            index &&
                                                            threeD
                                                                .threed_numbers[1] ==
                                                                index) ||
                                                        (threeD
                                                            .threed_numbers[1] ==
                                                            index &&
                                                            threeD
                                                                .threed_numbers[2] ==
                                                                index) ||
                                                        (threeD
                                                            .threed_numbers[0] ==
                                                            index &&
                                                            threeD
                                                                .threed_numbers[2] ==
                                                                index)
                                                    "
                                                >
                                                    {{
                                                        threeD
                                                            .threed_numbers[0] ==
                                                            index &&
                                                        threeD
                                                            .threed_numbers[1] ==
                                                            index &&
                                                        threeD
                                                            .threed_numbers[2] ==
                                                            index
                                                            ? "3"
                                                            : "2"
                                                    }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal, Tab, Ripple, initTWE, Input } from "tw-elements";
import {
    getApiData,
    postApiData,
    deleteApiData,
} from "../../utilities/ajax-helpers";

export default {
    data() {
        return {
            threeDList: [],
            numCount: [],
            active_tab: null,
        };
    },

    methods: {
        // async get2DList(range) {
        //     this.active_tab = range;
        //     let url = '/api/2d/analysis?range=' + range;
        //     const response = await getApiData({ url: url });
        //     if (response.data) {
        //         this.twoDList = response.data.results;
        //         this.numCount = response.data.frequencies;
        //     }
        //     else {
        //         console.log('some errors occur');
        //     }
        // }
        async get3DList() {
            let url = "http://128.199.218.198:83/api/3d/analysis";
            const response = await getApiData({ url: url });
            if (response.data) {
                this.threeDList = response.data.results;
                this.numCount = response.data.frequencies;
            } else {
            }
        },
    },

    mounted() {
        this.get3DList();
        initTWE({ Modal, Tab, Ripple });
    },
};
</script>
