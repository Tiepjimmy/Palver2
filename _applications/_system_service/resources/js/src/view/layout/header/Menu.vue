<template>
  <ul class="menu-nav">
    <router-link
      to="/dashboard"
      v-slot="{ href, navigate, isActive, isExactActive }"
    >
      <li
        aria-haspopup="true"
        data-menu-toggle="hover"
        class="menu-item"
        :class="[
          isActive && 'menu-item-active',
          isExactActive && 'menu-item-active'
        ]"
      >
        <a :href="href" class="menu-link" @click="navigate">
          <span class="menu-text"> Dashboard </span>
        </a>
      </li>
    </router-link>

      <li
          aria-haspopup="true"
          data-menu-toggle="click"
          class="menu-item menu-item-submenu menu-item-open-dropdown"
          v-bind:class="{ 'menu-item-active': hasActiveChildren('/custom') }"
      >
          <a href="#" class="menu-link menu-toggle">
              <span class="menu-text"> Hệ thống </span>
          </a>
          <div class="menu-submenu menu-submenu-classic">
              <ul class="menu-subnav">
                  <li
                      aria-haspopup="true"
                      data-menu-toggle="hover"
                      class="menu-item menu-item-submenu"
                  >
                      <a href="#" class="menu-link menu-toggle">
                          <i class="menu-icon flaticon2-list-2"></i>
                          <span class="menu-text"> Hướng dẫn sử dụng </span>
                      </a>
                  </li>
                  <router-link
                      to="/changelog"
                      v-slot="{ href, navigate, isActive, isExactActive }"
                  >
                      <li
                          aria-haspopup="true"
                          data-menu-toggle="hover"
                          class="menu-item"
                          :class="[
                isActive && 'menu-item-active',
                isExactActive && 'menu-item-active'
              ]"
                      >
                          <a :href="href" class="menu-link" @click="navigate">
                              <i class="menu-icon far fa-user"></i>
                              <span class="menu-text">Changelog</span>
                          </a>
                      </li>
                  </router-link>

              </ul>
          </div>
      </li>
  </ul>
</template>

<script>
export default {
  name: "KTMenu",
  methods: {
    hasActiveChildren(match) {
      return this.$route["path"].indexOf(match) !== -1;
    }
  }
};
</script>
