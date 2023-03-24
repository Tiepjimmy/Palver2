<template>
  <div class="p-5 om-wp">
    <div
      class="om-wp_border-top om-wp_border-right om-wp_border-left
             w-fit-content rounded-t-sm bg-white px-3 py-1">
      Chi tiết đơn hàng
    </div>
    <div class="d-flex flex-row align-items-stretch">
      <div class="border bg-white">
        <v-data-table
          class="om-wp_border-bottom table-order-detail"
          :headers="headers"
          :items="order.products"
          fixed-header
          hide-default-footer
          :items-per-page="limit"
          no-data-text="Không tồn tại dữ liệu"
          item-key="id"
        >
          <template v-slot:header.discount_amount="{ header }">
            <div class="d-flex">
              <v-btn
                x-small
                depressed
                class="mr-1"
                :color="getDiscountType() == 'cash' ? 'primary' : ''"
              >
                Giảm giá
              </v-btn>
              <v-btn
                x-small
                depressed
                :color="getDiscountType() != 'cash' ? 'primary' : ''"
              >
                Giảm còn
              </v-btn>
            </div>
          </template>

          <template v-slot:item.index="{ index }">
            <div class="mr-2">{{ index + 1 }}</div>
          </template>

          <template v-slot:item.created_at="{ item }">
            <div>{{ formatTime(item) }}</div>
          </template>

          <template v-slot:item.discount_amount="{ item }">
            <div>{{ $helper.formatCurrency(item.discount_amount, ',') }}</div>
          </template>

          <template v-slot:item.product_price="{ item }">
            <div>{{ $helper.formatCurrency(item.product_price, ',') }}</div>
          </template>

          <template v-slot:item.total="{ item }">
            <div>{{ $helper.formatCurrency(item.total, ',') }}</div>
          </template>
        </v-data-table>

        <div class="d-flex px-3 pt-2">
          <div>
            <span><b>Ghi chú: </b> {{ getNoteOrder() }}</span>
          </div>

          <div class="cost ml-auto">
            <div class="d-flex">
              <span>Tổng tiền</span>
              <span class="ml-auto">{{ $helper.formatCurrency(order.sub_total, ',') }}</span>
            </div>
            <v-divider class="mt-0"></v-divider>
            <div class="d-flex">
              <span>Chiết khấu</span>
              <span class="ml-auto">{{ $helper.formatCurrency(order.discount_amount, ',') }}</span>
            </div>
            <v-divider class="mt-0"></v-divider>
            <div class="d-flex">
              <span>Phí vận chuyển</span>
              <span class="ml-auto">{{ $helper.formatCurrency(order.shipping_amount, ',') }}</span>
            </div>
            <v-divider class="mt-0"></v-divider>
            <div class="d-flex">
              <b>Khách phải trả</b>
              <b class="ml-auto">{{ $helper.formatCurrency(order.grand_total, ',') }}</b>
            </div>
          </div>
        </div>

        <div class="pl-3 pb-3 cursor-pointer w-fit-content light-blue--text" @click="hideDetail()" >
          <v-icon small color="#03a9f4">
            fas fa-angle-double-up
          </v-icon>
          <span>Thu gọn</span>
        </div>
      </div>
      <div class="ml-3 p-3 border bg-white" style="min-width: 300px">
        <div><b>{{ order.customer_name }}</b></div>
        <div><b>SĐT:</b> <span class="ml-5">{{ order.customer_mobile }}</span></div>
        <div><b>Địa chỉ:</b> <span class="ml-5">
          {{ order.order_address.address }},
          {{ order.order_address.ward.ward_name }},
          {{ order.order_address.district.district_name }},
          {{ order.order_address.province.province_name }}
        </span></div>
        <div class="d-flex mt-5">
          <v-btn class="mr-2" color="primary" small @click="printOrder()">In</v-btn>
          <v-btn class="mr-2" color="primary" small @click="viewOrder()">Chi tiết</v-btn>
          <v-btn class="mr-2" color="primary" small @click="editOrder()">Sửa</v-btn>
          <v-btn class="mr-2" color="primary" small @click="cancelOrder()">Hủy Đơn</v-btn>
        </div>
      </div>


    </div>

  </div>

</template>

<script>
import Order from "@/models/order/order";
import {NoteTypeOrder} from "@/helpers/enums";

export default {
  name: "Detail",
  props: {
    order: {
      type: Object,
      default: new Order()
    }
  },
  data() {
    return {
      limit: 10,
      headers: [
        {text: 'STT', value: 'index', align: 'center', width: '50', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Mã sản phẩm', value: 'product_code',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Tên hiển thị', value: 'product_name',  align: 'center', width: '150', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Đơn vị', value: 'product_unit', align: 'center', width: '50', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Giá bán', value: 'product_price', align: 'center', width: '120', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Giảm giá', value: 'discount_amount', align: 'center', width: '120', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Số lượng', value: 'quantity', align: 'center', width: '50', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Thành tiền', value: 'total', align: 'center', width: '120', sortable: false},
      ],
    }
  },
  methods: {
    getDiscountType() {
      let products = this.order.products

      return products[0].discount_type
    },
    getNoteOrder() {
      let note = this.order.notes.find(i => i.type == NoteTypeOrder.Order)

      if (note) {
        return note.note
      }

      return
    },
    hideDetail() {
      this.$emit('hideDetail')
    },
    printOrder() {
      this.$emit('printOrder', this.order)
    },
    viewOrder() {
      return this.$router.push({name: 'om.order.detail', params: {id: this.order.id}})
    },
    editOrder() {
      return this.$router.push({name: 'om.order.edit', params: {id: this.order.id}})
    },
    cancelOrder() {
      this.$modal.show('modal-order-cancel-reason', {order: this.order})
    },

  }
}
</script>

<style scoped>
.cost {
  min-width: 250px;
}
</style>