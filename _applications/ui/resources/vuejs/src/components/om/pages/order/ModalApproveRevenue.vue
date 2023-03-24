<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="70%"
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
        <v-card flat>
          <p>
            <b>Mã đơn hàng:</b>
            <span>{{ order.code }}</span>
          </p>
          <p>
            <b>Vận chuyển bởi:</b>
<!--            <span>{{ order.shipping_unit.name }}</span>-->
            <span>Giao hàng tiết kiệm</span>
          </p>
        </v-card>
        <v-card flat>
          <p>
            <b>Mã vận đơn:</b>
<!--            <span>{{ order.lading_code }}</span>-->
            <span>VD123456</span>
            <span class="text-success ml-3 cursor-pointer" @click="copyOrderLadingCode">Sao chép</span>
          </p>
          <v-btn
            class="my-5 ml-auto"
            dark small
            color="success"
            @click="confirmMultiPayment"
          >
            Xác nhận
          </v-btn>
          <v-row class="" v-show="firstFetched">
            <v-col md="12">
              <v-card class="mb-1">
                <v-data-table
                  class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
                  v-model="selected"
                  no-data-text="Không tồn tại dữ liệu"
                  :headers="headers"
                  :items="listData"
                  hide-default-footer
                  show-select
                >
                  <template v-slot:item.created_at="{ item }">
                    <span>
                      {{ formatTime(item.created_at) }}
                    </span>
                  </template>
                  <template v-slot:item.payment_amount="{ item }">
                    <span
                      class="text-success"
                    >
                      {{ $helper.formatCurrency(item.payment_amount, ',') }}
                    </span>
                  </template>
                  <template v-slot:item.payment_method="{ item }">
                    <span>
                      {{ item.payment_method.name }}
                    </span>
                  </template>
                  <template v-slot:item.status="{ item }">
                    <span>{{ item.confirmed_by ? 'Đã thu tiền' : 'Đã thanh toán'}}</span>
                  </template>
                  <template v-slot:item.created_by="{ item }">
                    <span>{{ item.user_created.full_name}}</span>
                  </template>
                  <template v-slot:item.confirmed_by="{ item }">
                    <span v-if="item.confirmed_by">{{ item.user_confirmed.full_name}}</span>
                  </template>
                  <template
                    v-slot:item.note="{ item }"
                  >
                    <v-tooltip
                      v-if="item.note"
                      bottom
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-icon
                          class="cursor-pointer"
                          small
                          color="darken-2"
                          v-bind="attrs"
                          v-on="on"
                        >
                          mdi-note
                        </v-icon>
                      </template>
                      <span
                      >
                        {{ item.note }}
                      </span>
                    </v-tooltip>
                  </template>
                  <template v-slot:item.action="{ item }">
                    <v-btn
                      v-if="!item.confirmed_by"
                      class="my-5"
                      dark small
                      color="success"
                      @click="confirmPayment(item)"
                    >
                      Xác nhận
                    </v-btn>
                    <v-btn
                      v-else
                      class="my-5"
                      dark small
                      color="error"
                      @click="cancelConfirmPayment(item)"
                    >
                      Hủy xác nhận
                    </v-btn>
                  </template>
                </v-data-table>
              </v-card>
            </v-col>
          </v-row>
        </v-card>
      </div>
    </modal>
  </transition>
</template>

<script>
import Filter from "@/core/filter";
import OrderPayment from "@/models/order/order_payment";
import {EventBus} from "@/core/plugins/event_bus";
import Swal from "sweetalert2";
import moment from "moment"
import Order from "@/models/order/order";
import Collection from "@/core/collection";

