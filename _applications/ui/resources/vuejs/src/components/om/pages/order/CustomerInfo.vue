<template>
  <v-card class="py-5" outlined>
    <div class="px-5">
      <div class="d-flex">
        <h5 class="">Thông tin khách hàng</h5>
        <div class="ml-auto" v-if="order.lead_id">
          Kênh-Sub kênh:
          <span class="light-blue--text ml-1">
          {{ order.lead.sub_channel.name }}
          </span>
        </div>
      </div>
      <v-row class="">
        <v-col cols="5" class="mt-2">
          <div class="d-flex align-items-center ">
            <v-avatar
              color="indigo"
              size="36"
            >
              <v-icon large dark>
                mdi-account-circle
              </v-icon>
            </v-avatar>
            <div class="mx-3 ">
              <div>{{ order.customer_name }}</div>
              <div>{{ order.customer_mobile }}</div>
            </div>
          </div>

        </v-col>
      </v-row>
    </div>
    <v-divider></v-divider>
    <div class="px-5" >
      <div>
        <h5>Địa chỉ giao hàng</h5>
        <span class="d-block">{{ customerAddress.mobile }}</span>
        <span class="d-block">
          {{ customerAddress.address }},
          {{ customerAddress.ward.ward_name }},
          {{ customerAddress.district.district_name }},
          {{ customerAddress.province.province_name }}
        </span>
        <span
          v-if="$route.name == 'om.order.edit'"
          class="cursor-pointer light-blue--text"
          @click="changeAddressShipping()"
        >Thay đổi địa chỉ giao hàng</span>
      </div>
    </div>

  </v-card>
</template>

<script>
import CustomerAddress from "@/models/customer/customer_address";
import Order from "@/models/order/order";
import ModalCreateShippingAddress from "@/components/om/pages/order/ModalCreateShippingAddress";
import Collection from "@/core/collection";

export default {
  props: {
    order: {
      type: Object,
      default: new Order()
    },
    customerAddress: {
      type: Object,
      default: new CustomerAddress()
    },
    listAddressCustomer: {
      type: Array,
      default: new Collection(CustomerAddress)
    },
  },
  name: "CustomerInfo",
  components: {
    ModalCreateShippingAddress
  },
  data() {
    return {

    }
  },
  methods: {
    changeAddressShipping() {
      this.$modal.show('modal-change-shipping-address', {
        customerId: this.order.customer_id,
        listAddress: this.listAddressCustomer
      })
    },

  },
  async mounted() {

  }
}
</script>

<style scoped>

</style>