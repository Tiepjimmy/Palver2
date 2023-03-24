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
              <div>
                <label class="om-wp-label-modal">Nguồn khách hàng</label>
                <v-select
                  no-data-text="không tìm thấy dữ liệu"
                  class="flex-basis"
                  v-model="customer.sub_channel_id"
                  :items="listSubChannel"
                  item-text="name"
                  item-value="id"
                  :rules="[rules.subChannel]"
                  placeholder="Chọn kênh-sub kênh"
                  dense
                  outlined
                >
                  <template v-slot:item="{ item }">
                    <div>{{ item.name }}</div>
                  </template>
                </v-select>
              </div>
            </v-col>

            <v-col cols="12" class="py-0">
              <div>
                <label class="om-wp-label-modal">Họ và tên khách hàng</label>
                <v-text-field
                  v-model="customer.name"
                  :rules="[rules.name]"
                  dense
                  outlined
                  placeholder="Họ tên khách hàng"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">SĐT chính</label>
                <v-text-field
                  v-model="customer.mobile"
                  :rules="[rules.mobile]"
                  @keypress="handleInputNumber"
                  dense
                  outlined
                  maxlength="14"
                  placeholder="SĐT chính"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">SĐT phụ</label>
                <v-text-field
                  v-model="customer.extra_mobile"
                  @keypress="handleInputNumber"
                  dense
                  outlined
                  maxlength="14"
                  placeholder="SĐT phụ"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Email</label>
                <v-text-field
                  v-model="customer.email"
                  :rules="customer.email ? [rules.email] : []"
                  dense
                  outlined
                  placeholder="Email"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Ngày sinh</label>
                <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  :return-value.sync="customer.birth_date"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="customer.birth_date"
                      placeholder="Ngày sinh"
                      readonly
                      dense
                      outlined
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="customer.birth_date"
                    no-title
                    scrollable
                    locale="vi"
                  >
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="menu = false"
                    >
                      Hủy
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.menu.save(customer.birth_date)"
                    >
                      Chọn
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Giới tính</label>
                <v-select
                  v-model="customer.gender"
                  :items="genders"
                  item-text="label"
                  item-value="value"
                  placeholder="Chọn giới tính"
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Nhóm khách hàng</label>
                <v-select
                  v-model="customer.customer_group_id"
                  :items="customerGroups"
                  item-text="name"
                  item-value="id"
                  placeholder="Nhóm khách hàng"
                  dense
                  outlined
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Địa chỉ chi tiết</label>
                <v-text-field
                  v-model="customer.address"
                  :rules="[rules.address]"
                  dense
                  outlined
                  placeholder="Địa chỉ chi tiết"
                >
                </v-text-field>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Thành phố/Tỉnh</label>
                <v-select
                  v-model="customer.province_id"
                  :items="provinces"
                  item-text="province_name"
                  item-value="id"
                  placeholder="Thành phố/Tỉnh"
                  dense
                  outlined
                  @change="selectProvince(customer.province_id)"
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Quận/Huyện</label>
                <v-select
                  v-model="customer.district_id"
                  :items="districts"
                  :disabled="disableDistrict"
                  item-text="district_name"
                  item-value="id"
                  placeholder="Quận/Huyện"
                  dense
                  outlined
                  @change="selectDistrict(customer.district_id)"
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Phường/Xã</label>
                <v-select
                  v-model="customer.ward_id"
                  :items="wards"
                  :disabled="disableWard"
                  item-text="ward_name"
                  item-value="id"
                  placeholder="Phường Xã"
                  dense
                  outlined
                >
                </v-select>
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
import {mapGetters} from "vuex";
import SubChannel from "@/models/marketing/sub_channel";
import Customer from "@/models/customer/customer";
import User from "@/models/user/user";
import Districts from "@/models/master/districts/districts";
import Provinces from "@/models/master/provinces/provinces";
import Wards from "@/models/master/wards/wards";

export default {
  name: "ModaEditCustomer",
  data() {
    return {
      menu: false,
      districts: new Collection(Districts),
      disableDistrict: true,
      disableWard: true,
      provinces: new Collection(Provinces),
      wards: new Collection(Wards),
      modalName: 'modal-edit-customer',
      title: 'Cập nhật khách hàng',
      customer: new Customer(),
      listSubChannel: new Collection(SubChannel),
      listUser: new Collection(User),
      customerGroups: [
        {id: 1, name: 'Nhóm bản lẻ'},
        {id: 2, name: 'Nhóm bán buôn'}
      ],
      genders: [
        {value: 1, label: 'Nam'},
        {value: 2, label: 'Nữ'},
        {value: 0, label: 'Chưa xác định'}
      ],
      rules: {
        name: value => !!value || 'Tên khách hàng bắt buộc nhập.',
        mobile: value => !!value || 'SĐT chính bắt buộc nhập.',
        subChannel: value => !!value || 'Nguồn khách hàng bắt buộc nhập.',
        address: value => !!value || 'Địa chỉ chi tiết bắt buộc nhập.',
        email: value => {
          if (value.length >= 1) {
            const pattern = /.+@.+\..+/
            return pattern.test(value) || 'Emai không hợp lệ.';
          }
        }
      },
    }
  },
  methods: {
    handleInputNumber(evt) {
      evt = (evt) ? evt : window.event;
      let expect = evt.target.value.toString() + evt.key.toString();

      if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    async selectProvince() {
      this.districts = new Collection(Districts)
      this.wards = new Collection(Wards)
      this.customer.district_id = null
      this.disableDistrict = false
      this.disableWard = true

      if (this.customer.province_id) {
        await new Districts().districts({province_id: this.customer.province_id}).then((result) => {
          this.districts.push(...result)
        })
      }
    },
    async selectDistrict() {
      this.wards = new Collection(Wards)
      this.customer.ward_id = null
      this.disableWard = false

      if (this.customer.district_id) {
        await new Wards().wards({district_id: this.customer.district_id}).then((result) => {
          this.wards.push(...result)
        })
      }
    },
    async beforeOpen(event) {
      this.districts = new Collection(Districts)
      this.wards = new Collection(Wards)
      this.customer = _.cloneDeep(event.params.customer)
      this.customer.updated_by = this.user.id

      if (this.customer.province_id) {
        await new Districts().districts({province_id: this.customer.province_id}).then((result) => {
          this.disableDistrict = false
          this.districts.push(...result)
        })
      } else {
        this.disableDistrict = true
      }

      if (this.customer.district_id) {
        await new Wards().wards({district_id: this.customer.district_id}).then((result) => {
          this.disableWard = false
          this.wards.push(...result)
        })
      } else {
        this.disableWard = true
      }
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()
          await this.customer.updateAsync()
          this.$emit('updateCustomer', this.customer)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Bạn đã cập nhật khách hàng thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
        }
      }
    },
    async loadConfig() {
      this.subChannelState.then((result) => {
        this.listSubChannel.push(...result)
      })

      this.provinceState.then((result) => {
        this.provinces.push(...result)
      })

      this.userState.then((result) => {
        this.listUser.push(...result.items)
      })
    }
  },
  computed: {
    ...mapGetters({
      subChannelState: 'marketing/subChannels',
      userState: 'marketing/userRoleMarketing',
      provinceState: 'order/provinces',
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