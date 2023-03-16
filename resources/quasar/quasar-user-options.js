//import "./quasar.sass";
import "@quasar/extras/material-icons/material-icons.css";
import { Notify, date, Loading } from "quasar";

// To be used on app.use(Quasar, { ... })
export default {
    plugins: { Notify, Loading, date },
    config: {
        extras: ["material-icons-outlined"],
        framework: {
            iconSet: "material-icons-outlined", // Quasar icon set
        },
        notify: {
            /* look at QuasarConfOptions from the API card */
        },
    },
};
