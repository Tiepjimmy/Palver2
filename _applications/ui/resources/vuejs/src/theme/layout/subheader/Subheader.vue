<template>
  <div
    class="subheader py-2 py-lg-4 subheader-solid"
    v-bind:class="subheaderClasses"
    id="kt_subheader"
  >
    <div
      class="d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"
      v-bind:class="{ 'container-fluid': widthFluid, container: !widthFluid }"
    >
      <div class="d-flex align-items-center flex-wrap mr-1">
        <h5 class="text-dark font-weight-bold my-2 mr-5">
          {{ title }}
        </h5>
        <ul
          class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2"
        >
          <li class="breadcrumb-item">
            <router-link :to="'/'" class="subheader-breadcrumbs-home">
              <i class="flaticon2-shelter text-muted icon-1x"></i>
            </router-link>
          </li>

            <li v-for="(breadcrumb, i) in breadcrumbs" class="breadcrumb-item" :key="`${i}-${breadcrumb.id}`">
              <router-link
                v-if="breadcrumb.route"
                :key="i"
                :to="breadcrumb.route"
                class="text-muted"
              >
                {{ breadcrumb.title }}
              </router-link>
              <span class="text-muted" :key="i" v-if="!breadcrumb.route">
                {{ breadcrumb.title }}
              </span>
            </li>
        </ul>
      </div>
      <div class="d-flex align-items-center">
        <div v-for="(action, index) in actionAdd" :key="index" style="margin-left: 10px;">
          <component v-if="action.type == 'component'" :is="action.content"></component>
          <b-button v-if="action.type == 'modal'" class="btn btn-light font-weight-bold btn-sm" v-b-modal="action.param">{{action.text}}</b-button>
          <b-button v-if="action.type == 'click'" class="btn btn-light font-weight-bold btn-sm" v-on:click="handleClick">{{action.text}}</b-button>
          <router-link v-if="action.type == 'link'" :to="action.param" class="btn btn-light font-weight-bold btn-sm">{{action.text}}</router-link>
          <a v-if="action.type == 'href'" class="btn btn-light font-weight-bold btn-sm" :href="action.param">{{action.text}}</a>
          <b-dropdown
            v-if="action.type == 'modal-dropdown'"
            size="sm"
            variant="link"
            toggle-class="custom-v-dropdown"
            no-caret
            right
            no-flip
            text="Actions">
            <template v-slot:button-content>
              <b-button class="btn btn-light font-weight-bold btn-sm">{{action.text}}</b-button>
            </template>
            <b-dropdown-text v-for="(dropdown, key) in action.param" :key="key">
              <b-button class="btn btn-light font-weight-bold btn-sm" v-b-modal="dropdown.param" style="width: 150px;">{{dropdown.text}}</b-button>
            </b-dropdown-text>
          </b-dropdown>
        </div>
          

        <b-dropdown
          size="sm"
          variant="link"
          toggle-class="custom-v-dropdown"
          no-caret
          right
          no-flip
          text="Actions"
          v-b-tooltip.hover="'Thao tác nhanh'"
        >
          <template v-slot:button-content>
            <a href="#" class="btn btn-icon" data-toggle="dropdown">
              <span class="svg-icon svg-icon-success svg-icon-2x">
                <!--begin::Svg Icon-->
                <inline-svg src="media/svg/icons/Files/File-plus.svg" />
                <!--end::Svg Icon-->
              </span>
            </a>
          </template>
          <!--begin::Navigation-->
          <div class="navi navi-hover min-w-md-250px">
            <b-dropdown-text tag="div" class="navi-header font-weight-bold">
              Chuyển nhanh tới:
              <i
                class="flaticon2-information"
                data-toggle="tooltip"
                data-placement="left"
                v-b-tooltip.hover
                title="Xem thêm..."
              />
            </b-dropdown-text>
            <b-dropdown-text
              tag="div"
              class="navi-separator mb-3"
            ></b-dropdown-text>
            <b-dropdown-text tag="div" class="navi-item">
              <a href="#" class="navi-link">
                <span class="navi-icon">
                  <i class="flaticon2-drop"></i>
                </span>
                <span class="navi-text">Đơn hàng mới</span>
              </a>
            </b-dropdown-text>
            <b-dropdown-text tag="div" class="navi-item">
              <a href="#" class="navi-link">
                <span class="navi-icon">
                  <i class="flaticon2-calendar-8"></i>
                </span>
                <span class="navi-text">Yêu cầu hỗ trợ</span>
              </a>
            </b-dropdown-text>
            <b-dropdown-text tag="div" class="navi-item">
              <a href="#" class="navi-link">
                <span class="navi-icon">
                  <i class="flaticon2-telegram-logo"></i>
                </span>
                <span class="navi-text">Dự án</span>
              </a>
            </b-dropdown-text>
            <b-dropdown-text tag="div" class="navi-item">
              <a href="#" class="navi-link">
                <span class="navi-icon">
                  <i class="flaticon2-new-email"></i>
                </span>
                <span class="navi-text">Tin nhắn</span>
                <span class="navi-label">
                  <span class="label label-success label-rounded">5</span>
                </span>
              </a>
            </b-dropdown-text>
            <b-dropdown-text
              tag="div"
              class="navi-separator mt-3"
            ></b-dropdown-text>
            <b-dropdown-text tag="div" class="navi-footer">
              <a
                class="btn btn-light-primary font-weight-bolder btn-sm"
                href="#"
                >Cập nhật dự án</a
              >
              <a
                class="btn btn-clean font-weight-bold btn-sm"
                href="#"
                data-toggle="tooltip"
                data-placement="left"
                v-b-tooltip.hover
                title="Xem thêm chi tiết..."
                >Xem thêm</a
              >
            </b-dropdown-text>
          </div>
          <!--end::Navigation-->
        </b-dropdown>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.custom-v-dropdown {
  &.dropdown-toggle {
    padding: 0;
    &:hover {
      text-decoration: none;
    }

    &.dropdown-toggle-no-caret {
      &:after {
        content: none;
      }
    }
  }

  &.dropdown-menu {
    margin: 0;
    padding: 0;
    outline: none;
    .b-dropdown-text {
      padding: 0;
    }
  }
}
</style>

<script>
import { mapGetters } from "vuex";
import {SET_SUBMIT} from "@/core/services/store/breadcrumbs.module";

export default {
  name: "KTSubheader",
  props: {
    breadcrumbs: Array,
    actionAdd: Array,
    title: String
  },
  computed: {
    ...mapGetters(["layoutConfig"]),

    /**
     * Check if subheader width is fluid
     */
    widthFluid() {
      return this.layoutConfig("subheader.width") === "fluid";
    },

    subheaderClasses() {
      const classes = [];
      const style = this.layoutConfig("subheader.style");
      if (style) {
        classes.push(style);

        if (style === "solid") {
          classes.push("bg-white");
        }

        if (this.layoutConfig("subheader.fixed")) {
          classes.push("border-top");
        }
      }
      return classes.join(" ");
    }
  },
  methods: {
    handleClick() {
      this.$store.dispatch(SET_SUBMIT, true);
    }
  }
};
</script>
