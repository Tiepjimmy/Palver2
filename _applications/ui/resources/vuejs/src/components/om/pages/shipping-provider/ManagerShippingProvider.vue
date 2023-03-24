<template>
  <v-card class="px-5 pb-5 om-wp">
    <v-tabs v-model="tab">
      <v-tab
        v-for="item in items"
        :key="item"
        @change="changeTab(item)"
      >
        {{ item }}
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item
        key="Đối tác kết nối vận chuyển"
      >
        <tab-shipping-partner :isChange="isChange" />
      </v-tab-item>

      <v-tab-item
        key="Đối tác tự liên hệ"
      >
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import TabShippingPartner from "@/components/om/pages/shipping-provider/TabShippingPartner";

export default {
  name: "ManagerShippingProvider",
  components: {
    TabShippingPartner
  },
  data() {
    return {
      firstFetched: false,
      tab: null,
      items: ['Đối tác kết nối vận chuyển', 'Đối tác tự liên hệ'],
      isChange: false
    }
  },
  methods: {
    changeTab(item) {
      this.isChange = true
      if (item == 'Đối tác kết nối vận chuyển') {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Quản lý đối tác kết nối vận chuyển" }])
      } else {
        this.$store.dispatch(SET_BREADCRUMB, [{title: "Quản lý đối tác tự liên hệ"}])
      }
    }
  },
  created() {
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{ title: "Quản lý đơn vị vận chuyển" }]);
  },
}
</script>

<style lang="scss">

</style>