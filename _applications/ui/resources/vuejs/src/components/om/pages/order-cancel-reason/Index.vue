<template>
  <v-card class="om-wp px-5">
    <v-row class="mt-5">
      <v-col cols="6" sm="4" md="4" lg="4" xl="3">
        <div class="d-flex flex-column h-100">
          <v-text-field
              class="flex-basis"
              v-model="params.keyword"
              dense
              outlined
              hide-details
              placeholder="Tìm kiếm mã, nội dung lý do"
              @keyup.enter.native="search()"
          >
          </v-text-field>
        </div>
      </v-col>
    </v-row>

    <div class="my-5 d-flex">
      <v-btn
          class="ml-auto"
          dark small
          color="success"
          @click="openModalCreate()"
      >
        Thêm mới
      </v-btn>
    </div>

    <v-data-table
        class="om-wp_border-left om-wp_border-top om-wp_border-bottom"
        :headers="headers"
        :items="dataList"
        no-data-text="Không tồn tại dữ liệu"
        :items-per-page="params.limit"
        hide-default-footer
        item-key="name"
    >
      <template v-slot:item.action="{ item }">
        <v-icon
            class="cursor-pointer"
            small
            color="darken-2"
            @click="openModalEdit(item)"
        >
          fas fa-edit
        </v-icon>

        <v-icon
            class="cursor-pointer"
            color="darken-2"
            @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
      <template v-slot:item.order="{ item, index }">
        <span>{{ ((params.p - 1) * params.limit) + index + 1 }}</span>
      </template>
      <template v-slot:item.active="{ item }">
        <v-icon
            v-if="item.is_active"
            color="darken-2"
        >
          done
        </v-icon>
      </template>
    </v-data-table>

    <div class="py-3 d-flex align-items-center">
      <b-form-select
          class="om-wp-list-number ml-5"
          v-model="params.limit"
          :options="options"
          size="sm"
          @change="search()"
      ></b-form-select>

      <div class="ml-3">Tổng số: <b>{{ total }}</b></div>

      <v-pagination
          v-show="totalPage > 1"
          class="ml-auto"
          v-model="params.p"
          circle
          :length="totalPage"
          :total-visible="5"
          @input="paginate(params.p)"
      ></v-pagination>
    </div>

    <modal-create-order-cancel-reason
        @store="store"
    />

    <modal-edit-order-cancel-reason
        @update="update"
    />
  </v-card>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import OrderCancelReason from "@/models/order-cancel-reason/order_cancel_reason";
import ModalCreateOrderCancelReason from "@/components/om/pages/order-cancel-reason/ModalCreateOrderCancelReason";
import ModalEditOrderCancelReason from "@/components/om/pages/order-cancel-reason/ModalEditOrderCancelReason";
import Swal from "sweetalert2";

export default {
  name: "OrderCancelReason",
  components: {
    ModalCreateOrderCancelReason,
    ModalEditOrderCancelReason
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(this.$route.query),
      orderCancelReason: new OrderCancelReason(),
      dataList: new Collection(OrderCancelReason),
      total: 0,
      page: 1,
      totalPage: 1,
      headers: [
        {text: 'Tiện ích', value: 'action', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'STT', value: 'order', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Mã lý do', value: 'code', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Nội dung', value: 'content', align: 'left', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Hiệu lực', value: 'active', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'}
      ],
      options: [10, 20, 30]
    }
  },
  methods: {
    async store() {
      this.params.p = 1
      this.page = 1;
      await this.paginate(1)
    },
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
    },
    async update() {
      this.params.p = 1
      this.page = 1;
      await this.paginate(1)
    },
    openModalCreate() {
      this.$modal.show('modal-create-order-cancel-reason', {})
    },
    openModalEdit(item) {
      this.$modal.show('modal-edit-order-cancel-reason', {
        orderCancelReason: item
      })
    },
    async submit() {
      if (this.$refs.form.validate()){
        try {
          this.loadingStart()
          this.messageSuccess('Bạn đã tạo lý do hủy đơn thành công')
          this.params.p = 1
          this.page = 1;
          await this.paginate(1)
        } catch (e) {
          this.handleException(e)
        }
      }
    },
    async search() {
      this.params.p = 1
      this.params.offset = (this.params.p - 1) * this.params.limit;
      await this.listAsync()
    },
    async listAsync() {
      try {
        const params = this.params.reduces()
        this.loadingStart()
        this.dataList = await this.orderCancelReason.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    },
    deleteItem(item) {
      if (! item.id) {
        return
      }
      Swal.fire({
        text: `Bạn có chắc chắn muốn xóa lý do "${item.content}" ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          this.confirmDelete(item.id)
        }
      })
    },
    async confirmDelete(id) {
      try {
        this.loadingStart()
        await this.orderCancelReason.deleteAsync(id)
        this.messageSuccess('Bạn đã xóa lý do hủy đơn thành công')
        this.params.p = 1
        this.page = 1;
        await this.paginate(1)
      } catch (e) {
        this.handleException(e)
      }
    }
  },
  async created() {
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Danh sách lý do hủy đơn"}]);
  },
}
</script>

<style lang="scss">

</style>