<template lang="">

    <div class="flex justify-between py-4 px-0 lg:px-4 mb-4" :class="getUser && isHomePage ? 'bg-[#FDC652] text-white !px-8 font-semibold' : 'bg-transparent'">
        <div v-if="isHomePage && user">
            <p>{{ user.name }}</p>
            <p>{{ user.balance?.toLocaleString() }}</p>
        </div>
        <FcmNotification :get-noti="getNotis"></FcmNotification>
        <button v-if="hideBackBtn == false">
            <a @click="backBtn">
                <i class="fas fa-chevron-left"></i>
            </a>
        </button>
        <p :class="textColor" class="text-black text-base">{{ title }}</p>
        <div class="flex gap-x-4">
            <!-- <button>
                <i class="fal fa-search"></i>
            </button> -->
            <a href="/notifications" :class="isHomePage ? 'pt-3' : ''">
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
