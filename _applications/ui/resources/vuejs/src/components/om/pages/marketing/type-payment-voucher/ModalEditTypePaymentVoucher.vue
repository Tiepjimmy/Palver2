<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="50%"
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
            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Tên loại chứng từ chi <span style="color:red">(*)</span></label>
                <v-text-field
                  v-model="typePaymentVoucher.type_name"
                  :rules="[rules.type_name, rules.length_200]"
                  dense
                  outlined
                  placeholder="Tên loại chứng từ chi"
                >
                </v-text-field>
              </div>
              <div>
                <label class="om-wp-label-modal">Mã loại chứng từ chi <span style="color:red">(*)</span></label>
                <v-text-field
                  v-model="typePaymentVoucher.type_code"
                  :rules="[rules.type_code, rules.length_20]"
                  dense
                  outlined
                  disabled
                  placeholder="Mã loại chứng từ chi"
                >
                </v-text-field>
              </div>
              <div>
                <v-checkbox
                  v-model="typePaymentVoucher.is_business_result"
                  :label="`Hoạch toán kết quả kinh doanh`"
                ></v-checkbox>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Mô tả</label>
                <v-textarea
                  v-model="typePaymentVoucher.note"
                  dense
                  outlined
                  :rules="[rules.length_200]"
                  rows="6"
                  label="Mô tả"
                >
                </v-textarea>
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
import TypePaymentVoucher from "@/models/marketing/type_payment_voucher";
import Collection from "@/core/collection";

export default {
  name: "ModalEditTypePaymentVoucher",
  data() {
    return {
      modalName: 'modal-edit-type-payment-voucher',
      title: 'Chỉnh sửa loại chứng từ chi',
      typePaymentVoucher: new TypePaymentVoucher(),
      rules: {
        type_name: value => !!value || 'Tên loại chứng từ chi bắt buộc nhập.',
        type_code: value => !!value || 'Mã loại chứng từ chi bắt buộc nhập.',
        length_20: value => value.length <= 20 || 'Không được nhập quá 20 ký tự',
        length_200: value => (( value === null || value === '') || value.length <= 200) || 'Không được nhập quá 200 ký tự',
      },
    }
  },
  methods: {
    beforeOpen(event) {
      this.typePaymentVoucher = _.cloneDeep(event.params.typePaymentVoucher)
    },
    beforeClose() {
      this.typePaymentVoucher.reset()
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()
          await this.typePaymentVoucher.updateAsync()
          this.$emit('update', this.typePaymentVoucher)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã cập nhật loại chứng từ chi thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
    }
  },
  mounted() {
  },
}
</script>

<style scoped>

</style>