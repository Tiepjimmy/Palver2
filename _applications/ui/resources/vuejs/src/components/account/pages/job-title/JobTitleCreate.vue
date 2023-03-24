<template>
  <b-modal
    title="Thêm chức danh"
    size="xl"
    name="addChucDanh"
    id="addChucDanh"
    @hide="clearModal"
  >
    <div class="row my-1">
      <div class="col-12 col-sm-2"></div>
      <div class="col-12 col-sm-9">
        <div class="form-group">
          <label class="form-label">Cơ cấu tổ chức</label>
          <treeselect
            :normalizer="normalizer"
            v-if="optionToChuc"
            :multiple="true"
            :options="optionToChuc"
            :flat="true"
            :default-expand-level="2"
            placeholder="Chọn cơ cấu tổ chức"
            v-model="listSelectedToChuc"
          />
          <p class="text-danger" v-show="errorCoCauToChuc">{{ errorCoCauToChuc }}</p>
        </div>
      </div>
      <div class="col-12 col-sm-1"></div>
    </div>
    <div class="row my-1">
      <div class="col-12 col-sm-2"></div>
      <div class="col-12 col-sm-4">
        <div class="form-group">
          <label class="form-label">Tên chức danh</label>
        </div>
      </div>
      <div class="col-12 col-sm-1"></div>
      <div class="col-12 col-sm-4">
        <div class="form-group">
          <label class="form-label">Nhóm chức danh</label>
        </div>
      </div>
      <div class="col-12 col-sm-1 pt-2">
        <span class="svg-icon svg-icon-success svg-icon-5hx them_chuc_danh" @click="addJobTitle">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
          <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="black"/>
          <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="black"/>
          </svg>
        </span>
      </div>
    </div>
    <div class="chuc_danh_container">
      <div class="row my-1"
           v-for="(chucDanh, index) in listChucDanh"
      >
        <div class="col-12 col-sm-2"></div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <input
              type="text" class="form-control" placeholder="Nhập tên chức danh" v-model="chucDanh.ten_chuc_danh">
            <p v-if="validateErrors" class="text-danger" v-show="validateErrors[index].ten_chuc_danh">{{ validateErrors[index].ten_chuc_danh }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-1"></div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <select
              v-model="chucDanh.nhom_chuc_danh"
              class="form-control">
              <option value="">Chọn nhóm chức danh</option>
              <option value="manager">Quản lý</option>
              <option value="staff">Nhân viên</option>
              <option value="other">Khác</option>
            </select>
            <p v-if="validateErrors" class="text-danger" v-show="validateErrors[index].nhom_chuc_danh">{{ validateErrors[index].nhom_chuc_danh }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-1 pt-6">
          <span class="svg-icon svg-icon-muted svg-icon-5hx xoa_chuc_danh" @click="deleteJobTitle(index)">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
              <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="black"/>
              <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="black"/>
            </svg>
          </span>
        </div>
      </div>
    </div>
    
    <div slot="modal-footer">
      <button type="button"
              class="btn btn-outline-secondary"
              @click="$bvModal.hide('addChucDanh')"
              data-dismiss="modal"
      >
        Hủy bỏ
      </button>
      
      <button type="submit" class="btn btn-outline-primary" @click="storeJobTitle">
        <span v-if="loadingStoreChucDanh" class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
        Tạo mới
      </button>
    </div>
  </b-modal>
</template>

<style>
.them_chuc_danh,
.xoa_chuc_danh {
  cursor: pointer;
}
.form-group {
  margin-bottom: 0.3rem;
}
.modal-backdrop {
  background-color: rgba(1,1,1,0.1) !important;
}
.modal {
  left: 130px;
}
</style>

<script>
import Swal from "sweetalert2";
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import JobTitle from "@/models/job-title/job-title";

export default {
  props: [
    'createToChuc',
  ],
  data() {
    return {
      listSelectedToChuc: [],
      listChucDanh: [
        {
          ten_chuc_danh: '',
          nhom_chuc_danh: '',
        }
      ],
      validateErrors: [
        {
          ten_chuc_danh: '',
          nhom_chuc_danh: '',
        }
      ],
      loadingStoreChucDanh: false,
      errorCoCauToChuc: '',
      optionToChuc: null
    }
  },
  watch: {
    createToChuc() {
      this.optionToChuc = this.generateOption(this.createToChuc);
    }
  },
  computed: {
    //
  },
  components: {
    Treeselect
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
    addJobTitle() {
      this.listChucDanh.push({
        ten_chuc_danh: '',
        nhom_chuc_danh: ''
      });
      this.validateErrors.push({
        ten_chuc_danh: '',
        nhom_chuc_danh: ''
      });
    },
    deleteJobTitle(index) {
      this.listChucDanh.splice(index, 1);
      this.validateErrors.splice(index, 1);
    },
    storeJobTitle() {
      this.validateErrors.forEach(validateError => {
        validateError.ten_chuc_danh = '';
        validateError.nhom_chuc_danh = '';
      });
      this.errorCoCauToChuc = '';
      this.loadingStoreChucDanh = true;
      let arrayPromise = [];
      if (this.listSelectedToChuc.length > 0) {
        this.listSelectedToChuc.forEach(selectedToChuc => {
          this.listChucDanh.forEach(chucDanh => {
            let promise = new Promise((resolve, reject) => {
              let jobTitle = new JobTitle();
              let storeData = {
                store_id: selectedToChuc,
                active_status: "active",
                job_title_name: chucDanh.ten_chuc_danh,
                job_title_type: chucDanh.nhom_chuc_danh,
              };
              jobTitle.storeJobTitle(storeData)
                .then(response => {
                  resolve(response);
                })
                .catch(error => {
                  reject(error);
                })
            });
            arrayPromise.push(promise);
          });
        });
        Promise.all(arrayPromise).then((arrResponse) => {
          this.loadingStoreChucDanh = false;
          let checkError = false;
          let checkSystemError = false;
          arrResponse.forEach((response, index) => {
            if (response.success) {
              this.listChucDanh.splice(index, 1);
              this.validateErrors.splice(index, 1);
            } else if (!response.success && response.errors.code == "E000003") {
              if (response.data.job_title_name) {
                this.validateErrors[index].ten_chuc_danh = response.data.job_title_name[0];
              } else {
                this.validateErrors[index].ten_chuc_danh = '';
              }
              if (response.data.job_title_type) {
                this.validateErrors[index].nhom_chuc_danh = response.data.job_title_type[0];
              } else {
                this.validateErrors[index].nhom_chuc_danh = '';
              }
              checkError = true;
            } else {
              checkError = true;
              checkSystemError = true;
            }
          });
          if (!checkError) {
            this.listSelectedToChuc =  [];
            this.listChucDanh = [
              {
                ten_chuc_danh: '',
                nhom_chuc_danh: '',
              }
            ];
            this.validateErrors = [
              {
                ten_chuc_danh: '',
                nhom_chuc_danh: '',
              }
            ];
            this.$emit('chucDanhAdded');
            Swal.fire(
              'Thành công!',
              'Đã thêm mới chức danh thành công',
              'success'
            )
          } else {
            if (checkSystemError) {
              this.$emit('chucDanhAddedFail');
              Swal.fire(
                'Không thành công!',
                'Đã xảy ra lỗi, vui lòng liên hệ admin',
                'error'
              )
            }
          }
        });
      } else {
        this.errorCoCauToChuc = "Vui lòng chọn cơ cấu tổ chức";
        this.loadingStoreChucDanh = false;
      }
    },
    clearModal() {
      this.validateErrors.forEach(validateError => {
        validateError.ten_chuc_danh = '';
        validateError.nhom_chuc_danh = '';
      });
    }
  }
};
</script>
