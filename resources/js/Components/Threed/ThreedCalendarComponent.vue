<template>
    <div class="w-full lg:w-7/12 mx-auto px-4 bg-white pb-20">
        <div class="flex justify-between py-4 mb-4">
            <button>
                <a href="/home">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p class="text-black text-base">3D ပြကဒိန်</p>
            <div class="flex gap-x-4">
                <button>
                    <i class="fal fa-search"></i>
                </button>
                <button>
                    <i class="fal fa-bell"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-11">
            <div class="threed-bg text-center border"></div>
            <div
                v-for="(month, name) in threedList"
                :key="name"
                class="threed-bg text-white px-2 py-2 text-center border"
            >
                {{ name }}
            </div>
        </div>

        <div
            class="grid grid-flow-col grid-cols-11 border-b border-[#f3f2f2]"
            style="grid-template-rows: repeat(24, minmax(0, 1fr))"
        >
            <p
                v-for="num in monthNumbers"
                :key="num"
                class="px-2 py-2 threed-bg text-white text-center border"
            >
                {{ num }}
            </p>
            <div v-for="threed in threedList" :key="threed" class="contents">
                <p
                    v-for="num in threed"
                    :key="num"
                    class="threed-calendar-row px-2 py-2 text-center text-gray-800 border-b border-transparent"
                >
                    {{ num.winning_number }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal, Ripple, initTWE, Input } from "tw-elements";
import {
    getApiData,
    postApiData,
    deleteApiData,
} from "../../utilities/ajax-helpers";
import {
    getCurrentDate,
    convertToFriendlyDate,
    convertToMonth,
} from "../../utilities/datetime-helpers";

export default {
    data() {
        return {
            datetest: null,
            threedList: null,
            monthNumbers: [
                "01",
                "02",
                "03",
                "04",
                "05",
                "06",
                "07",
                "08",
                "09",
                "10",
                "11",
                "12",
                "13",
                "14",
                "15",
                "16",
                "17",
                "18",
                "19",
                "20",
                "21",
                "22",
                "23",
                "24",
            ],
        };
    },

    methods: {
        // async getMonthAndYear() {
        //     this.year = getCurrentDate().substring(0, 4)
        //     this.month = getCurrentDate().substring(5, 7)
        // },
        async getThreedResults() {
            const response = await getApiData({
                url: "http://128.199.218.198:83/api/3d/results/calendar",
            });
            if (response.data) {
                this.threedList = response.data;
            } else {
            }
        },
    },

    mounted() {
        this.getThreedResults();
        initTWE({ Modal, Ripple });
    },
};
</script>
