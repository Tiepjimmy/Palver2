<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="30%"
      :minWidth="375"
      height="auto"
      :scrollable="true"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <header class="modal-header flex">
        <h4 class="">{{ title }}</h4>
        <span class="ml-auto cursor-pointer light-blue--text" @click="openModalCreate()">Thêm địa chỉ mới</span>
      </header>
      <div
        class="modal-body p-0 pb-5"
      >
        <div
          v-for="(item, index) in dataList"
          :key="index"
        >
          <v-divider class="my-0" v-if="index > 0"></v-divider>
          <div class="om-wp_hover px-5 pt-5">
            <div @click="changeAdressShipping(item)">
              <span>{{ item.mobile }}</span> <br>
              <span>
              {{ item.address }},
              {{ item.ward.ward_name }},
              {{ item.district.district_name }},
              {{ item.province.province_name }}
            </span>
            </div>
            <span class="cursor-pointer light-blue--text" @click="openModalEdit(item)">Sửa</span>
          </div>
        </div>
      </div>
      <modal-edit-shipping-address @update="update" />
    </modal>
  </transition>


</template>

<script>

import Collection from "@/core/collection";
import ModalEditShippingAddress from "@/components/om/pages/order/ModalEditShippingAddress";
import CustomerAddress from "@/models/customer/customer_address";

export default {
  name: 'ModalChangeShippingAddress',
  components: {ModalEditShippingAddress},
  data() {
    return {
      customerId: null,
      customerMobile: null,
      modalName: 'modal-change-shipping-address',
      title: 'Thay đổi địa chỉ',
      customerAddress: new CustomerAddress(),
      dataList: new Collection(Object),
    }
  },
  methods: {
    update(data) {
      const item = this.dataList.find(i => i.id == data.id)

      if (item) {
        item.bind(data)
      }
    },
    openModalEdit(item) {
      this.$modal.show('modal-edit-shipping-address', {address: item})
    },
    openModalCreate() {
      this.$modal.show('modal-create-shipping-address', {
        customerId: this.customerId,
        customerMobile: this.customerMobile
      })
    },
    changeAdressShipping(item) {
      this.$emit('updateAddressShipping', item)
      this.closeModal()
    },
    async beforeOpen(event) {
      this.dataList = _.cloneDeep(event.params.listAddress)
      this.customerId = event.params.customerId
      this.customerMobile = event.params.customerMobile

      if (this.dataList.length < 1) {
        await this.fetchData(this.customerId)
      }
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async store(id) {
      await this.fetchData(id)
      this.$emit('loadAddress', this.dataList)
    },
    async fetchData(customerId) {
      try {
        this.loadingStart()

        this.dataList = await this.customerAddress.getListAsync({customer_id: customerId, store_id: 1})
      } catch (e) {
        this.handleException()
      } finally {
        this.loadingClose()
      }
    },
  },
  mounted() {

  },
  async created() {
  }

}
</script>