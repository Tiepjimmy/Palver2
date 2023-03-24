<template>

  <ul class="menu-nav">
    <!--      db + layout-->
    <router-link to="/" v-slot="{ href, navigate, isActive, isExactActive }">
      <li aria-haspopup="true" data-menu-toggle="hover" class="menu-item"
          :class="[isExactActive && 'menu-item-active']">
        <a :href="href" class="menu-link" @click="navigate">
          <i class="menu-icon flaticon2-architecture-and-city"></i>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>
    </router-link>
    <!--      ..db + layout-->

    <template v-for="menu in currentAvailableMenu" v-if="!!currentUserPersonalInfo">
      <li class="menu-section">
        <h4 class="menu-text">{{ menu.name }}</h4>
        <i class="menu-icon flaticon-more-v2"></i>
      </li>
      <router-link v-if="!!currentUserPersonalInfo && routerExists(child.path)"
                   :to="{ name: child.path }"
                   v-slot="{ href, navigate, isActive, isExactActive }"
                   v-for="child in menu.child"
                   v-bind:key="menu.quyen_cd">
        <li aria-haspopup="true" data-menu-toggle="hover" class="menu-item"
            :class="[isActive && 'menu-item-active', isExactActive && 'menu-item-active']">
          <a :href="href" class="menu-link" @click="navigate">
                    <span class="menu-icon svg-icon svg-icon-color">
                        <inline-svg v-bind:src="child.icon"></inline-svg>
                    </span>
            <span class="menu-text">{{ child.title }}</span>
          </a>
        </li>
      </router-link>
    </template>

    <!--he thong-->
    <li class="menu-section">
      <h4 class="menu-text">Hệ thống</h4>
      <i class="menu-icon flaticon-more-v2"></i>
    </li>

    <li aria-haspopup="true" data-menu-toggle="hover" class="menu-item menu-item-submenu"
        v-bind:class="{ 'menu-item-open': hasActiveChildren('/profile') }">
      <a href="#" class="menu-link menu-toggle">
        <i class="menu-icon far flaticon2-open-text-book"></i>
        <span class="menu-text">Hướng dẫn sử dụng</span>
      </a>
    </li>
    <!--..he thong-->
  </ul>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import router from "@/router";

export default {
  name: "KTMenu",
  methods: {
    hasActiveChildren(match) {
      return this.$route["path"].indexOf(match) !== -1;
    },
    routerExists(name){
      return router.resolve({ 'name' : name}).resolved.matched.length > 0;
    }
  },
  mounted() {
    console.log('currentAvailableMenu#', this.currentAvailableMenu)
  },
  computed: {
    ...mapGetters(["currentAvailableMenu", "currentUserPersonalInfo", "auth/user"])
  }
};
</script>
