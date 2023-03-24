import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import VueI18n from 'vue-i18n'
import VueMoment from 'vue-moment'
import {UPDATE_OWNER} from "@/core/services/store/product.module";
import VModal from 'vue-js-modal'
import CKEditor from '@ckeditor/ckeditor5-vue2';
// import Echo from 'laravel-echo'

Vue.config.productionTip = false;

// Global 3rd party plugins
import "popper.js";
import "tooltip.js";
import PerfectScrollbar from "perfect-scrollbar";
window.PerfectScrollbar = PerfectScrollbar;

// Vue 3rd party plugins
import i18n from "@/core/plugins/vue-i18n";
import vuetify from "@/core/plugins/vuetify";
import "@/core/plugins/portal-vue";
import "@/core/plugins/bootstrap-vue";
import "@/core/plugins/perfect-scrollbar";
import "@/core/plugins/inline-svg";
import "@/core/plugins/metronic";
import '@/core/plugins/vee_validate'
import '@/core/plugins/axios'
import "@/core/plugins/treeselect";
import GlobalMixins from "./mixins/global";
import Utility from "@/helpers/utility"

Vue.use(VueI18n)
Vue.use(VueMoment)
Vue.mixin(GlobalMixins)
Vue.use(Utility)
Vue.use(VModal)
Vue.use(CKEditor);

// window.Echo = new Echo({
//   broadcaster: "socket.io",
//   encrypted: true,
//   enabledTransports: ['ws', 'wss', "websocket"],
//   host: SKIO_DOMAIN
// });

router.beforeEach((to, from, next) => {
  //Check thông tin owner shop
  Promise.all([store.dispatch(UPDATE_OWNER)]).then(next);
});

new Vue({
  router,
  store,
  i18n,
  vuetify,
  render: h => h(App)
}).$mount("#app");
