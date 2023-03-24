<template>
  <div class="card card-docs mb-12">
    <div class="text-center border-0 pt-5">
      <h1 class="card-title text-center flex-column">
        <span class="card-label fw-bolder mb-1">Log thay đổi version của hệ thống quản lý bán hàng Tuha_v2</span>
      </h1>
    </div>

    <div class="card-body fs-6 px-10 px-lg-15 text-gray-700">
      <!--begin::Changelog-->
      <div class="accordion accordion-flush accordion-icon-toggle col-12" id="kt_accordion">
        <!--begin::Item-->
        <div class="row" v-if="loading">
          <div class="accordion-item mb-5 col-md-6">
            <div class="accordion-header py-3 text-center">
              <h2 class="fs-2 text-gray-800 fw-bolder mb-0 ms-4">UI</h2>
            </div>
            <div class="accordion-body border p-4" v-for="(api,k) in changelogUI" :key="k">
              <!--begin::Header-->
              <div class="version">
                <h3 class="fs-2 text-gray-800 fw-bolder mb-0 ms-4 text-center">{{ k }}</h3>
              </div>

              <div class="date-createlog" v-for="(value,index) in api" :key="index">
                <div class="accordion-header py-3 d-flex">
                  <h3 class="fs-2 text-gray-800 fw-bolder mb-0">{{ value.date }}</h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="fs-2 mt-1 mb-1 py-0">
                  <div class="accordion-body ps-0 pt-0" v-for="(val,i) in value.changelog" :key="i">
                    <div class="mb-5">
                      <h3 class="fs-6 fw-bolder mb-1">

                        <code class="ms-0" v-if=" i =='new'">Thêm mới</code>
                        <code class="ms-0" v-else-if="i =='update'">Chỉnh sửa</code>
                        <code class="ms-0" v-else>Fix bug</code>
                      </h3>
                      <ul class="my-0 py-0" v-for=" (ver) in val" :key="ver">
                        <p class="py-2" style="padding-left:30px">
                          {{ ver }}
                        </p>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end::Body-->
          </div>
          <div class="accordion-item mb-5 col-md-6">
            <div class="accordion-header py-3 text-center">
              <h2 class="fs-2 text-gray-800 fw-bolder mb-0 ms-4">API</h2>
            </div>
            <div class="accordion-body border p-4" v-for="(api,k) in changelogAPI" :key="k">
              <!--begin::Header-->
              <div class="version">
                <h3 class="fs-2 text-gray-800 fw-bolder mb-0 ms-4 text-center">{{ k }}</h3>
              </div>

              <div class="date-createlog" v-for="(value,index) in api" :key="index">
                <div class="accordion-header py-3 d-flex">
                  <h3 class="fs-2 text-gray-800 fw-bolder mb-0">{{ value.date }}</h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="fs-2 mt-1 mb-1 py-0">
                  <div class="accordion-body ps-0 pt-0" v-for="(val,i) in value.changelog" :key="i">
                    <div class="mb-5">
                      <h3 class="fs-6 fw-bolder mb-1">

                        <code class="ms-0" v-if=" i =='new'">Thêm mới</code>
                        <code class="ms-0" v-else-if="i =='update'">Chỉnh sửa</code>
                        <code class="ms-0" v-else>Fix bug</code>
                      </h3>
                      <ul class="my-0 py-0" v-for=" (ver) in val" :key="ver">
                        <p class="py-2" style="padding-left:30px">
                          {{ ver }}
                        </p>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end::Body-->
          </div>

        </div>
        <!--end::Item-->
      </div>
      <!--end::Changelog-->
    </div>
    <!--end::Card Body-->
  </div>
</template>

<style scoped>

</style>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import ApiService from "@/core/api.service";
import changelog_config from "@/core/config/changelog.config";

export default {
  data() {
    return {
      changelogUI: [],
      changelogAPI: [],
      loading: false
    };
  },
  components: {},
  beforeCreate() {
    //Lấy thông tin liên quan đến Danh mục sản phẩm
    // ApiService.get("/proxy/account/v1/changelog")
    //   .then(response => {
    //     this.changelogUI = changelog_config;
    //     this.changelogAPI = response.data.data;
    //     this.loading = true;
    //   })
    //   .catch(error => console.log(error));
  },
  computed: {},
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      {title: "Dashboard", route: "dashboard"},
      {title: "Changelog"}
    ]);
  },
  methods: {}
};
</script>
