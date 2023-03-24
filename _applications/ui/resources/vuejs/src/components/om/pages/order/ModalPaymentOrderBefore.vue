<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="60%"
      :minWidth="375"
      height="auto"
      :scrollable="true"
      :clickToClose="false"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <header class="modal-header flex">
        <h4 class="m-auto">{{ title }}</h4>
        <v-btn
          icon
          @click="closeModal()"
        >
          <v-icon
          >
            mdi-close
          </v-icon>
        </v-btn>
      </header>
      <div class="modal-body">
        <v-form ref="form">
          <v-row class="">
            <v-col cols="6" class="py-0">
              <label>Hình thức thanh toán</label>
              <v-select
                v-model="orderPayment.payment_method_id"
                :items="payments"
                item-value="value"
                item-text="label"
                placeholder="Hình thức thanh toán"
                :rules="[rules.method]"
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
                :rules="[rules.payment]"
                @keypress="handleInputNumber"
                @input="getRemain()"
              />
            </v-col>

            <v-col cols="6" class="py-0">
              <label>Ngày thanh toán</label>
              <datetime-picker-palee
                v-model="orderPayment.payment_at"
                :placeholder="'Ngày thanh toán'"
                :rules="[rules.time]"
              />
            </v-col>

            <v-col cols="6" class="py-0">
              <label>Ghi chú</label>
              <v-text-field
                v-model="orderPayment.note"
                placeholder="Ghi chú"
                outlined
                dense
              >
              </v-text-field>
            </v-col>

            <v-col cols="6" class="py-0">
              <label>Còn lại</label>
              <v-input-currency
                class="text-right-input"
                v-model="orderPayment.remain"
                :hideDetails="true"
                disabled
                background-color="#ededed"
              />
            </v-col>
          </v-row>
        </v-form>
      </div>
      <footer class="modal-footer">
        <div class="d-flex">
          <v-btn class="ml-auto mr-3" @click="closeModal()">Hủy bỏ</v-btn>
          <v-btn dark class="primary" @click="save()">Thanh toán</v-btn>
        </div>
      </footer>
    </modal>
  </transition>
</template>


<script>
import OrderPayment from "@/models/order/order_payment";
import DatetimePickerPalee from "@/components/om/widgets/DateTimePicker";
import VInputCurrency from "@/components/om/widgets/VInputCurrency";
import moment from "moment"

export default {
  name: "ModalPaymentOrderBefore",
  components: {DatetimePickerPalee, VInputCurrency},
  data() {
    return {
      grandTotal: 0,
      modalName: 'modal-payment-order-before',
      title: 'Xác nhận thanh toán đơn hàng',
      menu: false,
      optionPayment: null,
      orderPayment: new OrderPayment(),
      payments: [
        {value: 1, label: 'Tiền mặt'},
        {value: 2, label: 'Chuyển khoản'},
        {value: 3, label: 'Quẹt thẻ'},
      ],
      rules: {
        method: value => !!value || 'Hình thức thanh toán bắt buộc chọn',
        payment: value => this.orderPayment.payment_amount > 0 || 'Số tiền thanh toán bắt buộc nhập',
        time: value => !!value || 'Ngày thanh toán bắt buộc nhập'
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.grandTotal = event.params.grandTotal
      this.orderPayment.payment_amount = this.grandTotal
      this.orderPayment.remain = this.grandTotal - this.orderPayment.payment_amount
      this.orderPayment.payment_at = moment().format('YYYY-MM-DD hh:mm')
    },
    beforeClose() {

    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    changePaymentConfirm() {

    },
    getRemain() {
      if (this.orderPayment.payment_amount > this.grandTotal) {
        this.orderPayment.payment_amount = this.grandTotal
      }

      this.orderPayment.remain = Number(this.grandTotal) - Number(this.orderPayment.payment_amount)
    },
    handleInputNumber(evt) {
      evt = (evt) ? evt : window.event;
      let expect = evt.target.value.toString() + evt.key.toString();

      if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    save() {
      if (this.$refs.form.validate()) {
        this.orderPayment.created_by = this.user.id
        this.orderPayment.store_id = 1

        const payment = this.orderPayment.reduces(false)

        if (payment.user_created) {
          delete payment.user_created
        }

        this.$emit('update', payment)
        this.closeModal()
      }
    }
  },
  created() {
  }
}
</script>

<style scoped>

</style>