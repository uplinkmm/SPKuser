<template lang="">
    <div
        class="flex relative justify-between py-4 px-8 lg:px-4 mb-4 items-center -mx-4"
        :class="
            isHomePage ? 'bg-[#29261D] text-white]' : 'bg-[#29261D] text-white'
        "
    >
        <FcmNotification :get-noti="getNotis"></FcmNotification>

        <template v-if="isHomePage">
            <div class="flex items-center w-full">
                <template v-if="getUser">
                    <div class="flex items-center gap-x-3 flex-1 min-w-0">
                        <img
                            src="../../../../public/icons/logo_transparent.png"
                            class="w-10 h-10 object-contain shrink-0"
                            alt=""
                        />
                        <div class="flex items-center gap-x-2 min-w-0">
                            <i
                                class="far fa-user-circle text-gray-300 text-xl"
                            ></i>
                            <p
                                class="text-gray-200 text-lg font-semibold truncate mb-0"
                            >
                                {{ getUser?.name }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-x-3 shrink-0">
                        <div class="flex items-center gap-x-2">
                            <i class="far fa-wallet text-gray-200 text-2xl"></i>
                            <p
                                class="text-gray-200 text-2xl font-semibold mb-0"
                            >
                                {{ (getUser?.balance ?? 0).toLocaleString() }}
                            </p>
                        </div>

                        <a
                            href="/wallet"
                            class="w-7 h-7 rounded-full bg-[#FFC529] text-black flex items-center justify-center"
                        >
                            <i class="fas fa-plus text-sm"></i>
                        </a>

                        <a href="/notifications" class="relative pl-2">
                            <i class="far fa-bell text-gray-200 text-2xl"></i>
                            <span
                                v-if="notiCount > 0"
                                class="absolute -top-2 -right-1 text-white rounded px-1 bg-red-700 font-semibold text-xs"
                            >
                                {{ notiCount }}
                            </span>
                        </a>
                    </div>
                </template>

                <template v-else>
                    <div class="w-10 flex items-center justify-start">
                        <img
                            src="../../../../public/icons/logo_transparent.png"
                            class="w-10 h-10 object-contain"
                            alt=""
                        />
                    </div>

                    <div class="flex-1 text-center">
                        <p class="text-2xl font-semibold text-white">
                            ရွှေပေါက်ကန်
                        </p>
                    </div>

                    <div class="w-10 flex items-center justify-end">
                        <a href="/notifications" class="relative">
                            <i class="far fa-bell text-white text-2xl"></i>
                            <span
                                v-if="notiCount > 0"
                                class="absolute -top-2 -right-2 text-white rounded px-1 bg-red-700 font-semibold text-xs"
                            >
                                {{ notiCount }}
                            </span>
                        </a>
                    </div>
                </template>
            </div>
        </template>

        <template v-else>
            <button v-if="hideBackBtn == false">
                <a @click="backBtn">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </button>
            <p
                :class="textColor"
                class="text-2xl font-semibold text-white ml-12"
            >
                {{ title }}
            </p>
            <div class="flex gap-x-4">
                <button @click="focusSearchInput">
                    <i class="fal fa-search text-white text-2xl"></i>
                </button>
                <a href="/notifications">
                    <i class="far fa-bell text-white text-2xl"></i>
                    <span
                        v-if="notiCount > 0"
                        class="ml-2 text-white rounded pl-0.5 pr-1 bg-red-700 font-semibold text-sm"
                    >
                        {{ notiCount }}
                    </span>
                </a>
            </div>
        </template>
    </div>
    <transition name="fade-in">
        <!-- search -->
        <div
            :class="showSearch ? 'block' : 'hidden'"
            class="fixed left-0 right-0 bottom-[60px] block w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 top-[0] bg-black overflow-hidden overflow-y-auto no-scrollbar z-50 bg-img"
            style="height: calc(100vh - 60px)"
        >
            <div
                class="flex relative justify-between py-3 px-0 lg:px-4 mb-4 items-center bg-[#FFC529] text-white -mx-4"
            >
                <div>
                    <button>
                        <a @click="showSearch = false">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </button>
                    <input
                        v-model="search_input"
                        @keydown.enter="searchSlots"
                        ref="searchInput"
                        placeholder="Search slots games"
                        class="py-1 h-full ml-2 bg-transparent text-sm focus:right-0 focus:shadow-none focus:outline-none border-b px-2 placeholder-gray-600"
                    />
                </div>
                <div class="flex gap-x-4">
                    <button @click="searchSlots">
                        <i class="fal fa-search text-white text-2xl"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-y-auto no-scrollbar">
                <p
                    v-if="isEmpty"
                    class="text-white text-center py-4 text-sm font-semibold"
                >
                    No results found!
                </p>

                <div
                    v-for="(game, index) in searchResults"
                    :key="index"
                    class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4"
                >
                    <img
                        @click="getGameUrl(game)"
                        :src="game.image_url"
                        alt=""
                        class="w-full mr-4 cursor-pointer"
                    />
                    <div class="cursor-pointer">
                        <p>{{ game.name }}</p>
                        <p>{{ game.product.name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import FcmNotification from "../Notifications/FcmNotification.vue";
import { getApiData, postApiDataSlot } from "../../utilities/ajax-helpers";

export default {
    name: "Navbar",
    components: {
        FcmNotification,
    },
    props: {
        needAuth: {
            default: true,
        },
        title: {},
        hideBackBtn: {
            default: false,
        },
        backBtn: {
            type: Function,
        },
        isHomePage: {
            default: false,
        },
        textColor: {
            default: "text-black",
        },
    },
    data() {
        return {
            user: "",
            showSearch: false,
            search_input: "",
            searchResults: [],
            isEmpty: false,
        };
    },
    computed: {
        ...mapGetters(["notiCount", "getToken", "getUser"]),
    },
    methods: {
        ...mapMutations(["setNotiCount", "setUser", "setUserBalance"]),
        async getNotis() {
            let response = await getApiData({
                url: `/api/notification_list?type=betting_win&page=1&is_count=0`,
                token: this.getToken ? this.getToken : "",
            });
            if (response.success) {
                this.setNotiCount(response.data.count);
                this.user = response.data.user;
                this.setUserBalance(response.data.user);
            } else {
                if (
                    response.message == "Please login to continue" &&
                    this.needAuth
                ) {
                    window.location.href = "/login_register";
                } else if (
                    response.message == "Please login to continue" &&
                    !this.needAuth
                ) {
                    this.setUser("");
                    this.setUserBalance({
                        balance: 0,
                        name: "",
                        game_money_balance: 0,
                    });
                }
            }
        },
        async searchSlots() {
            let response = await getApiData({
                url: `/api/game/search_game?search_input=${this.search_input}`,
                token: this.getToken,
            });
            if (response.data.data) {
                this.searchResults = response.data.data;
                if (this.searchResults.length == 0) {
                    this.isEmpty = true;
                } else {
                    this.isEmpty = false;
                }
            }
        },
        async getGameUrl(game) {
            if (!this.getToken) {
                this.$notify({
                    text: "Please login to continue!",
                    type: "error",
                });
                window.location.href = "/login_register";
                return;
            }
            let url = `/api/game/Seamless/LaunchGame`;
            let formData = new FormData();
            formData.append("productId", game.product.code);
            formData.append("gameType", game.game_type_id);
            formData.append("gameId", game.code);

            let response = await postApiDataSlot({
                url: url,
                form_data: formData,
                token: this.getToken,
            });

            console.log(game.code);
            console.log(response.data);
            if (response?.data?.ErrorCode == 0) {
                this.$notify({
                    text: "Loading....",
                    type: "info",
                });
                window.location.href = response.data.Url;
            } else {
                this.$notify({
                    text: "Something went wrong.Try again!",
                    type: "error",
                });
            }
        },
        focusSearchInput() {
            this.showSearch = true;
            setTimeout(() => {
                this.$refs.searchInput.focus();
            }, 1);
        },
    },
    mounted() {
        if (this.needAuth == true && !this.getUser) {
            window.location.href = "/login_register";
        }
        this.getNotis();
    },
};
</script>
<style lang=""></style>
