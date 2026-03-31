<template lang="">
    <a
        href="/2d/live"
        class="background-black rounded-2xl shadow-lg flex flex-col items-center justify-between overflow-hidden p-4 h-full"
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
        <div class="w-full mx-auto flex flex-col items-center h-full gap-3">
            <div class="text-center">
                <p class="text-[#D3A12A] text-3xl font-semibold leading-tight">
                    2D Live
                </p>
                <p class="text-white text-xl font-medium leading-tight">
                    {{ displayTime }} {{ displayMeridiem }}
                </p>
            </div>

            <div class="flex items-center justify-center w-full">
                <p
                    class="font-semibold animate-pulse leading-none whitespace-nowrap text-green-500 drop-shadow-lg"
                    style="font-size: clamp(72px, 22vw, 110px)"
                >
                    {{ twoDList?.twod }}
                </p>
            </div>

            <div class="w-full space-y-2">
                <div class="grid grid-cols-2 gap-x-4">
                    <p
                        class="text-[#D3A12A] text-base font-semibold text-center mb-0"
                    >
                        {{ twoDList?.set }}
                    </p>
                    <p
                        class="text-[#D3A12A] text-base font-semibold text-center mb-0"
                    >
                        {{ twoDList?.value }}
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-x-4">
                    <p
                        class="text-[#D3A12A] text-sm font-semibold text-center mb-0"
                    >
                        Set
                    </p>
                    <p
                        class="text-[#D3A12A] text-sm font-semibold text-center mb-0"
                    >
                        Value
                    </p>
                </div>
            </div>

            <!-- <div class="grid grid-cols-2 gap-x-4">
                <div class="text-center">
                    <p class="text-white text-base font-semibold mb-1">
                        Modern
                    </p>
                    <p class="text-white text-base font-semibold mb-0">
                        {{ modernInternetLatest?.Modern ?? "--" }}
                    </p>
                </div>
                <div class="text-center">
                    <p class="text-white text-base font-semibold mb-1">
                        Internet
                    </p>
                    <p class="text-white text-base font-semibold mb-0">
                        {{ modernInternetLatest?.Internet ?? "--" }}
                    </p>
                </div>
            </div> -->
        </div>
    </a>
</template>
<script>
import moment from "moment";
import { getApiData } from "../../utilities/ajax-helpers";
export default {
    data() {
        return {
            twoDList: null,
            intervalId: null,
            loading: false,
        };
    },
    computed: {
        modernInternetLatest() {
            const list = this.twoDList?.modern_internet?.numbers;
            if (!Array.isArray(list) || list.length === 0) return null;
            return list[list.length - 1];
        },
        displayMoment() {
            const raw = this.twoDList?.time;
            if (!raw) return null;
            const m = moment(
                raw,
                [moment.ISO_8601, "YYYY-MM-DD HH:mm:ss", "YYYY-MM-DDTHH:mm:ss"],
                true,
            );
            return m.isValid() ? m : moment(raw);
        },
        displayTime() {
            const m = this.displayMoment;
            if (!m || !m.isValid()) return "";
            return m.format("h:mm");
        },
        displayMeridiem() {
            const m = this.displayMoment;
            if (!m || !m.isValid()) return "";
            return m.format("A");
        },
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
