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
          <div class="">
            <label class="om-wp-label-modal">Tên kết quả</label>
            <v-text-field
              v-model="result.name"
              :rules="[rules.name]"
              dense
              outlined
              maxlength="250"
              placeholder="Nhập tên kết quả"
            >
            </v-text-field>
          </div>
          <div>
            <div class="d-flex om-wp-label-modal">
              <label class="">Chỉ áp dụng cho nhiệm vụ</label>
              <v-tooltip right>
                <template v-slot:activator="{ on, attrs }">
                  <v-icon
                    class="mb-1 ml-1"
                    small
                    color="red"
                    v-bind="attrs"
                    v-on="on"
                  >
                    info
                  </v-icon>
                </template>
                <span>Để trống nếu muốn áp dụng tất cả</span>
              </v-tooltip>
            </div>
            <v-select
              v-model="result.task_ids"
              no-data-text="Không có dữ liệu"
              :items="listTask"
              clearable
              item-text="name"
              item-value="id"
              placeholder="Nhiệm vụ áp dụng"
              dense
              outlined
              multiple
            >
              <template v-slot:item="{ item }">
                {{item.name}}
              </template>
            </v-select>
          </div>
          <div>
            <label class="om-wp-label-modal">Trạng thái kết quả tương ứng</label>
            <v-select
              v-model="result.lead_status_id"
              no-data-text="Không có dữ liệu"
              :items="listStatus"
              :rules="[rules.status]"
              item-text="name"
              item-value="id"
              placeholder="Trạng thái tương ứng"
              dense
              outlined
            ></v-select>
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
import LeadStatus from "@/models/marketing/lead_status";
import Result from "@/models/mission/result";

export default {
  name: 'ModalCreateResult',
  data() {
    return {
      modalName: 'modal-create-result',
      title: 'Thêm kết quả',
      result: new Result(),
      listStatus: new Collection(LeadStatus),
      listTask: new Collection(Task),
      rules: {
        name: value => !!value || 'Tên kết quả bắt buộc nhập.',
        status: value => !!value || 'Trạng thái bắt buộc nhập.',
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.listStatus = _.cloneDeep(event.params.listStatus)
      this.listTask = _.cloneDeep(event.params.listTask)
      this.result.created_by = this.user.id
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
      this.result = new Result()
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()

          await this.result.storeAsync()
          this.$emit('store', this.result)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã thêm mới kết quả thành công')
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