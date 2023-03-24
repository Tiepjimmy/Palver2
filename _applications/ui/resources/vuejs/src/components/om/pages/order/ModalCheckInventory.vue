<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="75%"
      :minWidth="375"
      height="auto"
      :scrollable="true"
      :clickToClose="false"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <header class="modal-header flex align-items-center">
        <h4 class="mr-5">{{ title }}</h4>

        <v-select
          style="max-width: 400px"
          no-data-text="không tìm thấy dữ liệu"
          v-model="inventory_id"
          :items="listInventory"
          placeholder="Chọn kho"
          dense
          outlined
          hide-details
          @change="search()"
        >
        </v-select>
        <v-btn
          class="ml-auto"
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
        <div>
          <v-data-table
            class="om-wp_border"
            no-data-text="Không tồn tại dữ liệu"
            :headers="headers"
            :items="dataList"
            hide-default-footer
            :items-per-page="params.limit"
          >
          </v-data-table>
        </div>

      </div>

    </modal>
  </transition>
</template>

<script>

import Collection from "@/core/collection";
import Filter from "@/core/filter";

export default {
  name: 'ModalCheckInventory',
  data() {
    return {
      params: new Filter(),
      inventory_id: null,
      modalName: 'modal-check-inventory',
      title: 'Kiểm tra thông tin tồn kho',
      dataList: new Collection(Object),
      listInventory: new Collection(Object),
      headers: [
        {text: 'Mã sản phẩm', value: 'product_cd', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Tên hiển thị', value: 'name',  align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Tồn kho khả dụng', value: 'lot', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Tồn kho thực tế', value: 'expiry', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Lô - Hạn sử dụng', value: 'lot', align: 'center', sortable: false},
      ],

    }
  },
  methods: {
    beforeOpen(event) {

    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async search() {
      this.params.offset = 0
      await this.fetchData()
    },
    async fetchData() {
      const params = this.params.reduces()
      try {
        this.loadingStart()
      } catch (e) {
        this.handleException()
      } finally {
        this.loadingClose()
      }
    },
    async save() {
      this.closeModal()
    }
  },
  mounted() {

  },
  async created() {
    await this.fetchData()
  }

}
</script>