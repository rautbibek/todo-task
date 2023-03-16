export default {
    setUser: (state, user) => {
        localStorage.setItem("TOKEN", user.access_token);
        state.user.token = user.access_token;
        state.user.auth_user = user.user;
    },
    setAuthUser(state, user) {
        state.user.auth_user = user.user;
    },
    logout: (state) => {
        state.user.token = null;
        state.user.auth_user = {};
        localStorage.clear();
    },
};
