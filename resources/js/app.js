import "./bootstrap";

import { createApp } from "vue";
import { Quasar } from "quasar";
// Import icon libraries
import "@quasar/extras/material-icons/material-icons.css";
import router from "./router/router";
import store from "./store";
// Import Quasar css
import "quasar/src/css/index.sass";
import app from "./app.vue";
import quasarUserOptions from "../quasar/quasar-user-options";

const myApp = createApp(app);
myApp.use(Quasar, quasarUserOptions).use(store).use(router);

myApp.mount("#app");
