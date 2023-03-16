<template>
    <q-layout view="lHh Lpr lFf" class="app-bg">
        <q-header class="text-grey-8 app-bg">
            <q-toolbar class="toolbar">
                <q-btn
                    flat
                    dense
                    round
                    @click="toggleLeftDrawer"
                    aria-label="Menu"
                    icon="menu"
                    v-if="$q.screen.lt.lg"
                />

                <q-btn
                    flat
                    no-caps
                    no-wrap
                    class="q-ml-xs"
                    v-if="$q.screen.gt.xs"
                >
                </q-btn>

                <q-space />

                <q-space />

                <div class="q-gutter-sm row items-center no-wrap">
                    <div style="cursor: pointer">
                        <q-avatar size="35px">
                            <img
                                src="https://cdn.quasar.dev/img/boy-avatar.png"
                            />
                        </q-avatar>
                        <!-- <div class="q-ml-sm">
                            <div style="font-size: 12px; font-weight: bold">
                                Bibek raut
                            </div>
                            <small style="font-size: 10px; font-weight: 400"
                                >14 Days ago</small
                            >
                        </div> -->

                        <q-menu
                            auto-close
                            transition-show="jump-down"
                            transition-hide="jump-up"
                        >
                            <div
                                style="
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    padding: 10px;
                                    background-color: #7367f0;
                                    text-align: center;
                                    color: white;
                                "
                            >
                                <div>
                                    <q-avatar size="80px">
                                        <img
                                            src="https://cdn.quasar.dev/img/boy-avatar.png"
                                        />
                                    </q-avatar>
                                    <div>{{ user?.name }}</div>
                                    <small>
                                        {{ user?.created_at }}
                                    </small>
                                </div>
                            </div>

                            <q-list style="min-width: 240px">
                                <q-item v-ripple clickable>
                                    <q-item-section avatar>
                                        <q-icon name="account_circle" />
                                    </q-item-section>
                                    <q-item-section>Profile</q-item-section>
                                </q-item>

                                <q-item clickable>
                                    <q-item-section avatar>
                                        <q-icon name="settings" />
                                    </q-item-section>
                                    <q-item-section>Setting</q-item-section>
                                </q-item>
                                <q-item clickable>
                                    <q-item-section avatar>
                                        <q-icon name="delete" />
                                    </q-item-section>
                                    <q-item-section>Trash</q-item-section>
                                </q-item>

                                <q-item clickable>
                                    <q-item-section avatar>
                                        <q-icon name="help" />
                                    </q-item-section>
                                    <q-item-section
                                        >Help &amp; Feedback</q-item-section
                                    >
                                </q-item>
                                <q-separator />
                                <q-item v-ripple clickable @click="logout">
                                    <q-item-section avatar>
                                        <q-icon name="logout" />
                                    </q-item-section>
                                    <q-item-section>Logout</q-item-section>
                                </q-item>
                            </q-list>
                        </q-menu>
                    </div>
                </div>
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="drawer"
            show-if-above
            :mini="miniDrawer"
            :width="270"
            :breakpoint="1200"
            @mouseover="checkOnHoverMenu"
            @mouseout="checkOnMouseOutMenu"
            :mini-to-overlay="smallMenu"
        >
            <q-scroll-area class="fit">
                <div class="sidebar-header">
                    <q-toolbar-title
                        v-if="!miniDrawer"
                        shrink
                        class="text-weight-bold"
                    >
                        <q-avatar size="30px">
                            <img src="../../assets/logo.png" alt="logo" />
                        </q-avatar>
                        ase<span>task</span>
                    </q-toolbar-title>
                    <q-toolbar-title v-else class="text-weight-bold">
                        <q-avatar size="30px">
                            <img
                                src="../assets/logo.png"
                                height="50px"
                                alt="logo"
                            />
                        </q-avatar>
                    </q-toolbar-title>

                    <div @click="smallMenuSetting" v-show="!miniDrawer">
                        <q-icon
                            color="primary"
                            size="sm"
                            :name="
                                smallMenu
                                    ? 'radio_button_unchecked'
                                    : 'radio_button_checked'
                            "
                        />
                    </div>
                </div>

                <q-list dense>
                    <div v-for="menu in menus" :key="menu.text">
                        <q-expansion-item
                            expand-separator
                            :icon="menu.icon"
                            :label="menu.text"
                            :to="menu.path"
                            :class="menu.children ? 'menu-item' : 'menu'"
                            :expand-icon="
                                menu.children ? 'expand_less' : 'ion-add'
                            "
                        >
                            <q-expansion-item
                                :header-inset-level="0.1"
                                :icon="child.icon"
                                expand-icon="ion-add"
                                :label="child.text"
                                v-for="child in menu.children"
                                :key="child.text"
                                :to="child.path"
                                v-show="child.permissions"
                            >
                            </q-expansion-item>
                        </q-expansion-item>
                        <div v-if="menu.subheader">
                            <q-separator spaced />
                            <q-item-label header>{{
                                menu.subheader
                            }}</q-item-label>
                        </div>
                    </div>
                </q-list>
            </q-scroll-area>
        </q-drawer>

        <q-page-container>
            <div class="q-px-md" style="margin: 1rem; border-radius: 0.428rem">
                <router-view v-slot="{ Component }">
                    <Transition name="scale-in" mode="out-in" appar>
                        <component :is="Component" :key="$route.fullPath" />
                    </Transition>
                </router-view>
            </div>
        </q-page-container>
    </q-layout>
