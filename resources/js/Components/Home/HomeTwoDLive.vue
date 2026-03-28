<template lang="">
    <a
        href="/2d/live"
        class="background-black rounded-2xl shadow-lg flex justify-center flex-col overflow-hidden"
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
        <div class="w-full mx-auto flex flex-col h-full py-4 px-5">
            <p class="text-[#D3A12A] text-2xl font-semibold text-center mb-2">
                2D Live
            </p>

            <div class="flex items-center justify-between mb-2 gap-x-3 min-w-0">
                <div class="text-left min-w-0 flex-1">
                    <p
                        class="text-white text-2xl font-medium leading-none mb-2"
                    >
                        {{ displayTime }}
                    </p>
                    <p
                        class="text-white text-2xl font-medium leading-none mb-0"
                    >
                        {{ displayMeridiem }}
                    </p>
                </div>

                <div class="shrink-0 text-right">
                    <p
                        class="font-semibold leading-none whitespace-nowrap animate-pulse text-green-500"
                        style="font-size: clamp(48px, 14vw, 72px)"
                    >
                        {{ twoDList?.twod }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-x-4 mb-1">
                <p
                    class="text-[#D3A12A] text-md font-semibold text-center mb-0"
                >
                    {{ twoDList?.set }}
                </p>
                <p
                    class="text-[#D3A12A] text-md font-semibold text-center mb-0"
                >
                    {{ twoDList?.value }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-x-4 mb-2">
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
