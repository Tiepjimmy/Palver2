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
          <v-row>
            <v-col cols="12" class="py-0">
              <div>
                <label class="om-wp-label-modal">Mã lý do</label>
                <v-text-field
                    v-model="orderCancelReason.code"
                    dense
                    outlined
                    placeholder="Nhập mã lý do"
                >
                </v-text-field>
                <p v-if="validateErrors.code" class="text-danger">{{ validateErrors.code }}</p>
              </div>
            </v-col>
            <v-col cols="12" class="py-0">
              <div>
                <label class="om-wp-label-modal">Nội dung</label>
                <v-text-field
                    v-model="orderCancelReason.content"
                    :rules="[rules.content]"
                    dense
                    maxlength="200"
                    outlined
                    placeholder="Nhập lý do hủy đơn"
                >
                </v-text-field>
                <p v-if="validateErrors.content" class="text-danger">{{ validateErrors.content }}</p>
              </div>
            </v-col>
            <v-col cols="12" class="py-0">
              <div>
                <v-checkbox
                    v-model="orderCancelReason.is_active"
                    :label="`Hiệu lực`"
                ></v-checkbox>
              </div>
            </v-col>
          </v-row>
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
import OrderCancelReason from "@/models/order-cancel-reason/order_cancel_reason";

export default {
  name: "ModalEditOrderCancelReason",
  data() {
    return {
      modalName: 'modal-edit-order-cancel-reason',
      title: 'Cập nhật lý do hủy đơn',
      orderCancelReason: new OrderCancelReason(),
      rules: {
        content: value => !!value || 'Nội dung bắt buộc nhập.',
      },
      validateErrors: {
        code: '',
        content: ''
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.orderCancelReason = _.cloneDeep(event.params.orderCancelReason)
    },
    beforeClose() {
      this.validateErrors = {
        code: '',
        content: ''
      };
      this.orderCancelReason.reset()
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.validateErrors = {
            code: '',
            content: ''
          };
          this.loadingStart()
          this.orderCancelReason.updated_by = this.user.id
          await this.orderCancelReason.updateAsync()
          this.$emit('update', this.orderCancelReason)
          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã cập nhật lý do hủy đơn thành công')
        } catch (e) {
          this.messageWarning('Bạn đã cập nhật lý do hủy đơn không thành công, vui lòng thử lại')
          let response = e.response.data;
          if (response.status_code == 422) {
            for (let [key, value] of Object.entries(response.errors)) {
              this.validateErrors[key] = value.message;
            }
          }
        } finally {
          this.loadingClose()
        }
      }
    },
  },
  mounted() {
  },
}
</script>

<style scoped>

</style>