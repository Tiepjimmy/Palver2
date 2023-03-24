<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="60%"
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
                <label class="om-wp-label-modal">Mã khách hàng</label>
                <v-text-field
                  v-model="lead.code"
                  dense
                  disabled
                  outlined
                  placeholder="Mã khách hàng"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Loại khách hàng</label>
                <v-select
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="lead.type"
                  :items="types"
                  item-text="label"
                  item-value="value"
                  placeholder="Loại khách hàng"
                  dense
                  :rules="[rules.type]"
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Tên khách hàng</label>
                <v-text-field
                  v-model="lead.name"
                  dense
                  :rules="[rules.name]"
                  outlined
                  placeholder="Tên khách hàng"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Nhân viên phụ trách</label>
                <v-select
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="lead.assigned_user_id"
                  :items="listUser"
                  item-text="full_name"
                  item-value="id"
                  placeholder="Nhân viên phụ trách"
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Số điện thoại</label>
                <v-text-field
                  v-model="lead.mobile"
                  dense
                  :rules="[rules.mobile]"
                  outlined
                  maxlength="14"
                  @keypress="handleInputNumber"
                  placeholder="Số điện thoại"
                >
                </v-text-field>
              </div>

              <div>
                <label class="om-wp-label-modal">Kênh</label>
                <v-autocomplete
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="lead.channel_id"
                  :items="listChannel"
                  item-text="name"
                  item-value="id"
                  placeholder="Kênh"
                  dense
                  :rules="[rules.channel]"
                  outlined
                  @change="getSubChannelOption()"
                >
                </v-autocomplete>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Mô tả</label>
                <v-textarea
                  v-model="lead.description"
                  dense
                  outlined
                  rows="6"
                  placeholder="Mô tả"
                >
                </v-textarea>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Sub Kênh</label>
                <v-autocomplete
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="lead.sub_channel_id"
                  :items="optionSubChannel"
                  item-text="name"
                  item-value="id"
                  placeholder="Sub kênh"
                  dense
                  :rules="[rules.sub]"
                  outlined
                >
                </v-autocomplete>
              </div>

              <div>
                <label class="om-wp-label-modal">Trạng thái</label>
                <v-select
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="lead.lead_status_id"
                  :items="listStatus"
                  item-text="name"
                  item-value="id"
                  placeholder="Trạng thái"
                  disabled
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Ghi chú</label>
                <v-textarea
                  v-model="lead.note"
                  dense
                  rows="6"
                  outlined
                  placeholder="Ghi chú"
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
import Channel from "@/models/marketing/channel";
import Collection from "@/core/collection";
import SubChannel from "@/models/marketing/sub_channel";
import Lead from "@/models/marketing/leads";
import {mapGetters} from "vuex";
import LeadStatus from "@/models/marketing/lead_status";
import {STATUS_WAIT_LEAD} from "@/config/app";

export default {
  name: "ModalCreateDataLead",
  data() {
    return {
      modalName: 'modal-create-data-lead',
      title: 'Thêm mới data số',
      lead: new Lead(),
      listChannel: new Collection(Channel),
      listSubChannel: new Collection(SubChannel),
      listUser: new Collection(Object),
      optionSubChannel: new Collection(SubChannel),
      listStatus: new Collection(LeadStatus),
      types: [
        {value: 0, label: 'Chưa có đơn'},
        {value: 1, label: 'Đã có đơn'},
      ],
      rules: {
        name: value => !!value || 'Tên khách hàng bắt buộc nhập',
        mobile: value => !!value || 'Số điện thoại bắt buộc nhập',
        channel: value => !!value || 'Kênh bắt buộc nhập',
        sub: value => !!value || 'Sub kênh bắt buộc nhập',
        type: value => value != null || value == 0 || 'Loại khách hàng bắt buộc nhập',
      }
    }
  },
  methods: {
    beforeOpen(event) {
      this.lead.lead_status_id = STATUS_WAIT_LEAD
      this.lead.created_by = this.user.id
    },
    beforeClose() {
      this.optionSubChannel = new Collection(SubChannel)
    },
    closeModal() {
      this.$modal.hide(this.modalName)
      this.lead.reset()
    },
    getSubChannelOption() {
      this.lead.sub_channel_id = null
      this.optionSubChannel = this.listSubChannel.filter((i) => {
        return i.channel_id == this.lead.channel_id
      })
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()

          await this.lead.storeAsync()
          this.$emit('store')

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã thêm data số thành công')
        } catch (e) {
          this.handleException(e)
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
    },
    async loadConfig() {
      this.marketingConfig.then((result) => {
        this.listChannel.push(...result.channels)
        this.listSubChannel.push(...result.subChannels)
        this.listUser.push(...result.listUser)
        this.listStatus.push(...result.leadStatuses)
      })
    }
  },
  computed: {
    ...mapGetters({
      marketingConfig: 'omConfig/marketing'
    }),
  },
  async created() {
    await this.loadConfig()
  },
  mounted() {
  },
}
</script>

<style scoped>

</style>