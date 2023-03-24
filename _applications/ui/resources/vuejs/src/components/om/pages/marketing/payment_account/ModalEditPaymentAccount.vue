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
                <label>Trạng thái</label>
                <v-select
                  no-data-text="không tìm thấy dữ liệu"
                  v-model="paymentAccount.is_active"
                  :items="statuses"
                  item-text="label"
                  item-value="value"
                  placeholder="Trạng thái"
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Ngân hàng</label>
                <v-select
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="paymentAccount.bank_name"
                  :items="listBank"
                  item-text="short_name"
                  item-value="short_name"
                  :rules="[rules.bankName]"
                  placeholder="Chọn ngân hàng"
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Tên chủ tài khoản</label>
                <v-text-field
                  v-model="paymentAccount.card_owner"
                  :rules="[rules.cardOwner]"
                  dense
                  outlined
                  placeholder="Tên chủ tài khoản"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Loại thẻ</label>
                <v-select
                  class="flex-basis"
                  v-model="paymentAccount.card_type"
                  :items="cardTypes"
                  item-text="label"
                  item-value="value"
                  :rules="[rules.cardType]"
                  placeholder="Chọn loại thẻ"
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Số thẻ</label>
                <v-text-field
                  v-model="paymentAccount.card_number"
                  :rules="[rules.cardNumber]"
                  dense
                  outlined
                  @keypress="handleInputNumber"
                  maxlength="30"
                  placeholder="Nhập số thẻ"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Nhân viên QLTK</label>
                <v-select
                  class="flex-basis"
                  v-model="paymentAccount.user_assign_ids"
                  :items="listUser"
                  item-text="full_name"
                  item-value="id"
                  :rules="[rules.userAssign]"
                  placeholder="Chọn nhân viên"
                  dense
                  multiple
                  outlined
                >
                  <template v-slot:item="{ item }">
                    {{item.full_name}}
                  </template>
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Số tài khoản</label>
                <v-text-field
                  v-model="paymentAccount.account_number"
                  :rules="[rules.accountNumber]"
                  dense
                  maxlength="30"
                  @keypress="handleInputNumber"
                  outlined
                  placeholder="Nhập số tài khoản"
                >
                </v-text-field>
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
import PaymentAccount from "@/models/marketing/payment_account";
import Collection from "@/core/collection";
import User from "@/models/user/user";

export default {
  name: "ModalEditPaymentAccount",
  data() {
    return {
      modalName: 'modal-edit-payment-account',
      title: 'Chỉnh sửa tài khoản MKT',
      paymentAccount: new PaymentAccount(),
      listBank: new Collection(Object),
      listUser: new Collection(User),
      cardTypes: [
        {value: 1, label: 'ATM'},
        {value: 2, label: 'Visa credit'},
        {value: 3, label: 'Master card'},
        {value: 4, label: 'Visa debit'}
      ],
      statuses: [
        {
          label: "Đang hoạt động",
          value: 1
        },
        {
          label: "Ngừng hoạt động",
          value: 0
        }
      ],
      rules: {
        bankName: value => !!value || 'Ngân hàng bắt buộc nhập.',
        cardType: value => !!value || 'Loại thẻ bắt buộc nhập.',
        cardOwner: value => !!value || 'Chủ tài khoản bắt buộc nhập.',
        userAssign: value => value.length > 0 || 'Nhân viên QLTK bắt buộc nhập.',
        cardNumber: value => !!value || 'Số thẻ bắt buộc nhập.',
        accountNumber: value => !!value || 'Số tài khoản bắt buộc nhập.',
      },
    }
  },
  methods: {
    beforeOpen(event) {
      this.listBank = _.cloneDeep(event.params.listBank)
      this.paymentAccount = _.cloneDeep(event.params.paymentAccount)
      console.log(this.paymentAccount.users.pluck('id'))
      this.listUser = _.cloneDeep(event.params.listUser)
      this.paymentAccount.user_assign_ids = this.paymentAccount.users.pluck('id')
    },
    beforeClose() {
      this.paymentAccount.reset()
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()
          await this.paymentAccount.updateAsync()
          this.$emit('update', this.paymentAccount)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã cập nhật tài khoản quảng cáo MKT thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
    },
    handleInputNumber(evt) {
      evt = (evt) ? evt : window.event;
      let expect = evt.target.value.toString() + evt.key.toString();

      if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
        evt.preventDefault();
      } else {
        return true;
      }
    }
  },
  mounted() {
  },
}
</script>

<style scoped>

</style>