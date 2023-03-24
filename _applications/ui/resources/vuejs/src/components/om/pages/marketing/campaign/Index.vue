<template>
  <v-card class="om-wp px-5">
    <v-row class="mt-5">
      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Kênh chạy data</label>
          <v-autocomplete
            no-data-text="không tìm thấy dữ liệu"
            class="flex-basis"
            v-model="params.channel_id"
            :items="listChannel"
            item-text="name"
            item-value="id"
            dense
            outlined
            hide-details
            @change="search()"
          >
          </v-autocomplete>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Sub kênh chạy data</label>
          <v-autocomplete
            no-data-text="không tìm thấy dữ liệu"
            class="flex-basis"
            v-model="params.sub_channel_id"
            :items="listSubChannel"
            item-text="name"
            item-value="id"
            dense
            outlined
            hide-details
            @change="search()"
          >
          </v-autocomplete>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Loại sản phẩm</label>
          <v-autocomplete
            no-data-text="không tìm thấy dữ liệu"
            class="flex-basis"
            v-model="params.product_catalog_id"
            :items="productCatalog"
            item-text="product_catalog_name"
            item-value="id"
            dense
            outlined
            hide-details
            @change="search()"
          >
          </v-autocomplete>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Chiến dịch</label>
          <v-text-field
            class="flex-basis"
            v-model="params.title"
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

    <v-simple-table class="om-wp_border-top om-wp_border-left om-wp_border-bottom">
      <thead>
      <tr>
        <th
          v-for="(parent, index) in headers.parents"
          :key="index"
          :rowspan="!parent.children ? 2 : 1 "
          :colspan="parent.children ? 3 : 1 "
          class="text-center om-wp_border-right"
          :class="parent.children ? '' : 'om-wp_border-bottom' "
          :style="{minWidth: parent.width}">
          <v-icon
            v-if="parent.value == 'history'"
            class="cursor-pointer"
            color="darken-2">
            fas fa-cog
          </v-icon>
          {{ parent.text }}
        </th>
      </tr>
      <tr>
        <th
          v-for="(children, index) in headers.children"
          :key="index"
          class="text-center om-wp_border-right om-wp_border-top"
          style="min-width: 100px;">{{ children.text }}</th>
      </tr>
      </thead>

      <tbody>
        <tr v-show="total < 1">
          <td colspan="19" class="text-center om-wp_border-right">
            Không tồn tại dữ liệu
          </td>
        </tr>
        <tr v-for="(item, index) in dataList" :key="index">
          <td class="text-center om-wp_border-right">
            <v-icon
              class="cursor-pointer"
              color="darken-2"
            >
              fas fa-angle-double-right
            </v-icon>

          </td>
          <td class="text-center om-wp_border-right">
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
          </td>
          <td class="text-center om-wp_border-right">
            {{ formatTime(item.start_at) }} - <br>
            {{ formatTime(item.end_at) }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.title }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.advertisement_id }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.channel ? item.channel.name : '' }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.sub_channel ? item.sub_channel.name : '' }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.product_catalog ? item.product_catalog.product_catalog_name : '' }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.link_token }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.user_assign ? item.user_assign.full_name : '' }}
          </td>
          <td class="text-center om-wp_border-right">
            <div v-for="account in item.payment_accounts">
              {{ account.card_owner }}
            </div>
          </td>
          <td class="text-center om-wp_border-right">
            {{ $helper.formatCurrency(item.estimated_amount, ',') }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.estimated_data }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ $helper.formatCurrency(item.estimated_revenue, ',') }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ $helper.formatCurrency(item.actual_amount, ',') }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.actual_data }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ $helper.formatCurrency(item.actual_revenue, ',') }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ item.reference_source }}
          </td>
          <td class="text-center om-wp_border-right">
            {{ getPercent(item.actual_amount, item.actual_revenue) }}
          </td>
        </tr>
      </tbody>

    </v-simple-table>

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

    <modal-create-campaign
      @store="store"
    />

    <modal-edit-campaign
      @update="update"
    />
  </v-card>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import ModalCreateCampaign from "@/components/om/pages/marketing/campaign/ModalCreateCampaign";
