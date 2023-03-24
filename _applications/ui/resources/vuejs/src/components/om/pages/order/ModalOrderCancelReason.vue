<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="40%"
      :minWidth="375"
      height="auto"
      :scrollable="true"
      :clickToClose="false"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <div class="modal-body">
        <div class="d-flex mb-2 align-items-center">
          <h5 class="">{{ title }}</h5>
          <div
            @click="closeModal()"
            class="d-flex cursor-pointer light-blue--text ml-auto align-items-center"
          >
            <span>Trở về</span>
            <v-icon color="#03a9f4">
              mdi-arrow-right-bold
            </v-icon>
          </div>

        </div>
        <v-card outlined class="mb-3 p-3">
          <div>
            <span class="font-weight-bold">Mã đơn hàng:</span>
            <span>{{ order.code }}</span>
          </div>

          <div>
            <span class="font-weight-bold">Trạng thái đơn hàng:</span>
            <span class="font-weight-bold green--text">{{ order.order_status.name }}</span>
          </div>

          <div>
            <span class="font-weight-bold">Vận chuyển bởi:</span>
            <span>Giao hàng tiết kiệm</span>
          </div>
        </v-card>
        <v-card outlined class="p-3">
          <v-row>
            <v-col cols="7" class="">
              <v-text-field
                v-model="params.keyword"
                placeholder="Tìm kiếm mã, nội dung lý do"
                hide-details
                prepend-inner-icon="search"
                outlined
                dense
                @keyup.native.enter="search()"
              >
              </v-text-field>
            </v-col>

            <v-col cols="5" class="d-flex">
              <v-btn
                class="ml-auto"
                color="primary"
                @click="openModalCreate()"
              >
                Thêm mới
              </v-btn>
            </v-col>

          </v-row>

          <v-data-table
            :height="dataList.length > 5 ? '280' : ''"
            no-data-text="Không tồn tại dữ liệu"
            :headers="headers"
            :items="dataList"
            hide-default-footer
            fixed-header
          >
            <template v-slot:item.checked="{ item }">
              <v-checkbox
                v-model="item.checked"
                hide-details
                dense
                @change="selectCancelReason(item, $event)"
              ></v-checkbox>
            </template>
          </v-data-table>
        </v-card>

        <div class="mt-3">
          <v-pagination
            v-show="totalPage > 1"
            class="ml-auto"
            v-model="page"
            circle
            :length="totalPage"
            :total-visible="5"
            @input="paginate(page)"
          ></v-pagination>
        </div>

        <div class="d-flex mt-5">
          <v-btn
            class="ml-auto"
            @click="submit()"
            color="primary"
          >
            Hoàn thành
          </v-btn>
        </div>
      </div>
      <modal-create-order-cancel-reason @store="search()"/>

    </modal>

  </transition>
</template>

<script>
import OrderCancelReason from "@/models/order-cancel-reason/order_cancel_reason";
import Collection from "@/core/collection";
import Order from "@/models/order/order";
import ModalCreateOrderCancelReason from "@/components/om/pages/order-cancel-reason/ModalCreateOrderCancelReason";
import Filter from "@/core/filter";
import Swal from "sweetalert2";

export default {
  name: "ModalOrderCancelReason",
  components: {ModalCreateOrderCancelReason},
  data() {
    return {
      params: new Filter(),
      modalName: 'modal-order-cancel-reason',
      title: 'Lý do hủy đơn',
      selectItem: null,
      order: new Order(),
      page: 1,
      totalPage: 1,
      reason: new OrderCancelReason(),
      dataList: new Collection(OrderCancelReason),
      headers: [
        {text: 'Chọn', value: 'checked', align: 'center', width: 70, sortable: false},
        {text: 'Mã lý do', value: 'code', align: 'center', width: 100, sortable: false},
        {text: 'Nội dung', value: 'content', sortable: false},
      ],
    }
  },
  methods: {
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
      this.page = page
    },
    selectCancelReason(item, event) {
      _.forEach(this.dataList, (i) => {
        if (item.id == i.id) {
          i.checked = event
        } else {
          i.checked = false
        }
      })

      let reason = this.dataList.find(i => i.checked)

      this.selectItem = reason ? reason : null
    },
    openModalCreate() {
      this.$modal.show('modal-create-order-cancel-reason')
    },
    beforeOpen(event) {
      this.order = _.cloneDeep(event.params.order)
    },
    defaultSelect() {
      this.selectItem = null

      _.forEach(this.dataList, (i) => {
        i.checked = false
      })
    },
    beforeClose() {

    },
    closeModal() {
      this.defaultSelect()
      this.$modal.hide(this.modalName)
    },
    submit() {
      if (this.selectItem) {
        Swal.fire({
          title: 'E020002',
          text: `Bạn có chắc chắn muốn hủy đơn hàng ${this.order.code} ?`,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy'
        }).then((result) => {
          if (result.isConfirmed) {
            this.save()
          }
        })
      } else {
        this.messageError('E000003, Lý do hủy đơn bắt buộc chọn ')
      }
    },
    async search() {
      this.defaultSelect()
      this.params.offset = 0
      this.page = 1
      await this.listAsync()
    },
    async save() {
      try {
        await new Order().cancelOrder(this.order.id, {cancel_reason_id: this.selectItem.id})
        this.messageSuccess('Bạn đã hủy đơn hàng thành công')
        this.$emit('cancelOrder')
        this.closeModal()
      } catch (e) {
        this.handleException(e || 'Có lỗi xảy ra vui lòng thử lại')
      }
    },
    async listAsync() {
      try {
        const params = this.params.reduces()
        this.dataList = await this.reason.getListAsync(params)
        this.totalPage = this.dataList.totalPage
      } catch (e) {
        this.handleException(e || 'Lỗi lấy danh sách lý do hủy đơn')
      }
    },
  },
  async created() {
    this.params.limit = 10
    await this.listAsync()
  }
}
</script>