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
        key="Kênh"
      >
        <tab-channel :isChange="isChange" />
      </v-tab-item>

      <v-tab-item
        key="Sub kênh"
      >
        <tab-sub-channel :isChange="isChange" />
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import TabChannel from "@/components/om/pages/marketing/channel/Index"
import TabSubChannel from "@/components/om/pages/marketing/sub_channel/Index"

export default {
  name: "Manager",
  components: {
    TabChannel,
    TabSubChannel
  },
  data() {
    return {
      firstFetched: false,
      tab: null,
      items: ['Kênh', 'Sub kênh'],
      isChange: false
    }
  },
  methods: {
    changeTab(item) {
      this.isChange = true
      if (item == 'Kênh') {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Quản lý kênh" }])
      } else {
        this.$store.dispatch(SET_BREADCRUMB, [{title: "Quản lý Sub kênh"}])
      }
    }
  },
  created() {
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{ title: "Quản lý kênh" }]);
  },
}
</script>

<style lang="scss">

</style>