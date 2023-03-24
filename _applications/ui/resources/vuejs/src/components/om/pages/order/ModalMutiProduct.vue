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
        <v-text-field
          class="mb-3"
          v-model="params.name"
          dense
          outlined
          hide-details
          prepend-inner-icon="fas fa-search"
          placeholder="Tìm kiếm sản phẩm"
        ></v-text-field>
        <v-data-table
          v-model="selected"
          no-data-text="Không tồn tại dữ liệu"
          :headers="headers"
          :items="dataList"
          hide-default-footer
          :items-per-page="params.limit"
          show-select
        >
          <template v-slot:item.avatar="{ item }">
            <div>

            </div>
          </template>
          <template v-slot:item.about="{ item }">
            <div class="d-flex align-items-center">
              <img width="50" height="50" :src="item.product_avatar" alt="">
              <div class="ml-2 flex">
                <div>{{ item.product_cd }}</div>
                <div>{{ item.product_name }}</div>
                <b-form-select
                  v-model="item.lot_id"
                  class="mb-1"
                  size="sm"
                  @change="changeExpirydate(item)"
                >
                  <b-form-select-option
                    v-for="(i, index) in item.stocks"
                    :key="index"
                    :value="i.lot_id"
                  >
                    {{i.lot_expired_date}} - {{i.lot_name}}
                  </b-form-select-option>
                </b-form-select>
              </div>

            </div>
          </template>
          <template v-slot:item.price="{ item }">
            <div>{{ $helper.formatCurrency(item.product_price, ',') }}</div>
          </template>
        </v-data-table>
        <div class="py-3 d-flex align-items-center">
          <div class="ml-3">Tổng số: <b>{{ dataList.length }}</b></div>
          <v-pagination
            v-if="totalPage > 1"
            class="ml-auto"
            v-model="page"
            circle
            :length="totalPage"
            :total-visible="6"
            @input="paginate(page)"
          ></v-pagination>
        </div>
      </div>
      <footer class="modal-footer">
        <div class="d-flex">
          <v-btn class="ml-auto mr-3" @click="cancel()">Hủy bỏ</v-btn>
          <v-btn dark class="primary" @click="save()">Thêm vào đơn</v-btn>
        </div>
      </footer>
    </modal>
  </transition>
</template>

<script>

import Collection from "@/core/collection";
import Filter from "@/core/filter";
import Order from "@/models/order/order";

export default {
  name: 'ModalMultiProduct',
  props: ['totalPrice'],
  data() {
    return {
      params: new Filter(),
      selected: [],
      total: 0,
      page: 1,
      totalPage: 1,
      modalName: 'modal-multi-product',
      title: 'Chọn nhiều sản phẩm',
      dataList: new Collection(Object),
      products: new Collection(Object),
      headers: [
        {text: 'Thông tin sản phẩm', value: 'about', width: '220', align: 'center', sortable: false},
        {text: 'Giá bán lẻ', value: 'price',  align: 'center', sortable: false},
        {text: 'Tồn kho khả dụng', value: 'quantity_available', align: 'center', sortable: false},
        {text: 'Tồn kho thực tế', value: 'quantity_really', align: 'center', sortable: false},
      ],

    }
  },
  methods: {
    changeExpirydate(item) {
      let stock = item.stocks.find(i => i.lot_id == item.lot_id)

      item.quantity_available = stock.quantity_available
      item.quantity_really = stock.quantity_really
    },
    beforeOpen(event) {

    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
      this.selected = []
    },
    async paginate(page) {
      this.params.page = page
      await this.fetchData()
      this.page = page
    },
    cancel() {
      this.closeModal()
    },
    async search() {
      this.page = 1
      this.params.offset = 0
      this.selected = []
      await this.fetchData()
    },
    async fetchData() {
      const params = Object.assign({store_id: 1}, this.params.reduces())
      try {
        this.loadingStart()
        new Order().getListProduct(params).then((result) => {
          if (result.data) {
            _.forEach(result.data.items, (i) => {
              let product = {
                id: i.id,
                product_name: i.product_name,
                product_cd: i.product_cd,
                product_avatar: i.product_entity_avatar,
                product_price: i.price.prices,
                unit: i.unit,
                sku: i.sku,
                stocks: i.stocks,
                quantity_available: i.stocks[0].quantity_available,
                quantity_really: i.stocks[0].quantity_really,
                lot_id:  i.stocks[0].lot_id
              }

              this.dataList.push(product)
            })

            this.total = result.data.total
            this.totalPage = result.data.total_page;
          }
        })

      } catch (e) {
        this.handleException()
      } finally {
        this.loadingClose()
      }
    },
    async save() {
      this.$emit('selectMultiProduct', this.selected)
      this.closeModal()
    }
  },
  mounted() {

  },
  async created() {
    this.params.limit = 5
    await this.fetchData()
  }

}
</script>
<style lang="scss">

</style>