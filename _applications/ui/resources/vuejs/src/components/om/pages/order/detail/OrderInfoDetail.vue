<template>
  <div>
    <v-card outlined class="mb-5">
      <h5 class="px-3 pt-3">Thông tin đơn hàng</h5>
      <v-divider clas="mt-0"></v-divider>
      <v-row class="px-3 pb-3">
        <v-col cols="12" class="pb-0">
          <span class="font-weight-bold mr-3">
            Chi nhánh:
          </span>
          <span>
            Nguyễn Trãi
          </span>
        </v-col>

        <v-col cols="12" class="pb-0">
          <span class="font-weight-bold mr-3">
            Kho:
          </span>
          <span>
            {{ warehouse.warehouse_name }}
          </span>
        </v-col>

        <v-col cols="12" class="pb-0">
          <span class="font-weight-bold mr-3 d-block">
            Địa chỉ lấy hàng:
          </span>
          <span>
            {{ warehouse.address }},
            {{ warehouse.province.province_name }},
            {{ warehouse.district.district_name }},
            {{ warehouse.ward.ward_name }}
          </span>
        </v-col>

        <v-col cols="12" class="pb-0">
          <span class="font-weight-bold mr-3">
            Mã đơn hàng:
          </span>
          <span>
            {{ order.code }}
          </span>
        </v-col>

        <v-col cols="12" class="pb-0">
          <span class="font-weight-bold mr-3">
            Ngày dự kiến giao:
          </span>
          <span>
            21/12/2022
          </span>
        </v-col>

        <v-col cols="12" class="pb-0">
          <span class="font-weight-bold mr-3">
            Người tạo đơn:
          </span>
          <span>
           {{ order.user_created.full_name }}
          </span>
        </v-col>

        <v-col cols="12" class="pb-0">
          <span class="font-weight-bold mr-3">
            Người tạo số:
          </span>
          <span v-if="order.lead_id">
            {{ order.lead.user_created.full_name }}
          </span>
        </v-col>

        <v-col cols="12">
          <span class="font-weight-bold mr-3">
            Người Upsale:
          </span>
          <span>
            {{ order.user_upsale.full_name }}
          </span>
        </v-col>
      </v-row>
    </v-card>

    <v-card outlined class="px-3 py-5">
      <label>Sub trạng thái</label>
      <v-select
        v-model="order.sub_status_id"
        :items="subStatuses"
        item-text="name"
        item-value="id"
        outlined
        disabled
        background-color="#ededed"
        hide-selected
        dense
        hide-details
        placeholder="Chọn sub trạng thái"
      ></v-select>
    </v-card>
  </div>
</template>

<script>
import Order from "@/models/order/order";
import Warehouse from "@/models/warehouse/warehouse";

export default {
  name: "OrderInfoDetail",
  props: {
    order: {
      type: Object,
      default: new Order()
    },
    warehouse: {
      type: Object,
      default: new Warehouse()
    },
    subStatuses: [],
  },
  data() {
    return {

    }
  },
  methods: {
  }
}
</script>

<style scoped>

</style>