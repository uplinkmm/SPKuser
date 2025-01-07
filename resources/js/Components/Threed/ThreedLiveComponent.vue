<template>
    <div class="w-full lg:w-7/12 mx-auto px-4 bg-white pb-20">

        <div class="flex justify-between py-4 mb-4">
            <button>
                <a href="/home">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p class=" text-black text-base">
                3D Live
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
        <div class="w-full mx-0 lg:w-7/12 lg:mx-auto mb-12">
            <div v-for="(threed,index) in threeDList" class="rounded-lg py-4 px-4 lg:px-8 threed-bg text-white mb-4">
                <div class="contents">
                    <div class="flex justify-between mb-3">
                        <p>
                            Date
                        </p>
                        <p class="text-black">
                            3D
                        </p>
                    </div>
                    <div class="flex justify-between">
                        <p>
                            {{ threed.open_date }}
                        </p>
                        <p class="">
                            {{ threed.winning_number }}
                        </p>
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
            threeDList: [],
        };
    },

    methods: {
        async getInitial3DList() {
            const response = await getApiData({ url: 'http://128.199.218.198:83/api/3d/results/yearly' });
            if (response.data) {
                this.threeDList = response.data;
            }
            else {
            }
        },

    },

    mounted() {
        this.getInitial3DList();
        // this.get2DLive();
        initTWE({ Modal, Ripple });
    },
}
</script>
