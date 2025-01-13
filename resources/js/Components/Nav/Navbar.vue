<template lang="">

    <div class="flex relative justify-between py-4 px-0 lg:px-4 mb-4 items-center" :class="getUser && isHomePage ? 'bg-[#FDC652] text-white font-semibold -mx-4' : 'bg-[#DDA33F] text-white -mx-4'">
        <div v-if="isHomePage && user" class="flex gap-x-2 text-sm">
            <p>{{ user.name }}</p> 
            <p>{{ user.balance?.toLocaleString() }}</p>
        </div>
        <FcmNotification :get-noti="getNotis"></FcmNotification>
        <button v-if="hideBackBtn == false">
            <a @click="backBtn">
                <i class="fas fa-chevron-left"></i>
            </a>
        </button>
        <p :class="textColor" class="text-white text-base">{{ title }}</p>
        <div class="flex gap-x-4">
            <button @click="searchBtn()">
                <i class="fal fa-search"></i>
            </button>
            <a href="/notifications" :class="isHomePage ? 'pt-0' : ''">
                <i class="far fa-bell" ></i>
                <span
                    v-if="notiCount > 0"
                    class="ml-2 text-white rounded pl-0.5 pr-1 bg-red-700 font-semibold text-sm"
                >
                    {{ notiCount }}
                </span>
            </a>
        </div>
        
    </div>
    <transition name="fade-in">
    <!-- search -->
    <div v-if="isSearch" class="fixed left-0 right-0 bottom-[60px] block w-full sm:w-3/12 sm:min-w-[480px] mx-auto px-4 top-[0] bg-black overflow-hidden overflow-y-auto no-scrollbar z-50 bg-img" style="height:calc(100vh - 60px)">
        <div class="flex relative justify-between py-3 px-0 lg:px-4 mb-4 items-center bg-[#DDA33F] text-white -mx-4">
            <div>
                <button>
                    <a @click="cancelSearch()">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </button>
                <input class="py-1 h-full ml-2 bg-transparent text-sm focus:right-0 focus:shadow-none focus:outline-none border-b px-2">
            </div>
            <div class="flex gap-x-4">
                <button>
                    <i class="fal fa-search"></i>
                </button>
                
            </div>
        </div>
        
        <div class="overflow-y-auto no-scrollbar">
            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>
            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>

            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>

            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>

            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>
            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>
            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>
            <div class="grid grid-cols-2 text-white items-end gap-x-4 border-b-2 border-gray-400 py-4 px-2 mb-4">
                <img src="../../../../public/img/Rise-of-Pyramids_339x180-1.png"
                    alt=""
                    class="w-full mr-4"
                />
                <div>
                    <p>Thor</p>
                    <p>Pragmatic Play</p>
                </div>
            </div>
        </div>
        
        
    </div>
    </transition>
</template>
<script>
import { mapGetters, mapMutations } from "vuex";
import FcmNotification from "../Notifications/FcmNotification.vue";
import { getApiData } from "../../utilities/ajax-helpers";

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
            isSearch:false,
        };
    },
    computed: {
        ...mapGetters(["notiCount", "getToken", "getUser"]),
    },
    methods: {
        ...mapMutations(["setNotiCount"]),
        async getNotis() {
            let response = await getApiData({
                url: `/api/notification_list?type=betting_win&page=1&is_count=0`,
                token: this.getToken,
            });
            if (response.success) {
                this.setNotiCount(response.data.count);
                this.user = response.data.user;
            } else {
                if (response.message == "Please login to continue" && this.needAuth) {
                    window.location.href = "/login_register";
                }
            }
        },
        searchBtn(){
            this.isSearch = true;
        },
        cancelSearch(){
            this.isSearch = false;
        }
    },
    mounted() {
        if (this.needAuth == true && !this.getUser) {
            window.location.href = "/login_register";
        }
        this.getNotis();
    },
};
</script>
<style lang="">

</style>
