<template lang="">
    <a
        href="/2d/live"
        class="background-black rounded-2xl shadow-lg flex justify-center flex-col"
    >
        <!-- <div class="w-fit mx-auto">
                        <div>
                            <img
                                class="w-24 mb-4"
                                src="../../../../public/img/Paper.png"
                            />
                            <p class="text-white text-xl pl-2">2D Live</p>
                        </div>
                    </div> -->
        <div class="w-full mx-auto flex flex-col justify-between h-full py-16">
            <div>
                <p class="text-white text-xl font-semibold text-center">
                    {{ twoDList?.twod }}
                </p>
            </div>
            <div class="flex justify-between w-full px-[8%]">
                <div class="text-center">
                    <p class="text-white text-xs">
                        {{ twoDList?.set }}
                    </p>
                    <p class="text-white text-xs">Modern</p>
                </div>
                <div class="text-center">
                    <p class="text-white text-xs">
                        {{ twoDList?.value }}
                    </p>
                    <p class="text-white text-xs">Internet</p>
                </div>
            </div>
            <div>
                <p class="text-white text-lg font-semibold text-center">
                    2D Live
                </p>
            </div>
        </div>
    </a>
</template>
<script>
import { getApiData } from "../../utilities/ajax-helpers";
export default {
    data() {
        return {
            twoDList: null,
            intervalId: null,
            loading: false,
        };
    },
    methods: {
        async get2DList() {
            if (this.loading == false) {
                this.loading = true;
                const response = await getApiData({
                    url: "https://admin.shwepaukkan.com/api/2d/live",
                    // url: "http://localhost:4100/api/2d/live",
                });
                if (response.data) {
                    this.twoDList = response.data;
                    this.loading = false;
                } else {
                    this.loading = false;
                }
            }
        },
    },

    created() {
        this.intervalId = setInterval(() => this.get2DList(), 3000);
    },

    mounted() {
        this.get2DList();
    },
    beforeDestroy() {
        clearInterval(this.intervalId);
    },
};
</script>
<style lang=""></style>
