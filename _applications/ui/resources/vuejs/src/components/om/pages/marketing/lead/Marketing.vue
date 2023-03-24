<template>
  <v-card class="om-wp px-5">
    <v-row class="mt-5">
      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Ngày tạo</label>
          <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="time"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="time"
                class="flex-basis"
                placeholder="Từ ngày - đến ngày"
                readonly
                dense
                clearable
                outlined
                hide-details
                v-bind="attrs"
                v-on="on"
                prepend-inner-icon="date_range"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="time"
              no-title
              range
              scrollable
              locale="vi"
            >
              <v-spacer></v-spacer>
              <v-btn
                text
                color="primary"
                @click="menu = false"
              >
                Hủy
              </v-btn>
              <v-btn
                text
                color="primary"
                @click="changeTime()"
              >
                Chọn
              </v-btn>
            </v-date-picker>
          </v-menu>
        </div>
      </v-col>
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
          <label class="flex-1 d-flex flex-column place-content-end">Số trùng</label>
          <v-select
            class="flex-basis"
            v-model="params.is_duplicated"
            :items="duplicates"
            item-text="label"
            item-value="value"
            dense
            outlined
            hide-details
            @change="search()"
          ></v-select>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Nhân viên tạo</label>
          <v-autocomplete
            no-data-text="không tìm thấy dữ liệu"
            class="flex-basis"
            v-model="params.user_id"
            :items="listUser"
            item-text="full_name"
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
          <label class="flex-1 d-flex flex-column place-content-end">Loại data</label>
          <v-select
            class="flex-basis"
            v-model="params.type"
            :items="types"
            item-text="label"
            item-value="value"
            dense
            outlined
            hide-details
            @change="search()"
          ></v-select>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Số điện thoại</label>
          <v-text-field
            class="flex-basis"
            dense
            outlined
            hide-details
            @keypress="handleInputNumber"
            v-model="params.mobile"
            placeholder="Nhập để tìm kiếm"
            @keyup.enter.native="search()"
          >
          </v-text-field>
        </div>
      </v-col>
    </v-row>

    <v-row class="my-5">
      <v-btn
        class="ml-3"
        dark small
        color="cyan"
        @click="openModalSettingAssignData()"
      >
        <v-icon
          left
          small
        >
          fas fa-cog
        </v-icon>
        Cấu hình chia số
      </v-btn>

      <v-btn
        class="ml-auto mr-3"
        dark small
        color="success"
        @click="openModalCreate()"
      >
        Thêm mới
      </v-btn>
      <v-btn
        class="mr-3"
        dark small
        color="warning"
      >
        Nhập file
      </v-btn>
    </v-row>

    <v-row class="my-5">
      <v-btn
        class="ml-3 mr-5"
        dark small
        color="primary"
        @click="openModalAssignData()"
      >
        Chia số
      </v-btn>
      <div class="ml-auto d-flex">
        <div
          v-for="(item, index) in totaLeadByStatus"
          class="mr-3"
          :key="index"
          v-show="item.value"
        >
          <v-checkbox
            v-model="params.status_ids"
            :color="item.color"
            :value="item.value"
            hide-details
            @change="filterStatuses()"
          >
            <template v-slot:label>
              <div :style="{color: item.color}">{{ item.name }} ({{ item.total }})</div>
            </template>
          </v-checkbox>
        </div>
      </div>
    </v-row>

    <v-data-table
      class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
      :headers="headers"
      :items="dataList"
      v-model="selected"
      no-data-text="Không tồn tại dữ liệu"
      :items-per-page="params.limit"
      hide-default-footer
      show-select
      item-key="id"
    >
      <template v-slot:header.setting="{ header }">
        <v-btn icon @click="settingColumn()">
          <v-icon>fas fa-cog</v-icon>
        </v-btn>
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
          @click="deleteItem(item.id)"
        >
          mdi-delete
        </v-icon>
      </template>

      <template v-slot:item.channel="{ item }">
        <div>{{ item.channel ? item.channel.name : '' }}</div>
      </template>

      <template v-slot:item.lead_status_id="{ item }">
        <v-chip
          :color="getColorStatus(item.lead_status_id)"
          outlined
          small
          class="ma-2"
        >
          {{ getNameStatus(item.lead_status_id) }}
        </v-chip>
      </template>

      <template v-slot:item.is_duplicated="{ item }">
        <v-chip
          :color="item.is_duplicated ? 'green' : ''"
          :class="item.is_duplicated ? 'cursor-pointer' : ''"
          outlined
          small
          class="ma-2"
          @click="openModalMobileDuplicate(item)"
        >
          {{ getNameDuplicate(item.is_duplicated) }}
        </v-chip>
      </template>

      <template v-slot:item.sub_channel="{ item }">
        <div>{{ item.sub_channel ? item.sub_channel.name : '' }}</div>
      </template>

      <template v-slot:item.user_created="{ item }">
        <div>{{ item.user_created ? item.user_created.full_name : '' }}</div>
      </template>

      <template v-slot:item.user_assigned="{ item }">
        <div>{{ item.user_assigned ? item.user_assigned.full_name : '' }}</div>
      </template>

      <template v-slot:item.bundle="{ item }">
        <div>{{ item.bundle ? item.bundle.product_catalog_name : '' }}</div>
      </template>

      <template v-slot:item.created_at="{ item }">
        <div>{{ formatTime(item.created_at) }}</div>
      </template>

      <template v-slot:item.setting="{ item }">
        <v-btn
          small
          :disabled="item.lead_status_id == statusReject"
          color="error"
          @click="rejectData(item)"
        >
          Hủy số
        </v-btn>
      </template>
    </v-data-table>

    <div class="py-3 d-flex align-items-center">
      <b-form-select
        class="om-wp-list-number"
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
        :total-visible="6"
        @input="paginate(page)"
      ></v-pagination>
    </div>

    <modal-assign-group-sale @store="store" />

    <modal-setting-assign-group-sale />

    <modal-mobile-duplicate />

    <modal-create-data-lead @store="store" />

    <modal-edit-data-lead @update="update" />
  </v-card>
