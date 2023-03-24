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
        <h5>Chia theo pool (Tất cả sale đều nhìn thấy)</h5>
        <v-switch
          class="w-fit-content"
          v-model="pool"
          disabled
          color="success"
        ></v-switch>

        <h5>Chia đều</h5>
        <v-switch
          class="w-fit-content"
          v-model="equal"
          color="success"
        ></v-switch>

        <v-form ref="form">
          <v-row v-show="equal" v-for="(setting, index) in settingSales" :key="index" >
            <v-col class="py-0">
              <h5>Giờ nhận data số</h5>
              <v-autocomplete
                v-model="setting.time"
                :items="hours"
                :rules="[rules.time]"
                multiple
                dense
                outlined
                small-chips
                placeholder="Thời gian"
              >
                <template v-slot:item="{ item }">
                  {{item}}
                </template>
                <template v-slot:selection="data">
                  <v-chip
                    v-bind="data.attrs"
                    :input-value="data.selected"
                    close
                    @click="data.select"
                    @click:close="removeTime(data.item, setting)"
                  >
                    {{ data.item }}
                  </v-chip>
                </template>
              </v-autocomplete>
            </v-col>

            <v-col class="py-0">
              <h5>Nhân viên sale</h5>
              <div class="d-flex">
                <v-autocomplete
                  class="mr-3"
                  v-model="setting.users"
                  :items="listSale"
                  item-text="full_name"
                  item-value="id"
                  :rules="[rules.sale]"
                  multiple
                  dense
                  outlined
                  small-chips
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
                      @click:close="removeUser(data.item, setting)"
                    >
                      {{ data.item.full_name }}
                    </v-chip>
                  </template>
                </v-autocomplete>
                <v-btn
                  v-show="index > 0"
                  color="error"
                  fab dark x-small
                  @click="removeItem(index)"
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
                  @click="addItem()"
                >
                  <v-icon
                    color="darken-2"
                  >
                    fas fa-plus
                  </v-icon>
                </v-btn>
              </div>

            </v-col>
          </v-row>
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
import moment from "moment";
import Lead from "@/models/marketing/leads";

export default {
  name: "ModalSettingAssignSale",
  data() {
    return {
      equal: true,
      pool: false,
      hours: [],
      modalName: 'modal-setting-assign-sale',
      title: 'Cấu hình chia data số',
      settingSales: [
        {
          time: [],
          users: []
        }
      ],
      listSale: [
        {
          id: 1,
          full_name: 'Sale 1'
        },
        {
          id: 2,
          full_name: 'Sale 2'
        }
      ],
      rules: {
        time: value => value.length > 0 || 'Thời gian bắt buộc nhập',
        sale: value => value.length > 0 || 'Nhân viên sale bắt buộc nhập',
      }
    }
  },
  methods: {
    get24h() {
      const locale = 'en';
      const hours = [];

      moment.locale(locale);

      for(let hour = 0; hour < 24; hour++) {
        hours.push(moment({ hour }).format('HH:mm'));
        hours.push(
          moment({
            hour,
            minute: 30
          }).format('HH:mm')
        );
      }

      return hours
    },
    removeTime(item, setting) {
      const index = setting.time.indexOf(item)
      if (index >= 0) setting.time.splice(index, 1)
    },

    removeUser(item, setting) {
      const index = setting.users.indexOf(item.id)
      if (index >= 0) setting.users.splice(index, 1)
    },
    addItem() {
      this.settingSales.push({time: [], users: []})
    },

    removeItem(index) {
      this.settingSales.splice(index, 1)
    },
    beforeOpen(event) {
      this.hours = this.get24h()
    },
    beforeClose() {
      this.settingSales = [{time: [], users: []}]
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async submit() {
      if (this.equal) {
        await this.acceptIsEqual()
      } else {
        await this.acceptNotEqual()
      }
    },
    async acceptIsEqual() {
      let setting_marketing_user_assign = {
        assign_by_pool: [],
        assign_by_robin_round: this.settingSales
      }

      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()

          await new Lead().settingMarketingUserAssign({user_assign_settings: setting_marketing_user_assign})
          this.closeModal()
          this.messageSuccess('Bạn đã Cấu hình chia số thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
    },
    async acceptNotEqual() {
      try {
        this.loadingStart()

        this.closeModal()
        this.messageSuccess('Bạn đã Cấu hình chia số thành công')
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    }
  },
  mounted() {
  },
}
</script>

<style scoped>

</style>