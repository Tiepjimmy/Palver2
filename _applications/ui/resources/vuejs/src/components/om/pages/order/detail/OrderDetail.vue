<template>
  <div class="om-wp" v-if="firstFetched">
    <order-header
      :order="order"
      @cancelOrder="cancelOrder"
      @editOrder="editOrder"
      @coppyOrder="coppyOrder"
    />

    <v-row>
      <v-col cols="8">
        <v-card outlined class="om-wp p-5">
          <customer-info
            :order="order"
            :customerAddress="customerAddress"
            :listAddressCustomer="listAddressCustomer"
          />

          <order-product-detail
            :order="order"
          />

          <payment-detail
            :order="order"
            @update="fetchData"
          />

          <log-order-status
            :order="order"
            @cancelOrder="cancelOrder"
            @editOrder="editOrder"
            @coppyOrder="coppyOrder"
            @approveOrder="approveOrder"
            @rejectApproveOrder="rejectApproveOrder"
            @shippingSuccess="shippingSuccessOrder"
            @refund="refundOrder"
            @shippingOrder="shippingOrder"
          />

        </v-card>
      </v-col>

      <v-col cols="4">
        <order-info-detail
          :order="order"
          :warehouse="warehouse"
          :subStatuses="subStatuses"
        />
      </v-col>
    </v-row>

    <div class="d-flex mt-3">
      <div class="ml-auto">
        <v-btn
          v-if="order.order_status_id == statusApprove"
          small
          dark
          class="mr-3"
          color="primary"
        >
          Chuyển hàng
        </v-btn>

        <v-btn
          v-if="! order.approved_at"
          small
          dark
          class="mr-3"
          color="primary"
          @click="approveOrder()"
        >
          Duyệt đơn
        </v-btn>
        <v-btn
          small
          dark
          color="primary"
          @click="approveRevenue()"
        >
          Xác nhận doanh thu thực tế
        </v-btn>
      </div>

    </div>
    
    <modal-approve-revenue
      @confirm="confirm"
      @cancelConfirm="cancelConfirm"
      :order="order"
    />

    <modal-order-cancel-reason @cancelOrder="fetchData"/>

    <modal-confirm-shipping @update="confirmShipping"/>
  </div>

</template>

<script>
import OrderStatus from "@/models/order/order_status";
import Collection from "@/core/collection";
import User from "@/models/user/user";
import SubChannel from "@/models/marketing/sub_channel";
import Order from "@/models/order/order";
import CustomerAddress from "@/models/customer/customer_address";
import Warehouse from "@/models/warehouse/warehouse";
import PaymentDetail from "@/components/om/pages/order/edit/PaymentDetail";
import CustomerInfo from "@/components/om/pages/order/CustomerInfo";
import LogOrderStatus from "@/components/om/pages/order/LogOrderStatus";
import OrderProductDetail from "@/components/om/pages/order/detail/OrderProductDetail";
import OrderInfoDetail from "@/components/om/pages/order/detail/OrderInfoDetail";
import ModalApproveRevenue from "@/components/om/pages/order/ModalApproveRevenue";
import OrderHeader from "@/components/om/pages/order/OrderHeader";
import {ORDER_STATUS_APPROVE, ORDER_STATUS_STORE} from "@/config/app";
import Swal from "sweetalert2";
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import ModalOrderCancelReason from "@/components/om/pages/order/ModalOrderCancelReason";
import ModalConfirmShipping from "@/components/om/pages/order/ModalConfirmShipping";

export default {
  name: "DetailOrder",
  components: {
    PaymentDetail,
    CustomerInfo,
    LogOrderStatus,
    OrderProductDetail,
    OrderInfoDetail,
    ModalApproveRevenue,
    OrderHeader,
    ModalOrderCancelReason,
    ModalConfirmShipping
  },
  data() {
    return {
      firstFetched: false,
      statusWaiting: ORDER_STATUS_STORE,
      statusApprove: ORDER_STATUS_APPROVE,
      order: new Order(),
      query: null,
      grandTotal: 0,
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
    shippingOrder() {
      this.$modal.show('modal-confirm-shipping', {ids: [this.order.id]})
    },
    confirmShipping() {
      this.fetchData()
    },
    async shippingSuccessOrder() {
      try {
        await new Order().shippingSuccess(this.order.id)
        this.messageSuccess('Đơn hàng đã được giao thành công')
        this.fetchData()
      } catch (e) {
        this.handleException(e)
      }
    },
    async refundOrder() {
      try {
        await new Order().refund(this.order.id)
        this.messageSuccess('Chuyển hoàn đơn hàng thành công')
        this.fetchData()
      } catch (e) {
        this.handleException(e)
      }
    },
    async rejectApproveOrder() {
      this.fetchData()
    },
    async approveOrder() {
      Swal.fire({
        text: `Bạn có chắc chắn muốn duyệt đơn hàng ${this.order.code}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then(async (result) => {
        if (result.isConfirmed) {
          await this.confirmApproveOrder()
        }
      })
    },
    async confirmApproveOrder() {
      try {
        this.loadingStart()
        await this.order.approveOrder([this.order.id])
        this.messageSuccess('Bạn đã duyệt đơn thành công')
        await this.fetchData()
      } catch (e) {
        this.handleException(e)
      }

    },
    coppyOrder() {
      console.log(this.order.id)
    },
    editOrder() {
      return this.$router.push({name: 'om.order.edit', params: {id: this.order.id}})
    },
    cancelOrder() {
      this.$modal.show('modal-order-cancel-reason', {order: this.order})
    },
    async getCustomerInfo() {
      this.customerAddress.bind(this.order.order_address)

      const params = {
        customer_id: this.order.customer_id,
        store_id: this.order.store_id
      }

      this.listAddressCustomer = await this.customerAddress.getListAsync(params)
    },
    async getListWarehouse() {
      await new Order().listWarehouse().then((result) => {
        this.warehouses.push(...result.data.items)
      })
    },
    async fetchData() {
      try {
        await this.order.loadByIdAsync(this.$route.params.id)
        this.warehouse = this.warehouses.find(i => i.id == this.order.shipping_detail.warehouse_id)
        this.firstFetched = true
      } catch (e) {
        this.handleException('Lỗi lấy thông tin đơn hàng')
      }
    },
    approveRevenue() {
      this.$modal.show('modal-approve-revenue', {order: this.order})
    },
    approve() {},
    confirm() {},
    cancelConfirm() {},
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
  },
  async created() {
    await this.getListWarehouse()
    await this.fetchData()
    await this.getSubStatus()
    await this.getCustomerInfo()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Chi tiết đơn hàng"}]);
  }
}
</script>

<style scoped>

</style>