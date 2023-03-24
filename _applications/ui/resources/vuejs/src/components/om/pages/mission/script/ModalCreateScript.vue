<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="30%"
      :minWidth="375"
      height="auto"
      :scrollable="true"
      :clickToClose="false"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <header class="modal-header flex">
        <h4 class="m-auto">{{ title }}</h4>
        <v-btn
          icon
          @click="closeModal()"
        >
          <v-icon
          >
            mdi-close
          </v-icon>
        </v-btn>
      </header>
      <div class="modal-body">
        <v-form ref="form">
          <div>
            <label class="om-wp-label-modal">Nhiệm vụ</label>
            <v-select
              v-model="script.task_id"
              no-data-text="Không có dữ liệu"
              :items="listTask"
              :rules="[rules.task]"
              item-text="name"
              item-value="id"
              placeholder="Chọn nhiệm vụ"
              dense
              outlined
              @change="getResultByTask(script.task_id)"
            ></v-select>
          </div>
          <div>
            <label class="om-wp-label-modal">Kết quả</label>
            <v-select
              v-model="script.result_id"
              no-data-text="Không có dữ liệu"
              :items="listResult"
              :rules="[rules.result]"
              item-text="name"
              item-value="id"
              placeholder="Chọn kết quả"
              dense
              outlined
            ></v-select>
          </div>
          <div>
            <label class="om-wp-label-modal">Nhiệm vụ kế tiếp</label>
            <v-select
              v-model="script.next_task_id"
              no-data-text="Không có dữ liệu"
              :items="listTask"
              item-text="name"
              item-value="id"
              placeholder="Nhiệm vụ kế tiếp"
              :rules="[rules.nextTask]"
              dense
              outlined
            ></v-select>
          </div>
          <div class="">
            <label class="om-wp-label-modal">Thực hiện sau</label>
            <v-text-field
              v-model="script.next_task_end_at"
              dense
              outlined
              placeholder="Nhập thời gian">
            </v-text-field>
          </div>
        </v-form>
      </div>
      <footer class="modal-footer">
        <div class="d-flex">
          <v-btn class="ml-auto mr-3" @click="closeModal()">Hủy bỏ</v-btn>
          <v-btn dark class="primary" @click="save()">Lưu</v-btn>
        </div>
      </footer>
    </modal>
  </transition>
</template>

<script>
import Task from "@/models/mission/task";
import Collection from "@/core/collection";
import Result from "@/models/mission/result";
import Script from "@/models/mission/script";

export default {
  name: 'ModalCreateScript',
  data() {
    return {
      modalName: 'modal-create-script',
      title: 'Thêm điều kiện',
      script: new Script(),
      listTask: new Collection(Task),
      listResult: new Collection(Result),
      resultOptions: new Collection(Result),
      rules: {
        task: value => !!value || 'Nhiệm vụ bắt buộc nhập.',
        result: value => !!value || 'Kết quả bắt buộc nhập.',
        nextTask: value => !!value || 'Nhiệm vụ kế tiếp bắt buộc nhập.',
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.listTask = _.cloneDeep(event.params.listTask)
      this.listResult = new Collection(Result)
      this.script.created_by = this.user.id
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
      this.script = new Script()
    },
    async getResultByTask(value) {
      this.script.result_id = null
      this.listResult = await new Result().getAllResult({task_id: value})
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()

          await this.script.storeAsync()
          this.$emit('store', this.script)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Thêm mới nhiệm vụ thành công')
        } catch (e) {
          this.handleException(e)
        }
      }
    }
  },
  mounted() {
  },

}
</script>
<style lang="scss">

</style>