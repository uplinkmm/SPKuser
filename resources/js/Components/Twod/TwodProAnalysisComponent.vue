<template>
    <div class="w-full lg:w-7/12 mx-auto px-4 bg-white pb-8 min-h-[200vh] pt-0 lg:pt-8">
        <div class="flex justify-between py-4 px-0 lg:px-4 mb-4">
            <button>
                <a href="/home">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p class=" text-black text-base">
                Lucky Numbers
            </p>
            <div class="flex gap-x-4">
                <button>
                    <i class="fal fa-search"></i>
                </button>
                <button>
                    <i class="fal fa-bell"></i>
                </button>
            </div>
        </div>

        <div class="flex justify-center flex-col px-8 mb-4">
            <div class="grid grid-cols-4 gap-x-8 mb-4 w-8/12 mx-auto">
                <transition-group name="fade-in" mode="out-in">
                    <!-- <div v-for="(digit, index) in fourDigit"
                        class="text-center bg-[#F69312] text-white aspect-square rounded-md">
                        <p v-show="!isClick3"
                            class="h-full w-full flex justify-center text-center flex-col text-xl font-semibold">
                            {{ digit }}
                        </p>
                        <p v-show="isClick3" :class="isClick3 ? 'change-num' : ''"
                            class="test h-full w-full flex justify-center text-center flex-col text-xl font-semibold">

                        </p>
                    </div> -->
                    <div class="text-center bg-[#F69312] text-white aspect-square rounded-md">
                        <p v-show="!isClick3"
                            class="h-full w-full flex justify-center text-center flex-col text-xl font-semibold">
                            {{ digitOne }}
                        </p>
                        <p v-show="isClick3" :class="isClick3 ? 'change-num' : ''"
                            class="test h-full w-full flex justify-center text-center flex-col text-xl font-semibold">

                        </p>
                    </div>
                    <div class="text-center bg-[#F69312] text-white aspect-square rounded-md">
                        <p v-show="!isClick3"
                            class="h-full w-full flex justify-center text-center flex-col text-xl font-semibold">
                            {{ digitTwo }}
                        </p>
                        <p v-show="isClick3" :class="isClick3 ? 'change-num' : ''"
                            class="test h-full w-full flex justify-center text-center flex-col text-xl font-semibold">

                        </p>
                    </div>
                    <div class="text-center bg-[#F69312] text-white aspect-square rounded-md">
                        <p v-show="!isClick3"
                            class="h-full w-full flex justify-center text-center flex-col text-xl font-semibold">
                            {{ digitThree }}
                        </p>
                        <p v-show="isClick3" :class="isClick3 ? 'change-num' : ''"
                            class="test h-full w-full flex justify-center text-center flex-col text-xl font-semibold">

                        </p>
                    </div>
                    <div class="text-center bg-[#F69312] text-white aspect-square rounded-md">
                        <p class="h-full w-full flex justify-center text-center flex-col text-xl font-semibold">
                            {{ digitFour.toFixed(0) }}
                        </p>
                        <!---
                        <p v-show="isClick3" :class="isClick3 ? 'hjhkhjkhk' : ''"
                            class="test h-full w-full flex justify-center text-center flex-col text-xl font-semibold">

                        </p> -->
                    </div>
                </transition-group>
            </div>
            <div class="w-full flex justify-center">
                <button @click="getNumberList()"
                    class="text-black border-[#F69312] border px-4 py-1 rounded-lg text-sm hover:bg-[#F69312] hover:text-white">
                    Get Lucky Number
                </button>
            </div>

            <!-- Type a number: <input v-model.number="number" />
            <p>{{ tweened.toFixed(0) }}</p> -->

        </div>


        <div class=" transition delay-200 ease-in-out">
            <div class="flex flex-col">
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-left text-sm font-light text-surface">
                                <thead class="border-b border-neutral-200 font-medium bg-[#F69312] text-white">
                                    <tr>
                                        <th scope="col" class="px-3 py-4 border-none w-16">Number</th>
                                        <th scope="col" class="px-3 py-4 border-none">count</th>
                                        <th scope="col" class="px-3 py-4 border-none text-right">Update</th>
                                    </tr>
                                </thead>
                                <Transition name="fade" :duration="{ enter: 500, leave: 800 }">
                                    <tbody v-if="numberList.length > 0">
                                        <tr v-for="num in numberList" class="border-b border-neutral-200">
                                            <td class="whitespace-nowrap px-3 md:px-6 py-4 font-medium w-16">{{ num.twoD }}
                                            </td>
                                            <td class="px-3 py-4">
                                                {{ num.frequency }}
                                            </td>
                                            <td class="px-3 py-4 text-right">
                                                <p class="text-sm ">
                                                    {{ num.last_occurrence.stock_datetime }}
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </Transition>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal, Ripple, initTWE, Input } from "tw-elements";
import { getApiData, postApiData, deleteApiData } from '../../utilities/ajax-helpers';
import gsap from 'gsap'

export default {
    data() {
        return {
            numberList: [],
            fourDigit: ['*', '*', '*', '*'],
            oneToFour:[1,2,3,4],
            isClick: false,
            isClick3: false,
            number: 0,
            tweened: 0,

            digitOne: 0,
            digitTwo: 0,
            digitThree: 0,

            digitFour: 0,
            numberOne: 0,
            numberTwo: 0,
            numberThree: 0,
            numberFour: 0,
        };
    },

    methods: {
        async getNumberList() {
            this.numberList = [];
            const response = await getApiData({ url: 'http://128.199.218.198:83/api/2d/lucky_numbers' });
            if (response.data) {
                setTimeout(() => {
                    this.numberList = response.data.combinations;
                }, 1400);
                this.fourDigit = response.data.lucky_numbers;
                this.numberOne = this.fourDigit[0];
                this.numberTwo = this.fourDigit[1];
                this.numberThree = this.fourDigit[2];
                this.numberFour = this.fourDigit[3];

                this.isClick3 = true;
                setTimeout(() => {
                    this.isClick3 = false;
                }, 800);
            }
            else {
                // console.log('some errors occur');
            }
        },
    },

    watch: {
        number(n){
            gsap.to(this, { duration: 0.5, tweened: Number(n) || 0 })
        },

        numberOne(n) {
            gsap.to(this, { duration: 0.5, digitOne: Number(n) || 0 })
        },
        numberTwo(n) {
            gsap.to(this, { duration: 0.5, digitTwo: Number(n) || 0 })
        },
        numberThree(n) {
            gsap.to(this, { duration: 0.5, digitThree: Number(n) || 0 })
        },
        numberFour(n){
            gsap.to(this, { duration: 0.5, digitFour: Number(n) || 0 })
        },
    },

    mounted() {
        this.getNumberList();
        initTWE({ Modal, Ripple });
    }
}
</script>
