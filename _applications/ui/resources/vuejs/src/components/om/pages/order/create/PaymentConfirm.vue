<template>
  <v-card class="py-5 mt-5" outlined>
    <div class="px-5 d-flex align-items-center mb-3">
      <v-icon class="mr-2">far fa-credit-card</v-icon>
      <h5 class="mb-0">Xác nhận thanh toán</h5>
    </div>

    <div class="px-5 ml-5">
      <v-radio-group
        v-model="optionPayment"
        @change="changePaymentConfirm()"
      >
        <v-radio
          class="w-fit-content"
          label="Khách hàng thanh toán trước"
          value="1"
        ></v-radio>
        <v-radio
          class="w-fit-content"
          label="Thu COD sau khi giao hàng thành công"
          value="2"
        ></v-radio>
        <v-radio
          class="w-fit-content"
          label="Thanh toán sau"
          value="3"
        ></v-radio>
      </v-radio-group>
    </div>
    <v-divider class="mx-0" v-if="optionPayment == 1 && acceptPaymentBefore"></v-divider>
    <v-row class="p-5" v-if="optionPayment == 1 && acceptPaymentBefore">
      <v-col cols="6" class="py-0">
        <label>Hình thức thanh toán</label>
        <v-select
          v-model="orderPayment.payment_method_id"
          :items="payments"
          item-value="value"
          item-text="label"
          placeholder="Hình thức thanh toán"
          disabled
          outlined
          dense
        >
        </v-select>
      </v-col>

      <v-col cols="6" class="py-0">
        <label>Số tiền thanh toán</label>
        <v-input-currency
          class="text-right-input"
          v-model="orderPayment.payment_amount"
          disabled
          outlined
          dense
        >
        </v-input-currency>
      </v-col>

      <v-col cols="6" class="py-0">
        <label>Ngày thanh toán</label>
        <v-text-field
          outlined
          dense
          disabled
          v-model="orderPayment.payment_at"
          placeholder="Ngày thanh toán"
        >
        </v-text-field>
      </v-col>

      <v-col cols="6" class="py-0">
        <label>Ghi chú</label>
        <v-text-field
          v-model="orderPayment.note"
          placeholder="Ghi chú"
          outlined
          dense
          disabled
        >
        </v-text-field>
      </v-col>

      <v-col cols="6" class="py-0">
        <label>Còn lại</label>
        <v-input-currency
          class="text-right-input"
          v-model="orderPayment.remain"
          placeholder="Còn lại"
          disabled
          outlined
          dense
          hide-details
        >
        </v-input-currency>
      </v-col>
    </v-row>
    <modal-payment-order-before @update="updatePayment"/>
  </v-card>
</template>

<script>
import OrderPayment from "@/models/order/order_payment";
import ModalPaymentOrderBefore from "@/components/om/pages/order/ModalPaymentOrderBefore";
import VInputCurrency from "@/components/om/widgets/VInputCurrency";

export default {
  name: "PaymentConfirm",
  props: ['grandTotal'],
  components: {VInputCurrency, ModalPaymentOrderBefore},
  data() {
    return {
      menu: false,
      acceptPaymentBefore: false,
      optionPayment: null,
      orderPayment: new OrderPayment(),
      payments: [
        {value: 1, label: 'Tiền mặt'},
        {value: 2, label: 'Chuyển khoản'},
        {value: 3, label: 'Quẹt thẻ'},
      ],
    }
  },
  methods: {
    changePaymentConfirm() {
      if (this.optionPayment == 1) {
        this.$modal.show('modal-payment-order-before', {grandTotal: this.grandTotal})
      } else {
        this.orderPayment.reset()
        this.acceptPaymentBefore = false
      }
    },
    updatePayment(data) {
      this.orderPayment.bind(data)
      this.acceptPaymentBefore = true
      this.$emit('updatePayment', this.orderPayment)
    }
  },
  watch: {
    grandTotal(value) {
      return this.orderPayment.remain = Number(value) - this.orderPayment.payment_amount
    }
  },
  created() {
  }
}
</script>

<style scoped>

</style>