import actions from "./actions";
import mutations from "./mutations";
import getters from "./getters";
export default {
    namespaced: true,
    state: {
        user: {
            auth_user: {},
            token: localStorage.getItem("TOKEN"),
        },
    },
    actions,
    getters,
    mutations,
};
