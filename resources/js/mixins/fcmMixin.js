// src/mixins/fcmMixin.js
import firebase from "firebase/compat/app";
import "firebase/messaging";

export default {
    data() {
        return {
            fcmToken: null,
        };
    },
    async mounted() {
        try {
            const permission = await Notification.requestPermission();
            // console.log("Notification permission", permission);
            let notiType = "warn";
            if (permission === "denied") {
                notiType = "warn";
            }
            if (permission === "granted") {
                notiType = "info";
                this.firebaseMessaging = firebase.messaging();
                this.fcmToken = await this.firebaseMessaging.getToken();
                // console.log("FCM token", this.fcmToken);
            }
            // this.$notify({
            //     text: `Notification permission ${permission}`,
            //     type: notiType,
            // });
        } catch (error) {
            console.error(error);
            // this.$notify({
            //     text: "Firebase error",
            //     type: "error",
            // });
        }
    },
};
