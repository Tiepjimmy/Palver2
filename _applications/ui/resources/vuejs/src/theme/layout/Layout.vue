<template>
  <div class="d-flex flex-column flex-root">
    <!-- begin:: Header Mobile -->
    <KTHeaderMobile></KTHeaderMobile>
    <!-- end:: Header Mobile -->

    <Loader v-if="loaderEnabled" v-bind:logo="loaderLogo" v-bind:message="message"></Loader>

    <!-- begin::Body -->
    <div class="d-flex flex-row flex-column-fluid page">
      <!-- begin:: Aside Left -->
      <KTAside v-if="asideEnabled"></KTAside>
      <!-- end:: Aside Left -->

      <div id="kt_wrapper" class="d-flex flex-column flex-row-fluid wrapper">
        <!-- begin:: Header -->
        <KTHeader></KTHeader>
        <!-- end:: Header -->

        <!-- begin:: Content -->
        <div id="kt_content" class="content d-flex flex-column flex-column-fluid">
          <!-- begin:: Content Head -->

          <!-- begin:: Content Head -->
          <KTSubheader
            v-if="subheaderDisplay"
            v-bind:breadcrumbs="breadcrumbs"
            v-bind:actionAdd="actionAdd"
            v-bind:title="pageTitle"
          />
          <!-- end:: Content Head -->

          <!-- begin:: Content Body -->
          <div class="d-flex flex-column-fluid">
            <div
              :class="{
                'container-fluid': contentFluid,
                container: !contentFluid
              }"
            >
              <transition mode="out-in">
                <router-view 
                  v-bind:actionSubmit="actionSubmit"
                  v-bind:currentOwnerShop="currentOwnerShop" 
                  v-bind:accessMedia="accessMedia"
                />
              </transition>
            </div>
          </div>
        </div>
        <KTFooter></KTFooter>
      </div>
    </div>
    <KTStickyToolbar v-if="toolbarDisplay"></KTStickyToolbar>
    <KTScrollTop></KTScrollTop>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import KTAside from "./aside/Aside.vue";
import KTHeader from "./header/Header.vue";
import KTHeaderMobile from "./header/HeaderMobile.vue";
import KTFooter from "./footer/Footer.vue";
import HtmlClass from "@/core/services/htmlclass.service";
import KTSubheader from "./subheader/Subheader.vue";
import KTStickyToolbar from "./extras/StickyToolbar.vue";
import KTScrollTop from "./extras/ScrollTop";
import Loader from "@/theme/content/Loader.vue";
import {
  ADD_BODY_CLASSNAME,
  REMOVE_BODY_CLASSNAME
} from "@/core/services/store/htmlclass.module.js";

export default {
  name: "Layout",
  components: {
    KTAside,
    KTHeader,
    KTHeaderMobile,
    KTFooter,
    KTSubheader,
    KTStickyToolbar,
    KTScrollTop,
    Loader
  },
  data(){
      return {
          message: ""
      }
  },
  created() {
    // show page loading
    this.$store.dispatch(ADD_BODY_CLASSNAME, "page-loading");

    // initialize html element classes
    HtmlClass.init(this.layoutConfig());
  },
  mounted() {
    this.$store.dispatch(REMOVE_BODY_CLASSNAME, "page-loading");
  },
  watch: {

  },
  methods: {},
  computed: {
    ...mapGetters({
      "breadcrumbs": "breadcrumbs",
      "pageTitle": "pageTitle",
      "layoutConfig": "layoutConfig",
      "actionAdd": "actionAdd",
      "actionSubmit": "actionSubmit",
      "currentOwnerShop": "currentOwnerShop",
      "accessMedia": "accessMedia"
    }),

    /**
     * Check if the page loader is enabled
     * @returns {boolean}
     */
    loaderEnabled() {
      return !/false/.test(this.layoutConfig("loader.type"));
    },

    /**
     * Check if container width is fluid
     * @returns {boolean}
     */
    contentFluid() {
      return this.layoutConfig("content.width") === "fluid";
    },

    /**
     * Page loader logo image using require() function
     * @returns {string}
     */
    loaderLogo() {
      return this.layoutConfig("loader.logo");
    },

    /**
     * Check if the left aside menu is enabled
     * @returns {boolean}
     */
    asideEnabled() {
      return !!this.layoutConfig("aside.self.display");
    },

    /**
     * Set the right toolbar display
     * @returns {boolean}
     */
    toolbarDisplay() {
      // return !!this.layoutConfig("toolbar.display");
      return true;
    },

    /**
     * Set the subheader display
     * @returns {boolean}
     */
    subheaderDisplay() {
      return !!this.layoutConfig("subheader.display");
    }
  }
};
</script>
