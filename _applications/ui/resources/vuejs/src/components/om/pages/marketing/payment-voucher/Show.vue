<template>
  <v-row>
    <v-col cols="12" sm="12" md="12" lg="12" xl="12">
      <v-btn
        color="teal darken-1"
        class="white--text mr-4"
      >
        In chứng từ
      </v-btn>

      <v-menu
        rounded="lg"
        offset-y
        class="ml-auto"
      >
        <template v-slot:activator="{ attrs, on }">
          <v-btn
            color="teal darken-1"
            class="white--text"
            v-bind="attrs"
            v-on="on"
          >
            Thao tác với chứng từ chi
          </v-btn>
        </template>

        <v-list>
          <v-list-item
            link
          >
            <v-list-item-title @click="deleteItem()">
              Hủy
            </v-list-item-title>
          </v-list-item>

          <v-list-item
            link
          >
            <v-list-item-title @click="openModalEdit()">
              Sửa
            </v-list-item-title>
          </v-list-item>

          <v-list-item
            link
          >
            <v-list-item-title @click="openModalCreate()">
              Sao chép
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-col>

    <v-col cols="8" sm="6" md="8" lg="8" xl="8">
      <v-card class="om-wp px-5 mb-10">
        <h4 class="pt-5">
          Thông tin chung
          <v-chip
            class="ma-2 float-end"
            color="green"
            small
            text-color="white"
            v-if="paymentVoucher.is_active == 1"
          >
            Hoàn thành
          </v-chip>
          <v-chip
            class="ma-2 float-end"
            color="red"
            small
            text-color="white"
            v-else
          >
            Hủy
          </v-chip>
        </h4>
        

        <v-row class="mt-5">
          <v-col cols="6" sm="6" md="6" lg="6" xl="6">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Loại chứng từ (*)</label>
              <v-select
                class="flex-basis"
                v-model="paymentVoucher.type_voucher"
                clearable
                :items="type"
                :rules="[rules.type]"
                item-text="label"
                item-value="value"
                dense
                outlined
                hide-details
                placeholder="Chọn loại chứng từ"
                disabled
              ></v-select>
            </div>
          </v-col>

          <v-col cols="6" sm="6" md="6" lg="6" xl="6">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Đối tượng nhận (*)</label>
              <v-select
                class="flex-basis"
                v-model="paymentVoucher.customer_group_id"
                clearable
                :items="customer_group"
                :rules="[rules.subject]"
                item-text="name"
                item-value="id"
                dense
                outlined
                hide-details
                placeholder="Chọn đối tượng"
                disabled
              ></v-select>
            </div>
          </v-col>

          <v-col cols="6" sm="6" md="6" lg="6" xl="6">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Loại chứng từ chi (*)</label>
              <v-select
                class="flex-basis"
                v-model="paymentVoucher.type_payment_voucher_id"
                clearable
                :items="type_payment_voucher"
                :rules="[rules.type_payment_voucher_id]"
                item-text="type_name"
                item-value="id"
                dense
                outlined
                hide-details
                placeholder="Chọn loại phiếu chi"
                disabled
              ></v-select>
            </div>
          </v-col>

          <v-col cols="6" sm="6" md="6" lg="6" xl="6">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Tên người nhận (*)</label>
              <v-select
                class="flex-basis"
                v-model="paymentVoucher.customer_id"
                clearable
                :items="customer"
                :rules="[rules.customer]"
                item-text="name"
                item-value="id"
                dense
                outlined
                hide-details
                placeholder="Chọn người nhận"
                disabled
              ></v-select>
            </div>
          </v-col>

        </v-row>
      </v-card>

      <v-card class="om-wp px-5">
        <h4 class="pt-5">Giá trị ghi nhận</h4>

        <v-row class="mt-5">
          <v-col cols="6" sm="6" md="6" lg="6" xl="6">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">
                Đơn hàng gốc:
                <span v-for="order in paymentVoucher.order" :key="order">
                  {{ order }}
                </span>
              </label>
            
              <label class="d-flex flex-column place-content-end mt-5">Giá trị (*)</label>
              <v-text-field
                v-model="paymentVoucher.amount"
                :rules="[rules.value]"
                dense
                outlined
                disabled
                placeholder="Giá trị"
              >
              </v-text-field>

              <v-checkbox
                v-model="paymentVoucher.is_business_result"
                :label="`Hoạch toán kết quả kinh doanh`"
              ></v-checkbox>
            </div>
            
          </v-col>

          <v-col cols="6" sm="6" md="6" lg="6" xl="6">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Ghi chú</label>
                <v-textarea
                  v-model="paymentVoucher.description"
                  dense
                  outlined
                  rows="6"
                  label="Ghi chú"
                  disabled
                >
                </v-textarea>
            </div>
          </v-col>

        </v-row>
      </v-card>
    </v-col>

    <v-col cols="4" sm="6" md="4" lg="4" xl="4">
      <v-card class="om-wp px-5">
        <h4 class="pt-5">Thông tin mở rộng</h4>

        <v-row class="mt-5">
          <v-col cols="12" sm="12" md="12" lg="12" xl="12">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Chi nhánh</label>
              <v-text-field
                class="flex-basis"
                v-model="params.store_name"
                dense
                outlined
                hide-details
                disabled
              >
              </v-text-field>
            </div>
          </v-col>

          <v-col cols="12" sm="12" md="12" lg="12" xl="12">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Ngày ghi nhận</label>
                <datetime-picker-palee
                  v-model="paymentVoucher.confirmed_at_date"
                  :placeholder="'Chọn ngày kết thúc'"
                  :rules="[rules.created_at]"
                  disabled
                />
            </div>
          </v-col>

          <v-col cols="12" sm="12" md="12" lg="12" xl="12">
            <div class="d-flex flex-column h-100">
              <label class="d-flex flex-column place-content-end">Mô tả</label>
                <v-textarea
                  v-model="paymentVoucher.note"
                  dense
                  outlined
                  rows="6"
                  label="Mô tả"
                  disabled
                >
                </v-textarea>
            </div>
          </v-col>

        </v-row>
      </v-card>
    </v-col>

    </div>
  </v-row>
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
import ApiService from "@/core/api.service";

