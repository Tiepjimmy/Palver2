<template>
  <div>
    <!--begin::Header -->
    <div
      class="d-flex flex-column flex-center py-10 bgi-size-cover bgi-no-repeat rounded-top"
      :style="{ backgroundImage: `url(${backgroundImage})` }"
    >
      <h4 class="text-white font-weight-bold">
        Thao tác nhanh
      </h4>
      <span class="btn btn-success btn-sm font-weight-bold font-size-sm mt-2">
        23 việc cần làm
      </span>
    </div>
    <!--end::Header -->

    <!--begin::Nav -->
    <div class="row row-paddingless">
      <!--begin:Item-->
      <template v-for="(item, i) in list">
        <div class="col-6" v-bind:key="i">
          <router-link
            to="builder"
            class="d-block py-10 px-5 text-center bg-hover-light border-right border-bottom"
          >
            <span class="svg-icon svg-icon-3x svg-icon-success">
              <!--begin::Svg Icon-->
              <inline-svg :src="item.svg" />
              <!--end::Svg Icon-->
            </span>
            <span
              class="d-block text-dark-75 font-weight-bold font-size-h6 mt-2 mb-1"
            >
              {{ item.title }}
            </span>
            <span class="d-block text-dark-50 font-size-lg">
              {{ item.desc }}
            </span>
          </router-link>
        </div>
      </template>
      <!--end:Item-->
    </div>
    <!--end::Nav -->
  </div>
</template>

<script>
export default {
  name: "KTDropdownQuickAction",
  data() {
    return {
      list: [
        {
          title: "Tài khoản",
          desc: "Bảo mật",
          svg: "media/svg/icons/Shopping/Euro.svg"
        },
        {
          title: "Hệ thống",
          desc: "Bảo mật 2 lớp",
          svg:

            "media/svg/icons/Communication/Mail-attachment.svg"
        },
        {
          title: "Dự án",
          desc: "Nhiệm vụ đang chờ",
          svg: "media/svg/icons/Shopping/Box2.svg"
        },
        {
          title: "Người dùng",
          desc: "Chăm sóc khách hàng",
          svg: "media/svg/icons/Communication/Group.svg"
        }
      ]
    };
  },
  computed: {
    backgroundImage() {
      return "media/misc/bg-1.jpg";
    }
  }
};
</script>
