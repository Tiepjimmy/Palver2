<template>
  <b-modal
    title="Thêm nhóm nhà cung cấp"
    size="xl"
    name="addNhomNhaCungCap"
    id="addNhomNhaCungCap"
    @hide="clearModal"
  >
    <div class="px-5">
      <div v-if="nhomNhaCungCap" class="row my-5">
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label required">Tên nhóm nhà cung cấp<span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="nhomNhaCungCap.group_name"/>
            <p class="text-danger" v-if="validateError" v-show="validateError.group_name">{{ validateError.group_name }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Mã nhóm nhà cung cấp<span class="text-danger">*</span></label>
            <input type="text" class="form-control" v-model="nhomNhaCungCap.group_cd"/>
            <p class="text-danger" v-if="validateError" v-show="validateError.group_cd">{{ validateError.group_cd }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label required">Chọn cơ cấu tổ chức<span class="text-danger">*</span></label>
            <treeselect
              :normalizer="normalizer"
              :multiple="false"
              :options="optionsToChuc"
              placeholder="Chọn cơ cấu tổ chức"
              v-model="nhomNhaCungCap.store_id"
            />
            <p class="text-danger" v-if="validateError" v-show="validateError.store_id">{{ validateError.store_id }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Ghi chú</label>
            <input type="text" class="form-control" v-model="nhomNhaCungCap.note"/>
          </div>
        </div>
      </div>
    </div>
    
    <div slot="modal-footer">
      <button type="button"
              class="btn btn-outline-secondary"
              @click="$bvModal.hide('addNhomNhaCungCap')"
              data-dismiss="modal"
      >
        Hủy bỏ
      </button>
      
      <button type="submit" class="btn btn-outline-primary" @click="storeProviderGroup">
        <span v-if="loadingStoreNhomNhaCungCap" class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
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
import ProviderGroup from "@/models/provider-group/provider-group";

export default {
  props: [
    'listToChuc'
  ],
  data() {
    return {
      nhomNhaCungCap: {
        store_id: null,
        group_name: '',
        group_cd: '',
        note: '',
      },
      validateError: {
        store_id: '',
        group_name: '',
        group_cd: '',
        note: '',
      },
      loadingStoreNhomNhaCungCap: false
    }
  },
  computed: {
    optionsToChuc: function () {
      return this.generateOption(this.listToChuc);
    }
  },
  components: {
    Treeselect
  },
  beforeCreate() {
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
    storeProviderGroup() {
      this.loadingStoreNhomNhaCungCap = true;
      this.validateError = {
        store_id: '',
        group_name: '',
        group_cd: '',
        note: '',
      };
      let providerGroup = new ProviderGroup();
      providerGroup.store(this.nhomNhaCungCap)
        .then(response => {
          this.loadingStoreNhomNhaCungCap = false;
          if (response.success) {
            this.nhomNhaCungCap = {
              store_id: null,
              group_name: '',
              group_cd: '',
              note: '',
            };
            this.$emit('nhomNhaCungCapAdded', response.data);
            Swal.fire(
              'Thành công!',
              'Đã thêm mới nhóm nhà cung cấp thành công',
              'success'
            )
            this.$bvModal.hide('addNhomNhaCungCap');
          }
        })
        .catch(error => {
          this.loadingStoreNhomNhaCungCap = false;
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
            this.$emit('nhomNhaCungCapAddedFail');
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
        group_name: '',
        group_cd: '',
        note: '',
      };
    }
  }
};
</script>