</template>

<script lang="ts">
import { ref } from "vue";

import { fabYoutube } from "@quasar/extras/fontawesome-v6";
import store from "../store";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";
// import moment from "moment";
// import { useStore } from "vuex";
export default {
    name: "MainLayout",

    setup() {
        getAuthUser();

        const router = useRouter();
        const $q = useQuasar();
        const user = ref(null);
        const smallMenu = ref(false);
        const drawer = ref(false);
        const miniDrawer = ref(false);
        const loading = ref(false);
        const search = ref("");
        const menus = ref([
            {
                icon: "dashboard",
                text: "Dashboard",
                path: "/",
                permissions: true,
            },
        ]);
        // const store = useStore();

        function toggleLeftDrawer() {
            drawer.value = !drawer.value;
        }

        function toggleDarkMode() {
            $q.dark.toggle();
        }

        function smallMenuSetting() {
            smallMenu.value = !smallMenu.value;
            miniDrawer.value = smallMenu.value;
        }
        function checkOnHoverMenu() {
            if (smallMenu.value) {
                miniDrawer.value = false;
            }
        }

        function checkOnMouseOutMenu() {
            if (smallMenu.value) {
                miniDrawer.value = true;
            }
        }
        async function getAuthUser() {
            await store
                .dispatch("auth/authUser")
                .then((res) => {
                    user.value = res.data.user;
                })
                .catch(() => {
                    router.push({
                        name: "Login",
                    });
                });
        }

        function logout() {
            store
                .dispatch("auth/logout")
                .then(() => {
                    router.push({
                        name: "Login",
                    });
                })
                .catch(() => {
                    // $q.notify("Message");
                });
        }
        return {
            logout,
            fabYoutube,
            miniDrawer,
            drawer,
            search,
            user,
            smallMenu,
            getAuthUser,
            toggleDarkMode,
            smallMenuSetting,
            toggleLeftDrawer,
            checkOnHoverMenu,
            checkOnMouseOutMenu,

            menus,
        };
    },
};
</script>

<style scoped lang="scss">
.my-menu-link {
    color: white;
    background: #4e4e4d;
    background-color: green;
}
.toolbar {
    margin: 1.3rem 2rem 0;
    border-radius: 0.428rem;
    padding: 5px;
    border-radius: 5px;
    background-color: #fff !important;
    width: auto;
}
.breadcrumbs {
    margin: 1.3rem 2rem 0;
    border-radius: 0.428rem;
    width: auto;
}
.sidebar-header {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    margin-left: 10px;
    margin-bottom: 20px;
    align-items: center;
}
.menu-item {
    margin: 0px 10px;
    border-radius: 10px;
    color: black;
    :hover {
        border-radius: 10px;
    }
}
.menu {
    margin: 0px 10px;
    border-radius: 10px;
    :hover {
        border-radius: 10px;
    }
}

.app-bg {
    background-color: #f4f4f4;
}

.router-link--exact-active {
    color: greenyellow !important;
}
.router-link-active {
    color: red !important;
}
.bounce-enter-active {
    animation: bounce-in 0.5s;
}
.bounce-leave-active {
    animation: bounce-in 0.2s reverse;
}
@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1);
    }
    100% {
        transform: scale(1);
    }
}
</style>
