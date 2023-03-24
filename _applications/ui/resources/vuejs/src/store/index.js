import Vue from 'vue'
import Vuex from 'vuex'

import htmlClass from "@/core/services/store/htmlclass.module";
import config from "@/core/services/store/config.module";
import breadcrumbs from "@/core/services/store/breadcrumbs.module";
import profile from "@/core/services/store/profile.module";
import permission from "@/core/services/store/permission.module";
import product from "@/core/services/store/product.module";

import app from './app'
import auth from './auth'
import configs from './configs'
import order from './om/order'
import marketing from './om/marketing'
import omConfig from './om/om-configs'
import mission from './om/mission'
import inventory from "./inventory/inventory";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app,
    auth,
    htmlClass,
    config,
    breadcrumbs,
    profile,
    permission,
    configs,
    omConfig,
    order,
    product,
    marketing,
    mission,
    inventory,
  },
  strict: process.env.NODE_ENV !== "production",
});
