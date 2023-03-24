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
        <v-row>
          <v-col cols="6">
            <div>
              <h5>Địa chỉ lấy hàng</h5>
              <div>
                {{ warehouse.address }},
                {{ warehouse.ward.ward_name}},
                {{ warehouse.district.district_name}},
                {{ warehouse.province.province_name}}
              </div>
            </div>

            <div class="mt-5">
              <h5>Địa chỉ giao hàng</h5>
              <span class="d-block">{{ customerAddress.mobile }}</span>
              <div>
                {{ customerAddress.address }},
                {{ customerAddress.ward.ward_name}},
                {{ customerAddress.district.district_name}},
                {{ customerAddress.province.province_name}}
              </div>
            </div>

            <span
              class="cursor-pointer light-blue--text"
              @click="changeAddressShipping()">
              Thay đổi địa chỉ giao hàng
            </span>

            <v-row class="mt-5">
              <v-col cols="12">
                <h5>Thông tin lấy hàng</h5>
              </v-col>
              <v-col cols="3" class="align-self-center">Tiền thu hộ</v-col>
              <v-col cols="9">
                <v-input-currency
                  v-model="total"
                  class="text-right-input"
                  outlined
                  disabled
                  dense
                  hide-details
                ></v-input-currency>
              </v-col>

              <v-col cols="3" class="align-self-center">Khối lượng (g)</v-col>
              <v-col cols="9">
                <v-text-field
                  v-model="weight"
                  class="text-right-input"
                  outlined
                  disabled
                  dense
                  hide-details
                ></v-text-field>
              </v-col>
            </v-row>
          </v-col>

          <v-col cols="6">
            <h5>Phí dự kiến đối tác vận chuyển</h5>
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
      </div>
      <footer class="modal-footer">
        <div class="d-flex">
          <v-btn class="ml-auto mr-3" @click="closeModal()">Hủy bỏ</v-btn>
          <v-btn dark class="primary" @click="save()">Áp dụng</v-btn>
        </div>
      </footer>
    </modal>
  </transition>
</template>

<script>

import Collection from "@/core/collection";
import {EventBus} from "@/core/plugins/event_bus";
import VInputCurrency from "@/components/om/widgets/VInputCurrency";
import Warehouse from "@/models/warehouse/warehouse";
import CustomerAddress from "@/models/customer/customer_address";
import Order from "@/models/order/order";

export default {
  name: "ModalShippingOrder",
  props: {
    customerAddress: {
      type: Object,
      default: new CustomerAddress()
    }
  },
  components: {
    VInputCurrency
  },
  data() {
    return {
      deliveryId: null,
      total: 0,
      weight: 1,
      subTotal: 0,
      surcharge: 0,
      discount: 0,
      modalName: 'modal-shipping-order',
      title: 'Thêm phí vận chuyển',
      shippingAmount: 0,
      warehouse: new Warehouse(),
      order: new Order(),
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
    beforeOpen(event) {
      this.subTotal = event.params.subTotal
      this.surcharge = event.params.surcharge
      this.discount = event.params.discount
      this.warehouse = event.params.warehouse
      this.order = event.params.order
      // this.weight = event.params.weight

      this.total = this.subTotal + this.surcharge - this.discount + this.shippingAmount
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    save(isLoaded = false) {
      let data = {
        deliveryId: this.deliveryId,
        shippingAmount: this.shippingAmount,
        isLoaded: isLoaded
      }

      this.$emit('updateShippingOrder', data)
      this.closeModal()
    },
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
        this.deliveryId = null
      } else {
        this.deliveryId = item.id
        this.shippingAmount = item.shipping_amount
      }

      this.total = Number(this.subTotal) + Number(this.surcharge) + Number(item.shipping_amount) - Number(this.discount)
    },
    changeAddressShipping() {
      this.$modal.show('modal-change-shipping-address', {
        customerId: this.order.customer_id,
        customerMobile: this.order.customer_mobile,
        listAddress: []
      })
    },
    updateShippingAmount(data) {
      if (!data) {
        return
      }

      this.deliveryId = data.deliveryId
      this.shippingAmount = data.shippingAmount
      this.total = this.subTotal + this.surcharge + this.shippingAmount - this.discount

      _.forEach(this.listShipping, (i) => {
        if (this.deliveryId == i.id) {
          i.checked = true
        } else {
          i.checked = false
        }
      })

      this.save(true)
    }
  },
  created() {
    EventBus.$on('changeShippingAmountByDelivery', (data) => {
      this.updateShippingAmount(data)
    })
  }

}
</script>

<style scoped>

</style>