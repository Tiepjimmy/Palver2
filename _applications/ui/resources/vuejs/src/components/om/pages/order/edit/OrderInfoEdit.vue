<template>
  <div>
    <v-card outlined class="mb-5">
      <h5 class="px-3 pt-3">Thông tin đơn hàng</h5>
      <v-divider clas="mt-0"></v-divider>
      <v-row class="px-3 pb-3">
        <v-col cols="12">
          <v-row>
            <v-col cols="4" class="font-weight-bold pr-0">
              Chi nhánh:
            </v-col>
            <v-col cols="8">
              Nguyễn Trãi
            </v-col>
          </v-row>
        </v-col>

        <v-col cols="12">
          <v-row class="align-items-center">
            <v-col cols="4" class="font-weight-bold py-0 pr-0">
              Kho
            </v-col>
            <v-col cols="8" class="py-0">
              <v-select
                v-model="order.warehouse_id"
                :items="warehouses"
                item-text="warehouse_name"
                item-value="id"
                outlined
                dense
                hide-details
                placeholder="Chọn kho"
                @input="changeWarehouse"
              ></v-select>
            </v-col>
          </v-row>
        </v-col>

        <v-col cols="12">
          <label class="font-weight-bold">Địa chỉ lấy hàng:</label>
          <div>
            {{ warehouse.address }},
            {{ warehouse.province.province_name }},
            {{ warehouse.district.district_name }},
            {{ warehouse.ward.ward_name }}
          </div>
        </v-col>

        <v-col cols="12">
          <v-row class="align-items-center">
            <v-col cols="4" class="font-weight-bold py-0 pr-0">
              Mã đơn hàng:
            </v-col>
            <v-col cols="8" class="py-0">
              <v-text-field
                v-model="order.code"
                dense
                outlined
                hide-details
                maxlength="25"
                @input="changeOrderCode"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-col>

        <v-col cols="12" class="d-flex">
          <div class="font-weight-bold mr-3">
            Ngày dự kiến giao:
          </div>
          <div>
            21/12/202
          </div>
        </v-col>

        <v-col cols="12">
          <v-row class="align-items-center">
            <v-col cols="4" class="font-weight-bold py-0 pr-0">
              Người tạo đơn:
            </v-col>
            <v-col cols="8" class="py-0">
              <div>{{ order.user_created.full_name }}</div>
            </v-col>
          </v-row>
        </v-col>

        <v-col cols="12">
          <v-row class="align-items-center">
            <v-col cols="4" class="font-weight-bold pr-0">
              Người tạo số:
            </v-col>
            <v-col cols="8" class="py-0">
              <v-select
                v-model="order.user_created_lead_id"
                :items="listUser"
                item-text="full_name"
                item-value="id"
                outlined
                dense
                hide-details
                @change="changeUserCreateLead"
              ></v-select>
            </v-col>
          </v-row>
        </v-col>

        <v-col cols="12">
          <v-row class="align-items-center">
            <v-col cols="4" class="font-weight-bold pr-0">
              Người Upsale:
            </v-col>
            <v-col cols="8" class="">
              <v-select
                v-model="order.upsale_user_id"
                :items="listUser"
                item-text="full_name"
                item-value="id"
                outlined
                dense
                hide-details
                @change="changeUserUpsale"
              ></v-select>
            </v-col>
          </v-row>
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
        dense
        hide-details
        placeholder="Chọn sub trạng thái"
        @change="changeSubStatus"
      ></v-select>
    </v-card>
  </div>
</template>

<script>
import Order from "@/models/order/order";
import Collection from "@/core/collection";
import User from "@/models/user/user";
import Warehouse from "@/models/warehouse/warehouse";
import OrderStatus from "@/models/order/order_status";

export default {
  name: "OrderInfoEdit",
  props: {
    order: {
      type: Object,
      default: new Order()
    },
    listUser: {
      type: Array,
      default: new Collection(User)
    },
    warehouse: {
      type: Object,
      default: new Warehouse()
    },
    warehouses: {
      type: Array,
      default: new Collection(Warehouse)
    },
    subStatuses: [],
  },
  data() {
    return {
    }
  },
  methods: {
    changeWarehouse(value) {
      this.$emit('changeWarehouse', this.order.warehouse_id)
    },
    changeOrderCode(value) {
      this.$emit('changeOrderCode', this.order.code)
    },
    changeUserCreateLead(value) {
      this.$emit('changeUserCreateLead', this.order.user_created_lead_id)
    },
    changeUserUpsale(value) {
      this.$emit('changeWarehouse', this.order.upsale_user_id)
    },
    changeSubStatus(value) {
      this.$emit('changeSubStatus', this.order.sub_status_id)
    },
  },
  mounted() {
  }
}
</script>

<style scoped>

</style>