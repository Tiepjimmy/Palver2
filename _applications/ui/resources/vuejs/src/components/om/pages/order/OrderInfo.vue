<template>
  <v-card class="p-5 mt-5" outlined>
    <h5 v-if="$route.name == 'om.order.create'">Thông tin đơn hàng</h5>
    <v-row class="mt-3" v-if="$route.name == 'om.order.create'">
      <v-col cols="3" class="py-0">
        <label>Mã đơn hàng</label>
        <v-text-field
          v-model="orderCode"
          dense
          outlined
          maxlength="25"
          @input="changeCodeOrder()"
        ></v-text-field>
      </v-col>
      <v-col cols="3" class="py-0">
        <label>Kho</label>
        <v-select
          v-model="order.warehouse_id"
          :items="warehouses"
          item-text="warehouse_name"
          item-value="id"
          dense
          outlined
          @change="selectWarehouse()"
        ></v-select>
      </v-col>
      <v-col cols="6" class="py-0">
        <label>Địa chỉ lấy hàng</label>
        <div class="mt-3" v-if="order.warehouse_id">
          {{ warehouse.address }},
          {{ warehouse.province.province_name}},
          {{ warehouse.district.district_name}},
          {{ warehouse.ward.ward_name}}
        </div>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" class="pt-0">
        <v-btn
          small
          color="warning"
          @click="checkInventory()"
        >Kiểm tra tồn kho
        </v-btn>
      </v-col>
      <v-col cols="6" class="py-0">
        <div class="d-flex">
          <v-autocomplete
            class="mr-3"
            :items="singleProducts"
            item-value="id"
            item-text="product_name"
            no-data-text="Không có dữ liệu"
            outlined
            dense
            placeholder="Chọn sản phẩm đơn"
          >

            <template v-slot:item="{ item }">
              <v-list-item
                @mousedown.prevent
                @click="selectProduct(item)"
              >
                <div class="w-100">
                  <div class="d-flex align-items-center ">
                    <v-avatar
                      size="30"
                    >
                      <img
                        :src="item.product_avatar"
                        :alt="item.product_name"
                      >
                    </v-avatar>
                    <div class="ml-2 ">
                      <div>{{ item.product_name }}</div>
                      <div>{{ item.product_cd }}</div>
                    </div>
                    <div class="ml-auto text-right">
                      <div>{{ $helper.formatCurrency(item.product_price, ',') }}</div>
                      <div>{{ item.sku }}</div>
                    </div>
                  </div>
                  <v-divider class="my-1"></v-divider>
                </div>
              </v-list-item>

            </template>
          </v-autocomplete>
          <v-btn
            class="btn-input-dense"
            color="primary"
            @click="openModalMultiProduct()"
          >
            Chọn nhiều
          </v-btn>
        </div>
      </v-col>

      <v-col cols="6" class="py-0">
        <div class="d-flex">
          <v-autocomplete
            class="mr-3"
            :items="comboProducts"
            item-value="id"
            item-text="product_name"
            no-data-text="Không có dữ liệu"
            outlined
            dense
            disabled
            append-icon=""
            placeholder="Chọn sản phẩm combo"
            @change="selectComboProduct()"
          >
            <template v-slot:item="{ item }">
              <div class="d-flex align-items-center">
                <v-avatar
                  size="25"
                >
                  <img
                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                    alt="John"
                  >
                </v-avatar>
                <div class="ml-2 ">
                  <div>{{ item.name }}</div>
                  <div class="text-dark-50">{{ item.mobile }}</div>
                </div>
              </div>
            </template>
          </v-autocomplete>
          <v-btn
            class="btn-input-dense"
            color="primary"
            disabled
            @click="openModalMultiComboProduct()"
          >Chọn nhiều
          </v-btn>
        </div>
      </v-col>
    </v-row>

    <v-data-table
      class="om-wp_border"
      no-data-text="Không tồn tại dữ liệu"
      :headers="headers"
      :items="dataList"
      hide-default-footer
    >
      <template v-slot:header.discount_amount="{ header }">
        <div class="d-flex">
          <v-btn
            x-small
            @click="changeActionDiscount('cash')"
            class="mr-1"
            :color="discountTypeProduct == 'cash' ? 'primary' : ''"
          >
            Giảm giá
          </v-btn>
          <v-btn
            x-small
            @click="changeActionDiscount('percent')"
            :color="discountTypeProduct != 'cash' ? 'primary' : ''"
          >
            Giảm còn
          </v-btn>
        </div>
      </template>
      <template v-slot:item.product_price="{item}">
        <div>{{ $helper.formatCurrency(item.product_price, ',') }}</div>
      </template>

      <template v-slot:item.quantity="{ item }">
        <div>
          <b-form-input
            v-model="item.quantity"
            size="sm"
            type="number"
            minlength="1"
            min="1"
            @input="changeQuantity(item)"
          ></b-form-input>
        </div>
      </template>
      <template v-slot:item.discount_amount="{ item }">
        <div>
          <b-form-input
            v-model="item.discount_amount"
            size="sm"
            :max="item.maxDiscount"
            @keypress="handleInputNumber"
            @input="changeDiscount(item)"
          ></b-form-input>
        </div>
      </template>

      <template v-slot:item.total="{item}">
        <div>{{ $helper.formatCurrency(item.total, ',') }}</div>
      </template>

      <template v-slot:item.delete="{item, index}">
        <v-icon
          class="cursor-pointer"
          color="darken-2"
          @click="deleteOrderItem(index, item)"
        >
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>

    <v-row class="mt-3">
      <v-col cols="7" class="pr-30">
        <v-row>
          <v-col cols="3" class="align-self-center pr-0">Phụ thu</v-col>
          <v-col cols="9">
            <v-input-currency
              class="text-right-input"
              v-model="surcharge"
              :placeholder="'Phụ thu'"
              :hideDetails="true"
              @input="handleTotalPriceOrder(false)"
            />
          </v-col>
          <v-col cols="3" class="align-self-center pr-0">Khai giá</v-col>
          <v-col cols="9">
            <v-input-currency
              class="text-right-input"
              v-model="insurance"
              :hideDetails="true"
            />
          </v-col>
          <v-col cols="12">
            <label>Ghi chú</label>
            <v-textarea
              v-model="noteOrder"
              outlined
              hide-details
              rows="2"
              @input="updateNoteOrder()"
            >

            </v-textarea>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="5" class="pl-5" style="display: grid">
        <div class="d-flex mt-4">
          <span>Tổng tiền</span>
          <span class="ml-auto">{{ $helper.formatCurrency(subTotal, ',') }}</span>
        </div>
        <div class="d-flex mt-4">
          <span class="light-blue--text cursor-pointer" @click="openModalDiscountOrder()">Chiết khấu</span>
          <span class="ml-auto">{{ $helper.formatCurrency(discountOrder, ',') }}</span>
        </div>
        <div class="d-flex mt-4">
          <span class="light-blue--text cursor-pointer" @click="openModalShippingOrder()">Phí giao hàng</span>
          <span class="ml-auto">{{ $helper.formatCurrency(shippingAmount, ',') }}</span>
        </div>
        <div class="d-flex mt-4 font-weight-bold">
          <span class="">Khách phải trả</span>
          <span class="ml-auto">{{ $helper.formatCurrency(grandTotal, ',') }}</span>
        </div>
        <div class="d-flex mt-4">
          <v-btn
            color="warning"
            class="ml-auto"
            @click="acceptPromotion()"
          >
            Áp dụng khuyến mãi
          </v-btn>
        </div>
      </v-col>
    </v-row>

    <modal-discount-order
      @updateDiscountOrder="updateDiscountOrder"
    />

    <modal-muti-product
      @selectMultiProduct="selectMultiProduct"
    />

    <modal-shipping-order
      :customerAddress="customerAddress"
      @updateShippingOrder="updateShippingOrder"
    />

    <modal-check-inventory />

  </v-card>
