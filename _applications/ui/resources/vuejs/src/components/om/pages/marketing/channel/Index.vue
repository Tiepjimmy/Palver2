<template>
  <v-card flat>
    <v-row class="mt-5">
      <v-col cols="6" sm="4" md="3" lg="3" xl="3">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Tên kênh/Mã kênh</label>
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
            v-model="params.is_active"
            :items="statuses"
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

    <v-btn
      class="my-5"
      dark small
      color="error"
      @click="deleteMultiChannel()"
    >
      Xóa
    </v-btn>

    <v-row class="" v-show="firstFetched">
      <v-col md="8">
        <v-card class="mb-1">
          <v-data-table
            class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
            v-model="selected"
            no-data-text="Không tồn tại dữ liệu"
            :headers="headers"
            :items="dataList"
            hide-default-footer
            :items-per-page="params.limit"
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
                @click="deleteChannel(item)"
              >
                mdi-delete
              </v-icon>
            </template>

            <template  v-slot:item.is_active="{ item }">
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
        </v-card>
      </v-col>

      <v-col md="4">
        <v-card class="p-5 mb-1">
          <h5 class="text-center mb-5">Thêm kênh</h5>

          <v-form ref="form">
            <div class="" v-for="(item, index) in createItems">
              <label>Tên kênh</label>
              <div class="d-flex">
                <v-text-field
                  v-model="item.name"
                  :rules="[rules.required]"
                  dense
                  outlined
                  class="mr-5"
                  maxlength="250"
                  placeholder="Nhập tên kênh">
                </v-text-field>
                <v-btn
                  v-show="index > 0"
                  color="error"
                  fab dark x-small
                  @click="removeItemChannel(index)"
                >
                  <v-icon
                    color="darken-2"
                  >
                    fas fa-times
                  </v-icon>
                </v-btn>

                <v-btn
                  v-show="index == 0"
                  fab dark x-small
                  @click="addItemChannel()"
                >
                  <v-icon
                    color="darken-2"
                  >
                    fas fa-plus
                  </v-icon>
                </v-btn>

              </div>
            </div>

            <div class="d-flex mt-5">
              <v-btn class="ml-auto mr-3" @click="cancel()">Hủy bỏ</v-btn>
              <v-btn dark color="primary" @click="submit()">Lưu</v-btn>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>

    <modal-edit-channel
      @update="update"
    />
  </v-card>
</template>

<script>
import Channel from "@/models/marketing/channel";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import ModalEditChannel from "@/components/om/pages/marketing/channel/ModalEditChannel"
import Swal from "sweetalert2";
import {EventBus} from "@/core/plugins/event_bus";
import {mapGetters} from "vuex";

export default {
  name: "Channel",
  props: ['isChange'],
  components: {
    ModalEditChannel
  },
  data() {
    return {
      rules: {
        required: value => !!value || 'Tên kênh bắt buộc nhập.',
      },
      activeConfirm: false,
      params: new Filter(this.$route.query),
      firstFetched: false,
      channel: new Channel(),
      editChannel: new Channel(),
      dataList: new Collection(Channel),
      listChannel: new Collection(Channel),
      channelOptions: [],
      createItems: new Collection(Object, [new Channel()]),
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
        {text: 'Tiện ích', value: 'action',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mã kênh', value: 'code', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên kênh', value: 'name', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái', value: 'is_active', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
      ],
      isUpdate: false,
      options: [10, 20, 30]
    }
  },
  methods: {
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
      this.page = page
    },

    async update(data) {
      const item = this.dataList.find(i => i.id == data.id)

      if (item != null) {
        item.bind(data)
      }

      await this.updateListChannelState(data, 'edit')

      if (this.isChange) {
        this.isUpdate = true
      } else {
        this.isUpdate = false
      }
    },

    async updateListChannelState(data, action) {
      if (action == 'create') {
        this.listChannel.unshift(data)
      }

      if (action == 'edit') {
        let channel = this.listChannel.find(i => i.id == data.id)

        if (data.is_active && ! channel) {
          this.listChannel.unshift(data)
          _.orderBy(this.listChannel, ['id'], ['desc'])
        } else {
          this.listChannel = this.listChannel.filter((i) => {
            if (i.id == data.id) {
              return (i.name = data.name) && (i.is_active = data.is_active)
            } else {
              return i.is_active
            }
          })
        }
      }

      if (action == 'delete') {
        let ids = []

        if (data instanceof Array) {
          ids = data.pluck('id')
        } else {
          ids = [data.id]
        }

        _.forEach(ids, (i) => {
          const index = this.listChannel.findIndex( item => item.id == i)
          if (index >= 0) this.listChannel.splice(index, 1)
        })
      }

      let listChannel = this.listChannel.filter((i) => {
        return i.is_active
      })

      this.$store.commit('omConfig/update', {
        module: 'marketing', item: 'channels', data: _.cloneDeep(listChannel)
      })

      if (this.isChange) {
        EventBus.$emit('updateListChannel', this.listChannel)
      }
    },

    openModalEdit(item) {
      this.$modal.show('modal-edit-channel', {editChannel: item})
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
      this.createItems.push(new Channel())
    },

    removeItemChannel(index) {
      this.createItems.splice(index, 1)
    },

    resetItems() {
      this.createItems = [new Channel()]
      this.$refs.form.reset()
    },

    async submit() {
      if (this.$refs.form.validate()){

        try {
          this.loadingStart()
          await this.createChannel()
          this.resetItems()
          this.messageSuccess('Bạn đã tạo kênh thành công')
          await this.paginate(this.page = 1)
        } catch (e) {
          this.handleException(e)
        }
      }
    },

    async createChannel() {
      for (const i of this.createItems) {
        await new Channel().storeAsync(i).then((result) => {
          if (result) {
            const channel = {
              id: result.id,
              name: result.name,
              is_active: result.is_active
            }

            this.updateListChannelState(channel, 'create')
          }
        })
      }
    },

    cancel() {
      this.resetItems()
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

        this.dataList = await this.channel.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      }
    },

    deleteChannel(item) {
      if (! item) {
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
          this.confirmDeleteSingle(item)
        }
      })
    },

    deleteMultiChannel() {
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

    async confirmDeleteSingle(item) {
      try {
        this.loadingStart()

        await this.channel.deleteAsync(item.id)
        await this.updateListChannelState(item, 'delete')
        this.selected = []
        this.messageSuccess('Bạn đã xóa kênh thành công')
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

        await this.channel.deleteMultiAsync({ids: ids})
        await this.updateListChannelState(this.selected, 'delete')
        this.selected = []
        this.messageSuccess('Bạn đã xóa kênh thành công')
        await this.paginate(this.page = 1)
      } catch (e) {
        this.handleException(e)
      }
    },
    loadConfig() {
      this.marketingConfig.then((result) => {
        this.listChannel = _.cloneDeep(result.channels)
      })
    }
  },
  computed: {
    ...mapGetters({
      marketingConfig: 'omConfig/marketing'
    }),
  },
  async created() {
    this.loadConfig()
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
    // this.$store.dispatch(SET_BREADCRUMB, [{title: "Quản lý kênh"}]);
  },
}
</script>

<style lang="scss">

</style>