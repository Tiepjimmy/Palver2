<template>
  <v-card class="om-wp px-5">
    <v-row class="mt-5">
			<v-col cols="6" sm="4" md="3" lg="3" xl="3">
				<div class="d-flex flex-column h-100 mt25">
					<v-text-field
						class="flex-basis"
						v-model="params.voucher_code"
						dense
						outlined
						hide-details
						placeholder="Tìm kiếm theo mã chứng từ"
						@keyup.enter.native="search()"
					>
					</v-text-field>
				</div>
			</v-col>

			<v-col cols="6" sm="4" md="3" lg="3" xl="3">
				<div class="d-flex flex-column h-100">
					<label class="d-flex flex-column place-content-end">Trạng thái</label>
					<v-select
						class="flex-basis"
						v-model="params.is_active"
						clearable
						:items="status"
						item-text="label"
						item-value="value"
						dense
						outlined
						hide-details
						placeholder="Chọn trạng thái chứng từ"
						@change="search()"
					></v-select>
				</div>
			</v-col>

			<v-col cols="6" sm="4" md="3" lg="3" xl="3">
				<div class="d-flex flex-column h-100">
          <v-menu
            ref="createDatePicker"
            v-model="createDatePicker"
            :close-on-content-click="false"
            :return-value.sync="date"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="params.created_at"
                label="Ngày tạo"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="params.created_at"
              no-title
              scrollable
            >
              <v-spacer></v-spacer>
              <v-btn
                text
                color="primary"
                @click="cancelSearchCreate()"
              >
                Cancel
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="search()"
              >
                OK
              </v-btn>
            </v-date-picker>
          </v-menu>
				</div>
			</v-col>

			<v-col cols="6" sm="4" md="3" lg="3" xl="3">
				<div class="d-flex flex-column h-100">
					<v-menu
            ref="updateDatePicker"
            v-model="updateDatePicker"
            :close-on-content-click="false"
            :return-value.sync="date"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="params.updated_at"
                label="Ngày cập nhật"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="params.updated_at"
              no-title
              scrollable
            >
              <v-spacer></v-spacer>
              <v-btn
                text
                color="primary"
                @click="cancelSearchUpdate()"
              >
                Cancel
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="search()"
              >
                OK
              </v-btn>
            </v-date-picker>
          </v-menu>
				</div>
			</v-col>
    </v-row>

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
        Thêm mới chứng từ chi
      </v-btn>
    </div>

    <v-data-table
      class="om-wp_border-left om-wp_border-top om-wp_border-bottom"
      :headers="headers"
      :items="dataList"
      no-data-text="Không tồn tại dữ liệu"
      :items-per-page="params.per_page"
      hide-default-footer
      item-key="voucher_code"
    >
      <template v-slot:item.number="{ index }">
        {{ (page * params.per_page) + index + 1 }}
      </template>
      <template v-slot:item.is_active="{ item }">
        <span v-if="item.is_active === 1" style="color:#0abb87">Hoàn thành</span>
        <span v-else style="color:red">Hủy</span>
      </template>
      <template v-slot:item.typePaymentVoucher="{ item }">
        {{ item.typePaymentVoucher.type_name }}
      </template>
      <template v-slot:item.customer="{ item }">
        {{ item.customer.name }}
      </template>
      <template v-slot:item.customerGroup="{ item }">
        {{ item.customerGroup.name }}
      </template>
      <template v-slot:item.type_voucher="{ item }">
        <span v-if="item.type_voucher === 0">Phiếu chi</span>
        <span v-else>Sổ phụ ngân hàng</span>
      </template>
      <template v-slot:item.action="{ item }">
        <v-icon
          class="cursor-pointer"
          color="darken-2"
          @click="openModalDetail(item.id)"
        >
          mdi-alert-circle-outline
        </v-icon>
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
          @click="deleteItem(item.id, item.voucher_code)"
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

      <div class="ml-auto">Hiển thị: <b>{{ dataList.length }}</b>, Tổng: <b>{{ total }}</b></div>
    </div>
  </v-card>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import PaymentVoucher from "@/models/marketing/payment_voucher";
import Swal from "sweetalert2";
import axios from '@/core/plugins/axios';
import {mapGetters} from "vuex";
import User from "@/models/user/user";
import moment from "moment";
import DatetimePickerPalee from "@/components/om/widgets/DateTimePicker";

export default {
  name: "PaymentVoucher",
	components: {
    DatetimePickerPalee
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(this.$route.query),
      paymentVoucher: new PaymentVoucher(),
      dataList: new Collection(PaymentVoucher),
      total: 0,
      page: 1,
      totalPage: 1,
      headers: [
        {text: 'STT', value: 'number', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Loại chứng từ', value: 'type_voucher', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Mã chứng từ', value: 'voucher_code', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Loại chứng từ chi', value: 'typePaymentVoucher', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Đối tượng', value: 'customerGroup', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Giá trị chi', value: 'amount', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Thời gian tạo', value: 'created_at', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Người tạo', value: 'customer', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Trạng thái', value: 'is_active', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Tiện ích', value: 'action', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
      ],
			status: [
				{label: 'Tất cả', value: null},
				{label: 'Hoàn thành', value: 1},
				{label: 'Hủy', value: 0},
			],
      rules: {
        required: value => !!value || 'Tên kênh bắt buộc nhập.',
				created_at: value => !!value || 'Tên kênh bắt buộc nhập.',
				updated_at: value => !!value || 'Tên kênh bắt buộc nhập.',
      },
      options: [10, 20, 30],
      createDatePicker: false,
      updateDatePicker: false,
      date: null,
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

    openModalDetail(id) {
      return this.$router.push({name: 'om.payment-vouchers.show', params: {id: id}})
    },

    openModalCreate() {
      return this.$router.push({name: 'om.payment-vouchers.create'})
    },

    openModalEdit(item) {
      return this.$router.push({name: 'om.payment-vouchers.edit', params: {id: item.id}})
    },

    async search() {
      this.page = 1
      this.params.page = 1
      this.params.offset = 0
      this.createDatePicker = false
      this.updateDatePicker = false
      await this.listAsync()
    },

    async cancelSearchCreate() {
      this.createDatePicker = false
      this.params.created_at = null;
    },

    async cancelSearchUpdate() {
      this.updateDatePicker = false
      this.params.updated_at = null;
    },

    async listAsync() {
      try {
        const params = this.params.reduces()

        this.loadingStart()

        this.dataList = await this.paymentVoucher.getListAsync(params)
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
        text: `Bạn có chắc chắn muốn xóa chứng từ chi [${name}] ?`,
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

        await this.paymentVoucher.changeStatus(id)
        this.messageSuccess('Bạn đã hủy chứng từ chi thành công')
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
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Danh sách chứng từ chi"}]);
  },
}
</script>

<style lang="scss">
  .mt25 {
    margin-top: 25px;
  }
</style>