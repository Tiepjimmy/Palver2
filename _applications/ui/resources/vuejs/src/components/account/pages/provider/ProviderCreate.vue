<template>
  <b-modal
    title="Thêm nhà cung cấp"
    size="xl"
    name="addNhaCungCap"
    id="addNhaCungCap"
    @hide="clearModal"
  >
    <div class="px-5">
      <div v-if="loadingCreateInfo" class="row my-10">
        <div class="col-12 text-center">
          <span class="spinner spinner-primary"></span>
        </div>
      </div>
      
      <div v-if="!loadingCreateInfo && nhaCungCap" class="row my-5">
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label required">Tên nhà cung cấp<span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="nhaCungCap.provider_name"/>
            <p class="text-danger" v-if="validateError" v-show="validateError.provider_name">{{ validateError.provider_name }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label">Mã nhà cung cấp</label>
            <input type="text" class="form-control" v-model="nhaCungCap.provider_cd"/>
            <p class="text-danger" v-if="validateError" v-show="validateError.provider_cd">{{ validateError.provider_cd }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label">Mã số thuế</label>
            <input type="text" class="form-control" v-model="nhaCungCap.tax_cd"/>
          </div>
        </div>
        <div class="col-12 col-sm-12">
          <div class="form-group">
            <label class="form-label required">Nhóm nhà cung cấp<span class="text-danger">*</span></label>
            <label v-b-modal.addNhomNhaCungCap class="form-label required float-right text-success">Thêm nhóm nhà cung cấp</label>
            <treeselect
              :normalizer="normalizer"
              :multiple="true"
              :options="optionsNhomNhaCungCap"
              :flat="true"
              placeholder="Chọn nhóm nhà cung cấp"
              v-model="nhaCungCap.provider_group_id"
            />
            <p class="text-danger" v-if="validateError" v-show="validateError.provider_group_id">{{ validateError.provider_group_id }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label">Mô tả</label>
            <input type="text" class="form-control" v-model="nhaCungCap.description"/>
          </div>
        </div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label required">Số điện thoại<span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="nhaCungCap.phone"/>
            <p class="text-danger" v-if="validateError" v-show="validateError.phone">{{ validateError.phone }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label required">Email<span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="nhaCungCap.email"/>
            <p class="text-danger" v-if="validateError" v-show="validateError.email">{{ validateError.email }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-12">
          <div class="form-group">
            <label class="form-label required">Tổ chức nhận hàng<span class="text-danger">*</span></label>
            <treeselect
              :normalizer="normalizer"
              :multiple="true"
              :options="optionsToChuc"
              :flat="true"
              :default-expand-level="2"
              placeholder="Chọn cơ cấu tổ chức"
              v-model="nhaCungCap.store_id"
            />
            <p class="text-danger" v-if="validateError" v-show="validateError.store_id">{{ validateError.store_id }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label required">Địa chỉ chi tiết<span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="nhaCungCap.address"/>
            <p class="text-danger" v-show="validateError.address">{{ validateError.address }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label required">Tỉnh/Thành phố<span class="text-danger">*</span></label>
            <treeselect
              :options="optionsTinhThanhPho"
              placeholder="Chọn tỉnh/thành phố"
              v-model="nhaCungCap.province_id"
              @select="changeProvince"
            />
            <p class="text-danger" v-if="validateError" v-show="validateError.province_id">{{ validateError.province_id }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label required">Quận/Huyện<span class="text-danger">*</span></label>
            <treeselect
              :options="optionsQuanHuyen"
              placeholder="Chọn quận/huyện"
              v-model="nhaCungCap.district_id"
              @select="changeDistrict"
            />
            <p class="text-danger" v-show="validateError.district_id">{{ validateError.district_id }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label required">Phường/Xã<span class="text-danger">*</span></label>
            <treeselect
              :options="optionsPhuongXa"
              placeholder="Chọn phường/xã"
              v-model="nhaCungCap.ward_id"
            />
            <p class="text-danger" v-show="validateError.ward_id">{{ validateError.ward_id }}</p>
          </div>
        </div>
      </div>
    </div>
  
    <div class="popup-container">
      <provider-group-create
        :listToChuc="listToChuc"
        @nhomNhaCungCapAdded="providerGroupAdded"
      />
    </div>
    
    <div slot="modal-footer">
      <button type="button"
              class="btn btn-outline-secondary"
              @click="$bvModal.hide('addNhaCungCap')"
              data-dismiss="modal"
      >
        Hủy bỏ
      </button>
      
      <button type="submit" class="btn btn-outline-primary" @click="storeProvider">
        <span v-if="loadingStoreNhaCungCap" class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
        Tạo mới
      </button>
    </div>
  </b-modal>
</template>

<style>
.form-group {
  margin-bottom: 0.3rem;
}
.modal-backdrop {
  background-color: rgba(1,1,1,0.1) !important;
}
</style>

<script>
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import Swal from "sweetalert2";
import Provider from "@/models/provider/provider";
import ProviderGroupCreate from "@/components/account/pages/provider-group/ProviderGroupCreate";

export default {
  props: [
  
  ],
  data() {
    return {
      listNhomNhaCungCap: [],
      listToChuc: [],
      listTinhThanhPho: [],
      listQuanHuyen: [],
      listPhuongXa: [],
      nhaCungCap: {
        store_id: [],
        provider_group_id: [],
        province_id: null,
        district_id: null,
        ward_id: null,
        provider_cd: '',
        provider_name: '',
        email: '',
        phone: '',
        tax_cd: '',
        description: '',
        address: '',
        active_status: 'active',
      },
      validateError: {
        store_id: '',
        provider_group_id: '',
        province_id: '',
        district_id: '',
        ward_id: '',
        provider_cd: '',
        provider_name: '',
        email: '',
        phone: '',
        tax_cd: '',
        description: '',
        address: '',
        active_status: ''
      },
      loadingCreateInfo: false,
      loadingStoreNhaCungCap: false
    }
  },
  computed: {
    optionsToChuc: function () {
      return this.generateOption(this.listToChuc);
    },
    optionsNhomNhaCungCap: function () {
      return this.listNhomNhaCungCap.map(nhomNhaCungCap => {
        return {
          id: nhomNhaCungCap.id,
          label: nhomNhaCungCap.group_name
        }
      });
    },
    optionsTinhThanhPho: function () {
      return this.listTinhThanhPho.map(tinhThanhPho => {
        return {
          id: tinhThanhPho.id,
          label: tinhThanhPho.province_name
        }
      });
    },
    optionsQuanHuyen: function () {
      return this.listQuanHuyen.map(quanHuyen => {
        return {
          id: quanHuyen.id,
          label: quanHuyen.district_name
        }
      });
    },
    optionsPhuongXa: function () {
      return this.listPhuongXa.map(phuongXa => {
        return {
          id: phuongXa.id,
          label: phuongXa.ward_name
        }
      });
    },
  },
  components: {
    Treeselect,
    ProviderGroupCreate
  },
  beforeCreate() {
    let provider = new Provider();
    let promiseCreateInfo = new Promise((resolve, reject) => {
      provider.getCreateInfo()
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        })
    });
    let promiseListProvince = new Promise((resolve, reject) => {
      provider.getListProvince()
        .then(response => {
          resolve(response);
        })
        .catch(error => {
          reject(error);
        })
    });
    Promise.all([promiseCreateInfo, promiseListProvince]).then((arrResponse) => {
      let responseCreateInfo = arrResponse[0];
      let responseListProvince = arrResponse[1];
      this.listNhomNhaCungCap = responseCreateInfo.data.list_provider_group;
      this.listToChuc = responseCreateInfo.data.list_store;
      this.listTinhThanhPho = responseListProvince.data;
      this.loadingCreateInfo = false;
    });
  },
  methods: {
    normalizer(node){
      if(node.children==null || node.children=='null'){
        delete node.children;
      }
    },
    generateOption(treeListToChuc, idTrucThuoc = null) {
      let branch = [];
      treeListToChuc.forEach(toChuc => {
        if (toChuc.parent_id == idTrucThuoc) {
          branch.push({
            id: toChuc.id,
            label: toChuc.store_name,
            children: this.generateOption(treeListToChuc, toChuc.id)
          });
        }
      })
      return branch.length ? branch : null;
    },
    storeProvider() {
      this.loadingStoreNhaCungCap = true;
      this.validateError = {
        store_id: '',
        provider_group_id: '',
        province_id: '',
        district_id: '',
        ward_id: '',
        provider_cd: '',
        provider_name: '',
        email: '',
        phone: '',
        tax_cd: '',
        description: '',
        address: '',
        active_status: ''
      };
      let provider = new Provider();
      provider.store(this.nhaCungCap)
        .then(response => {
          this.loadingStoreNhaCungCap = false;
          if (response.success) {
            this.nhaCungCap = {
              store_id: [],
              provider_group_id: [],
              province_id: null,
              district_id: null,
              ward_id: null,
              provider_cd: '',
              provider_name: '',
              email: '',
              phone: '',
              tax_cd: '',
              description: '',
              address: '',
              active_status: 'active',
            };
            this.$emit('nhaCungCapAdded');
            Swal.fire(
              'Thành công!',
              'Đã thêm mới nhà cung cấp thành công',
              'success'
            )
          }
        })
        .catch(error => {
          this.loadingStoreNhaCungCap = false;
          let response = error.response.data;
          if (response.errors.code == "E000003") {
            let validateErrors = response.data;
            for (let [key, value] of Object.entries(validateErrors)) {
              this.validateError[key] = value[0];
            }
            Swal.fire(
              'Không thành công!',
              'Đã xảy ra lỗi, vui lòng kiểm tra lại',
              'error'
            );
          } else {
            this.$emit('nhaCungCapAddedFail');
            Swal.fire(
              'Không thành công!',
              'Đã xảy ra lỗi, vui lòng liên hệ admin',
              'error'
            )
          }
        })
    },
    clearModal() {
      this.validateError = {
        store_id: '',
        provider_group_id: '',
        province_id: '',
        district_id: '',
        ward_id: '',
        provider_cd: '',
        provider_name: '',
        email: '',
        phone: '',
        tax_cd: '',
        description: '',
        address: '',
        active_status: ''
      };
    },
    changeProvince(selected) {
      this.listQuanHuyen = [];
      this.nhaCungCap.district_id = null;
      this.listPhuongXa = [];
      this.nhaCungCap.ward_id = null;
      let idTinhThanhPho = selected.id;
      let provider = new Provider();
      provider.getListDistrict(idTinhThanhPho)
        .then(response => {
          this.listQuanHuyen = response.data;
        })
        .catch(error => {
          console.log(error);
        })
    },
    changeDistrict(selected) {
      this.listPhuongXa = [];
      this.nhaCungCap.ward_id = null;
      let idQuanHuyen = selected.id;
      let provider = new Provider();
      provider.getListWard(idQuanHuyen)
        .then(response => {
          this.listPhuongXa = response.data;
        })
        .catch(error => {
          console.log(error);
        })
    },
    providerGroupAdded(providerGroup) {
      this.listNhomNhaCungCap.push(providerGroup);
    }
  }
};
</script>
