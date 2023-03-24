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
        <h4 class="m-auto">{{ title }} ({{ ids.length }} đơn)</h4>
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
        <div class="font-size-sm font-weight-bold">
          Nếu chọn kết nối Hãng vận chuyển, vui lòng chuyển hàng dưới 100 đơn 1 lần để hệ thống đảm bảo hoạt động tốt nhất
        </div>

        <v-tabs v-model="tab" fixed-tabs>
          <v-tab>
            <v-icon left>
              far fa-handshake
            </v-icon>
            Đẩy qua hãng vận chuyển
          </v-tab>
          <v-tab>
            <v-icon left>
              fas fa-motorcycle
            </v-icon>
            Tự gọi shipper
          </v-tab>
          <v-tab>
            <v-icon left>
              fas fa-home
            </v-icon>
            Giao tại cửa hàng
          </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab" class="mt-3">
          <v-tab-item>
            <div class="d-flex align-items-center bg-gray-100 om-wp_border-bottom p-3">
              <span class="font-weight-bold">Hãng vận chuyển</span>
              <v-icon class="ml-auto" color="#03a9f4">fas fa-cog</v-icon>
            </div>

            <v-radio-group
              v-model="radioGroup"
              dense
              row
              hide-details
            >
              <v-radio
                class="w-50 mr-0 px-5"
                v-for="(item, index) in listDelivery"
                :key="index"
                :value="item.id"
              >
                <template v-slot:label>
                  <div>
                    <img
                      height="120"
                      :src="item.avatar"
                      :alt="item.name">
                  </div>
                </template>
              </v-radio>
            </v-radio-group>

            <div class="p-3 bg-gray-100">
              <div class="d-flex">
                <span class="font-weight-bold">Tài khoản hãng vận chuyển</span>
                <span class="light-blue--text ml-auto cursor-pointer">Thay đổi nhà vận chuyển</span>
              </div>
              <div class="font-weight-bold green--text">
                Viettel Post
              </div>
              <div>
                <span class="font-weight-bold">ID Tra cứu:</span>
                <span>FC24005-NguyenQuy</span>
              </div>
              <div>
                <span class="font-weight-bold">Mã xác thực:</span>
                <span>a0a2a2d2-0b87-4a18-83f2-2529882be2de</span>
              </div>
            </div>

            <v-row class="align-items-center mt-5">
              <v-col cols="3">
                <label class="font-weight-bold">Kiểm tra hàng</label>
              </v-col>
              <v-col cols="9">
                <v-select
                  v-model="check"
                  :items="checks"
                  item-value="value"
                  item-text="label"
                  dense
                  outlined
                  hide-details
                >
                </v-select>
              </v-col>

              <v-col cols="3">
                <label class="font-weight-bold">Vận chuyển thu tiền hộ</label>
              </v-col>
              <v-col cols="9">
                <v-select
                  v-model="cod"
                  :items="cods"
                  item-value="value"
                  item-text="label"
                  dense
                  outlined
                  hide-details
                >
                </v-select>
              </v-col>

              <v-col cols="3">
                <label class="font-weight-bold">Miễn phí vận chuyển</label>
              </v-col>
              <v-col cols="9">
                <v-select
                  v-model="freeShip"
                  :items="freeShips"
                  item-value="value"
                  item-text="label"
                  dense
                  outlined
                  hide-details
                >
                </v-select>
              </v-col>
              <v-col cols="3">
                <label class="font-weight-bold">Lấy hàng tại điểm</label>
              </v-col>
              <v-col cols="9">
                <v-select
                  v-model="address"
                  :items="addresses"
                  item-value="value"
                  item-text="label"
                  dense
                  outlined
                  hide-details
                >
                </v-select>
              </v-col>

              <v-col cols="3">
                <label class="font-weight-bold">Dịch vụ vận chuyển</label>
              </v-col>
              <v-col cols="9">
                <v-select
                  v-model="service"
                  :items="checks"
                  item-value="value"
                  item-text="label"
                  dense
                  outlined
                  hide-details
                >
                </v-select>
              </v-col>
            </v-row>

            <v-row class="mt-0">
              <v-col cols="3" class="align-self-end">
                <label class="font-weight-bold mb-0">Dịch vụ cộng thêm</label>
              </v-col>
              <v-col cols="9" class="d-flex">
                <div v-for="item in services" class="mr-3">
                  <v-checkbox
                    v-model="seviceIds"
                    :label="item.label"
                    :value="item.value"
                    dense
                    hide-details
                  >
                  </v-checkbox>
                </div>
              </v-col>
            </v-row>
          </v-tab-item>

          <v-tab-item>
          </v-tab-item>

          <v-tab-item>
          </v-tab-item>
        </v-tabs-items>
      </div>
      <footer class="modal-footer">
        <div class="d-flex">
          <div class="ml-auto">
            <v-btn
              class="mr-3"
              color="primary"
              small
              dark
              @click="submit()"
            >Xác nhận chuyển hàng
            </v-btn>
            <v-btn
              dark
              small
              @click="closeModal()"
            >Hủy bỏ
            </v-btn>
          </div>
        </div>
      </footer>
    </modal>
  </transition>
</template>

<script>
import Order from "@/models/order/order";

export default {
  name: "ModalConfirmShipping",
  data() {
    return {
      modalName: 'modal-confirm-shipping',
      title: 'Xác nhận chuyển hàng',
      ids: [],
      tab: null,
      radioGroup: null,
      seviceIds: [],
      listDelivery: [
        {
          id: 1,
          avatar: 'https://donhang.ghn.vn/static/media/Giao_Hang_Nhanh_Toan_Quoc_color.b7d18fe5.png',
          name: 'GHTK'
        },
        {
          id: 2,
          avatar: 'https://donhang.ghn.vn/static/media/Giao_Hang_Nhanh_Toan_Quoc_color.b7d18fe5.png',
          name: 'GHTK'
        },
        {
          id: 3,
          avatar: 'https://donhang.ghn.vn/static/media/Giao_Hang_Nhanh_Toan_Quoc_color.b7d18fe5.png',
          name: 'GHTK'
        },
        {
          id: 4,
          avatar: 'https://donhang.ghn.vn/static/media/Giao_Hang_Nhanh_Toan_Quoc_color.b7d18fe5.png',
          name: 'GHTK'
        }
      ],
      check: 1,
      cod: 1,
      freeShip: 1,
      address: 1,
      service: 1,
      checks: [
        {value: 1, label: 'Cho xem hàng và không cho thử' }
      ],
      cods: [
        {value: 1, label: 'Cho phép thu tiền hộ' }
      ],
      freeShips: [
        {value: 1, label: 'Miễn phí vận chuyển' }
      ],
      addresses: [
        {value: 1, label: 'COD đến lấy hàng' }
      ],
      deliveres: [
        {value: 1, label: 'Dịch vụ vận chuyển' }
      ],
      services: [
        {value: 1, label: 'Bảo hiểm'},
        {value: 2, label: 'Báo phát'},
        {value: 3, label: 'Phát tận tay'},
      ]
    }
  },
  methods: {
    beforeOpen(event) {
      this.ids = event.params.ids
    },
    beforeClose() {

    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async submit() {
      if (this.ids.length < 1) {
        this.messageError('Vui lòng chọn đơn hàng')
      }

      try {
        await new Order().shippingOrder({ids: this.ids})
        this.messageSuccess('Bạn đã xác nhận chuyển hàng thành công')
        this.$emit('updateShipping')
        this.closeModal()
      } catch (e) {

      }
    },
    getListDelivery() {

    },
  },
  created() {
  }
}
</script>

<style scoped>

</style>