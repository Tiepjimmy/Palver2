<template>
  <v-card class="p-5 mt-5" outlined>
    <v-data-table
      class="om-wp_border"
      :headers="headers"
      :items="order.products"
      hide-default-footer
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

      <template v-slot:item.product_price="{item}">
        <div>{{ $helper.formatCurrency(item.product_price, ',') }}</div>
      </template>

      <template v-slot:item.discount_amount="{item}">
        <div>{{ $helper.formatCurrency(item.discount_amount, ',') }}</div>
      </template>

      <template v-slot:item.total="{item}">
        <div>{{ $helper.formatCurrency(item.total, ',') }}</div>
      </template>
    </v-data-table>

    <v-row class="mt-3">
      <v-col cols="6">
        <v-row>
          <v-col cols="3" class="align-self-center pr-0">Phụ thu:</v-col>
          <v-col cols="9">{{ $helper.formatCurrency(order.surcharge, ',') }}</v-col>

          <v-col cols="3" class="align-self-center pr-0">Khai giá:</v-col>
          <v-col cols="9">{{ $helper.formatCurrency(order.insurance, ',') }}</v-col>

          <v-col cols="3" class="align-self-center pr-0">Ghi chú:</v-col>
          <v-col cols="9">{{ getNoteOrder() }}</v-col>
        </v-row>
      </v-col>
      <v-col cols="6" class="pl-5">
        <div class="d-flex ">
          <span>Tổng tiền</span>
          <span class="ml-auto">{{ $helper.formatCurrency(order.sub_total, ',') }}</span>
        </div>
        <div class="d-flex mt-4">
          <span class="light-blue--text cursor-pointer">Chiết khấu</span>
          <span class="ml-auto">{{ $helper.formatCurrency(getDiscountAmount(), ',') }}</span>
        </div>
        <div class="d-flex mt-4">
          <span class="light-blue--text cursor-pointer">Phí giao hàng</span>
          <span class="ml-auto">{{ $helper.formatCurrency(order.shipping_amount, ',') }}</span>
        </div>
        <div class="d-flex mt-4 font-weight-bold">
          <span class="">Khách phải trả</span>
          <span class="ml-auto">{{ $helper.formatCurrency(Math.round(order.grand_total), ',') }}</span>
        </div>
        <div class="d-flex mt-4">
        </div>
      </v-col>
    </v-row>

  </v-card>
</template>

<script>
import Order from "@/models/order/order";
import {NoteTypeOrder} from "@/helpers/enums";

export default {
  name: "OrderProductDetail",
  props: {
    order: {
      type: Object,
      default: new Order()
    }
  },
  components: {
  },
  data() {
    return {
      headers: [
        {text: 'Mã SP', value: 'product_code',  align: 'center', width: '100', sortable: false},
        {text: 'Tên hiển thị', value: 'product_name', width: '150' ,align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Đơn vị', value: 'product_unit', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Đơn giá', value: 'product_price', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Giảm giá', value: 'discount_amount', width: '150', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số lượng', value: 'quantity', width: '100', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Thành tiền', value: 'total', width: '150', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
      ],
    }

  },
  methods: {
    getDiscountAmount() {
      let discount = 0
      if (this.order.discount_type == 'cash') {
        discount = this.order.discount_amount
      } else {
        discount = Math.round(this.order.sub_total * this.order.discount_amount / 100)
      }

      return discount
    },
    getDiscountType() {
      if (this.order.products.length > 0) {
        let products = this.order.products

        return products[0].discount_type
      }

    },
    getNoteOrder() {
      let note = this.order.notes.find(i => i.type == NoteTypeOrder.Order)

      if (note) {
        return note.note
      }

      return
    },
  },
  async created() {
  },
  mounted() {
  }

}
</script>

<style scoped>

</style>