import { mapGetters } from "vuex/dist/vuex.cjs.js";

export default {
    computed: {
        ...mapGetters(["getToken"]),
    },
    created() {
        if (!this.getToken) {
            window.location.href = "/login_register";
        }
    },
};
