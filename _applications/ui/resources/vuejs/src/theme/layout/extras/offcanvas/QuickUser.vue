<template>
    <div v-else class="topbar-item">
        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
            <template v-if="!currentUserPersonalInfo">
                <div class="spinner spinner-primary"></div>
            </template>
            <template v-else>
                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Xin chào,</span>
                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">
                    {{currentUserPersonalInfo.full_name }}
                </span>
                <span class="symbol symbol-35 symbol-light-success">
                    <img v-if="false" alt="Pic" :src="currentUserPersonalInfo.avatar"/>
                    <span v-if="true" class="symbol-label font-size-h5 font-weight-bold">
                      {{ currentUserPersonalInfo.full_name.charAt(0).toUpperCase() }}
                    </span>
                </span>
            </template>
        </div>
        <div  id="kt_quick_user"  ref="kt_quick_user"  class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0">
                    Thông tin người dùng
                    <div v-if="!currentUserPersonalInfo" class="spinner spinner-primary"></div>
                    <small v-else class="text-muted font-size-sm ml-2">12 tin mới</small>
                </h3>
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->

            <!--begin::Content-->
            <div v-if="!currentUserPersonalInfo" class="spinner spinner-primary"></div>
            <perfect-scrollbar v-else class="offcanvas-content pr-5 mr-n5 scroll" style="max-height: 90vh; position: relative;">
                <!--begin::Header-->
                <div class="d-flex align-items-center mt-5">
                    <div class="symbol symbol-100 mr-5">
                        <img v-if="false" class="symbol-label" :src="currentUserPersonalInfo.avatar" alt="" />
                        <span v-if="true" class="symbol-label font-size-h1 font-weight-bold symbol-light-success">
                            {{ currentUserPersonalInfo.full_name.charAt(0).toUpperCase() }}
                        </span>
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <router-link to="/custom-pages/profile" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"></router-link>
                        <div class="text-muted mt-1">Pal Việt Nam</div>
                        <div class="navi mt-2">
                            <a href="#" class="navi-item">
                                <span class="navi-link p-0 pb-2">
                                    <span class="navi-icon mr-1">
                                        <span class="svg-icon svg-icon-lg svg-icon-primary">
                                          <!--begin::Svg Icon-->
                                          <inline-svg :src="$helper.url('media/svg/icons/Communication/Mail-notification.svg')" />
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text text-muted text-hover-primary">
                                    {{ currentUserPersonalInfo.email }}
                                    </span>
                                </span>
                            </a>
                        </div>
                        <button class="btn btn-light-primary btn-bold" @click="onLogout">Đăng xuất</button>
                    </div>
                </div>
                <!--end::Header-->
                <div class="separator separator-dashed mt-8 mb-5"></div>
                <!--begin::Nav-->
                <div class="navi navi-spacer-x-0 p-0">
                    <!--begin::Item-->
                    <router-link  to="/builder" @click.native="closeOffcanvas" href="#" class="navi-item">
                        <div class="navi-link">
                            <div class="symbol symbol-40 bg-light mr-3">
                                <div class="symbol-label">
                                    <span class="svg-icon svg-icon-md svg-icon-success">
                                        <!--begin::Svg Icon-->
                                        <inline-svg :src="$helper.url('media/svg/icons/General/Notification2.svg')"/>
                      <!--end::Svg Icon-->
                                    </span>
                                </div>
                            </div>
                            <div class="navi-text">
                                <router-link to="/custom-pages/profile">
                                    <div class="font-weight-bold">Thông tin</div>
                                </router-link>
                                <div class="text-muted">Cật nhật thông tin tài khoản</div>
                            </div>
                        </div>
                    </router-link>
                    <!--end:Item-->
                </div>
                <!--end::Nav-->
                <div class="separator separator-dashed my-7"></div>
            </perfect-scrollbar>
            <!--end::Content-->
        </div>
    </div>
</template>

<style lang="scss" scoped>
    #kt_quick_user {
        overflow: hidden;
    }
</style>

<script>
    import {mapGetters} from "vuex";
    import {LOGOUT} from "@/store/mutation-types";
    import KTLayoutQuickUser from "@/assets/js/layout/extended/quick-user.js";
    import KTOffcanvas from "@/assets/js/components/offcanvas.js";

    export default {
        name: "KTQuickUser",
        data() {
            return {
                list: [
                    {
                        title: "Thông báo lưu kho quá hạn",
                        desc: "Quá hạn 2 ngày",
                        alt: "",
                        svg: "media/svg/icons/Home/Library.svg",
                        type: "warning"
                    },
                    {
                        title: "Thông báo lưu kho quá hạn",
                        desc: "Quá hạn 2 ngày",
                        alt: "",
                        svg: "media/svg/icons/Communication/Write.svg",
                        type: "success"
                    },
                    {
                        title: "Thông báo lưu kho quá hạn",
                        desc: "Quá hạn 2 ngày",
                        alt: "",
                        svg: "media/svg/icons/Communication/Group-chat.svg",
                        type: "danger"
                    },
                    {
                        title: "Thông báo lưu kho quá hạn",
                        desc: "Quá hạn 2 ngày",
                        alt: "",
                        svg: "media/svg/icons/General/Attachment2.svg",
                        type: "info"
                    }
                ]
            };
        },
        mounted() {
            KTLayoutQuickUser.init('kt_quick_user');
        },
        methods: {
            onLogout() {
                this.$store
                    .dispatch(LOGOUT)
                    .then(() => this.$router.push({name: "login"}));
            },
            closeOffcanvas() {
                new KTOffcanvas(KTLayoutQuickUser.getElement()).hide();
            }
        },
        computed: {
            ...mapGetters(["currentUserPersonalInfo"]),

            getFullName() {
                return (
                    this.currentUserPersonalInfo.name
                );
            }
        }
    };
</script>
