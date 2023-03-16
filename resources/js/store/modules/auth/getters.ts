export default {
    isAuthenticated: (state) => {
        return state.user.token ? true : false;
    },
};
