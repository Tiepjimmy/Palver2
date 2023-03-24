<template>
  <div>
    <div
      class="d-flex align-items-center cursor-pointer light-blue--text w-fit-content mb-1"
      @click="$router.push({name: 'om.order.index'})"
    >
      <v-icon
        class="mr-1"
      >
        mdi-chevron-left
      </v-icon>

      <span>Danh sách đơn hàng có sẵn</span>
    </div>

    <div class="d-flex align-items-center mb-1">
      <span class="font-weight-bold font-size-h5 mr-3">{{ order.code }}</span>
      <span>{{ formatTime(order.created_at)}}</span>
    </div>

    <div class="d-flex align-items-center mb-3">
      <v-btn
        class="mr-5"
        small
        @click="printOrder()"
      >
        <v-icon
          small
        >
          mdi-printer
        </v-icon>
        In đơn hàng
      </v-btn>

      <v-menu
        offset-y
      >
        <template v-slot:activator="{ on, attrs }">
          <div
            v-bind="attrs"
            v-on="on"
          >
            Thao tác với đơn hàng
            <v-icon>mdi-chevron-down</v-icon>
          </div>

        </template>

        <v-list>
          <v-list-item style="min-height: 25px" class="cursor-pointer">
            <v-list-item-title @click="$emit('cancelOrder')">Hủy đơn</v-list-item-title>
          </v-list-item>

          <v-list-item style="min-height: 25px" class="cursor-pointer" v-if="$route.name == 'om.order.detail'">
            <v-list-item-title @click="$emit('editOrder')">Sửa đơn</v-list-item-title>
          </v-list-item>

          <v-list-item style="min-height: 25px" class="cursor-pointer">
            <v-list-item-title @click="$emit('coppyOrder')">Sao chép đơn hàng</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </div>
    
    <modal-print-order
      @print="print"
      :order="order"
    />
  </div>
</template>

<script>
import Order from "@/models/order/order";
import moment from "moment";
import ModalPrintOrder from "@/components/om/pages/order/print/ModalPrintOrder";

export default {
  name: "OrderHeader",
  props: {
    order: {
      type: Object,
      default: new Order()
    },
  },
  components: {
    ModalPrintOrder
  },
  data() {
    return {

    }
  },
  methods: {
    printOrder() {
      this.$modal.show('modal-print-order', {})
    },
    formatTime(time) {
      if (time) {
        return moment(time).format('DD-MM-YYYY HH:mm')
      }

      return
    },
    print() {
    }
  }
}
</script>

<style scoped>

</style>