<template>
  <v-card class="om-wp px-5">
    <div class="my-5 d-flex">
      <b-form-select
        class="om-wp-list-number mt-5"
        v-model="params.per_page"
        :options="options"
        size="sm"
        @change="search()"
      ></b-form-select>

      <v-btn
        class="ml-auto mt-5"
        dark small
        color="success"
        @click="openModalCreate()"
      >
        Thêm mới loại chứng từ chi
      </v-btn>
    </div>

    <v-data-table
      class="om-wp_border-left om-wp_border-top om-wp_border-bottom"
      :headers="headers"
      :items="dataList"
      no-data-text="Không tồn tại dữ liệu"
      :items-per-page="params.per_page"
      hide-default-footer
      item-key="name"
    >
      <template v-slot:item.number="{ index }">
        {{ ( (page - 1) * params.per_page) + index + 1 }}
      </template>
      <template v-slot:item.is_active="{ item }">
        <v-icon
          v-if="item.is_active === 1"
          class="cursor-pointer"
          small
          color="darken-2"
        >
          mdi-checkbox-marked-circle
        </v-icon>
      </template>
      <template v-slot:item.is_business_result="{ item }">
        <v-icon
          v-if="item.is_business_result === 1"
          class="cursor-pointer"
          small
          color="darken-2"
        >
          mdi-checkbox-marked-circle
        </v-icon>
      </template>
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
          @click="deleteItem(item.id, item.type_name)"
        >
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>

    <div class="py-3 d-flex align-items-center">
      <v-pagination
        v-show="totalPage > 1"
        v-model="page"
        circle
        :length="totalPage"
        :total-visible="5"
        @input="paginate(page)"
      ></v-pagination>

      <div class="ml-auto">Hiển thị: <b>{{ dataList.length }}</b>, Tổng số: <b>{{ total }}</b></div>
    </div>

    <modal-create-type-payment-voucher
      @store="store"
    />

    <modal-edit-type-payment-voucher
      @update="update"
    />
  </v-card>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import TypePaymentVoucher from "@/models/marketing/type_payment_voucher";
import ModalCreateTypePaymentVoucher from "@/components/om/pages/marketing/type-payment-voucher/ModalCreateTypePaymentVoucher";
import ModalEditTypePaymentVoucher from "@/components/om/pages/marketing/type-payment-voucher/ModalEditTypePaymentVoucher";
import Swal from "sweetalert2";
import axios from '@/core/plugins/axios';
import {mapGetters} from "vuex";
import User from "@/models/user/user";
import moment from "moment";

export default {
  name: "TypePaymentVoucher",
  components: {
    ModalCreateTypePaymentVoucher,
    ModalEditTypePaymentVoucher
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(this.$route.query),
      typePaymentVoucher: new TypePaymentVoucher(),
      dataList: new Collection(TypePaymentVoucher),
      total: 0,
      page: 1,
      totalPage: 1,
      headers: [
        {text: 'STT', value: 'number', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Mã loại chứng từ chi', value: 'type_code', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Loại chứng từ chi', value: 'type_name', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Hạch toán kết quả kinh doanh', value: 'is_business_result', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Hiệu lực', value: 'is_active', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Mô tả', value: 'note', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Ngày tạo', value: 'created_at', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Ngày cập nhật', value: 'updated_at', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Tiện ích', value: 'action', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
      ],
      rules: {
        required: value => !!value || 'Tên kênh bắt buộc nhập.',
      },
      options: [10, 20, 30],
    }
  },
  methods: {
    async store() {
      await this.paginate(1)
    },
    async paginate(page) {
      this.params.page = page
      await this.listAsync()
      this.page = page
    },

    async update(data) {
      await this.listAsync()
    },

    openModalCreate() {
      this.$modal.show('modal-create-type-payment-voucher', {})
    },

    openModalEdit(item) {
      this.$modal.show('modal-edit-type-payment-voucher', {
        typePaymentVoucher: item,
      })
    },

    async search() {
      this.page = 1
      this.params.page = 1
      this.params.offset = 0
      await this.listAsync()
    },

    async listAsync() {
      try {
        const params = this.params.reduces()

        this.loadingStart()

        this.dataList = await this.typePaymentVoucher.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.total_page
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    },

    deleteItem(id, name) {
      if (! id) {
        return
      }

      Swal.fire({
        text: `Bạn có chắc chắn muốn xóa loại chứng từ chi [${name}] ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          this.confirmDelete(id)
        }
      })
    },

    async confirmDelete(id) {
      try {
        this.loadingStart()

        await this.typePaymentVoucher.deleteAsync(id)
        this.messageSuccess('Bạn đã xóa loại chứng từ chi thành công')
        await this.paginate(1)
      } catch (e) {
        this.handleException(e)
      }
    }
  },
  async created() {
    this.params.per_page = this.$route.query.per_page || 10
    await this.listAsync()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Danh sách loại chứng từ chi"}]);
  },
}
</script>

<style lang="scss">

</style>