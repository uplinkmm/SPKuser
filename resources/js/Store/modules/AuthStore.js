export default {
    state() {
        return {
            user: null,
            token: null,
            csrfToken: null,
            buffaloAuth: null,
        };
    },

    mutations: {
        setUser(state, user) {
            state.user = user;
        },

        setBuffaloAuth(state, buffaloAuth) {
            state.buffaloAuth = buffaloAuth;
        },

        setToken(state, token) {
            state.token = token;
        },

        setCsrfToken(state, csrfToken) {
            state.csrfToken = csrfToken;
        },
    },

    actions: {},

    getters: {
        getUser(state) {
            return state.user;
        },

        getToken(state) {
            return state.token;
        },

        getCsrfToken(state) {
            return state.csrfToken;
        },

        getBuffaloAuth(state) {
            return state.buffaloAuth;
        },
    },
};
