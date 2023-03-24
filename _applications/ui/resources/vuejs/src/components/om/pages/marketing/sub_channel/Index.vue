<template>
  <v-card flat>
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
          <label class="flex-1 d-flex flex-column place-content-end">Mã Sub kênh/Tên sub kênh</label>
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
    </v-row>

    <div class="my-5 d-flex">
      <v-btn
        dark small
        color="error"
        @click="deleteMultiSubChannel()"
      >
        Xóa
      </v-btn>

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
      class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
      v-model="selected"
      :headers="headers"
      :items="dataList"
      hide-default-footer
      :items-per-page="params.limit"
      no-data-text="Không tồn tại dữ liệu"
      item-key="name"
      show-select
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
          @click="deleteSubChannel(item.id)"
        >
          mdi-delete
        </v-icon>
      </template>

      <template v-slot:item.is_active="{ item }">
        <div>
          <v-chip
            :color="getColorStatus(item.is_active)"
            outlined
            small
            class="ma-2"
          >
            {{ getNameStatus(item.is_active) }}
          </v-chip>

        </div>
      </template>

      <template v-slot:item.channel="{ item }">
        <div>{{ item.channel.name }}</div>
      </template>

      <template v-slot:item.created_at="{ item }">
        <div>{{ formatTime(item.created_at) }}</div>
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
        :total-visible="5"
        @input="paginate(page)"
      ></v-pagination>
    </div>

    <modal-create-sub-channel
      @store="listAsync"
    />

    <modal-edit-sub-channel
      @update="update"
    />
  </v-card>
</template>

<script>
import ModalCreateSubChannel from "@/components/om/pages/marketing/sub_channel/ModalCreateSubChannel"
import ModalEditSubChannel from "@/components/om/pages/marketing/sub_channel/ModalEditSubChannel"
import Filter from "@/core/filter";
import Collection from "@/core/collection";
import Swal from "sweetalert2";
import SubChannel from "@/models/marketing/sub_channel";
import moment from "moment"
import {EventBus} from "@/core/plugins/event_bus";
import {mapGetters} from "vuex";

export default {
  name: "SubChannel",
  props: ['isChange'],
  components: {
    ModalCreateSubChannel,
    ModalEditSubChannel
  },
  data() {
    return {
      loading: false,
      query: null,
      pageListChannel: 1,
      totalChannel: 10,
      listChannel: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      channelOptions: new Collection(Object),
      params: new Filter(this.$route.query),
      firstFetched: false,
      subChannel: new SubChannel(),
      dataList: new Collection(SubChannel),
      statuses: [
        {
          label: 'Tất cả',
          value: null
        },
        {
          label: 'Đang hoạt động',
          value: 1
        },
        {
          label: 'Ngừng hoạt động',
          value: 0
        }
      ],
      total: 0,
      page: 1,
      totalPage: 1,
      selected: [],
      headers: [
        {text: 'Tiện ích', value: 'action', align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Kênh', value: 'channel', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mã sub kênh', value: 'code', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên sub kênh', value: 'name', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái', value: 'is_active', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Ngày tạo', value: 'created_at', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
      ],
      options: [10, 20, 30]
    }
  },
  methods: {
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
      this.page = page
    },

    async store() {
      await this.paginate(this.page = 1)
    },

    update(data) {
      const item = this.dataList.find(i => i.id == data.id)

      if (item != null) {
        item.bind(data)
      }
    },

    formatTime(time) {
      return time ? moment(time).format("DD/MM/YYYY") : ''
    },

    openModalCreate() {
      this.$modal.show('modal-create-sub-channel', {listChannel: this.channelOptions})
    },

    openModalEdit(item) {
      this.$modal.show('modal-edit-sub-channel', {subChannel: item})
    },

    getColorStatus(status) {
      if (status == 1) {
        return 'success'
      }

      return 'red'
    },

    getNameStatus(status) {
      if (status == 1) {
        return 'Đang hoạt động'
      }

      return 'Ngừng hoạt động'
    },

    addItemChannel() {
      this.createItems.push(new SubChannel())
    },

    removeItemChannel(index) {
      this.createItems.splice(index, 1)
    },

    resetItems() {
      this.createItems = [new SubChannel()]
      this.$refs.form.reset()
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

        this.dataList = await this.subChannel.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    },

    deleteSubChannel(id) {
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
          this.confirmDeleteSingle(id)
        }
      })
    },

    deleteMultiSubChannel() {
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

    async confirmDeleteSingle(id) {
      try {
        this.loadingStart()

        await this.subChannel.deleteAsync(id)
        this.messageSuccess('Bạn đã xóa sub kênh thành công')
        this.selected = []
        await this.paginate(this.page = 1)
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

        await this.subChannel.deleteMultiAsync({ids: ids})
        this.selected = []
        this.messageSuccess('Bạn đã xóa sub kênh thành công')
        await this.paginate(this.page = 1)
      } catch (e) {
        this.handleException(e)
      }
    },

    async loadConfig() {
      this.marketingConfig.then((result) => {
        this.listChannel.push(...result.channels)
        this.channelOptions.push(...result.channels)
      })
    },
    updateListChannel(data) {
      if (data) {
        this.listChannel = new Collection(Object, [{id: null, name: 'Tất cả'}])
        this.listChannel.push(...data)
        this.channelOptions = _.cloneDeep(data)
      }
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
    if (this.isChange) {
      EventBus.$on('updateListChannel', async (data) => {
        this.updateListChannel(data)
        this.selected = []
        await this.paginate(1)
      })
    }
  },
}
</script>

<style scoped>

</style>