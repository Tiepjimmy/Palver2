<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="45%"
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
        <h5>Chọn data số chia</h5>
        <div class="ml-5">
          <v-radio-group
            v-model="leadOption"
            mandatory
          >
            <v-radio
              class="w-fit-content"
              :label="`Chia tất cả data số (${total})`"
              value="1"
            ></v-radio>
            <v-radio
              class="w-fit-content"
              :label="`Chia theo số data số đã chọn (${leadIds.length})`"
              value="2"
            ></v-radio>
          </v-radio-group>
        </div>

        <v-form ref="form">
          <div class="d-flex">
            <h5 class="mr-10 mt-2">Chọn nhân viên sale</h5>
            <v-autocomplete
              class="flex-basis"
              v-model="userIds"
              :items="listSale"
              item-text="full_name"
              item-value="id"
              multiple
              dense
              outlined
              small-chips
              :rules="[rules.sale]"
              placeholder="Chọn nhân viên sale"
            >
              <template v-slot:item="{ item }">
                {{item.full_name}}
              </template>
              <template v-slot:selection="data">
                <v-chip
                  v-bind="data.attrs"
                  :input-value="data.selected"
                  close
                  @click="data.select"
                  @click:close="removeUser(data.item)"
                >
                  {{ data.item.full_name }}
                </v-chip>
              </template>
            </v-autocomplete>
          </div>
        </v-form>
      </div>
      <footer class="modal-footer">
        <div class="d-flex ">
          <v-btn class="ml-auto mr-3" @click="closeModal()">Hủy bỏ</v-btn>
          <v-btn dark class="primary" @click="submit()">Chia số</v-btn>
        </div>
      </footer>
    </modal>
  </transition>
</template>

<script>

import Lead from "@/models/marketing/leads";

export default {
  name: "ModalAssignSale",
  data() {
    return {
      leadOption: null,
      leadIds: [],
      modalName: 'modal-assign-sale',
      title: 'Chia số cho nhóm sale',
      total: 0,
      userIds: [],
      listSale: [
        {id: 1, full_name: 'Sale 1'},
        {id: 2, full_name: 'Sale 2'}
      ],
      rules: {
        sale: value => value.length > 0 || 'Nhân viên sale bắt buộc nhập',
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.total = event.params.total
      this.dataParams = event.params.dataParams
      this.leadIds = event.params.selectLead.pluck('id')
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    removeUser(item) {
      const index = this.userIds.indexOf(item.id)
      if (index >= 0) this.userIds.splice(index, 1)
    },
    async submit() {
      if ((this.total > 0 && this.leadOption == 1) || (this.leadIds.length > 0 && this.leadOption == 2)) {
        await this.assignData()
      } else {
        this.messageError('Không có khách hàng để thực hiện chia')
      }
    },
    async assignData() {
      let params = {
        users: this.userIds,
        params: this.dataParams,
      }

      if (this.leadOption == 2) {
        params.leadIds = this.leadIds
      }

      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()

          await new Lead().assignUser(params)
          this.$emit('store')

          this.closeModal()
          this.messageSuccess('Bạn đã thực hiện chia số thành công')
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