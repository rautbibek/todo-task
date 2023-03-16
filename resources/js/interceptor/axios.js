import axios from "axios";
import { Notify } from "quasar";
import router from "../router/router";
import store from "../store/index";

const axiosClient = axios.create({
    baseURL: import.meta.env.VITE_BASE_URL,
});

const requestHandler = (request) => {
    request.Accept = "Application/json";
    request.headers.Authorization = `Bearer ${store.state["auth"].user.token}`;
    return request;
};

const responseHandler = (response) => {
    if (response?.data?.message) {
        Notify.create({
            type: "positive",
            timeout: 2000,
            progress: true,
            message: response?.data?.message,
        });
    }
    return response;
};

const errorHandler = (error) => {
    if (error.response?.status === 401) {
        Notify.create({
            progress: true,
            timeout: 1000,
            type: "negative",
            message: "Unauthorized access",
        });
        localStorage.clear();
        store.commit("auth/logout");
    } else if (error.response?.status === 403) {
        Notify.create({
            progress: true,
            timeout: 1000,
            type: "negative",
            message: error?.response?.data
                ? error?.response?.data?.message
                : error.message,
        });
        router.push({ name: "Forbidden" });
    } else if (error.response?.status === 500) {
        Notify.create(
            {
                progress: true,
                timeout: 2000,
                type: "negative",
                message: "Internal server error.",
            },
            100
        );
    } else {
        Notify.create({
            progress: true,
            timeout: 1000,
            type: "negative",
            message: error?.response?.data
                ? error?.response?.data?.message
                : error.message,
        });
    }

    return Promise.reject(error);
};

axiosClient.interceptors.request.use(
    (request) => requestHandler(request),
    (error) => errorHandler(error)
);

axiosClient.interceptors.response.use(
    (response) => responseHandler(response),
    (error) => errorHandler(error)
);
export default axiosClient;
