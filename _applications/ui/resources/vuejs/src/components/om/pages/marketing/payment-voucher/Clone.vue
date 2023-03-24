<template>
  <v-form ref="form">
    <v-row>
      <v-col cols="8" sm="6" md="8" lg="8" xl="8">
        <v-card class="om-wp px-5 mb-10">
          <h4 class="pt-5">Thông tin chung</h4>

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
                  placeholder="Chọn loại chứng từ"
                  @change="getCustomer()"
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
                  placeholder="Chọn đối tượng"
                  @change="getCustomer()"
                  :disabled="disabled.fetchData"
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
                  placeholder="Chọn loại phiếu chi"
                  @change="getCustomer()"
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
                  placeholder="Chọn người nhận"
                  @change="getOrder()"
                  :disabled="disabled.fetchData"
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
                <label class="d-flex flex-column place-content-end">Đơn hàng (*)</label>
                <v-select
                  class="flex-basis"
                  v-model="paymentVoucher.order"
                  clearable
                  :items="order"
                  item-text="code"
                  item-value="id"
                  dense
                  outlined
                  hide-details
                  :disabled="disabled.order"
                  placeholder="Chọn đơn hàng"
                  multiple
                  @change="updateAmount()"
                ></v-select>
              
                <label class="d-flex flex-column place-content-end mt-5">Giá trị (*)</label>
                <v-text-field
                  v-model="paymentVoucher.amount"
                  :rules="[rules.value]"
                  dense
                  outlined
                  :disabled="disabled.value"
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
                  >
                  </v-textarea>
              </div>
            </v-col>

          </v-row>
        </v-card>
      </v-col>

      <div class="my-5 ml-auto d-flex">
        <div class="mt-5 mr-3">
          <v-btn
            dark
            color="info"
            @click="openModalCreate()"
          >
            Hủy
          </v-btn>
          <v-btn
            dark
            color="success"
            @click="save()"
          >
            Tạo mới
          </v-btn>
        </div>
      </div>
    </v-row>
  </v-form>
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
      disabled: {
        order: true,
        value: true,
        fetchData: true,
      },
      customer_group: [],
      type_payment_voucher: []
    }
  },
  methods: {
    async getCustomer() {
      if (this.paymentVoucher.customer_group_id == null) {
        this.disabled.order = true;
        this.disabled.value = true;
        return;
      }

      this.customer = this.customer_group.filter(word => word.id == this.paymentVoucher.customer_group_id)[0].customer;
      if (this.paymentVoucher.customer_group_id !== 1 || this.paymentVoucher.customer_group_id !== 2) {
        this.disabled.value = false;
        this.disabled.order = true;
      }
    },
    async getOrder() {
      if (this.paymentVoucher.customer_group_id == null || this.paymentVoucher.customer_id == null) {
        this.disabled.order = true;
        this.disabled.value = true;
        return;
      }
      if (this.paymentVoucher.customer_id !== null) {
        this.disabled.order = false;
        this.disabled.value = true;
        this.params.type_voucher = this.paymentVoucher.type_voucher;
        this.params.customer_group_id = this.paymentVoucher.customer_group_id;
        this.params.customer_id = this.paymentVoucher.customer_id;
        try {
          this.loadingStart()
          
          let response = await ApiService.getAsync(ApiService.routes(this.apiGroup)['get-order'], this.params);
          this.order = response.data.orders;
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
    },
    async getCreateData() {
      try {
        let response = await this.paymentVoucher.createData();
        this.type_payment_voucher = response.type_payment_voucher;
        this.customer_group = response.customer_group;
        this.fetchDetail();
      } catch (e) {
        this.handleException(e);
      } finally {
        this.disabled.fetchData = false;
      }
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
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()
          this.paymentVoucher.confirmed_at = moment(this.paymentVoucher.confirmed_at_date).format('YYYY-MM-DD H:mm:s');
          await this.paymentVoucher.storeAsync()

          this.messageSuccess('Bạn đã thêm mới chứng từ chi thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
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
    openModalCreate () {
      return this.$router.push({name: 'om.payment-vouchers.index'})
    }
  },
  async created() {
    this.params.type = 'payment-voucher';
    this.params.store_name = 'Chi nhánh miền Bắc';
    this.params.store_id = 1;
    await this.getCreateData();
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Tạo mới chứng từ chi"}]);
  },
}
</script>

<style lang="scss">

</style>