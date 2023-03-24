<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="80%"
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
              <v-row>
                <v-col cols="12" class="py-0">
                  <div>
                    <label class="om-wp-label-modal">Mã khách hàng</label>
                    <v-text-field
                      v-model="lead.code"
                      dense
                      disabled
                      outlined
                      background-color="#ededed"
                      placeholder="Mã khách hàng"
                    >
                    </v-text-field>
                  </div>
                </v-col>

                <v-col cols="12" class="py-0">
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

                <v-col cols="12" class="py-0">
                  <div>
                    <label class="om-wp-label-modal">Số điện thoại</label>
                    <v-text-field
                      v-model="lead.mobile"
                      dense
                      disabled
                      background-color="#ededed"
                      :rules="[rules.mobile]"
                      outlined
                      placeholder="Số điện thoại"
                    >
                    </v-text-field>
                  </div>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="4">
              <v-row>
                <v-col cols="12" class="py-0">
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

                <v-col cols="12" class="py-0">
                  <div>
                    <label class="om-wp-label-modal">Mô tả</label>
                    <v-textarea
                      v-model="lead.description"
                      dense
                      outlined
                      rows="5"
                      placeholder="Mô tả"
                    >
                    </v-textarea>
                  </div>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="4">
              <v-row>
                <v-col cols="12" class="py-0">
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
                </v-col>

                <v-col cols="12" class="py-0">
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

                <v-col cols="12" class="py-0">
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
              </v-row>
            </v-col>
            <v-col cols="6">
              <v-row class="om-wp_border m-0 pt-3">
                <v-col cols="6" class="py-0">
                  <div>
                    <label class="om-wp-label-modal">Nhiệm vụ</label>
                    <v-select
                      v-model="lead.mission_id"
                      no-data-text="Không có dữ liệu"
                      :items="listTask"
                      item-text="name"
                      item-value="id"
                      placeholder="Nhiệm vụ"
                      dense
                      outlined
                      append-icon=""
                      disabled
                      background-color="#ededed"
                      @change="selectMission(lead.mission_id)"
                    ></v-select>
                  </div>
                </v-col>

                <v-col cols="6" class="py-0">
                  <div>
                    <label class="om-wp-label-modal">Kết quả</label>
                    <v-select
                      v-model="lead.result_id"
                      no-data-text="Không có dữ liệu"
                      :items="listResult"
                      :rules="[rules.result]"
                      item-text="name"
                      item-value="id"
                      placeholder="Kết quả"
                      dense
                      outlined
                      @change="selectResult(lead.result_id)"
                    ></v-select>
                  </div>
                </v-col>

                <v-col cols="6" class="py-0">
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
                      outlined
                      rows="1"
                      placeholder="Ghi chú"
                    >
                    </v-textarea>
                  </div>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="6" class="">
              <v-row class="om-wp_border m-0 h-100 pt-3">
                <v-col v-if="script.next_task_id" cols="6" class="py-0">
                  <div >
                    <label class="om-wp-label-modal">Nhiệm vụ kế tiếp</label>
                    <v-select
                      v-model="script.next_task_id"
                      no-data-text="Không có dữ liệu"
                      :items="listTask"
                      item-text="name"
                      item-value="id"
                      placeholder="Nhiệm vụ kế tiếp"
                      readonly
                      dense
                      outlined
                    ></v-select>
                  </div>
                </v-col>

                <v-col
                  v-if="! script.next_task_id"
                  class="align-self-center text-center"
                >
                  <div>
                    Không có nhiệm vụ tiếp theo
                  </div>
                </v-col>
              </v-row>
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
import Script from "@/models/mission/script";
import Task from "@/models/mission/task";
import Result from "@/models/mission/result";

export default {
  name: "ModalEditDataLeadByMission",
  data() {
    return {
      modalName: 'modal-edit-data-lead-by-mission',
      title: 'Cập nhật data số',
      lead: new Lead(),
      listChannel: new Collection(Channel),
      listSubChannel: new Collection(SubChannel),
      listUser: new Collection(Object),
      optionSubChannel: new Collection(SubChannel),
      listStatus: new Collection(LeadStatus),
      script: new Script(),
      listTask: new Collection(Task),
      listResult: new Collection(Result),
      scriptDefault: null,
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
        result: value => !!value || 'Kết quả bắt buộc nhập',
        status: value => !!value || 'Trạng thái bắt buộc nhập',
      }
    }
  },
  methods: {
    async selectMission(value) {
      this.lead.result_id = null
      this.listResult = await new Result().getAllResult({task_id: value})
      this.script = new Script()
    },
    async selectResult(value) {
      const result = this.listResult.find(i => i.id == value)

      this.lead.lead_status_id = result.lead_status_id

      await this.script.loadScript({task_id: this.lead.mission_id, result_id: value})
    },
    async beforeOpen(event) {
      this.lead = _.cloneDeep(event.params.lead)
      this.getSubChannelOption()

      if (this.lead.mission_id) {
        await this.selectMission(this.lead.mission_id)
      }
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    getSubChannelOption() {
      this.optionSubChannel = this.listSubChannel.filter((i) => {
        return i.channel_id == this.lead.channel_id
      })
    },
    setRequest() {
      delete this.lead.channel
      delete this.lead.sub_channel
      delete this.lead.script
      delete this.lead.task
      delete this.lead.user_assigned
      delete this.lead.user_created
    },
    async save() {
      if (this.$refs.form.validate()) {
        this.setRequest()

        try {
          this.loadingStart()
          await this.lead.updateBySale()
          this.$emit('update', this.lead)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã cập nhật data số thành công')
        } catch (e) {
          this.handleException(e)
        }
      }
    },
    async loadConfig() {
      this.marketingConfig.then((result) => {
        this.listChannel.push(...result.channels)
        this.listSubChannel.push(...result.subChannels)
        this.listUser.push(...result.listUser)
        this.listStatus.push(...result.leadStatuses)
      })

      this.missionConfig.then((result) => {
        this.listTask.push(...result.missionTasks)
      })
    }
  },
  computed: {
    ...mapGetters({
      missionConfig: 'omConfig/mission',
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