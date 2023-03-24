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
              <label class="om-wp-label-modal">Chọn kênh</label>
              <v-autocomplete
                no-data-text="không tìm thấy dữ liệu"
                class="flex-basis"
                v-model="channelId"
                :items="listChannel"
                :loading="loading"
                item-text="name"
                item-value="id"
                :rules="[ruleChannel.required]"
                dense
                outlined
                placeholder="Chọn kênh"
              >
              </v-autocomplete>
            </div>
          </v-col>

          <v-col cols="4">
            <div>
              <label class="om-wp-label-modal">Trạng thái</label>
              <v-text-field
                value="Hoạt động"
                disabled
                dense
                outlined
                background-color="#ededed"
              >
              </v-text-field>
            </div>
          </v-col>
        </v-row>

        <v-row v-for="(item, index) in createItems" :key="index">
          <v-col cols="4" class="py-0">
            <div class="">
              <label class="om-wp-label-modal">Mã Sub kênh</label>
              <v-text-field
                :rules="ruleCode"
                v-model="item.code"
                :value="item.code"
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
                v-model="item.name"
                :value="item.name"
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
                v-model="item.content"
                :value="item.content"
                dense
                outlined
                placeholder="Nội dung">
              </v-text-field>
            </div>
            <v-btn
              v-show="index > 0"
              color="error"
              fab dark x-small
              @click="removeItemSubChannel(index)"
            >
              <v-icon
                color="darken-2"
              >
                fas fa-times
              </v-icon>
            </v-btn>

            <v-btn
              v-show="index == 0"
              fab dark x-small
              @click="addItemSubChannel()"
            >
              <v-icon
                color="darken-2"
              >
                fas fa-plus
              </v-icon>
            </v-btn>
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
import Collection from "@/core/collection";
import Channel from "@/models/marketing/channel";
import {mapGetters} from "vuex";

export default {
  name: "ModalCreateSubChannel",
  data() {
    return {
      loading: false,
      query: null,
      pageListChannel: 1,
      totalChannel: 10,
      filterChannel: null,
      listChannel: new Collection(Channel),
      modalName: 'modal-create-sub-channel',
      title: 'Thêm sub kênh',
      subChannel: new SubChannel(),
      channelId: null,
      createItems: new Collection(Object, [new SubChannel()]),
      rules: {
        required: value => !!value || 'Tên Sub kênh bắt buộc nhập.',
      },
      ruleChannel: {
        required: value => !!value || 'Kênh bắt buộc nhập.',
      },
      ruleCode: [
        value => {
          let unique = false
          let code = this.createItems.filter((i) => {
            if (i.code == value && i.code != null && i.code != '') {
             return i
            }
          })

          unique = code.length <= 1 ? true : false
          return unique || 'Mã Sub kênh không được trùng'
        }
      ]
    }
  },
  methods: {
    beforeOpen(event) {
      this.listChannel = _.cloneDeep(event.params.listChannel)
    },
    beforeClose() {
      this.channelId = null
      this.createItems =new Collection(Object, [new SubChannel()])
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },

    async save() {
      if (this.$refs.form.validate()) {
        this.createItems = this.createItems.filter((i) => {
          return i.channel_id = this.channelId
        })

        try {
          this.loadingStart()
          await this.createSubChannel()
          this.$emit('store')

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã thêm mới sub kênh thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
    },

    async createSubChannel() {
      for (const i of this.createItems) {
        await new SubChannel().storeAsync(i)
      }
    },

    addItemSubChannel() {
      this.createItems.push(new SubChannel())
    },

    removeItemSubChannel(index) {
      this.createItems.splice(index, 1)
    },
  },
  async created() {
  },
  mounted() {
  },
}
</script>

<style lang="scss">
</style>