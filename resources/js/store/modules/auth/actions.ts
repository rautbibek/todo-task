import axiosClient from "../../../interceptor/axios.js";
export default {
    login: async ({ commit }, user) => {
        return await axiosClient.post("/login", user).then((res) => {
            commit("setUser", res.data);
            return res;
        });
    },
    authUser: async ({ commit }, user) => {
        return await axiosClient.get("/auth/user").then((res) => {
            commit("setAuthUser", res.data);
            return res;
        });
    },
    logout: ({ commit }) => {
        return axiosClient.post("/logout").then((res) => {
            commit("logout");
            return res;
        });
    },
};
