<template>
    <div class="w-full lg:w-7/12 mx-auto px-4 bg-white pb-8 min-h-[100vh]">
        <div class="flex justify-between py-4 px-0 lg:px-4 mb-4">
            <button>
                <a href="/home">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p class="text-black text-base">Analysis</p>
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
        <ul
            class="mb-5 flex list-none flex-row gap-x-3 flex-wrap justify-center border-b-0 ps-0"
            role="tablist"
            data-twe-nav-ref
        >
            <li role="presentation">
                <a
                    href="#tabs-one"
                    class="my-2 block rounded-full border-0 px-5 pb-2.5 pt-2.5 text-xs font-semibold leading-tight text-neutral-500 hover:isolate hover-twod hover:text-white focus:isolate"
                    :class="
                        active_tab == '1w'
                            ? 'twod-bg text-white'
                            : 'bg-white text-neutral-500'
                    "
                    @click="get2DList('1w')"
                >
                    တစ်ပတ်
                </a>
            </li>
            <li role="presentation">
                <a
                    href="#tabs-two"
                    class="my-2 block rounded-full border-0 px-5 pb-2.5 pt-2.5 text-xs font-semibold leading-tight text-neutral-500 hover:isolate hover-twod hover:text-white focus:isolate"
                    :class="
                        active_tab == '1m'
                            ? 'twod-bg text-white'
                            : 'bg-white text-neutral-500'
                    "
                    @click="get2DList('1m')"
                >
                    တစ်လ
                </a>
            </li>
            <li role="presentation">
                <a
                    href="#tabs-three"
                    class="my-2 block rounded-full border-0 px-5 pb-2.5 pt-2.5 text-xs font-semibold leading-tight text-neutral-500 hover:isolate hover-twod hover:text-white focus:isolate"
                    :class="
                        active_tab == '2m'
                            ? 'twod-bg text-white'
                            : 'bg-white text-neutral-500'
                    "
                    @click="get2DList('2m')"
                >
                    နှစ်လ
                </a>
            </li>
            <li role="presentation">
                <a
                    href="#tabs-three"
                    class="my-2 block rounded-full border-0 px-5 pb-2.5 pt-2.5 text-xs font-semibold leading-tight text-neutral-500 hover:isolate hover-twod hover:text-white focus:isolate"
                    :class="
                        active_tab == '6m'
                            ? 'twod-bg text-white'
                            : 'bg-white text-neutral-500'
                    "
                    @click="get2DList('6m')"
                >
                    ခြောက်လ
                </a>
            </li>
        </ul>

        <!--Tabs content-->
        <div class="mb-6">
            <div
                class="opacity-100 transition-opacity duration-150 ease-linear block"
            >
                <div class="text-center flex justify-center mb-3">
                    <p v-if="missing_num.length < 1">No Missing Number</p>
                    <div v-else class="flex">
                        <p class="mr-2 font-semibold text-base">
                            Missing Number :
                        </p>
                        <div class="flex gap-x-1 items-center">
                            <p
                                v-for="num in missing_num"
                                :key="num"
                                class="text-sm twod-bg text-white w-5 rounded-md"
                            >
                                {{ num }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table
                                class="min-w-full text-left text-sm font-light text-surface"
                            >
                                <thead
                                    class="border-b border-neutral-200 font-medium bg-white text-black"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-3 md:px-6 py-4 border-none"
                                        >
                                            Date
                                        </th>
                                        <th
                                            scope="col"
                                            class="pl-3 py-4 border-none"
                                        >
                                            Time
                                        </th>
                                        <th
                                            scope="col"
                                            class="pl-3 py-4 border-none"
                                        >
                                            2D
                                        </th>
                                        <th
                                            scope="col"
                                            class="pl-3 py-4 border-none"
                                        >
                                            <div class="flex">
                                                <!-- <p class="inline-block px-3">Time</p> -->
                                                <!-- <p class="inline-block pl-4">2D</p> -->
                                                <!-- <div class="flex"> -->
                                                <p
                                                    v-for="(
                                                        count, index
                                                    ) in numCount"
                                                    :key="index"
                                                    class="mx-4 relative"
                                                >
                                                    {{ index }}
                                                    <span
                                                        v-if="count != 0"
                                                        class="absolute -top-2 -right-4 bg-red-600 rounded-full text-white text-xs leading-none px-1 py-0.5"
                                                    >
                                                        {{ count }}
                                                    </span>
                                                </p>
                                                <!-- </div> -->
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(twoD, index) in twoDList"
                                        :key="index"
                                        class="border-b border-neutral-200"
                                    >
                                        <td
                                            class="whitespace-nowrap px-3 md:px-6 py-4 font-medium"
                                        >
                                            {{ twoD[0].stock_date }}
                                            <p class="mt-2">
                                                {{ twoD[0].day }}
                                            </p>
                                        </td>
                                        <td class="py-4">
                                            <p
                                                class="px-3 mb-3"
                                                v-for="(two_d, index) in twoD"
                                                :key="index"
                                            >
                                                {{ two_d.open_time }}
                                            </p>
                                        </td>
                                        <td class="py-4">
                                            <p
                                                class="px-3 mb-3"
                                                v-for="(two_d, index) in twoD"
                                                :key="index"
                                            >
                                                {{ two_d.twod }}
                                            </p>
                                        </td>
                                        <td>
                                            <div
                                                class="flex px-3 mb-3"
                                                v-for="(two_d, index) in twoD"
                                                :key="index"
                                            >
                                                <div
                                                    v-for="(
                                                        count, index
                                                    ) in numCount"
                                                    :key="index"
                                                    class="mx-2 rounded-full px-2 relative"
                                                    :class="
                                                        two_d.twod_numbers[0] ==
                                                            index ||
                                                        two_d.twod_numbers[1] ==
                                                            index
                                                            ? 'twod-bg text-white'
                                                            : 'bg-transparent text-black'
                                                    "
                                                >
                                                    {{ index }}
                                                    <span
                                                        class="absolute -top-3 -right-2 bg-red-600 text-white rounded-full px-1.5 text-xs"
                                                        v-show="
                                                            two_d
                                                                .twod_numbers[0] ==
                                                                index &&
                                                            two_d
                                                                .twod_numbers[1] ==
                                                                index &&
                                                            two_d
                                                                .twod_numbers[0] ==
                                                                two_d
                                                                    .twod_numbers[1]
                                                        "
                                                    >
                                                        2
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- <td class=" py-4">
                                            <div v-for="(two_d, index) in twoD" class="mb-3">
                                                <div class="flex justify-between">
                                                    <p class="px-3">
                                                        {{ two_d.open_time }}
                                                    </p>
                                                    <p class="px-3">
                                                        {{ two_d.twod }}
                                                    </p>
                                                    <div class="flex">
                                                        <div v-for="(count, index) in numCount"
                                                            class="mx-2 rounded-full px-2 relative"
                                                            :class="two_d.twod_numbers[0] == index || two_d.twod_numbers[1] == index ? 'twod-bg text-white' : 'bg-transparent text-black'">
                                                            {{ index }}
                                                            <span
                                                                class="absolute -top-3 -right-2 bg-red-600 text-white rounded-full px-1.5 text-xs"
                                                                v-show="two_d.twod_numbers[0] == index && two_d.twod_numbers[1] == index && two_d.twod_numbers[0] == two_d.twod_numbers[1]">
                                                                2
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </td> -->
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
            twoDList: [],
            numCount: [],
            missing_num: [],
            active_tab: null,
        };
    },

    methods: {
        async get2DList(range) {
            this.active_tab = range;
            let url =
                "http://128.199.218.198:83/api/2d/analysis?range=" + range;
            const response = await getApiData({ url: url });
            if (response.data) {
                this.twoDList = response.data.results;
                this.numCount = response.data.frequencies;
                this.missing_num = response.data.missing_numbers;
            } else {
            }
        },
    },

    mounted() {
        this.get2DList("1w");
        initTWE({ Modal, Tab, Select, Ripple });
    },
};
</script>
