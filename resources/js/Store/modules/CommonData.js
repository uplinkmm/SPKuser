export default {
    state() {
        return {
            noti_count: "",
            incoming_new_noti: 0,
            language_code: localStorage.getItem("appLanguage") || "mm",
            img_prefix: window.location.href.includes("shwepaukkan")
                ? "https://admin.shwepaukkan.com"
                : window.location.href.includes("test")
                ? "http://spkadmin.test"
                : "http://spkadmin.test",
        };
    },
    getters: {
        notiCount(state) {
            return state.noti_count;
        },
        incomingNewNoti(state) {
            return state.incoming_new_noti;
        },
        languageCode(state) {
            return state.language_code;
        },
        imgPrefix(state) {
            return state.img_prefix;
        },
    },
    mutations: {
        setNotiCount(state, noti) {
            state.noti_count = noti;
        },
        setIncomingNewNoti(state, noti) {
            state.incoming_new_noti = state.incoming_new_noti + 1;
        },
        setLanguageCode(state, payload) {
            state.language_code = payload;
            localStorage.setItem("appLanguage", payload);
        },
    },

    actions: {},
};
