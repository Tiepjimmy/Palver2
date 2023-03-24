<template>
  <transition name="overlay" mode="out-in">
    <modal
      transition="pop-out"
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
            <v-col cols="12" class="py-0">
              <v-row>
                <v-col cols="6">
                  <label class="om-wp-label-modal">Trạng thái</label>
                  <v-text-field
                    value="Hoạt động"
                    dense
                    outlined
                    disabled
                    background-color="#ededed"
                  >
                  </v-text-field>
                </v-col>
              </v-row>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Tên chiến dịch</label>
                <v-text-field
                  v-model="campaign.title"
                  :rules="[rules.title]"
                  dense
                  outlined
                  maxlength="250"
                  placeholder="Nhập tên chiến dịch"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">MKT phụ trách</label>
                <v-autocomplete
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="campaign.assigned_user_id"
                  :items="listUser"
                  item-text="full_name"
                  item-value="id"
                  :rules="[rules.userAssign]"
                  placeholder="Chọn MKT"
                  dense
                  outlined
                >
                </v-autocomplete>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">ID Quảng cáo</label>
                <v-text-field
                  v-model="campaign.advertisement_id"
                  :rules="advertisement"
                  dense
                  outlined
                  placeholder="Nhập ID quảng cáo"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Tài khoản</label>
                <v-autocomplete
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="campaign.payment_account_ids"
                  :items="listPaymentAccount"
                  item-text="card_owner"
                  item-value="id"
                  :rules="[rules.account]"
                  placeholder="Chọn tài khoản"
                  dense
                  small-chips
                  outlined
                  multiple
                >
                  <template v-slot:item="{ item }">
                    {{ item.card_owner }} - {{ getNameCard(item.card_type) }}
                  </template>

                  <template v-slot:selection="data">
                    <v-chip
                      v-bind="data.attrs"
                      :input-value="data.selected"
                      close
                      @click="data.select"
                      @click:close="removePaymentAccount(data.item)"
                    >
                      {{ data.item.card_owner }} - {{ getNameCard(data.item.card_type) }}
                    </v-chip>
                  </template>
                </v-autocomplete>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Ngày bắt đầu</label>
                <datetime-picker-palee
                  v-model="campaign.start_at"
                  :placeholder="'Chọn ngày bắt đầu'"
                  :rules="[rules.timeStart]"
                />

              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Ngày kết thúc</label>
                <datetime-picker-palee
                  v-model="campaign.end_at"
                  :placeholder="'Chọn ngày kết thúc'"
                  :rules="[rules.timeEnd]"
                />

              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Kênh</label>
                <v-autocomplete
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="campaign.channel_id"
                  :items="listChannel"
                  item-text="name"
                  item-value="id"
                  :rules="[rules.channel]"
                  placeholder="Chọn kênh"
                  dense
                  outlined
                  @change="getSubChannelOption()"
                >
                </v-autocomplete>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Kinh phí dự trù</label>
                <v-input-currency
                  v-model="campaign.estimated_amount"
                  placeholder="Nhập kinh phí"
                />
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Sub kênh</label>
                <v-select
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="campaign.sub_channel_id"
                  :items="optionSubChannel"
                  item-text="name"
                  item-value="id"
                  :rules="[rules.subChannel]"
                  placeholder="Chọn sub kênh"
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Data dự trù</label>
                <v-text-field
                  v-model="campaign.estimated_data"
                  dense
                  outlined
                  placeholder="Nhập số lượng data"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Loại sản phẩm</label>
                <v-autocomplete
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="campaign.product_catalog_id"
                  :items="productCatalog"
                  item-text="product_catalog_name"
                  item-value="id"
                  :rules="[rules.bundle]"
                  placeholder="Chọn sản phẩm"
                  dense
                  outlined
                >
                </v-autocomplete>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Doanh thu dự trù</label>
                <v-input-currency
                  v-model="campaign.estimated_revenue"
                  placeholder="Nhập doanh thu dự trù"
                />
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
import Collection from "@/core/collection";
import DatetimePickerPalee from "@/components/om/widgets/DateTimePicker";
import Campaign from "@/models/marketing/campaign";
import {mapGetters} from "vuex";
import SubChannel from "@/models/marketing/sub_channel";
import Channel from "@/models/marketing/channel";
import PaymentAccount from "@/models/marketing/payment_account";
import VInputCurrency from "@/components/om/widgets/VInputCurrency";

export default {
  name: "ModalCreateCampaign",
  components: {
    DatetimePickerPalee,
    VInputCurrency
  },
  data() {
    return {
      modalName: 'modal-create-campaign',
      title: 'Thêm mới chiến dịch',
      campaign: new Campaign(),
      listBank: new Collection(Object),
      listChannel: new Collection(Channel),
      listSubChannel: new Collection(SubChannel),
      optionSubChannel: new Collection(SubChannel),
      productCatalog: new Collection(Object),
      listPaymentAccount: new Collection(PaymentAccount),
      listUser: new Collection(Object),
      cardTypes: [],
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
      users: [
        {
          id: 1,
          name: 'Palee'
        },
        {
          id: 2,
          name: 'Tester'
        }
      ],
      rules: {
        title: value => !!value || 'Tên chiến dich bắt buộc nhập.',
        userAssign: value => !!value || 'MKT phụ trách bắt buộc nhập.',
        account: value => value.length > 0 || 'Tài khoản bắt buộc nhập.',
        timeStart: value => !!value || 'Ngày bắt đầu bắt buộc nhập.',
        timeEnd: value => !!value || 'Ngày kết thúc bắt buộc nhập.',
        channel: value => !!value || 'Kênh bắt buộc nhập.',
        subChannel: value => !!value || 'Sub kênh bắt buộc nhập.',
        bundle: value => !!value || 'Loại sản phẩm khoản bắt buộc nhập.'
      },
      advertisement: [
        (value) => !!value || "ID Quảng cáo bắt buộc nhập.",
        (value) => this.isURL(value) || "ID quảng cáo không hợp lệ",
      ],
    }
  },
  methods: {
    isURL(str) {
      let url;

      try {
        url = new URL(str);
      } catch (_) {
        return false;
      }

      return url.protocol === "http:" || url.protocol === "https:";
    },
    removePaymentAccount(item) {
      const index = this.campaign.payment_account_ids.indexOf(item.id)
      if (index >= 0) this.campaign.payment_account_ids.splice(index, 1)
    },
    getNameCard(type) {
      let card = this.cardTypes.find(i => i.value == type)

      if (card) {
        return card.label
      }
    },
    getSubChannelOption() {
      this.campaign.sub_channel_id = null
      this.optionSubChannel = this.listSubChannel.filter((i) => {
        return i.channel_id == this.campaign.channel_id
      })
    },
    beforeOpen(event) {
      this.cardTypes = _.cloneDeep(event.params.cardTypes)
      this.campaign.is_active = 1
      this.campaign.start_at = new Date()
      this.campaign.end_at = new Date()
      this.listBank = _.cloneDeep(event.params.listBank)
    },
    beforeClose() {
      this.optionSubChannel = new Collection(SubChannel)
      this.campaign.reset()
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async save() {
      this.campaign.created_by = this.user.id
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()
          await this.campaign.storeAsync()
          this.$emit('store')

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã thêm mới chiến dịch thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
    },
    async loadConfig() {
      this.marketingConfig.then((result) => {
        this.listChannel.push(...result.channels)
        this.listSubChannel.push(...result.subChannels)
        this.listPaymentAccount.push(...result.paymentAccounts)
        this.listUser.push(...result.listUser)
        this.productCatalog.push(...result.productCatalog)
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