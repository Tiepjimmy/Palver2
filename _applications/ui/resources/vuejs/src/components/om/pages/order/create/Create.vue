<template>
  <v-card class="om-wp p-5">
    <div class="d-flex">
      <h4>Tạo đơn hàng</h4>
    </div>

    <v-card class="py-5" outlined>
      <div class="px-5">
        <h5 class="">Thông tin khách hàng</h5>
        <v-row class="">
          <v-col cols="5" class="py-0">
            <div v-if="! order.customer_id">
              <label>&nbsp;</label>
              <v-autocomplete
                v-model="order.customer_id"
                :items="customers"
                item-value="id"
                item-text="name"
                no-data-text="Không có dữ liệu"
                outlined
                dense
                placeholder="Tìm kiếm khách hàng"
                @keypress="listCustomer"
                @change="selectCustomer()"
              >
                <template v-slot:prepend-item>
                  <v-list-item
                    ripple
                    @mousedown.prevent
                    @click="openModalCreateCustomer()"
                  >
                    <v-list-item-content>
                      <v-list-item-title>
                        <div class="d-flex align-items-center">
                          <v-avatar
                            color="#ededed"
                            size="25"
                          >
                            <v-icon dark>
                              mdi-account-circle
                            </v-icon>
                          </v-avatar>
                          <div class="ml-2 ">
                            Thêm mới khách hàng
                          </div>
                        </div>

                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </template>
                <template v-slot:item="{ item }">
                  <div class="d-flex align-items-center">
                    <v-avatar
                      color="indigo"
                      size="25"
                    >
                      <v-icon dark>
                        mdi-account-circle
                      </v-icon>
                    </v-avatar>
                    <div class="ml-2 ">
                      <div>{{ item.name }}</div>
                      <div class="text-dark-50">{{ item.mobile }}</div>
                    </div>
                  </div>
                </template>
              </v-autocomplete>
            </div>
            <div v-if="order.customer_id">
              <div class="d-flex align-items-center mt-3 ">
                <v-avatar
                  color="indigo"
                  size="40"
                >
                  <v-icon dark large>
                    mdi-account-circle
                  </v-icon>
                </v-avatar>
                <div class="mx-3 ">
                  <div>{{ order.customer_name }}</div>
                  <div>{{ order.customer_mobile }}</div>
                </div>
                <div class="">
                  <v-btn icon @click="clearCustomer()">
                    <v-icon>
                      fas fa-times
                    </v-icon>
                  </v-btn>
                  <v-btn
                    v-if="order.customer_id"
                    icon
                    @click="openModalEditCustomer()">
                    <v-icon>
                      fas fa-edit
                    </v-icon>
                  </v-btn>
                </div>
              </div>

              <div class="mt-5">
                <h5>Địa chỉ giao hàng</h5>
                <div v-if="order.customer_address_id">
                  <div>{{ customerAddress.mobile }}</div>
                  <div>
                    {{ customerAddress.address }},
                    {{ customerAddress.ward.ward_name }},
                    {{ customerAddress.district.district_name }},
                    {{ customerAddress.province.province_name }}
                  </div>
                  <span class="cursor-pointer light-blue--text mt-2" @click="changeAddressShipping()">Thay đổi địa chỉ giao hàng</span>
                </div>

                <span
                  v-else
                  class="cursor-pointer light-blue--text"
                  @click="createAddressShipping()">
                  Thêm mới địa chỉ giao hàng
                </span>
              </div>
            </div>

          </v-col>

          <v-col :cols="7" class="">
            <v-row>
              <v-col cols="6" class="py-0">
                <label>Chính sách giá</label>
                <v-select
                  append-icon=""
                  v-model="policy"
                  :items="policys"
                  item-value="value"
                  item-text="label"
                  outlined
                  dense
                  disabled
                  background-color="#ededed"
                ></v-select>
              </v-col>

              <v-col cols="6" class="py-0">
                <label>Người tạo số</label>
                <v-select
                  append-icon=""
                  v-model="order.user_created_lead_id"
                  :items="listUser"
                  item-value="id"
                  item-text="full_name"
                  placeholder="Người tạo số"
                  outlined
                  dense
                  disabled
                  background-color="#ededed"
                ></v-select>
              </v-col>

              <v-col cols="6" class="py-0">
                <label>Kênh - Sub kênh</label>
                <v-select
                  append-icon=""
                  v-model="order.sub_channel_id"
                  :items="listSubChannel"
                  item-value="id"
                  item-text="name"
                  placeholder="Kênh-Sub kênh"
                  outlined
                  dense
                  disabled
                  background-color="#ededed"
                ></v-select>
              </v-col>

              <v-col cols="6" class="py-0">
                <label>Người Up Sale</label>
                <v-select
                  v-model="order.upsale_user_id"
                  :items="listUser"
                  item-value="id"
                  item-text="full_name"
                  placeholder="Người up sale"
                  outlined
                  dense
                ></v-select>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </div>
    </v-card>

    <order-info
      :customer="customer"
      :order="order"
      :customerAddress="customerAddress"
      @changeCode="changeCodeOrder"
      @orderInfoUpdate="orderInfoUpdate"
    />

    <payment-confirm
      :grandTotal="order.grand_total"
      @updatePayment="updatePayment"
    />

    <packing-and-delivery :order="order" />

    <div class="d-flex mt-3">
      <v-btn
        class="ml-auto"
        color="primary"
        @click="submit()"
      >
        Tạo đơn và duyệt
      </v-btn>
    </div>

    <modal-create-customer @storeCustomer="storeCustomer"/>
    <modal-edit-customer @updateCustomer="updateCusomter"/>
    <modal-change-shipping-address
      ref="changeAddress"
      @loadAddress="loadAddress"
      @updateAddressShipping="updateAddressShipping"/>
    <modal-create-shipping-address
      @store="createAddress"
      @createCustomer="updateCustomer"
      @firstAddress="firstAddressCustomer"
    />

  </v-card>
