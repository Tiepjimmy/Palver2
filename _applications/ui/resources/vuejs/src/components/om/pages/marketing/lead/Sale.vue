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
    </v-row>

    <div class="d-flex my-5">
      <v-btn
        v-if="params.assign != 2"
        class="ml-auto"
        dark small
        color="success"
        @click="openModalCreate()"
      >
        Thêm mới
      </v-btn>
    </div>

    <v-data-table
      class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
      :headers="headers"
      :items="dataList"
      no-data-text="Không tồn tại dữ liệu"
      :items-per-page="params.limit"
      hide-default-footer
      item-key="id"
    >
      <template v-slot:header.setting="{ header }">
        <v-btn icon @click="settingColumn()">
          <v-icon>fas fa-cog</v-icon>
        </v-btn>
      </template>

      <template v-slot:item.setting="{ item, index }">
        <div class="d-flex align-items-center flex-column-reverse">
          <v-menu
            v-model="item.log"
            transition="scale-transition"
            :close-on-content-click="false"
            offset-x
            offset-y
            full-width
          >
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                small
                class="cursor-pointer"
                color="darken-2"
                v-on="on"
              >
                {{ item.detail ? 'fas fa-angle-double-down' : 'fas fa-angle-double-right' }}
              </v-icon>
            </template>
            <v-card color="#f0f8ff" class="overflow-x-auto">

            </v-card>
          </v-menu>
        </div>
      </template>

      <template v-slot:item.create_order="{ item }">
        <v-btn
          v-if="item.mission_id"
          small
          color="primary"
          @click="createOrder(item)"
        >
          Tạo đơn
        </v-btn>
      </template>

      <template v-slot:item.edit="{ item }">
        <v-icon
          class="cursor-pointer"
          small
          color="darken-2"
          @click="openModalEdit(item)"
        >
          fas fa-edit
        </v-icon>
      </template>

      <template v-slot:item.index="{ index }">
        <div>
          {{params.offset + 1 + index}}
        </div>
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
        <div>{{ getNameDuplicate(item.is_duplicated) }}</div>
      </template>

      <template v-slot:item.task="{ item }">
        <div>{{ getNameMission(item.mission_id) }}</div>
      </template>

      <template v-slot:item.result="{ item }">
        <div>{{ getNameResult(item.script) }}</div>
      </template>

      <template v-slot:item.sub_channel="{ item }">
        <div>{{ item.sub_channel ? item.sub_channel.name : '' }}</div>
      </template>

      <template v-slot:item.bundle="{ item }">
        <div>{{ item.bundle ? item.bundle.product_catalog_name : '' }}</div>
      </template>

      <template v-slot:item.user_created="{ item }">
        <div>{{ item.user_created ? item.user_created.full_name : '' }}</div>
      </template>

      <template v-slot:item.accept="{ item }">
        <v-btn
          v-if="! item.mission_id"
          small
          color="primary"
          @click="acceptData(item)"
        >
          Nhận số
        </v-btn>

        <v-btn
          v-if="item.mission_id"
          small
          color="warning"
          @click="cancelData(item)"
        >
          Nhả sô
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

    <modal-create-data-lead @store="store"/>

    <modal-edit-data-lead-by-mission @update="update"/>

  </v-card>
</template>

<script>
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import Swal from "sweetalert2";
import {mapGetters} from "vuex";
import Lead from "@/models/marketing/leads";
import moment from "moment";
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import LeadStatus from "@/models/marketing/lead_status";
import ModalCreateDataLead from "@/components/om/pages/marketing/lead/ModalCreateDataLead";
import ModalEditDataLeadByMission from "@/components/om/pages/marketing/lead/ModalEditDataLeadByMission";
import Task from "@/models/mission/task";
import Result from "@/models/mission/result";

export default {
  name: "Sale",
  components: {
    ModalCreateDataLead,
    ModalEditDataLeadByMission
  },
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
      productCatalog: new Collection(Object, [{product_catalog_name: 'Tất cả', id: null}]),
      listTask: new Collection(Task),
      listResult: new Collection(Result),
      statuses: new Collection(LeadStatus),
      duplicates: [
        {value: null, label: 'Tất cả'},
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
        {text: '', value: 'create_order',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: '', value: 'edit',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'STT', value: 'index',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mã KH', value: 'code',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên khách hàng', value: 'name',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số điện thoại', value: 'mobile', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mô tả', value: 'desciption', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái', value: 'lead_status_id', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Nhiệm vụ', value: 'task', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Kết quả', value: 'result', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Số trùng', value: 'is_duplicated', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Kênh', value: 'channel', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Sub kênh', value: 'sub_channel',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Loại sản phẩm', value: 'bundle', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Link URL', value: 'url', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'NV tạo', value: 'user_created', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Ghi chú', value: 'note', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: '', value: 'accept', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
      ],
      timeTypes: [
        {value: 1, label: 'Ngày tạo'},
        {value: 2, label: 'Ngày chia số'}
      ],
      options: [10, 20, 30],
    }
  },
  methods: {
    getNameMission(value) {
      let mission = this.listTask.find(i => i.id == value)

      if (mission) {
        return mission.name
      }

      return
    },
    getNameResult(script) {
      if (! script) {
        return
      }

      let result = this.listResult.find(i => i.id == script.result_id)

      if (result) {
        return result.name
      }

      return
    },
    createOrder(item) {
      return this.$router.push({name: 'om.order.create', query: {lead_id: item.id}})
    },
    async acceptData(item) {
      await new Lead().acceptAssign(item.id)
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

    settingColumn() {

    },
    async cancelData(item) {
      await new Lead().cancelAssign(item.id)
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

    openModalCreate() {
      this.$modal.show('modal-create-data-lead')
    },
    openModalEdit(item) {
      this.$modal.show('modal-edit-data-lead-by-mission', {lead: item})
    },

    async search() {
      this.page = 1
      this.params.offset = 0
      this.selected = []
      await this.listAsync()
    },

    async listAsync() {
      try {
        const params = Object.assign({assigned_user_id: this.user.id}, this.params.reduces())

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
        this.messageSuccess('Xóa data thành công')
        await this.paginate(1)
      } catch (e) {
        this.handleException(e)
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

      this.missionResult.then((result) => {
        this.listResult.push(...result)
      })

      this.missionTask.then((result) => {
        this.listTask.push(...result)
      })
    }
  },
  computed: {
    ...mapGetters({
      marketingConfig: 'omConfig/marketing',
      missionResult: 'mission/missionResult',
      missionTask: 'mission/missionTask',
    }),
  },
  async created() {
    await this.loadConfig()
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Danh sách data số"}]);
  },
}
</script>

<style lang="scss">

</style>