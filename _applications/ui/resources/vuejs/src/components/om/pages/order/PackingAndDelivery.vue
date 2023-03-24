<template>
  <v-card class="py-5 mt-5" outlined>
    <div class="px-5 d-flex align-items-center mb-3">
      <v-icon class="mr-2">fas fa-truck</v-icon>
      <h5 class="mb-0">Đóng gói và vận chuyển</h5>
    </div>

    <b-tabs content-class="mt-3">
      <b-tab title="Đẩy qua hãng vận chuyển">
        <tab-carrier
          v-if="order.customer_id && order.products.length > 0"
          :order="order"
        />
      </b-tab>
      <b-tab title="Tự gọi shipper" disabled><p>Tự gọi shipper</p></b-tab>
      <b-tab title="Nhận tại cửa hàng" disabled><p>Nhận tại cửa hàng</p></b-tab>
      <b-tab title="Giao hàng sau" disabled><p>Giao hàng sau</p></b-tab>
    </b-tabs>

  </v-card>
</template>

<script>
import TabCarrier from "@/components/om/pages/order/create/TabCarrier";
import Order from "@/models/order/order";

export default {
  name: "PackingAndDelivery",
  props: {
    order: {
      type: Object,
      default: new Order()
    },
  },
  components: {
    TabCarrier
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