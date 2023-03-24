<template>
  <v-card class="om-wp px-5">
    <v-row class="mt-5">
      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end"></label>
          <v-select
            placeholder="Lọc theo ngày"
            class="flex-basis"
            v-model="params.time_type"
            :items="timeTypes"
            item-text="label"
            item-value="value"
            dense
            outlined
            hide-details
          ></v-select>
        </div>
      </v-col>
      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end"></label>
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
                outlined
                hide-details
                v-bind="attrs"
                v-on="on"
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
          <label class="flex-1 d-flex flex-column place-content-end">Nguồn khách hàng</label>
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
          <label class="flex-1 d-flex flex-column place-content-end">Nhân viên phụ trách</label>
          <v-autocomplete
            no-data-text="không tìm thấy dữ liệu"
            class="flex-basis"
            v-model="params.user_id"
            :items="listUser"
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
    </v-row>

    <v-row class="mt-5">
      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Mã khách hàng</label>
          <v-text-field
            class="flex-basis"
            dense
            outlined
            hide-details
            v-model="params.code"
            placeholder="Nhập để tìm kiếm"
            @keyup.enter.native="search()"
          >
          </v-text-field>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Tên khách hàng</label>
          <v-text-field
            class="flex-basis"
            dense
            outlined
            hide-details
            v-model="params.name"
            placeholder="Nhập để tìm kiếm"
            @keyup.enter.native="search()"
          >
          </v-text-field>
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
            v-model="params.s"
            placeholder="Nhập để tìm kiếm"
            @keyup.enter.native="search()"
          >
          </v-text-field>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Trạng thái</label>
          <v-select
            class="flex-basis"
            v-model="params.status"
            :items="listStatus"
            item-text="name"
            item-value="id"
            dense
            outlined
            hide-details
            @change="search()"
          ></v-select>
        </div>
      </v-col>

    </v-row>

    <v-tabs class="mt-3">
      <v-tab @click="loadListData()">Data số</v-tab>
      <v-tab @click="loadListData(1)">Số chưa chia</v-tab>
      <v-tab @click="loadListData(2)">Số đã chia</v-tab>
    </v-tabs>

    <v-row class="my-5">
      <v-btn
        v-if="params.assign == 2"
        class="ml-3 mr-5"
        dark small
        color="warning"
        @click="openModalAssignData()"
      >
        Chia lại
      </v-btn>

      <v-btn
        v-if="params.assign == 1 && tab == 1"
        class="ml-3 mr-3"
        dark small
        color="primary"
        @click="openModalAssignData()"
      >
        Chia số
      </v-btn>

      <v-btn
        v-if="params.assign == 1 && tab == 1"
        class=""
        dark small
        color="error"
        @click="deleteMulti()"
      >
        Xóa
      </v-btn>

      <div class="d-flex ml-3" v-if="!tab">
        <v-checkbox
          class="mr-3"
          v-model="params.assign"
          label=""
          color="red"
          value="1"
          hide-details
          @change="filterDataNotAssign()"
        >
          <template v-slot:label>
            <div style="color: red">Số chưa chia ({{ totalNotAssign }})</div>
          </template>
        </v-checkbox>

        <v-checkbox
          class="mr-3"
          v-model="params.status"
          color="green"
          value="3"
          hide-details
          @change="filterReaching($event)"
        >
          <template v-slot:label>
            <div style="color: green">Số đang chăm sóc ({{ totalDataUnreach }})</div>
          </template>
        </v-checkbox>

        <v-checkbox
          class="mr-3"
          v-model="params.type"
          color="orange"
          value="1"
          hide-details
          @change="search()"
        >
          <template v-slot:label>
            <div style="color: orange">Số đã tạo đơn ({{ totalDataOrder }})</div>
          </template>
        </v-checkbox>
      </div>

      <div class="d-flex ml-3" v-if="params.assign == 2">
        <div
          v-for="(item, index) in listStatus"
          class="mr-3"
          :key="index"
          v-show="item.id"
        >
          <v-checkbox
            v-model="params.status_ids"
            :value="item.id"
            hide-details
            @change="filterStatuses()"
          >
            <template v-slot:label>
              <div :style="{color: item.color}">{{ item.name }} (0)</div>
            </template>
          </v-checkbox>
        </div>
      </div>

      <div class="d-flex ml-auto" v-if="params.assign != 2">
        <v-btn
          v-if="params.assign == 1 && tab == 1"
          class="mr-3"
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
          v-if="params.assign != 2"
          class="ml-auto mr-3"
          dark small
          color="success"
          @click="openModalCreate()"
        >
          Thêm mới
        </v-btn>
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

      <template v-slot:item.last_supported_at="{ item }">
        <div>{{ formatTime(item.last_supported_at) }}</div>
      </template>

      <template v-slot:item.created_at="{ item }">
        <div>{{ formatTime(item.created_at) }}</div>
      </template>

      <template v-slot:item.type="{ item }">
        <div>{{ getNameType(item.type) }}</div>
      </template>

      <template v-slot:item.setting="{ index }">
        <div>
          {{params.offset + 1 + index}}
        </div>
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

    <modal-assign-sale  @store="store"/>

    <modal-setting-assign-sale />
  </v-card>
</template>

