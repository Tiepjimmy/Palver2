<template>
  <div class="px-5">
    <v-checkbox
      label="Bảo hiểm hàng hóa"
      v-model="cargoInsurance"
      hide-details
    >

    </v-checkbox>

    <v-row class="om-wp_border mt-3 px-2">
      <v-col cols="12" class="pb-0">
        <h5>Chi phí vận chuyển ước tính của các gói cước</h5>
      </v-col>
      <v-col cols="3">
        <div class="om-wp_border h-100 align-items-center d-flex justify-content-center">
          <h4>TUHA_V2</h4>
        </div>
      </v-col>
      <v-col cols="9">
        <v-data-table
          class="om-wp_border"
          no-data-text="Không tồn tại dữ liệu"
          :headers="headers"
          :items="listShipping"
          hide-default-footer
        >
          <template v-slot:item.action="{item}">
            <v-checkbox
              v-model="item.checked"
              class="checkbox-table"
              hide-details
              @change="selectShippingAmount(item, $event)"
            ></v-checkbox>
          </template>

          <template v-slot:item.time="{item}">
            <div>{{ item.time }} ngày</div>
          </template>

          <template v-slot:item.shipping_amount="{item}">
            <div>{{ $helper.formatCurrency(item.shipping_amount, ',') }}</div>
          </template>
        </v-data-table>
      </v-col>

    </v-row>

    <v-row class="om-wp_border mt-7 px-2">
      <v-col cols="12" class="pb-0">
        <h5>Tiền thu hộ</h5>
      </v-col>
      <v-col cols="6">
        <v-row class="align-items-center">
          <v-col cols="3">Tiền đơn hàng</v-col>
          <v-col cols="7">
            <v-input-currency
              class="text-right-input"
              v-model="total"
              :hideDetails="true"
              :readonly="true"
              :background="'#ededed'"
            />
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="6">
        <v-row class="align-items-center">
          <v-col cols="3">Tiền phí ship</v-col>
          <v-col cols="7">
            <v-input-currency
              class="text-right-input"
              v-model="shippingAmount"
              :hideDetails="true"
              :readonly="true"
              :background="'#ededed'"
            />
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Collection from "@/core/collection";
import Order from "@/models/order/order";
import {EventBus} from "@/core/plugins/event_bus";
import VInputCurrency from "@/components/om/widgets/VInputCurrency";

export default {
  name: "TabCarrier",
  props: {
    order: {
      type: Object,
      default: new Order()
    },
  },
  components: {VInputCurrency},
  data() {
    return {
      total: 0,
      shippingAmount: 0,
      cargoInsurance: null,
      listShipping: new Collection(Object, [
        {id: 1, name: 'VNpost', time: '1-2', shipping_amount: 15000, checked: false},
        {id: 2, name: 'Nhanh.vn', time: '2-4', shipping_amount: 12000, checked: false},
        {id: 3, name: 'GHN', time: '1-2', shipping_amount: 10000, checked: false},
        {id: 4, name: 'J & T', time: '1-2', shipping_amount: 17000, checked: false},
      ]),
      headers: [
        {text: '', value: 'action',  align: 'center', width: '50', sortable: false},
        {text: 'Đối tác', value: 'name', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Thời gian dự kiến', value: 'time', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Phí dự kiến', value: 'shipping_amount', width: '100', align: 'center', sortable: false},
      ],
    }
  },
  methods: {
    selectShippingAmount(item, event) {
      _.forEach(this.listShipping, (i) => {
        if (item.id == i.id) {
          i.checked = event
        } else {
          i.checked = false
        }
      })

      let checked = this.listShipping.find(i => i.checked)

      if (! checked) {
        this.shippingAmount = 0
      } else {
        this.shippingAmount = item.shipping_amount
      }

      let data = {
        deliveryId: item.id,
        shippingAmount: this.shippingAmount
      }

      EventBus.$emit('changeShippingAmountByDelivery', data)
    },
    handleTotalOrder() {
      this.shippingAmount = this.order.shipping_amount
      this.total = Number(this.order.sub_total) + Number(this.order.surcharge) - Number(this.order.discount_amount)

      _.forEach(this.listShipping, (i) => {
        if (this.order.delivered_user_id == i.id) {
          i.checked = true
        } else {
          i.checked = false
        }
      })
    }
  },
  created() {
    EventBus.$on('updateShippingAmountByDelivery', this.handleTotalOrder)
  }

}
</script>

<style scoped>

</style>