<template>
  <v-card class="px-5 pb-5 om-wp">
    <v-tabs v-model="tab">
      <v-tab
        v-for="item in items"
        :key="item"
      >
        {{ item }}
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item
        key="Thiết lập"
      >
        <tab-script />
      </v-tab-item>

      <v-tab-item
        key="Nhiệm vụ"
      >
        <tab-task />
      </v-tab-item>

      <v-tab-item
        key="Kết quả"
      >
        <tab-result />
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import TabTask from "@/components/om/pages/mission/task/Index";
import TabResult from "@/components/om/pages/mission/result/Index";
import TabScript from "@/components/om/pages/mission/script/Index";
export default {
  components: {
    TabTask,
    TabResult,
    TabScript
  },
  data() {
    return {
      tab: null,
      items: ['Thiết lập', 'Nhiệm vụ', 'Kết quả'],
    }
  },
  methods: {

  }
}
</script>

<style scoped>

</style>