export default {
  name: "PaymentVoucher",
	components: {
    DatetimePickerPalee
  },
  data() {
    return {
      apiGroup: 'payment-voucher',
      firstFetched: false,
      params: new Filter(this.$route.query),
      paymentVoucher: new PaymentVoucher(),
      rules: {
        type: value => !!value || 'Loại chứng từ bắt buộc nhập.',
        subject: value => !!value || 'Đối tượng nhận buộc nhập.',
        type_payment_voucher_id: value => !!value || 'Loại chứng từ chi buộc nhập.',
        customer: value => !!value || 'Tên người nhận buộc nhập.',
				created_at: value => !!value || 'Ngày ghi nhận buộc nhập.',
        value: value => !!value || 'Giá trị nhập.',
      },
      type: [
        { label: 'Phiếu chi', value: 'tien_mat' },
        { label: 'Sổ phụ ngân hàng', value: 'so_phu_ngan_hang' }
      ],
      type_payment_voucher_id: [],
      customer: [],
      order: [],
      customer_group: [],
      type_payment_voucher: []
    }
  },
  methods: {
    async getCustomer() {
      if (this.paymentVoucher.customer_group_id == null) {
        return;
      }

      this.customer = this.customer_group.filter(word => word.id == this.paymentVoucher.customer_group_id)[0].customer;
    },
    async getOrder() {
      if (this.paymentVoucher.customer_group_id == null || this.paymentVoucher.customer_id == null) {
        return;
      }
      if (this.paymentVoucher.customer_id !== null) {
        this.params.type_voucher = this.paymentVoucher.type_voucher;
        this.params.customer_group_id = this.paymentVoucher.customer_group_id;
        this.params.customer_id = this.paymentVoucher.customer_id;
        let response = await ApiService.getAsync(ApiService.routes(this.apiGroup)['get-order'], this.params);
        this.order = response.data.orders;
      }
    },
    async getCreateData() {
      let response = await ApiService.getAsync(ApiService.routes(this.apiGroup)['create']);
      this.type_payment_voucher = response.data.type_payment_voucher;
      this.customer_group = response.data.customer_group;
      this.fetchDetail();
    },
    async fetchDetail() {
      await this.paymentVoucher.loadById(this.$route.params.id);
      this.paymentVoucher.confirmed_at_date = new Date(moment(this.paymentVoucher.confirmed_at,"YYYY-MM-DD H:mm"));
      this.getCustomer();
      this.fetchOrder();
    },
    async fetchOrder() {
      await this.getOrder();
      this.paymentVoucher.orderPaymentVoucher.forEach(payment => {
        if (this.paymentVoucher.order.indexOf(payment.order_id) === -1 ) {
          this.paymentVoucher.order.push(payment.order_id);
        }
      });
    },
    updateAmount() {
      this.paymentVoucher.payment_id = [];
      this.paymentVoucher.amount = 0;
      this.order.forEach(order => {
        if (this.paymentVoucher.order.indexOf(order.id) !== -1 ) {
          order.order_payments.forEach(order_payments => {
            this.paymentVoucher.amount += order_payments.payment_amount;
            this.paymentVoucher.payment_id.push(order_payments.id);
          });
        }
      });
    },
    deleteItem() {
      Swal.fire({
        text: "Bạn có chắc chắn muốn hủy ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          this.confirmDelete(this.$route.params.id)
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
    },
    openModalEdit() {
      return this.$router.push({name: 'om.payment-vouchers.edit', params: {id: this.$route.params.id}})
    },
    openModalCreate() {
      return this.$router.push({name: 'om.payment-vouchers.clone', params: {id: this.$route.params.id}})
    }
  },
  async created() {
    this.params.type = 'payment-voucher';
    this.params.store_name = 'Chi nhánh miền Bắc';
    await this.getCreateData();
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Chi tiết chứng từ chi"}]);
    this.fetchDetail();
  },
}
</script>

<style lang="scss">

</style>