<template>
    <div class="w-full lg:w-7/12 mx-auto px-4 bg-white pb-8 min-h-[100vh]">
        <div class="flex justify-between py-4 px-0 lg:px-4 mb-4">
            <button>
                <a href="/home">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p class=" text-black text-base">
                အိပ်မက်တစ်ရာ
            </p>
            <div class="flex gap-x-4">
                <div class="relative">
                    <!-- <button>
                        <i class="fal fa-search"></i>
                    </button> -->
                    <label for="search" class="relative rounded-md border overflow-hidden block">
                        <input type="text" id="search" class="border-0 px-1 py-1 text-sm" 
                            @input="searchDream" v-model="searchInput">
                        <i class="fal fa-search absolute top-1.5 right-2"></i>
                    </label>
                </div>
                <button>
                    <i class="fal fa-bell"></i>
                </button>
            </div>
        </div>


        <div>
            <div class="flex flex-col">
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full">
                        <div class="overflow-hidden">
                            <table class="min-w-full text-left text-sm font-light text-surface">
                                <thead class=" font-medium text-black">
                                    <tr>
                                        <th scope="col" class="px-3 md:px-6 py-4 font-normal">စဉ်</th>
                                        <th scope="col" class="py-3 font-normal whitespace-nowrap">အိပ်မက်</th>
                                        <th scope="col" class="px-3 py-4 font-normal"></th>
                                        <th scope="col" class="px-3 py-4 font-normal">နံပါတ်</th>
                                        <th scope="col" class="px-3 py-4 font-normal"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(dNumber,index) in dreamNumberList" class="">
                                        <td class="whitespace-nowrap px-3 md:px-6 py-4 font-medium">{{ index+1 }}</td>
                                        <td class=" py-4">
                                            <img class="w-12 lg:w-16 aspect-square" :ref="'image_' + dNumber.id"
                                                :src="placeholder" @load="loadDreamImage(dNumber.image_url, dNumber.id)"
                                                alt="">
                                        </td>
                                        <td class="px-3 py-4">
                                            <p class="text-xs ">
                                                {{ dNumber.name }}
                                            </p>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4">{{ dNumber.number }}</td>
                                        <td class="whitespace-nowrap px-3 py-4">
                                            <i class="fas fa-plus"></i>
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
import { Modal, Ripple, initTWE, Input } from "tw-elements";
import { getApiData, postApiData, deleteApiData } from '../../utilities/ajax-helpers';

export default {
    data() {
        return {
            realImage: null,
            placeholder: '/img/placeholder.svg',
            searchInput:null,
            dreamNumberList: [],
        };
    },

    methods: {
        async getDreamNumberList() {
            const response = await getApiData({ url: 'http://128.199.218.198:83/api/dream_numbers' });
            if (response.data) {
                this.dreamNumberList = response.data;
            }
            else {
            }
        },
        async searchDream() {
            const response = await getApiData({ url: 'http://128.199.218.198:83/api/dream_numbers?search=' + this.searchInput });
            if (response.data) {
                this.dreamNumberList = response.data;
            }
            else {
                // console.log('some errors occur');
            }
        },
        

        loadDreamImage(url, id) {
            // Simulate loading of high-quality image with delay
            this.$refs['image_' + id][0].src = url;
        }

    },

    created() {
        this.intervalId = setInterval(this.get2DLive, 3000);
    },

    mounted() {
        this.getDreamNumberList();
        initTWE({ Modal, Ripple });
    }
}
</script>
