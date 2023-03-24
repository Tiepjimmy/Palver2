<template>
  <v-card class="py-5 mt-5" outlined>
    <div class="px-5 d-flex align-items-center mb-3">
      <div
        class="d-flex align-items-center"
        v-if="getTotalPaid() < this.order.grand_total"
      >
        <v-icon class="mr-2">far fa-credit-card</v-icon>
        <h5 class="mb-0">Xác nhận thanh toán</h5>
      </div>

      <div class="d-flex align-items-center" v-if="getTotalPaid() >= this.order.grand_total">
        <v-icon
          class="mr-2"
          color="green"

        >mdi-check-circle</v-icon>
        <h5 class="mb-0">Đơn hàng đã được thanh toán toàn bộ </h5>
      </div>

      <v-btn
        v-if="getTotalPaid() < this.order.grand_total && $route.name == 'om.order.detail'"
        class="ml-auto"
        small
        @click="openModalConfirmPayment()"
      >
        Xác nhận thanh toán
      </v-btn>
    </div>

    <div class="d-flex mt-3 px-5" v-if="getTotalPaid() < this.order.grand_total">
      <div class="mr-10">Đã thanh toán: {{ $helper.formatCurrency(getTotalPaid(), ',') }}</div>
      <div>Còn lại: {{ getRemainPayment() }}</div>
    </div>

    <v-divider v-if="order.payments.length > 0" class="mx-0"></v-divider>
    <div
      v-if="order.payments.length > 0"
      v-for="(item, index) in order.payments"
      :key="index"
      class="px-5"
      :class="index > 0 ? 'mt-3' : ''"
    >
      <div class="d-flex mb-3">
        <span class="font-weight-bold mr-5">Thanh Toán lần {{ index + 1 }}: </span>
        <span>{{ formatTime(item.created_at) }}</span>
      </div>

      <div class="d-flex mb-3">
        <div class="w-50 text-center">
          <div class="text-black-50">Số tiền thanh toán</div>
          <span>{{ $helper.formatCurrency(item.payment_amount, ',') }}</span>
        </div>

        <div class="w-50 text-center">
          <div class="text-black-50">Phương thức thanh toán</div>
          <span>{{ getPaymentMethod(item.payment_method_id )}}</span>
        </div>
      </div>

      <div class="d-flex">
        <div class="w-50 text-center">
          <div class="text-black-50">Người thanh toán</div>
          <span>{{ item.user_created.full_name }}</span>
        </div>

        <div class="w-50 text-center">
          <div class="text-black-50">Ghi chú</div>
          <span>{{ item.note }}</span>
        </div>
      </div>
    </div>
    <modal-payment-order-before @update="updatePayment"/>
  </v-card>
</template>

<script>
import OrderPayment from "@/models/order/order_payment";
import ModalPaymentOrderBefore from "@/components/om/pages/order/ModalPaymentOrderBefore";
import Order from "@/models/order/order";
import moment from "moment"

export default {
  name: "PaymentDetail",
  props: {
    order: {
      type: Object,
      default: new Order()
    }
  },
  components: {ModalPaymentOrderBefore},
  data() {
    return {
      acceptPaymentBefore: false,
      orderPayment: new OrderPayment(),
      totalPaid: 0,
    }
  },
  methods: {
    formatTime(value) {
      if (!value) {
        return
      }

      return moment(value).format('DD-MM-YYYY HH:mm:ss')
    },
    getPaymentMethod(value) {
      let method
      switch (value) {
        case 1:
          method = 'Tiền mặt'
          break
        case 2:
          method = 'Chuyển khoản'
          break
        case 3:
          method = 'Quẹt thẻ'
          break
        default:
          method = 'Tiền mặt'
          break
      }

      return method
    },
    openModalConfirmPayment() {
      let total = this.order.grand_total - this.getTotalPaid()
      this.$modal.show('modal-payment-order-before', {grandTotal: total})
    },
    async updatePayment(data){

      try {
        await new Order().checkout(this.order.id, data)

        this.$emit('update')
        this.messageSuccess('Xác nhận thanh toán thành công')
      } catch (e) {
        this.handleException(e)
      }
    },
    getTotalPaid() {
      let payment = this.order.payments.pluck('payment_amount')

      return payment.reduce((a,b) => a + b, 0)
    },
    getRemainPayment() {
      this.orderPayment.remain = this.order.grand_total - this.getTotalPaid()

      return this.$helper.formatCurrency(this.orderPayment.remain, ',')
    }
  },
  created() {
  }
}
</script>

<style scoped>

</style>