</template>

<script>
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import Swal from "sweetalert2";
import {mapGetters} from "vuex";
import Lead from "@/models/marketing/leads";
import ModalAssignGroupSale from "@/components/om/pages/marketing/lead/ModalAssignGroupSale";
import ModalSettingAssignGroupSale from "@/components/om/pages/marketing/lead/ModalSettingAssignGroupSale";
import ModalMobileDuplicate from "@/components/om/pages/marketing/lead/ModalMobileDuplicate";
import moment from "moment";
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import LeadStatus from "@/models/marketing/lead_status";
import ModalCreateDataLead from "@/components/om/pages/marketing/lead/ModalCreateDataLead";
import ModalEditDataLead from "@/components/om/pages/marketing/lead/ModalEditDataLead";
import {STATUS_REJECT_LEAD} from "@/config/app";

export default {
  name: "MarketingLead",
  components: {
    ModalMobileDuplicate,
    ModalSettingAssignGroupSale,
    ModalAssignGroupSale,
    ModalCreateDataLead,
    ModalEditDataLead},
  data() {
    return {
      statusReject: STATUS_REJECT_LEAD,
      params: new Filter(this.$route.query),
      time: null,
      menu: false,
      firstFetched: false,
      lead: new Lead(),
      dataList: new Collection(Lead),
      listChannel: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      productCatalog: new Collection(Object, [{product_catalog_name: 'Tất cả', id: null}]),
      listUser: new Collection(Object, [{id: null, full_name: 'Tất cả'}]),
      listStatus: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      statuses: new Collection(LeadStatus),
      duplicates: [
        {value: null, label: 'Tất cả'},
        {value: 1, label: 'YES'},
        {value: 0, label: 'NO'}
      ],
      types: [
        {value: null, label: 'Tất cả'},
        {value: 1, label: 'Tạo tự động'},
        {value: 2, label: 'Tạo bằng tay'}
      ],
      total: 0,
      page: 1,
      totalPage: 1,
      selected: [],
      headers: [
        {text: '', value: 'setting', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: '', value: 'action',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái', value: 'lead_status_id', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số điện thoại', value: 'mobile', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên khách hàng', value: 'name',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mô tả', value: 'description', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số trùng', value: 'is_duplicated', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Kênh', value: 'channel', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Sub kênh', value: 'sub_channel',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Loại sản phẩm', value: 'bundle', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'NV tạo', value: 'user_created', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'NV phụ trách', value: 'user_assigned', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Ngày tạo', value: 'created_at', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
      ],
      options: [10, 20, 30],
      totaLeadByStatus: []
    }
  },
  methods: {
    changeTime() {
      this.$refs.menu.save(this.time)

      if (this.time.length == 2) {
        this.params.time_start = this.time[0]
        this.params.time_end = this.time[1]
        this.search()
      }
    },
    async filterStatuses() {
      this.params.status = null
      await this.search()
    },
    settingColumn() {

    },
    async rejectData(item) {
      await new Lead().rejectDataLead(item.id)
      await this.search()
    },

    formatTime(time) {
      return time ? moment(time).format("DD/MM/YYYY HH:mm") : ''
    },

    async paginate(page) {
      this.selected = []
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
      this.page = page
    },
    async store() {
      await this.paginate(1)
      await this.geTotalLeadByStatus()
    },
    async update(data) {
      await this.listAsync()
      await this.geTotalLeadByStatus()
    },

    getNameStatus(id) {
      let status = this.listStatus.find(i => i.id == id )

      if (status) {
        return status.name
      }
    },

    getColorStatus(id) {
      let status = this.listStatus.find( i => i.id == id )

      if (status) {
        return status.color
      }
    },

    getNameDuplicate(value) {
      let duplicate = this.duplicates.find(i => i.value == value)

      return duplicate.label
    },

    openModalSettingAssignData() {
      this.$modal.show('modal-setting-assign-group-sale')
    },

    openModalAssignData() {
      this.$modal.show('modal-assign-group-sale', {
        total: this.total,
        selectLead: this.selected,
        dataParams: this.params.reduces()
      })
    },

    openModalCreate() {
      this.$modal.show('modal-create-data-lead')
    },

    openModalEdit(item) {
      this.$modal.show('modal-edit-data-lead', {lead: item})
    },

    openModalMobileDuplicate(item) {
      if (item.is_duplicated) {
        this.$modal.show('modal-mobile-duplicate', {lead: item})
      }
    },

    async search() {
      this.page = 1
      this.params.offset = 0
      this.selected = []
      await this.listAsync()
    },

    async listAsync() {
      try {
        const params = this.params.reduces()

        this.loadingStart()

        this.dataList = await this.lead.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
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

        await this.lead.deleteAsync(id)
        this.messageSuccess('Bạn đã xóa data số thành công')
        await this.paginate(1)
      } catch (e) {
        this.handleException(e)
      }
    },

    async geTotalLeadByStatus() {
      await new Lead().getTotalLeadByStatus().then((result) => {
        this.totaLeadByStatus = _.cloneDeep(result)
      })
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
    async loadConfig() {
      this.marketingConfig.then((result) => {
        this.listChannel.push(...result.channels)
        this.listUser.push(...result.listUser)
        this.productCatalog.push(...result.productCatalog)
        this.listStatus.push(...result.leadStatuses)
        this.statuses.push(...result.leadStatuses)
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
    await this.geTotalLeadByStatus()
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Quản lý data số marketing"}]);
  },
}
</script>

<style lang="scss">

</style>