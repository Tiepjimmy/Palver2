import Vue from "vue";
import Vuex from "vuex";

import auth from "./auth.module";
import htmlClass from "./htmlclass.module";
import config from "./config.module";
import breadcrumbs from "./breadcrumbs.module";
import profile from "./profile.module";
import permission from "./permission.module";
import cropimage from "./cropimage.module";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        htmlClass,
        config,
        breadcrumbs,
        profile,
        permission,
        cropimage
    }
});
