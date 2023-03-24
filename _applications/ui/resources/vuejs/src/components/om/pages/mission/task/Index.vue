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
          Thêm nhiệm vụ
        </v-btn>
      </v-col>

      <v-col cols="3">
        <v-text-field
          class="flex-basis"
          v-model="params.s"
          dense
          outlined
          hide-details
          placeholder="Tìm kiếm nhiệm vụ"
          @keyup.enter.native="search()"
        >
        </v-text-field>
      </v-col>

    </v-row>

    <v-data-table
      class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
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
          @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>


      <template  v-slot:item.is_default="{ item }">
        <v-checkbox
          class="checkbox-table"
          v-model="item.is_default"
          hide-details
          @change="changeDefaultTask(item)"
        >
        </v-checkbox>
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

    <modal-create-task @store="store"/>

    <modal-edit-task @update="update"/>
  </div>

</template>

<script>
import Task from "@/models/mission/task";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import Swal from "sweetalert2";
import ModalCreateTask from "@/components/om/pages/mission/task/ModalCreateTask";
import ModalEditTask from "@/components/om/pages/mission/task/ModalEditTask";
import Script from "@/models/mission/script";
import {EventBus} from "@/core/plugins/event_bus";
import {mapGetters} from "vuex";

export default {
  name: "TabTask",
  components: {
    ModalCreateTask,
    ModalEditTask
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(),
      task: new Task(),
      dataList: new Collection(Task),
      listTask: new Collection(Task),
      total: 0,
      totalPage: 1,
      page: 1,
      headers: [
        {text: 'Tiện ích', value: 'action',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên nhiệm vụ', value: 'name', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Là nhiệm vụ mặc định', value: 'is_default', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái', value: 'is_active', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
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
    store(data) {
      this.updateTaskState(data, 'create')
      this.search()
    },
    update(data) {
      this.updateTaskState(data, 'edit')
      this.listAsync()
    },
    async updateTaskState(data, action) {
      if (action == 'create') {
        this.listTask.unshift(data)
      }

      if (action == 'edit') {
        let task = this.listTask.find(i => i.id == data.id)

        if (data.is_active && ! task) {
          this.listTask.unshift(data)
          _.orderBy(this.listTask, ['id'], ['desc'])
        } else {
          this.listTask = this.listTask.filter((i) => {
            if (i.id == data.id) {
              return (i.name = data.name) && (i.is_active = data.is_active)
            } else {
              return i.is_active
            }
          })
        }
      }

      if (action == 'delete') {
        const index = this.listTask.findIndex( item => item.id == data.id)
        if (index >= 0) this.listTask.splice(index, 1)
      }

      let listTask = this.listTask.filter((i) => {
        return i.is_active
      })

      this.$store.commit('omConfig/update', {
        module: 'mission', item: 'missionTasks', data: _.cloneDeep(listTask)
      })

      EventBus.$emit('updateTask', this.listTask)
    },
    openModalCreate() {
      this.$modal.show('modal-create-task')
    },
    openModalEdit(item) {
      this.$modal.show('modal-edit-task', {task: item})
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
    async listAsync() {
      try {
        const params = this.params.reduces()

        this.loadingStart()

        this.dataList = await this.task.getListAsync(params)
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
    async changeDefaultTask(item) {
      await this.task.updateAsync(item, item.id)
      await this.listAsync()
    },
    deleteItem(item) {
      if (! item.id) {
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
    async confirmDeleteSingle(item) {
      try {
        this.loadingStart()

        await this.task.deleteAsync(item.id)
        this.updateTaskState(item, 'delete')
        this.messageSuccess('Bạn đã xóa nhiệm vụ thành công')
        await this.listAsync()
      } catch (e) {
        this.handleException(e)
      }
    },
    async loadConfig() {
      this.missionConfig.then((result) => {
        this.listTask = _.cloneDeep(result.missionTasks)
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
    this.params.limit = 10
    await this.loadConfig()
    await this.listAsync()
  }
}
</script>

<style scoped>

</style>