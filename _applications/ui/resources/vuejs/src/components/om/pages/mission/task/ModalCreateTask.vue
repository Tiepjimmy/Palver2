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
            <label class="om-wp-label-modal">Tên nhiệm vụ</label>
            <v-text-field
              v-model="task.name"
              :value="task.name"
              :rules="[rules.required]"
              dense
              outlined
              maxlength="250"
              placeholder="Nhập tên nhiệm vụ">
            </v-text-field>
          </div>
          <div>
            <label class="om-wp-label-modal">Hành động mặc định khi nhận lead</label>
            <v-switch
              v-model="task.is_default"
              value="1"
              color="success"
            ></v-switch>
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

export default {
  name: 'ModalCreateTask',
  data() {
    return {
      modalName: 'modal-create-task',
      title: 'Thêm nhiệm vụ',
      task: new Task(),
      rules: {
        required: value => !!value || 'Tên nhiệm vụ bắt buộc nhập.',
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.task.created_by = this.user.id
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
      this.task = new Task()
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()

          await this.task.storeAsync().then((result) => {
            if (result) {
              const task = {
                id: result.id,
                name: result.name,
                is_active: result.is_active
              }

              this.$emit('store', task)
            }
          })


          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã thêm mới nhiệm vụ thành công')
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