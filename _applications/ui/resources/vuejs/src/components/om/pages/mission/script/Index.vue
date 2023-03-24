<template>
  <div>
    <v-row class="mt-3">
      <v-col class="d-flex align-items-center">
        <h5>Thiết lập nhiệm vụ</h5>
        <v-btn
          class="ml-auto"
          dark
          color="success"
          @click="openModalCreate()"
        >
          Thêm thiết lập
        </v-btn>
      </v-col>

    </v-row>

    <v-row class="" v-show="firstFetched">
      <v-col cols="3">
        <v-card outlined class="p-5 mb-1">
          <h5 class="mb-5 text-center">Nhiệm vụ</h5>
          <div class="">
            <div v-for="(item, index) in listTask" :key="index">
              <v-checkbox
                v-model="item.checked"
                :label="item.name"
                hide-details
                @change="changeTask(item)"
              >
              </v-checkbox>
              <v-divider class="my-3"></v-divider>
            </div>
          </div>

        </v-card>
      </v-col>
      <v-col cols="9">
        <v-card outlined class="mb-1">
          <v-data-table
            class="om-wp_border-bottom"
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

            <template  v-slot:item.result="{ item }">
              <div>{{ item.result ? item.result.name : '' }}</div>
            </template>

            <template  v-slot:item.next_task="{ item }">
              <div>{{ item.next_task ? item.next_task.name : 'Không có nhiệm vụ kế tiếp' }}</div>
            </template>

            <template  v-slot:item.next_task_end_at="{ item }">
              <div>{{ getTimeAfter(item.next_task_end_at) }}</div>
            </template>

            <template  v-slot:item.status="{ item }">
              <div>
                <v-chip
                  :color="getColorStatusLead(item.result.lead_status_id)"
                  outlined
                  small
                  class="ma-2"
                >
                  {{ getNameStatusLead(item.result.lead_status_id) }}
                </v-chip>

              </div>
            </template>
          </v-data-table>
          <div class="pl-3 py-3 d-flex align-items-center">
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
    </v-row>

    <modal-create-script @store="search"/>

    <modal-edit-script @update="update"/>
  </div>
</template>

<script>
import Task from "@/models/mission/task";
import Result from "@/models/mission/task";
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import Swal from "sweetalert2";
import ModalCreateScript from "@/components/om/pages/mission/script/ModalCreateScript";
import ModalEditScript from "@/components/om/pages/mission/script/ModalEditScript";
import {mapGetters} from "vuex";
import LeadStatus from "@/models/marketing/lead_status";
import Script from "@/models/mission/script";
import {EventBus} from "@/core/plugins/event_bus";

export default {
  name: "TabResult",
  components: {
    ModalEditScript,
    ModalCreateScript
  },
  data() {
    return {
      firstFetched: false,
      params: new Filter(),
      listTask: new Collection(Task),
      listResult: new Collection(Result),
      script: new Script(),
      oldSecleted: null,
      dataList: new Collection(Script),
      listStatus: new Collection(LeadStatus),
      total: 0,
      totalPage: 1,
      page: 1,
      headers: [
        {text: 'Tiện ich', value: 'action',  align: 'center', width: '100', sortable: false},
        {text: 'Kết quả', value: 'result', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Trạng thái tương ứng', value: 'status', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Nhiệm vụ kế tiếp', value: 'next_task', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Thời gian chờ', value: 'next_task_end_at', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'}
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
    async update(data) {
      await this.listAsync()
    },
    openModalCreate() {
      this.$modal.show('modal-create-script', {
        listResult: this.listResult,
        listTask: this.listTask,
      })
    },
    openModalEdit(item) {
      this.$modal.show('modal-edit-script', {
        script: item,
        listResult: this.listResult,
        listTask: this.listTask,
      })
    },
    getTimeAfter(value) {
      if (value) {
        return `${value} phút`
      }

      return ''
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
    async changeTask(item) {
      if (this.oldSecleted == item.id) {
        this.oldSecleted = null
        this.dataList = new Collection(Script)
        return
      }

      this.listTask.forEach((i) => {
        if (i.id == item.id) {
          return i.checked = true
        } else {
          return i.checked = false
        }
      })

      this.oldSecleted = item.id
      this.params.task_id = item.id
      await this.listAsync()
    },
    async firstLoad() {
      if (this.listTask.length > 0) {
        this.listTask[0].checked = true
        this.oldSecleted = this.listTask[0].id
        this.params.task_id = this.oldSecleted
        await this.listAsync()
      }
    },
    async listAsync() {
      try {
        const params = this.params.reduces()

        this.loadingStart()

        this.dataList = await this.script.getListAsync(params)
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
        await this.script.deleteAsync(id)
        await this.listAsync()
        this.messageSuccess('Xóa kết quả thành công')
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
        let listTask = _.cloneDeep(result.missionTasks)
        this.listTask = _.cloneDeep(listTask)
        this.listResult.push(...result.missionResults)
        this.firstLoad()
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
  }
}
</script>

<style scoped>

</style>