export default {
  name: "ModalApproveRevenue",
  data() {
    return {
      order: new Order(),
      modalName: 'modal-approve-revenue',
      title: 'Xác nhận doanh thu thực tế',
      rules: {
        content: value => !!value || 'Nội dung bắt buộc nhập.',
      },
      firstFetched: true,
      headers: [
        {text: 'Thời gian thanh toán', value: 'created_at', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số tiền', value: 'payment_amount', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Hình thức', value: 'payment_method', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái giao dịch', value: 'status', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Nhân viên thanh toán', value: 'created_by', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Xác nhận doanh thu', value: 'confirmed_by', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Ghi chú', value: 'note', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tiện ích', value: 'action', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
      ],
      selected: [],
      params: new Filter(this.$route.query),
      orderPayment: new OrderPayment(),
      listData: new Collection(OrderPayment)
    }
  },
  methods: {
    async beforeOpen(event) {
      this.order = _.cloneDeep(event.params.order)
      await this.listAsync()
    },
    beforeClose() {
      //
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async listAsync() {
      try {
        this.loadingStart()
        await this.orderPayment.getListPaymentByOrder(this.order.id).then((result) => {
          if (result) {
            this.listData = result
          }
        })
      } catch (e) {
        this.handleException(e || 'Có lỗi xảy ra')
      }
    },
    formatTime(value) {
      if (!value) {
        return
      }
      return moment(value).format('DD-MM-YYYY HH:mm:ss')
    },
    getNameStatus(status) {
      if (status) {
        return 'Đang hoạt động'
      }
      return 'Ngừng hoạt động'
    },
    getColorStatus(status) {
      if (status) {
        return 'success'
      }
      return 'red'
    },
    copyOrderLadingCode() {
      //navigator.clipboard.writeText(this.order.lading_code);
      navigator.clipboard.writeText("VD123456");
    },
    confirmPayment(item) {
      Swal.fire({
        text: `Bạn có chắc chắn đã nhận số tiền ${item.payment_amount} với đơn hàng ${this.order.code}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          this.confirmConfirmPayment(item.id)
        }
      })
    },

    async confirmConfirmPayment(id) {
      try {
        this.loadingStart()
        await this.orderPayment.confirmPayment(id)
        this.selected = []
        this.messageSuccess('Bạn đã nhận doanh thu thực tế thành công')
        await this.listAsync()
        // await this.paginate(this.page = 1)
        EventBus.$emit('confirm')
      } catch (e) {
        this.handleException(e)
      }
    },
    cancelConfirmPayment(item) {
      let id = item.id
      Swal.fire({
        text: `Bạn có chắc chắn hủy đã nhận ${item.payment_amount} của đơn hàng ${this.order.code}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          this.confirmCancelConfirmMultiPayment(item)
        }
      })
    },
    confirmMultiPayment() {
      if (this.selected.length < 1) {
        return
      }
      let ids = this.selected.pluck('id')
      Swal.fire({
        text: `Bạn có chắc chắn muốn xác nhận doanh thu thực tế đã chọn với đơn hàng ${this.order.code}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          this.confirmConfirmMultiPayment(ids)
        }
      })
    },
    async confirmConfirmMultiPayment(ids = []) {
      if (ids.length < 1) {
        return
      }
      try {
        this.loadingStart()
        await this.orderPayment.confirmMutilPayment({ids: ids})
        this.selected = []
        this.messageSuccess('Bạn đã xác nhận doanh thu thực tế thành công')
        this.listAsync()
        EventBus.$emit('confirm')
      } catch (e) {
        this.handleException(e)
      }
    },
    async confirmCancelConfirmMultiPayment(item) {
      if (! item.receipt_detail) {
        return
      }

      let params = {
        receipt_voucher_id: item.receipt_detail.id
      }

      try {
        this.loadingStart()
        await this.orderPayment.cancelConfirmPayment(params, item.id)
        this.selected = []
        this.messageSuccess('Hủy xác nhận doanh thu thực tế thành công')
        this.listAsync()
        // await this.paginate(this.page = 1)
        EventBus.$emit('cancelConfirm')
      } catch (e) {
        this.handleException(e)
      }
    },
  },
  mounted() {
  },
}
</script>

<style scoped>

</style>