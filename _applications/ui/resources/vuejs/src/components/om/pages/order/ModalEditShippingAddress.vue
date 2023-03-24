<template>
  <transition name="overlay" mode="out-in">
    <modal
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
            <v-col cols="6" class="py-0">
              <label>Số điện thoại</label>
              <v-text-field
                v-model="customerAddress.mobile"
                :rules="[rules.phone]"
                dense
                outlined
                @keypress="handleInputNumber"
                placeholder="Số điện thoại"
              ></v-text-field>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Thành phố/Tỉnh</label>
                <v-select
                  v-model="customerAddress.province_id"
                  :items="provinces"
                  item-text="province_name"
                  item-value="id"
                  placeholder="Thành phố/Tỉnh"
                  dense
                  outlined
                  @change="selectProvince(customerAddress.province_id)"
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Địa chỉ chi tiết</label>
                <v-text-field
                  v-model="customerAddress.address"
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
                <label class="om-wp-label-modal">Quận/Huyện</label>
                <v-select
                  v-model="customerAddress.district_id"
                  :items="districts"
                  :disabled="disableDistrict"
                  item-text="district_name"
                  item-value="id"
                  placeholder="Quận/Huyện"
                  dense
                  outlined
                  @change="customerAddress.selectDistrict(customerAddress.district_id)"
                >
                </v-select>
              </div>
            </v-col>

            <v-col cols="6" class="py-0">
              <div>
                <label class="om-wp-label-modal">Phường/Xã</label>
                <v-select
                  v-model="customerAddress.ward_id"
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
import Districts from "@/models/master/districts/districts";
import Provinces from "@/models/master/provinces/provinces";
import Wards from "@/models/master/wards/wards";
import {mapGetters} from "vuex";
import CustomerAddress from "@/models/customer/customer_address";

export default {
  name: 'ModalEditShippingAddress',
  data() {
    return {
      modalName: 'modal-edit-shipping-address',
      title: 'Cập nhật địa chỉ',
      customerAddress: new CustomerAddress(),
      districts: new Collection(Districts),
      disableDistrict: true,
      disableWard: true,
      provinces: new Collection(Provinces),
      wards: new Collection(Wards),
      rules: {
        phone: value => !!value || 'SĐT bắt buộc nhập.',
        address: value => !!value || 'Địa chỉ giao hàng bắt buộc nhập.',
        district: value => !!value || 'Quận/Huyện bắt buộc nhập.',
        ward: value => !!value || 'Phường/Xã hàng bắt buộc nhập.',
        province: value => !!value || 'Tỉnh/Thành bắt buộc nhập.',
      },
    }
  },
  methods: {
    async selectProvince() {
      this.districts = new Collection(Districts)
      this.customerAddress.district_id = null
      this.disableDistrict = false
      this.disableWard = true
      this.wards = new Collection(Wards)

      if (this.customerAddress.province_id) {
        await new Districts().districts({province_id: this.customerAddress.province_id}).then((result) => {
          this.districts.push(...result)
        })
      }
    },
    async selectDistrict() {
      this.wards = new Collection(Wards)
      this.customerAddress.ward_id = null
      this.disableWard = false

      if (this.customerAddress.district_id) {
        await new Wards().wards({district_id: this.customerAddress.district_id}).then((result) => {
          this.wards.push(...result)
        })
      }
    },
    async beforeOpen(event) {
      this.customerAddress = _.cloneDeep(event.params.address)

      if (this.customerAddress.province_id) {
        await new Districts().districts({province_id: this.customerAddress.province_id}).then((result) => {
          this.disableDistrict = false
          this.districts.push(...result)
        })
      } else {
        this.disableDistrict = true
      }

      if (this.customerAddress.district_id) {
        await new Wards().wards({district_id: this.customerAddress.district_id}).then((result) => {
          this.disableWard = false
          this.wards.push(...result)
        })
      } else {
        this.disableWard = true
      }
    },
    beforeClose() {
      this.disableWard = true
      this.disableDistrict = true
      this.districts = new Collection(Districts)
      this.wards = new Collection(Wards)
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    async save() {
      if (this.$refs.form.validate()) {
        try {
          this.loadingStart()
          // await this.customerAddress.updateAsync()
          this.$emit('update', this.customerAddress)

          this.$refs.form.reset()
          this.closeModal()
          this.messageSuccess('Cập nhật địa chỉ thành công')
        } catch (e) {
          this.handleException(e)
        } finally {
          this.loadingClose()
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
      this.provinceState.then((result) => {
        this.provinces.push(...result)
      })
    }
  },
  computed: {
    ...mapGetters({
      provinceState: 'order/provinces',
    }),
  },
  mounted() {

  },
  async created() {
    await this.loadConfig()
  }

}
</script>