import ModalEditCampaign from "@/components/om/pages/marketing/campaign/ModalEditCampaign";
import Swal from "sweetalert2";
import Campaign from "@/models/marketing/campaign";
import {mapGetters} from 'vuex'
import moment from "moment"

export default {
  name: "Campaign",
  components: {
    ModalCreateCampaign,
    ModalEditCampaign
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(this.$route.query),
      campaign: new Campaign(),
      dataList: new Collection(Campaign),
      listChannel: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      headers: {
        parents: [
          {text: '', value: 'history', width: '50px', children: false},
          {text: 'Tiện ích', value: 'action', width: '100px', children: false},
          {text: 'Thời gian', value: 'time',  width: '200px', children: false},
          {text: 'Chiến dịch', value: 'title',  width: '150px', children: false},
          {text: 'ID quảng cáo', value: 'advertisement_id',  width: '150px', children: false},
          {text: 'Kênh', value: 'channel_id',  width: '150px', children: false},
          {text: 'Sub kênh', value: 'sub_channel_id',  width: '150px', children: false},
          {text: 'Loại sản phẩm', value: 'product_catalog',  width: '150px', children: false},
          {text: 'Link token', value: 'link_token',  width: '150px', children: false},
          {text: 'Marketing phụ trách', value: 'bundle',  width: '150px', children: false},
          {text: 'Tài khoản', value: 'payment_accounts',  width: '150px', children: false},
          {text: 'Dự trù', value: 'estimate',  width: '300px', children: true},
          {text: 'Thực tế', value: 'revenue',  width: '300px', children: true},
          {text: 'Tham chiếu', value: 'reference',  width: '150px', children: false},
          {text: 'Chi phí/Doanh thu', value: 'percent',  width: '150px', children: false},
        ],
        children: [
          {text: 'Kinh phí'},
          {text: 'Data'},
          {text: 'Doanh thu'},
          {text: 'Kinh phí'},
          {text: 'Data'},
          {text: 'Doanh thu'}
        ]
      },
      listBank: new Collection(Object),
      listSubChannel: new Collection(Object, [{name: 'Tất cả', id: null}]),
      productCatalog: new Collection(Object, [{product_catalog_name: 'Tất cả', id: null}]),
      total: 0,
      page: 1,
      totalPage: 1,
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
    formatTime(time) {
      return time ? moment(time).format("HH:mm:ss DD/MM/YYYY") : ''
    },

    getPercent(mount, revenue) {
      let percent = (mount / revenue * 100).toFixed(2)

      if (isNaN(percent)) {
        return '--'
      }
      return percent + '%'
    },
    async store() {
      await this.paginate(1)
    },
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
      this.page = page
    },

    async update() {
      await this.listAsync()
    },

    openModalCreate() {
      this.$modal.show('modal-create-campaign', {
        listBank: this.listBank,
        cardTypes: this.cardTypes
      })
    },

    openModalEdit(item) {
      this.$modal.show('modal-edit-campaign', {
        campaign: item,
        listBank: this.listBank,
        cardTypes: this.cardTypes
      })
    },

    async submit() {
      if (this.$refs.form.validate()){

        try {
          this.loadingStart()
          this.messageSuccess('Tạo kênh thành công')
          await this.paginate(1)
        } catch (e) {
          this.handleException(e)
        }
      }
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

        this.dataList = await this.campaign.getListAsync(params)
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

    async confirmDelete(id) {
      try {
        this.loadingStart()

        await this.campaign.deleteAsync(id)
        this.messageSuccess('Bạn đã xóa chiến dịch thành công')
        await this.paginate(1)
      } catch (e) {
        this.handleException(e)
      }
    },

    async loadConfig() {
      this.marketingConfig.then((result) => {
        this.listChannel.push(...result.channels)
        this.listSubChannel.push(...result.subChannels)
        this.productCatalog.push(...result.productCatalog)
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
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Quản lý chiến dịch"}]);
  },
}
</script>

<style lang="scss">

</style>