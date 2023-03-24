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
            <label class="om-wp-label-modal">Tên kênh</label>
            <v-text-field
              v-model="channel.name"
              :value="channel.name"
              :rules="[rules.required]"
              dense
              outlined
              maxlength="250"
              placeholder="Nhập tên kênh">
            </v-text-field>
          </div>
          <div>
            <label class="om-wp-label-modal">Trạng thái</label>
            <v-select
              v-model="channel.is_active"
              :value="channel.is_active"
              :items="statuses"
              item-text="label"
              item-value="value"
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
import Channel from "@/models/marketing/channel";

export default {
  name: 'ModalEditChannel',
  data() {
    return {
      modalName: 'modal-edit-channel',
      title: 'Chỉnh sửa kênh',
      channel: new Channel(),
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
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.channel.bind(event.params.editChannel)
    },
    beforeClose() {
      // console.log(this.channel)
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()

          await new Channel().updateAsync(this.channel.reduces(false), this.channel.id).then((result) => {
            if (result) {
              const channel = {
                id: result.id,
                name: result.name,
                is_active: result.is_active
              }

              this.$emit('update', channel)
            }
          })

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã cập nhật kênh thành công')
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