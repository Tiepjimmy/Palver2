<template>
  <div>
    <div
      class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top"
      :style="{ backgroundImage: `url(${backgroundImage})` }"
    >
      <h4 class="d-flex flex-center rounded-top">
        <span class="text-white">Thông báo</span>
        <span
          class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2"
        >
          23 mới
        </span>
      </h4>

      <ul
        class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8"
        role="tablist"
      >
        <li class="nav-item">
          <a
            v-on:click="setActiveTab"
            data-tab="0"
            class="nav-link active"
            data-toggle="tab"
            href="#"
            role="tab"
          >
            Thông báo
          </a>
        </li>
        <li class="nav-item">
          <a
            v-on:click="setActiveTab"
            data-tab="1"
            class="nav-link"
            data-toggle="tab"
            href="#"
            role="tab"
          >
            Sự kiện
          </a>
        </li>
        <li class="nav-item">
          <a
            v-on:click="setActiveTab"
            data-tab="2"
            class="nav-link"
            data-toggle="tab"
            href="#"
            role="tab"
          >
            Lịch sử
          </a>
        </li>
      </ul>
    </div>

    <b-tabs class="hide-tabs" v-model="tabIndex">
      <b-tab active class="p-8">
        <perfect-scrollbar
          class="scroll pr-7 mr-n7"
          style="max-height: 40vh; position: relative;"
        >
          <template v-for="(item, i) in list1">
            <!--begin::Item-->
            <div class="d-flex align-items-center mb-6" v-bind:key="i">
              <!--begin::Symbol-->
              <div
                class="symbol symbol-40 mr-5"
                v-bind:class="`symbol-light-${item.color}`"
              >
                <span class="symbol-label">
                  <span
                    class="svg-icon svg-icon-lg"
                    v-bind:class="`svg-icon-${item.color}`"
                  >
                    <!--begin::Svg Icon-->
                    <inline-svg :src="item.svg" />
                    <!--end::Svg Icon-->
                  </span>
                </span>
              </div>
              <!--end::Symbol-->
              <!--begin::Text-->
              <div class="d-flex flex-column font-weight-bold">
                <a
                  href="#"
                  class="text-dark text-hover-primary mb-1 font-size-lg"
                >
                  {{ item.title }}
                </a>
                <span class="text-muted">
                  {{ item.desc }}
                </span>
              </div>
              <!--end::Text-->
            </div>
            <!--end::Item-->
          </template>
        </perfect-scrollbar>
      </b-tab>

      <b-tab>
        <perfect-scrollbar
          class="navi navi-hover scroll my-4"
          style="max-height: 40vh; position: relative;"
        >
          <template v-for="(item, i) in list2">
            <a href="#" class="navi-item" v-bind:key="i">
              <div class="navi-link">
                <div class="navi-icon mr-2">
                  <i v-bind:class="item.icon"></i>
                </div>
                <div class="navi-text">
                  <div class="font-weight-bold">
                    {{ item.title }}
                  </div>
                  <div class="text-muted">
                    {{ item.desc }}
                  </div>
                </div>
              </div>
            </a>
          </template>
        </perfect-scrollbar>
      </b-tab>

      <b-tab>
        <div class="d-flex flex-center text-center text-muted min-h-200px">
          Không có thông báo mới
        </div>
      </b-tab>
    </b-tabs>
  </div>
</template>

<style lang="scss">
/* hide default vue-bootstrap tab links */
.hide-tabs > div:not(.tab-content) {
  display: none;
}
</style>

<script>
export default {
  name: "KTDropdownNotification",
  data() {
    return {
      tabIndex: 0,
      list1: [
        {
          title: "Thông báo mới",
          desc: "Tài khoản đăng nhập ở thiết bị khác",
          color: "primary",
          svg: "media/svg/icons/Home/Library.svg"
        },
        {
            title: "Thông báo mới",
            desc: "Tài khoản đăng nhập ở thiết bị khác",
          color: "warning",
          svg: "media/svg/icons/Communication/Write.svg"
        },
        {
            title: "Thông báo mới",
            desc: "Tài khoản đăng nhập ở thiết bị khác",
          color: "success",
          svg:
            "media/svg/icons/Communication/Group-chat.svg"
        },
        {
            title: "Thông báo mới",
            desc: "Tài khoản đăng nhập ở thiết bị khác",
          color: "danger",
          svg: "media/svg/icons/General/Attachment2.svg"
        },
        {
            title: "Thông báo mới",
            desc: "Tài khoản đăng nhập ở thiết bị khác",
          color: "info",
          svg:

            "media/svg/icons/Communication/Shield-user.svg"
        },
        {
            title: "Thông báo mới",
            desc: "Tài khoản đăng nhập ở thiết bị khác",
          color: "info",
          svg:

            "media/svg/icons/Communication/Mail-notification.svg"
        },
        {
            title: "Thông báo mới",
            desc: "Tài khoản đăng nhập ở thiết bị khác",
          color: "info",
          svg: "media/svg/icons/Design/Bucket.svg"
        }
      ],
      list2: [
        {
          title: "Hoàn tất thông tin đăng ký",
          desc: "23 giờ trước",
          icon: "flaticon2-line-chart text-success"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-paper-plane text-danger"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-user flaticon2-line- text-success"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-pin text-primary"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-sms text-danger"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-pie-chart-3 text-warning"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon-pie-chart-1 text-info"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-settings text-success"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon-safe-shield-protection text-primary"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-notification text-primary"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon2-fax text-success"
        },
        {
            title: "Hoàn tất thông tin đăng ký",
            desc: "23 giờ trước",
          icon: "flaticon-download-1 text-danger"
        }
      ]
    };
  },
  methods: {
    setActiveTab(event) {
      const tab = event.target.closest('[role="tablist"]');
      const links = tab.querySelectorAll(".nav-link");
      // remove active tab links
      for (let i = 0; i < links.length; i++) {
        links[i].classList.remove("active");
      }

      // set clicked tab index to bootstrap tab
      this.tabIndex = parseInt(event.target.getAttribute("data-tab"));

      // set current active tab
      event.target.classList.add("active");
    }
  },
  computed: {
    backgroundImage() {
      return "media/misc/bg-1.jpg";
    }
  }
};
</script>