</template>

<script>
import Collection from "@/core/collection";
import Warehouse from "@/models/warehouse/warehouse";
import OrderProduct from "@/models/order/order_product";
import ModalDiscountOrder from "@/components/om/pages/order/ModalDiscountOrder";
import ModalMutiProduct from "@/components/om/pages/order/ModalMutiProduct";
import ModalShippingOrder from "@/components/om/pages/order/ModalShippingOrder";
import OrderNote from "@/models/order/order_note";
import VInputCurrency from "@/components/om/widgets/VInputCurrency";
import Order from "@/models/order/order";
import ModalCheckInventory from "@/components/om/pages/order/ModalCheckInventory";
import {NoteTypeOrder} from "@/helpers/enums";
import CustomerAddress from "@/models/customer/customer_address";
import {EventBus} from "@/core/plugins/event_bus";

export default {
  name: "OrderInfo",
  props: {
    order: {
      type: Object,
      default: new Order()
    },
    customerAddress: {
      type: Object,
      default: new CustomerAddress()
    }
  },
  components: {
    ModalDiscountOrder,
    ModalMutiProduct,
    ModalShippingOrder,
    VInputCurrency,
    ModalCheckInventory
  },
  data() {
    return {
      delProducts: [],
      surcharge: 0,
      insurance: 0,
      grandTotal: 0,
      subTotal: 0,
      discount: 0,
      discountOrder: 0,
      shippingAmount: 0,
      isLoaded: false,
      noteDiscount: null,
      discountTypeProduct: 'cash',
      orderCode: null,
      noteOrder: null,
      warehouseId: null,
      deliveryId: null,
      singleProducts: new Collection(Object),
      comboProducts: new Collection(Object),
      warehouse: new Warehouse(),
      dataList: new Collection(OrderProduct),
      notes: new Collection(OrderNote),
      warehouses: new Collection(Warehouse),
      headers: [
        {text: 'Mã SP', value: 'product_code',  align: 'center', width: '100', sortable: false},
        {text: 'Tên hiển thị', value: 'product_name', align: 'center', width: '150', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Đơn vị', value: 'product_unit', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Đơn giá', value: 'product_price', align: 'center', width: '150', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Giảm giá', value: 'discount_amount', width: '150', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số lượng', value: 'quantity', width: '100', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Thành tiền', value: 'total', align: 'center', width: '150', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: '', value: 'delete', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
      ],
    }

  },
  methods: {
    updateNoteOrder() {
      const note = this.notes.find(i => i.type == NoteTypeOrder.Order)

      if (this.noteOrder) {
        if (! note) {
          this.notes.push({
            type: NoteTypeOrder.Order,
            note: this.noteOrder
          })
        } else {
          this.notes = this.notes.filter((i) => {
            if (i.type == NoteTypeOrder.Order) {
              return i.note = this.noteOrder
            } else {
              return i
            }
          })
        }

      } else {
        const index = this.notes.indexOf(this.noteOrder)
        if (index >= 0) this.notes.splice(index, 1)

        this.notes.splice(index, 1)
      }

      this.updateOrderInfo()
    },
    handleInputNumber(evt) {
      evt = (evt) ? evt : window.event;
      let expect = evt.target.value.toString() + evt.key.toString();

      if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    changeCodeOrder() {
      this.$emit('changeCode', this.orderCode)
    },
    updateShippingOrder(data) {
      this.shippingAmount = data.shippingAmount
      this.deliveryId = data.deliveryId
      this.isLoaded = data.isLoaded
      this.handleTotalPriceOrder(this.isLoaded)
    },
    openModalShippingOrder() {
      if (this.order.products.length < 1 || ! this.order.customer_id) {
        return
      }

      this.$modal.show('modal-shipping-order', {
        subTotal: Number(this.subTotal),
        surcharge: Number(this.surcharge),
        discount: Number(this.discountOrder),
        warehouse: this.warehouse,
        order: this.order,
        weigth: 1
      })
    },
    openModalDiscountOrder() {
      if (this.order.products.length < 1 || ! this.order.customer_id) {
        return
      }

      this.$modal.show('modal-discount-order', {
        discount: this.discount,
        notes: this.notes,
        subTotal: this.subTotal,
        discountType: this.order.discount_type
      })
    },
    updateDiscountOrder(data) {
      this.discount = data.discount
      this.order.discount_type = data.discountType

      const note = this.notes.find(i => i.type == NoteTypeOrder.Discount)

      if (data.note) {
        if (! note) {
          this.notes.push({
            type: NoteTypeOrder.Discount,
            note: data.note
          })
        } else {
          this.notes = this.notes.filter((i) => {
            if (i.type == NoteTypeOrder.Discount) {
              return i.note = data.note
            } else {
              return i
            }
          })
        }
      } else {
        const index = this.notes.indexOf(data.note)
        if (index >= 0) this.notes.splice(index, 1)

        this.notes.splice(index, 1)
      }

      this.handleTotalPriceOrder()
    },
    changeActionDiscount(discount = 'cash') {
      this.discountTypeProduct = discount

      this.dataList.forEach(i => {
        i.discount_type = this.discountTypeProduct
        i.discount_amount = 0
        if (this.discountTypeProduct == 'cash') {
          i.total = Number(i.product_price) * Number(i.quantity)
        } else {
          i.total = 0
        }
      })

      this.handleTotalOrder()
    },
    handleTotalOrdeItem(item) {
      item.maxDiscount = item.product_price
      item.discount_type = this.discountTypeProduct

      if (this.discountTypeProduct == 'cash') {
        item.total = (item.product_price - Number(item.discount_amount)) * Number(item.quantity)
      } else {
        item.total = Number(item.discount_amount) * Number(item.quantity)
      }

      if (item.discount_amount > item.product_price) {
        item.discount_amount = item.maxDiscount
        item.total = 0
      }

      this.handleTotalOrder()
    },
    handleTotalOrder() {
      this.subTotal = _.sumBy(this.dataList, 'total')
      this.handleTotalPriceOrder()
    },
    handleTotalPriceOrder(isLoaded = false) {
      if (this.order.discount_type == 'percent') {
        this.discountOrder = Math.round(Number(this.subTotal) * Number(this.discount) / 100)
      } else {
        this.discountOrder = Number(this.discount)
      }

      this.grandTotal = Number(this.subTotal) - Number(this.discountOrder) + Number(this.surcharge) + Number(this.shippingAmount)

      if (! isLoaded) {
        this.isLoaded = false
      }

      this.updateOrderInfo()
    },
    updateOrderInfo() {
      let data = {
        products: this.dataList,
        discount_amount: this.discount,
        shipping_amount: this.shippingAmount,
        surcharge: this.surcharge,
        notes: this.notes,
        insurance: this.insurance,
        subTotal: this.subTotal,
        grandTotal: this.grandTotal,
        deliveryId: this.deliveryId,
        isLoaded: this.isLoaded,
        delProdutcs: this.delProducts
      }

      this.$emit('orderInfoUpdate', data)
    },
    changeDiscount(item) {

      if (item.discount_amount == '' || item.discount_amount < 0) {
        item.discount_amount = 0
      }

      this.handleTotalOrdeItem(item)
    },
    changeQuantity(item) {
      if (item.quantity < 1 || ! item.quantity) {
        item.quantity = 1
      }

      this.handleTotalOrdeItem(item)
    },
    deleteOrderItem(index, item) {
      if (item.id) {
        this.delProducts.push(item.id)
      }

      this.dataList.splice(index, 1)
      this.handleTotalOrder()
    },
    checkInventory() {
      // this.$modal.show('modal-check-inventory')
    },
    selectMultiProduct(data) {
      _.forEach(data, (item) => {
        this.selectProduct(item)
      })
    },
    selectProduct(item) {
      let checkDuplicate = this.dataList.find(i => i.product_id == item.id)

      if (checkDuplicate) {
        checkDuplicate.quantity += 1
      } else {
        const OrderProduct = {
          product_id: item.id,
          product_code: item.product_cd,
          product_name: item.product_name,
          quantity: 1,
          product_unit: item.unit,
          discount_amount: 0,
          product_price: item.product_price,
          total: this.discountTypeProduct == 'cash' ? item.product_price : 0,
          lot_id: item.lot_id
        }

        this.dataList.push(OrderProduct)
      }

      this.changeActionDiscount(this.discountTypeProduct)
    },
    openModalMultiProduct() {
      this.$modal.show('modal-multi-product')
    },
    selectComboProduct() {

    },
    openModalMultiComboProduct() {

    },
    async getListWarehouse() {
      new Order().listWarehouse().then((result) => {
        this.warehouses.push(...result.data.items)
      })
    },
    selectWarehouse() {
      this.warehouse = this.warehouses.find(i => i.id == this.order.warehouse_id)
    },
    acceptPromotion() {

    },
    getSingleProducts() {
      new Order().getListProduct({store_id: 1}).then((result) => {
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
              quantity_available: i.stocks[0]?.quantity_available,
              quantity_really: i.stocks[0]?.quantity_really,
              lot_id: i.stocks[0]?.lot_id
            }

            this.singleProducts.push(product)
          })
        }
      })
    }
  },
  async created() {
    EventBus.$on('getWarehouse', (data) => {
      this.warehouse = data
    })
    this.getSingleProducts()
    await this.getListWarehouse()
  },
  mounted() {
    if (this.order.customer_id) {
      this.dataList = this.order.products
      this.shippingAmount = this.order.shipping_amount
      this.surcharge = this.order.surcharge
      this.notes = this.order.notes
      this.insurance = this.order.insurance
      this.subTotal = this.order.sub_total
      this.grandTotal = this.order.grand_total
      this.discountType = this.order.discount_type
      this.discountTypeProduct = this.dataList[0].discount_type
      this.discount = this.order.discount_amount

      if (this.discountType == 'percent') {
        this.discountOrder = this.subTotal * this.order.discount_amount / 100
      } else {
        this.discountOrder = this.order.discount_amount
      }

      let note = this.notes.find(i => i.type = NoteTypeOrder.Order)

      if (note) {
        this.noteOrder = note.note
      }
    }

  }

}
</script>

<style scoped>

</style>