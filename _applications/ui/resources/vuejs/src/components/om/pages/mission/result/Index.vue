<template>
  <div class="mission-task">
    <v-row class="mb-3">
      <v-col cols="3" class="d-flex ml-auto">
        <v-btn
          class="ml-auto"
          dark
          color="success"
          @click="openModalCreate()"
        >
          Thêm kết quả
        </v-btn>
      </v-col>

      <v-col cols="3">
        <v-text-field
          class="flex-basis"
          v-model="params.s"
          dense
          outlined
          hide-details
          placeholder="Tìm kiếm kết quả"
          @keyup.enter.native="search()"
        >
        </v-text-field>
      </v-col>

    </v-row>

    <v-data-table
      class="om-wp_border"
      no-data-text="Không tồn tại dữ liệu"
      :headers="headers"
      :items="dataList"
      hide-default-footer
      :items-per-page="params.limit"
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

      <template  v-slot:item.status_id="{ item }">
        <div>
          <v-chip
            :color="getColorStatusLead(item.lead_status_id)"
            outlined
            small
            class="ma-2"
          >
            {{ getNameStatusLead(item.lead_status_id) }}
          </v-chip>

        </div>
      </template>

      <template  v-slot:item.task="{ item }">
        <div>{{ getNameTask(item) }}</div>
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

    <modal-create-result @store="search"/>

    <modal-edit-result @update="update"/>
  </div>

</template>

<script>
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import Swal from "sweetalert2";
import ModalCreateResult from "@/components/om/pages/mission/result/ModalCreateResult";
import ModalEditResult from "@/components/om/pages/mission/result/ModalEditResult";
import {mapGetters} from "vuex";
import LeadStatus from "@/models/marketing/lead_status";
import Result from "@/models/mission/result";
import Task from "@/models/mission/task";
import {EventBus} from "@/core/plugins/event_bus";

export default {
  name: "TabResult",
  components: {
    ModalCreateResult,
    ModalEditResult
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(),
      result: new Result(),
      dataList: new Collection(Result),
      listStatus: new Collection(LeadStatus),
      listTask: new Collection(Task),
      total: 0,
      totalPage: 1,
      page: 1,
      headers: [
        {text: 'Tiện ích', value: 'action',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên kết quả', value: 'name', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái kết quả tương ứng', value: 'status_id', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Phạm vi áp dụng', value: 'task', sortable: false, class: 'om-wp_border-left text-center', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái', value: 'is_active', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
      ],
      listFake: [
        {
          id: 1,
          name: 'Bỏ qua',
          lead_status_id: 1,
          is_active: 1,
          task: [
            {id: 1, name: 'Gọi lần 1'},
            {id: 1, name: 'Gọi lần 2'}
          ],
          user_created_id: 1,
          user_updated_id: 1,
          created_at: null,
          updated_at: null,
        }
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
    update(data) {
      const item = this.dataList.find(i => i.id == data.id)

      if (item != null) {
        item.bind(data)
      }

    },
    openModalCreate() {
      this.$modal.show('modal-create-result', {
        listStatus: this.listStatus,
        listTask: this.listTask
      })
    },
    openModalEdit(item) {
      this.$modal.show('modal-edit-result', {
        result: item,
        listStatus: this.listStatus,
        listTask: this.listTask
      })
    },
    getNameTask(item) {
      if (item.tasks.length == this.listTask.length) {
        return 'Tất cả'
      }

      if (item.tasks.length > 0) {
        return item.tasks.pluck('name').join()
      }

      return ''
    },
    getNameStatus(value) {
      if (value == 1) {
        return 'Đang hoạt động'
      }

      return 'Ngừng hoạt động'
    },
    getColorStatus(value) {
      if (value == 1) {
        return 'success'
      }

      return 'warning'
    },
    getNameStatusLead(value) {
      let status = this.listStatus.find(i => i.id == value )

      if (status) {
        return status.name
      }
    },

    getColorStatusLead(value) {
      let status = this.listStatus.find( i => i.id == value )

      if (status) {
        return status.color
      }
    },
    async listAsync() {
      try {
        const params = this.params.reduces()

        this.loadingStart()

        this.dataList = await this.result.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    },
    async search() {
      this.page = 1
      this.params.offset = 0
      await this.listAsync()
    },
    changeDefaultTask(item) {

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
          this.confirmDeleteSingle(id)
        }
      })
    },
    async confirmDeleteSingle(id) {
      try {
        this.loadingStart()

        await this.result.deleteAsync(id)
        this.messageSuccess('Bạn đã xóa kết quả thành công')
        await this.listAsync()
      } catch (e) {
        this.handleException(e)
      }
    },
    updateTask() {
      EventBus.$on('updateTask', async (data) => {
        if (data) {
          console.log(data)
          this.listTask = data
          await this.paginate(1)
        }
      })
    },
    async loadConfig() {
      this.missionConfig.then((result) => {
        this.listStatus.push(...result.leadStatuses)
        this.listTask.push(...result.missionTasks)
      })
    }
  },
  computed: {
    ...mapGetters({
      missionConfig: 'omConfig/mission'
    }),
  },
  mounted() {

  },
  async created() {
    this.updateTask()
    this.params.limit = 10
    await this.loadConfig()
    await this.listAsync()
  }
}
</script>

<style scoped>

</style>