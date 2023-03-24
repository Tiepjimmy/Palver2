<template>
  <transition name="overlay" mode="out-in">
    <modal
    :id="modalName"
    :name="modalName"
    :adaptive="true"
    width="55%"
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
          <v-col cols="4">
            <div>
              <label class="om-wp-label-modal">Kênh</label>
              <v-text-field
                v-model="subChannel.channel.name"
                disabled
                background-color="#ededed"
                dense
                outlined
              >
              </v-text-field>
            </div>
          </v-col>

          <v-col cols="4">
            <div>
              <label class="om-wp-label-modal">Trạng thái</label>
              <v-select
                v-model="subChannel.is_active"
                :items="statuses"
                item-text="label"
                item-value="value"
                dense
                outlined
              ></v-select>
            </div>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="4" class="py-0">
            <div class="">
              <label class="om-wp-label-modal">Mã Sub kênh</label>
              <v-text-field
                v-model="subChannel.code"
                :value="subChannel.code"
                :rules="[ruleCode.required]"
                dense
                outlined
                placeholder="Mã sub kênh">
              </v-text-field>
            </div>
          </v-col>

          <v-col cols="4" class="py-0">
            <div>
              <label class="om-wp-label-modal">Sub kênh</label>
              <v-text-field
                v-model="subChannel.name"
                :value="subChannel.name"
                :rules="[rules.required]"
                dense
                outlined
                placeholder="Tên sub kênh">
              </v-text-field>
            </div>
          </v-col>

          <v-col cols="4" class="d-flex align-items-center py-0">
            <div class="mr-3">
              <label class="om-wp-label-modal">Nội dung</label>
              <v-text-field
                v-model="subChannel.content"
                :value="subChannel.content"
                dense
                outlined
                placeholder="Nội dung">
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
import SubChannel from "@/models/marketing/sub_channel";

export default {
  name: 'ModelEditSubChannel',
  data() {
    return {
      code: null,
      modalName: 'modal-edit-sub-channel',
      title: 'Chỉnh sửa sub kênh',
      subChannel: new SubChannel(),
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
        required: value => !!value || 'Tên kênh bắt buộc nhập.',
      },
      ruleCode: {
        required: value => !!value || 'Mã sub kênh bắt buộc nhập.',
        unique: value => {
          let unique

          if (value == this.code) {
            unique = false
          }

          return unique || 'Mã Sub kênh không được trùng'
        }
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.subChannel.bind(event.params.subChannel)
      this.code = this.subChannel.code
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
      this.subChannel = new SubChannel()
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()
          await this.subChannel.updateAsync()
          this.$emit('update', this.subChannel)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã cập nhật sub kênh thành công')
        } catch (e) {
          this.handleException(e)
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
<style lang="scss">

</style>
