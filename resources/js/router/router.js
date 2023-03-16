import store from "../store/index";
import { createRouter, createWebHistory } from "vue-router";
// import { auth } from "./middleware/index";

// import { useStore } from "vuex";
// const store = useStore();
const routes = [
    {
        path: "/auth",
        redirect: { name: "Login" },
        name: "GuestLayout",
        meta: { isGuest: true },
        component: () => import("../layouts/GuestLayout.vue"),
        children: [
            {
                path: "/login",
                name: "Login",
                component: () => import("../pages/Login.vue"),
            },
            {
                path: "/register",
                name: "Register",
                component: () => import("../pages/Register.vue"),
            },
        ],
    },
    {
        path: "/",
        name: "MainLayout",
        redirect: "/dashboard",
        meta: {
            requiresAuth: true,
        },
        component: () => import("../layouts/MainLayout.vue"),
        children: [
            {
                path: "/",
                name: "Dashboard",
                component: () => import("../pages/Dashboard.vue"),
            },
            {
                path: "/project/:id/task",
                name: "Task",
                component: () => import("../pages/Task.vue"),
            },
        ],
    },
    {
        path: "/:pathMatch(.*)*",
        name: "notfound",
        component: () => import("../pages/error/404.vue"),
    },
    {
        path: "/forbidden",
        name: "Forbidden",
        component: () => import("../pages/error/403.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state["auth"].user.token) {
        next({ name: "Login" });
    } else if (store.state["auth"].user.token && to.meta.isGuest) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});
export default router;
