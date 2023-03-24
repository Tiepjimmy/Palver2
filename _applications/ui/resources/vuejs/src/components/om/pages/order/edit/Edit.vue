<template>
  <div class="om-wp" v-if="firsFetched">
    <order-header
      :order="order"
    />

    <v-row>
      <v-col cols="8">
        <v-card outlined class="om-wp p-5">
          <customer-info
            :order="order"
            :customerAddress="customerAddress"
            :listAddressCustomer="listAddressCustomer"
            @updateAddressShipping="updateAddressShipping"
          />

          <order-info
            :order="order"
            :customerAddress="customerAddress"
            @orderInfoUpdate="orderInfoUpdate"
          />

          <payment-detail
            :order="order"
          />

          <log-order-status
            :order="order"
          />

        </v-card>
      </v-col>

      <v-col cols="4">
        <order-info-edit
          :subStatuses="subStatuses"
          :order="order"
          :warehouse="warehouse"
          :warehouses="warehouses"
          :listUser="listUser"
          @changeWarehouse="changeWarehouse"
          @changeOrderCode="changeOrderCode"
          @changeUserCreateLead="changeUserCreateLead"
          @changeUserUpsale="changeUserUpsale"
          @changeSubStatus="changeSubStatus"
        />
      </v-col>
    </v-row>

    <div class="d-flex mt-3">
      <v-btn
        class="ml-auto"
        color="primary"
        @click="submit">
        Lưu</v-btn>
    </div>

    <modal-change-shipping-address
      @updateAddressShipping="updateAddressShipping"
    />

    <modal-create-shipping-address
      ref="changeAddress"
      @store="createAddress"
    />
  </div>

</template>

<script>
import Collection from "@/core/collection";
import {mapGetters} from "vuex";
import User from "@/models/user/user";
import SubChannel from "@/models/marketing/sub_channel";
import Order from "@/models/order/order";
import OrderInfo from "@/components/om/pages/order/OrderInfo";
import PaymentDetail from "@/components/om/pages/order/edit/PaymentDetail";
import {EventBus} from "@/core/plugins/event_bus";
import CustomerAddress from "@/models/customer/customer_address";
import Lead from "@/models/marketing/leads";
import CustomerInfo from "@/components/om/pages/order/CustomerInfo";
import Warehouse from "@/models/warehouse/warehouse";
import ModalCreateShippingAddress from "@/components/om/pages/order/ModalCreateShippingAddress";
import OrderInfoEdit from "@/components/om/pages/order/edit/OrderInfoEdit";
import LogOrderStatus from "@/components/om/pages/order/LogOrderStatus";
import moment from "moment";
import OrderHeader from "@/components/om/pages/order/OrderHeader";
import ModalChangeShippingAddress from "@/components/om/pages/order/ModalChangeShippingAddress";
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import OrderStatus from "@/models/order/order_status";

