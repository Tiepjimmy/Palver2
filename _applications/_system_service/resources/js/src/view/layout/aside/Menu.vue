<template>

    <ul class="menu-nav">
        <!--      db + layout-->
        <router-link to="/dashboard" v-slot="{ href, navigate, isActive, isExactActive }" >
            <li aria-haspopup="true" data-menu-toggle="hover" class="menu-item" :class="[isActive && 'menu-item-active', isExactActive && 'menu-item-active']">
                <a :href="href" class="menu-link" @click="navigate">
                    <i class="menu-icon flaticon2-architecture-and-city"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
        </router-link>
        <!--      ..db + layout-->

        <!--      cau hinh doanh nghiep-->
        <li class="menu-section text-center" v-if="!currentUserPersonalInfo">
            <div class="spinner spinner-primary"></div>
        </li>
        <template v-for="menu in currentAvaiableMenu" v-if="!!currentUserPersonalInfo">
            <li class="menu-section">
                <h4 class="menu-text">{{menu.name}}</h4>
                <i class="menu-icon flaticon-more-v2"></i>
            </li>
            <router-link v-if="!!currentUserPersonalInfo" :to="child.path" v-slot="{ href, navigate, isActive, isExactActive }" v-for="child in menu.child" v-bind:key="menu.quyen_cd">
                <li aria-haspopup="true" data-menu-toggle="hover" class="menu-item" :class="[isActive && 'menu-item-active', isExactActive && 'menu-item-active']">
                    <a :href="href" class="menu-link" @click="navigate">
                    <span class="menu-icon svg-icon svg-icon-color">
                        <inline-svg v-bind:src="child.icon" ></inline-svg>
                    </span>
                        <span class="menu-text">{{child.title}}</span>
                    </a>
                </li>
            </router-link>
        </template>

        <!--      ..cau hinh doanh nghiep-->

        <!--he thong-->
        <li class="menu-section">
            <h4 class="menu-text">Hệ thống</h4>
            <i class="menu-icon flaticon-more-v2"></i>
        </li>

        <li aria-haspopup="true" data-menu-toggle="hover" class="menu-item menu-item-submenu" v-bind:class="{ 'menu-item-open': hasActiveChildren('/profile') }">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon far fa-user"></i>
                <span class="menu-text">Hướng dẫn sử dụng</span>
            </a>
        </li>

        <router-link to="/changelog"v-slot="{ href, navigate, isActive, isExactActive }">
            <li aria-haspopup="true" data-menu-toggle="hover" class="menu-item" :class="[isActive && 'menu-item-active',isExactActive && 'menu-item-active']">
                <a :href="href" class="menu-link" @click="navigate">
                    <i class="menu-icon far fa-user"></i>
                    <span class="menu-text">Changelog</span>
                </a>
            </li>
        </router-link>
        <!--..he thong-->
    </ul>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "KTMenu",
        methods: {
            hasActiveChildren(match) {
                return this.$route["path"].indexOf(match) !== -1;
            }
        },
        computed: {
            ...mapGetters(["currentAvaiableMenu", "currentUserPersonalInfo"])
        }
    };
</script>
