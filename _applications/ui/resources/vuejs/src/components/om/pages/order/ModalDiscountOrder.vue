<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      :width="375"
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
          <div class="d-flex">
            <v-btn
              @click="changePercent('cash')"
              :color="discountType == 'cash' ? 'primary' : ''"
              class="btn-discount btn-input-dense">Giá trị</v-btn>
            <v-btn
              @click="changePercent('percent')"
              :color="discountType == 'percent' ? 'primary' : ''"
              class="btn-discount btn-input-dense mr-3">%</v-btn>
            <v-input-currency
              class="text-right-input"
              v-model="discount"
              :rules="[rules.total]"
              :hideDetails="false"
            />
          </div>

          <div class="">
            <label class="om-wp-label-modal">Lý do</label>
            <v-text-field
              v-model="note"
              dense
              outlined
              hide-details
            >
            </v-text-field>
          </div>
        </v-form>
      </div>
      <footer class="modal-footer">
        <div class="d-flex">
          <v-btn class="ml-auto mr-3" @click="closeModal()">Hủy bỏ</v-btn>
          <v-btn dark class="primary" @click="save()">Áp dụng</v-btn>
        </div>
      </footer>
    </modal>
  </transition>
</template>

<script>

import VInputCurrency from "@/components/om/widgets/VInputCurrency";
import {NoteTypeOrder} from "@/helpers/enums";

export default {
  name: 'ModalDiscountOrder',
  components: {
    VInputCurrency
  },
  data() {
    return {
      subTotal: 0,
      discountType: 'cash',
      note: null,
      discount: 0,
      modalName: 'modal-discount-order',
      title: 'Chiết khấu',
      rules: {
        total: value => {
          if (this.discountType == 'percent') {
            let total = this.discount * this.subTotal / 100
            return total <= this.subTotal || 'Chiết khấu lớn hơn giá trị đơn hàng'
          } else {
            return this.discount <= this.subTotal || 'Chiết khấu lớn hơn giá trị đơn hàng'
          }
        }
      }

    }
  },
  methods: {
    beforeOpen(event) {
      this.discount = event.params.discount
      this.subTotal = event.params.subTotal

      if (event.params.discountType) {
        this.discountType = event.params.discountType
      }

      let noteDiscount = event.params.notes.find(i => i.type == NoteTypeOrder.Order)

      if (noteDiscount) {
        this.note = noteDiscount.note
      }
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
      this.discount = 0
      this.note = null
    },
    changePercent(type = 'cash') {
      this.discountType = type
    },
    async save() {
      if (this.$refs.form.validate()) {
        let data = {
          discount: this.discount,
          note: this.note,
          discountType: this.discountType
        }

        this.$emit('updateDiscountOrder', data)
        this.closeModal()
      }
    }
  },
  mounted() {
  },

}
</script>
<style lang="scss">

</style>