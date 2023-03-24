<template>
  <v-card class="om-wp px-5">
    <v-row class="mt-5">
      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
          <div class="d-flex flex-column h-100">
            <label class="flex-1 d-flex flex-column place-content-end">Loại ngân hàng</label>
            <v-select
              class="flex-basis"
              v-model="params.bank_name"
              clearable
              :items="listBank"
              item-text="short_name"
              item-value="short_name"
              dense
              outlined
              hide-details
              placeholder="Chọn ngân hàng"
              @change="search()"
            ></v-select>
          </div>
        </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Chủ tài khoản</label>
          <v-text-field
            class="flex-basis"
            v-model="params.card_owner"
            dense
            outlined
            hide-details
            placeholder="Nhập để tìm kiếm"
            @keyup.enter.native="search()"
          >
          </v-text-field>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Số tài khoản</label>
          <v-text-field
            class="flex-basis"
            v-model="params.account_number"
            dense
            outlined
            hide-details
            placeholder="Nhập để tìm kiếm"
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
          @click="deleteItem(item.id)"
        >
          mdi-delete
        </v-icon>
      </template>

      <template v-slot:item.users="{ item }">
        <div v-for="user in item.users">{{ user.full_name }}</div>
      </template>

      <template v-slot:item.card_type="{ item }">
        <div>{{ getCardType(item.card_type) }}</div>
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
        v-model="page"
        circle
        :length="totalPage"
        :total-visible="5"
        @input="paginate(page)"
      ></v-pagination>
    </div>

    <modal-create-payment-account
      @store="store"
    />

    <modal-edit-payment-account
      @update="update"
    />
  </v-card>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import PaymentAccount from "@/models/marketing/payment_account";
import ModalCreatePaymentAccount from "@/components/om/pages/marketing/payment_account/ModalCreatePaymentAccount";
import ModalEditPaymentAccount from "@/components/om/pages/marketing/payment_account/ModalEditPaymentAccount";
import Swal from "sweetalert2";
import axios from '@/core/plugins/axios';
import {mapGetters} from "vuex";
import User from "@/models/user/user";

export default {
  name: "PaymentAccount",
  components: {
    ModalCreatePaymentAccount,
    ModalEditPaymentAccount
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(this.$route.query),
      paymentAccount: new PaymentAccount(),
      dataList: new Collection(PaymentAccount),
      listBank: new Collection(Object, [{label: 'Tất cả', value: null}]),
      listUser: new Collection(User),
      total: 0,
      page: 1,
      totalPage: 1,
      headers: [
        {text: 'Tiện ích', value: 'action', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Ngân hàng', value: 'bank_name', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Loại thẻ', value: 'card_type', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Chủ tài khoản', value: 'card_owner', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Số thẻ', value: 'card_number', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Số tài khoản', value: 'account_number', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'NV QL tài khoản', value: 'users', align: 'center', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
      ],
      rules: {
        required: value => !!value || 'Tên kênh bắt buộc nhập.',
      },
      options: [10, 20, 30],
      cardTypes: [
        {value: 1, label: 'ATM'},
        {value: 2, label: 'Visa credit'},
        {value: 3, label: 'Master card'},
        {value: 4, label: 'Visa debit'}
      ],
    }
  },
  methods: {
    async store() {
      await this.paginate(1)
    },
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
      this.page = page
    },

    async update(data) {
      await this.listAsync()
    },

    openModalCreate() {
      this.$modal.show('modal-create-payment-account', {
        listBank: this.listBank,
        listUser: this.listUser
      })
    },

    openModalEdit(item) {
      this.$modal.show('modal-edit-payment-account', {
        paymentAccount: item,
        listBank: this.listBank,
        listUser: this.listUser
      })
    },

    getCardType(type) {
      let card = this.cardTypes.find(i => i.value == type)

      return card.label
    },

    async search() {
      this.page = 1
      this.params.offset = 0
      await this.listAsync()
    },

    async listAsync() {
      try {
        const params = this.params.reduces()

        this.loadingStart()

        this.dataList = await this.paymentAccount.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    },

    deleteItem(id) {
      if (! id) {
        return
      }

      Swal.fire({
        text: "Bạn có chắc chắn muốn xóa ?",
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

    getlistBank() {
      axios.get('https://api.vietqr.io/v2/banks').then((result) => {
        this.listBank = result.data.data
      })
    },

    async confirmDelete(id) {
      try {
        this.loadingStart()

        await this.paymentAccount.deleteAsync(id)
        this.messageSuccess('Bạn đã xóa tài khoản quảng cáo MKT thành công')
        await this.paginate(1)
      } catch (e) {
        this.handleException(e)
      }
    },
    async loadConfig() {
      this.marketingConfig.then((result) => {
        this.listUser.push(...result.listUser)
      })
    }
  },
  computed: {
    ...mapGetters({
      marketingConfig: 'omConfig/marketing'
    }),
  },
  async created() {
    await this.loadConfig()
    this.getlistBank()
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Quản lý tài khoản tiền MKT"}]);
  },
}
</script>

<style lang="scss">

</style>