</template>

<script>
import Customer from "@/models/customer/customer";
import Collection from "@/core/collection";
import ModalCreateCustomer from "@/components/om/pages/customer/ModalCreateCustomer";
import ModalEditCustomer from "@/components/om/pages/customer/ModalEditCustomer";
import {mapGetters} from "vuex";
import User from "@/models/user/user";
import SubChannel from "@/models/marketing/sub_channel";
import Order from "@/models/order/order";
import OrderInfo from "@/components/om/pages/order/OrderInfo";
import PaymentConfirm from "@/components/om/pages/order/create/PaymentConfirm";
import PackingAndDelivery from "@/components/om/pages/order/PackingAndDelivery";
import {EventBus} from "@/core/plugins/event_bus";
import ModalChangeShippingAddress from "@/components/om/pages/order/ModalChangeShippingAddress";
import CustomerAddress from "@/models/customer/customer_address";
import Lead from "@/models/marketing/leads";
import ModalCreateShippingAddress from "@/components/om/pages/order/ModalCreateShippingAddress";
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";

export default {
  name: "CreateOrder",
  components: {
    ModalCreateCustomer,
    ModalEditCustomer,
    OrderInfo,
    PaymentConfirm,
    PackingAndDelivery,
    ModalChangeShippingAddress,
    ModalCreateShippingAddress
  },
  data() {
    return {
      listAddressCustomer: new Collection(CustomerAddress),
      customerAddress: new CustomerAddress(),
      singleProducts: new Collection(Object),
      comboProducts: new Collection(Object),
      order: new Order(),
      query: null,
      grandTotal: 0,
      lead: new Lead(),
      customer: new Customer(),
      customers: new Collection(Customer),
      listUser: new Collection(User),
      listSubChannel: new Collection(SubChannel),
      policy: 1,
      policys: [
        {value: 1, label: 'Giá bán lẻ'},
        {value: 2, label: 'Giá bán buôn'}
      ],
    }
  },
  methods: {
    createAddress(data) {
      this.$refs.changeAddress.store(this.order.customer_id)
    },
    loadAddress(data) {
      this.listAddressCustomer = data
    },
    firstAddressCustomer(data) {
      this.getCustomerInfo()
    },
    updateCustomer(data) {
      this.customer.bind(data)
      this.order.customer_id = data.id
      this.getCustomerInfo()
    },
    createAddressShipping() {
      this.$modal.show('modal-create-shipping-address', {
        first: true,
        customerId: this.customer.id,
        customerMobile: this.customer.mobile
      })
    },
    updateAddressShipping(data) {
      this.customerAddress = data
      this.order.customer_address_id = this.customerAddress.id
    },
    updatePayment(data) {
      this.order.payment = data
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

      if (! data.isLoaded) {
        EventBus.$emit('updateShippingAmountByDelivery', this.order)
      }
    },
    changeCodeOrder(data) {
      this.order.code = data
    },
    async updateCusomter(data) {
      this.customer.bind(data)
      this.order.customer_name = this.customer.name
      this.order.customer_mobile = this.customer.mobile
      this.order.customer_email = this.customer.email
    },
    checkDataRequest() {
      this.order.created_by = this.user.id
      let orderData = this.order.reduces(false)

      delete orderData.lead
      delete orderData.user_created
      delete orderData.user_upsale
      delete orderData.detail
      delete orderData.sub_total
      delete orderData.grand_total
      delete orderData.address

      if (! orderData.payment.payment_method_id) {
        delete orderData.payment
      }

      return orderData
    },
    checkValidate(order) {
      if (! order.customer_id) {
        this.messageError('Vui lòng chọn khách hàng')
        return false
      }

      if (! order.customer_address_id) {
        this.messageError('Vui lòng nhập địa chỉ giao hàng')
        return false
      }

      if (! order.warehouse_id) {
        this.messageError('Vui lòng chọn kho')
        return false
      }

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
        await this.order.storeAsync(orderData)
        this.messageSuccess('Đơn hàng đã được tạo thành công')
        return this.$router.push({name: 'om.order.detail', params: {id: this.order.id}})
      } catch (e) {
        this.handleException(e)
      }
    },
    storeCustomer() {
      this.listCustomer()
    },
    changeAddressShipping() {
      this.$modal.show('modal-change-shipping-address', {
        customerId: this.order.customer_id,
        listAddress: this.listAddressCustomer,
        customerMobile: this.order.customer_mobile
      })
    },
    clearCustomer() {
      this.order.customer_id = null
      this.order.customer_name = null
      this.order.customer_mobile = null
      this.customer = new Customer()
    },
    openModalCreateCustomer() {
      this.$modal.show('modal-create-customer')
    },
    openModalEditCustomer() {
      this.$modal.show('modal-edit-customer', {customer: this.customer})
    },
    async selectCustomer() {
      this.customer = this.customers.find(i => i.id == this.order.customer_id)
      await this.getCustomerInfo()

    },
    async getCustomerInfo() {
      this.order.customer_id = this.customer.id
      this.order.customer_name = this.customer.name
      this.order.customer_mobile = this.customer.mobile
      this.order.customer_email = this.customer.email
      // this.order.sub_channel_id = this.customer.sub_channel_id

      const params = {
        customer_id: this.order.customer_id,
        store_id: 1
      }

      this.listAddressCustomer = await new CustomerAddress().getListAsync(params)

      if (this.listAddressCustomer.length > 0) {
        this.customerAddress = this.listAddressCustomer[0]
        this.order.customer_address_id = this.customerAddress.id
      } else {
        this.customerAddress = new CustomerAddress()
        this.order.customer_address_id = null
      }
    },
    async listCustomer() {
        this.customers = await new Customer().getListAsync({store_id: 1, limit: 10, offset: 0})
    },
    filterCustomer(e) {
      let value = e.target._value
      setTimeout(async() => {
        this.customers = await this.customer.getListAsync({s: value})
      }, 700)
    },
    async loadConfig() {
      this.subChannelState.then((result) => {
        this.listSubChannel.push(...result)
      })

      this.userState.then((result) => {
        this.listUser.push(...result.items)
      })
    },
    async getLead(id) {
      await this.lead.loadById(id)
      this.order.lead_id = this.lead.id
      this.order.sub_channel_id = this.lead.sub_channel_id
      this.order.user_created_lead_id = this.lead.created_by
    }
  },
  computed: {
    ...mapGetters({
      subChannelState: 'marketing/subChannels',
      userState: 'marketing/userRoleMarketing',
    }),
  },
  watch: {
    query: function (value) {
      if (!value) {
        return
      }

      setTimeout(() => {
        this.selectCustomer(value)
      }, 700)
    }
  },
  async created() {
    if (this.$route.query.lead_id) {
      await this.getLead(this.$route.query.lead_id)
    }
    await this.loadConfig()
    await this.listCustomer()

  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Tạo đơn hàng"}]);
  }
}
</script>

<style scoped>

</style>