<script>
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import Swal from "sweetalert2";
import {mapGetters} from "vuex";
import Lead from "@/models/marketing/leads";
import ModalAssignSale from "@/components/om/pages/marketing/lead/ModalAssignSale";
import ModalSettingAssignSale from "@/components/om/pages/marketing/lead/ModalSettingAssignSale";
import ModalMobileDuplicate from "@/components/om/pages/marketing/lead/ModalMobileDuplicate";
import moment from "moment";
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import LeadStatus from "@/models/marketing/lead_status";
import {STATUS_REACHING_LEAD} from "@/config/app";

export default {
  name: "SaleLead",
  components: {ModalMobileDuplicate, ModalSettingAssignSale, ModalAssignSale},
  data() {
    return {
      params: new Filter(this.$route.query),
      tab: null,
      time: null,
      menu: false,
      firstFetched: false,
      lead: new Lead(),
      dataList: new Collection(Lead),
      listChannel: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      listUser: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      listStatus: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      statuses: new Collection(LeadStatus),
      duplicates: [
        {value: 1, label: 'YES'},
        {value: 0, label: 'NO'}
      ],
      total: 0,
      totalNotAssign: 0,
      totalDataOrder: 0,
      totalDataUnreach: 0,
      page: 1,
      totalPage: 1,
      selected: [],
      headers: [
        {text: '', value: 'setting', align: 'center', width: '50', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: '', value: 'action',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mã KH', value: 'code',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên khách hàng', value: 'name',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số điện thoại', value: 'mobile', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mô tả', value: 'note', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái', value: 'lead_status_id', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số trùng', value: 'is_duplicated', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Kênh', value: 'channel', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Sub kênh', value: 'sub_channel',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Loại sản phẩm', value: 'bundle', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Link URL', value: 'url', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Ngày trao đổi cuối', value: 'last_supported_at', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trao đổi cuối', value: 'last_supported', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Loại KH', value: 'type', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'NV tạo', value: 'user_created', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'NV phụ trách', value: 'user_assigned', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Ngày nhận số', value: 'assigned_at', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
      ],
      timeTypes: [
        {value: 1, label: 'Ngày tạo'},
        {value: 2, label: 'Ngày chia số'}
      ],
      options: [10, 20, 30],
    }
  },
  methods: {
    filterDataNotAssign() {
      console.log(this.tab)
      this.search()
    },
    async loadListData(assign = null) {
      this.tab = assign
      this.params.assign = assign
      await this.search()
    },
    changeTime() {
      this.$refs.menu.save(this.time)

      if (this.time.length == 2) {
        this.params.time_start = this.time[0]
        this.params.time_end = this.time[1]
        this.search()
      }
    },
    async filterReaching(event) {
      if (event) {
        this.params.status = STATUS_REACHING_LEAD
      } else {
        this.params.status = null
      }
      await this.search()
    },
    async filterStatuses() {
      this.params.status = null
      await this.search()
    },
    settingColumn() {

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
    store() {
      this.paginate(1)
    },
    async update(data) {
      await this.listAsync()
    },

    getNameType(type) {
      if (type) {
        return 'Đã có đơn'
      }

      return 'Chưa có đơn'
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

      if (duplicate) {
        return duplicate.label
      }
    },

    openModalAssignData() {
      this.$modal.show('modal-assign-sale', {
        total: this.total,
        selectLead: this.selected,
        dataParams: this.params.reduces()
      })
    },
    openModalSettingAssignData() {
      this.$modal.show('modal-setting-assign-sale')
    },
    openModalCreate() {
      this.$modal.show('modal-create-data-lead')
    },
    openModalEdit(item) {
      this.$modal.show('modal-edit-data-lead', {lead: item})
    },

    async search() {
      this.page = 1
      this.params.offset = 0
      this.selected = []
      await this.listAsync()
    },

    async listAsync() {
      try {
        const params = Object.assign({sale_assigned: 1}, this.params.reduces())

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

    deleteMulti() {
      if (this.selected.length < 1) {
        return
      }

      let ids = this.selected.pluck('id')

      Swal.fire({
        text: "Bạn có chắc chắn muốn xóa!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          this.confirmDeleteMulti(ids)
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

    async confirmDeleteMulti(ids = []) {
      if (ids.length < 1) {
        return
      }

      try {
        this.loadingStart()

        await this.lead.deleteMultiAsync({ids: ids})
        this.selected = []
        this.messageSuccess('Bạn đã xóa data số thành công')
        await this.paginate(this.page = 1)
      } catch (e) {
        this.handleException(e)
      }
    },

    async loadConfig() {
      this.channelState.then((result) => {
        this.listChannel.push(...result)
      })

      this.userState.then((result) => {
        this.listUser.push(...result.items)
      })

      this.leadStatusState.then((result) => {
        this.listStatus.push(...result)
        this.statuses.push(...result)
      })
    }
  },
  computed: {
    ...mapGetters({
      channelState: 'marketing/channels',
      userState: 'marketing/userRoleMarketing',
      leadStatusState: 'marketing/leadStatus',
    }),
  },
  async created() {
    await this.loadConfig()
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Danh sách chia số cho Sale"}]);
  },
}
</script>

<style lang="scss">

</style>