export default {
  name: "EditOrder",
  components: {
    OrderInfo,
    PaymentDetail,
    CustomerInfo,
    OrderInfoEdit,
    ModalCreateShippingAddress,
    LogOrderStatus,
    OrderHeader,
    ModalChangeShippingAddress
  },
  data() {
    return {
      oldWarehouseId: null,
      firsFetched: false,
      order: new Order(),
      query: null,
      grandTotal: 0,
      lead: new Lead(),
      listUser: new Collection(User),
      listSubChannel: new Collection(SubChannel),
      customerAddress: new CustomerAddress(),
      listAddressCustomer: new Collection(CustomerAddress),
      warehouse: new Warehouse(),
      warehouses: new Collection(Warehouse),
      orderStatus: new OrderStatus(),
      subStatuses: new Collection(OrderStatus)
    }
  },
  methods: {
    printOrder() {

    },
    formatTime(time) {
      if (time) {
        return moment(time).format('DD-MM-YYYY HH:mm')
      }

      return
    },
    changeWarehouse(data) {
      this.order.warehouse_id = data
      this.warehouse = this.warehouses.find(i => i.id == this.order.warehouse_id)
      EventBus.$emit('getWarehouse', this.warehouse)
    },
    changeOrderCode(data) {
      this.order.code = data
    },
    changeUserCreateLead(data) {
      this.order.user_created_lead_id = data
    },
    changeUserUpsale(data) {
      this.order.upsale_user_id = data
    },
    changeSubStatus(data) {
      this.order.sub_status_id = data
    },
    async createAddress(data) {
       await this.$refs.changeAddress.fetchData(this.order.customer_id)
    },
    updateAddressShipping(data) {
      this.customerAddress = data
      this.order.customer_address_id = data.id
    },
    orderInfoUpdate(data) {
      this.order.products = data.products
      this.order.discount_amount = data.discount_amount
      this.order.shipping_amount = data.shipping_amount
      this.order.insurance = data.insurance
      this.order.surcharge = data.surcharge
      this.order.notes = data.notes
      this.order.sub_total = data.subTotal
      this.order.grand_total = data.grandTotal
      this.order.delivered_user_id = data.deliveryId
      this.order.order_product_delete = data.delProdutcs

      if (! data.isLoaded) {
        EventBus.$emit('updateShippingAmountByDelivery', this.order)
      }
    },
    changeCodeOrder(data) {
      this.order.code = data
    },
    checkDataRequest() {
      this.order.created_by = this.user.id
      let orderData = this.order.reduces(false)

      delete orderData.user_created
      delete orderData.user_upsale
      delete orderData.detail
      delete orderData.sub_total
      delete orderData.grand_total

      if (! orderData.payment.payment_method_id) {
        delete orderData.payment
      }

      if (orderData.payments) {
        delete orderData.payments
      }

      if (orderData.address) {
        delete orderData.address
      }

      if (orderData.lead) {
        delete orderData.lead
      }

      if (this.oldWarehouseId == orderData.warehouse_id) {
        delete orderData.warehouse_id
      }

      return orderData
    },
    checkValidate(order) {
      if (! order.products) {
        this.messageError('Vui lòng chọn sản phẩm')
        return false
      }

      return true
    },
    async submit() {
      const orderData = this.checkDataRequest()

      if (! this.checkValidate(orderData)) {
        return
      }

      try {
        this.loadingStart()
        await this.order.updateAsync(orderData, orderData.id)
        this.messageSuccess('Đơn hàng đã được cập nhật thành công')
        return this.$router.push({name: 'om.order.detail', params: {id: this.order.id}})
      } catch (e) {
        this.handleException(e)
      }
    },
    store() {

    },
    changeAddressShipping() {
      this.$modal.show('modal-change-shipping-address', {
        customerId: this.order.customer_id,
        customerMobile: this.order.customer_mobile
      })
    },
    async getCustomerInfo() {
      this.customerAddress.bind(this.order.order_address)

      const params = {
        customer_id: this.order.customer_id,
        store_id: 1
      }

      this.listAddressCustomer = await new CustomerAddress().getListAsync(params)
    },
    async fetchData() {
      try {
        await this.order.loadByIdAsync(this.$route.params.id)
        this.order.warehouse_id = this.order.shipping_detail.warehouse_id
        this.oldWarehouseId = this.order.shipping_detail.warehouse_id
        this.warehouse = this.warehouses.find(i => i.id == this.order.shipping_detail.warehouse_id)
        this.firsFetched = true
      } catch (e) {
        this.handleException('Lỗi lấy thông tin đơn hàng')
      }
    },
    async loadConfig() {
      this.subChannelState.then((result) => {
        this.listSubChannel.push(...result)
      })

      this.userState.then((result) => {
        this.listUser.push(...result.items)
      })
    },
    async getListWarehouse() {
      await new Order().listWarehouse().then((result) => {
        this.warehouses.push(...result.data.items)
      })
    },
    selectWarehouse(value) {
      this.warehouse = this.warehouses.find(i => i.id == value)
    },
    async getLead(id) {
      await this.lead.loadById(id).then((result) => {
        if (result) {
          this.order.lead_id = result.id
          this.order.customer_name = result.name
          this.order.customer_mobile = result.mobile
          this.order.customer_email = result.email
          this.order.sub_channel_id = result.sub_channel_id
        }
      })
    },
    async getSubStatus() {
      try {
        await this.orderStatus.getSubStatusOrder(this.order.id).then((result) => {
          this.subStatuses = result
        })
      } catch (e) {
        this.handleException(e)
      }
    }
  },
  computed: {
    ...mapGetters({
      subChannelState: 'marketing/subChannels',
      userState: 'marketing/userRoleMarketing',
    }),
  },
  async created() {
    await this.loadConfig()
    await this.getListWarehouse()
    await this.fetchData()
    await this.getSubStatus()
    EventBus.$emit('getWarehouse', this.warehouse)
    await this.getCustomerInfo()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Chỉnh sửa đơn hàng"}]);
  }
}
</script>

<style scoped>

</style>