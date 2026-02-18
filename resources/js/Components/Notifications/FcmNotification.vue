<template>
    <notifications position="top center" />
</template>

<script>
import firebase from "firebase/compat/app";
import "firebase/messaging";
import { mapGetters, mapMutations } from "vuex";

export default {
    data() {
        return {
            firebaseMessaging: null,
            fcmToken: null,
            user: null,
            department: null,
            notifications: [],
            newNofiCount: 0,
        };
    },
    props: {
        getNoti: {
            type: Function,
        },
    },
    methods: {
        ...mapGetters(["getUser", "getToken"]),
        ...mapMutations(["setIncomingNewNoti"]),
        async startOnMessageListener() {
            // console.log(`im running`);
            try {
                await this.firebaseMessaging.onMessage((payload) => {
                    console.log("message received: ", payload);
                    let title = payload.notification.title;
                    let body = payload.notification.body;
                    let notiOptions = { body: body };

                    new Notification(title, notiOptions);
                    this.$notify({
                        title: payload.notification.title,
                        text: payload.notification.body,
                        type: "info",
                    });
                    this.getNoti();
                    this.setIncomingNewNoti();
                });
            } catch (error) {
                // console.log("error", error);
            }
        },

        async requestPermission() {
            try {
                const permission = await Notification.requestPermission();
                if (permission == "denied") {
                    // this.$notify({
                    //     text: `Notification permission ${permission}`,
                    //     type: "warn",
                    // });
                }
                if (permission == "granted") {
                    // console.log(`permission granted`);
                    this.firebaseMessaging = firebase.messaging();
                    this.fcmToken = await this.firebaseMessaging.getToken();
                    console.log(this.fcmToken);
                    this.startOnMessageListener();
                }
            } catch (error) {
                // this.$notify({
                //     text: "Firebase error",
                //     type: "error",
                // });
            }
        },
    },

    created() {
        this.user = this.getUser();
        // this.department = this.getDepartment();
        this.requestPermission();
        // this.getNotifications();
    },

    mounted() {
        // initTE({ Dropdown, Modal, Select, Ripple });
    },
};
</script>
