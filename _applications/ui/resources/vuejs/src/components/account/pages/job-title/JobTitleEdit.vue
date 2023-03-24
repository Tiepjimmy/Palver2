<template>
  <b-modal
    title="Chỉnh sửa chức danh"
    size="xl"
    name="editToChuc"
    id="editToChuc"
    @hide="clearModal"
  >
    <div>
      <div class="row my-1">
        <div class="col-12 col-sm-2"></div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label">Cơ cấu tổ chức</label>
            <input type="text" class="form-control" v-model="editToChuc.store_name" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-1"></div>
        <div class="col-12 col-sm-4">
        
        </div>
        <div class="col-12 col-sm-1"></div>
      </div>
      <div class="row my-1">
        <div class="col-12 col-sm-2 py-0">
        </div>
        <div class="col-12 col-sm-4 mt-5 py-0">
          <div class="form-group">
            <label class="form-label">Tên chức danh</label>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0"></div>
        <div class="col-12 col-sm-4 mt-5 py-0">
          <div class="form-group">
            <label class="form-label">Nhóm chức danh</label>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0">
        </div>
      </div>
      <div class="row my-1" v-for="(chucDanh, index) in listChucDanh" v-bind:key="chucDanh.id">
        <div class="col-12 col-sm-2 d-flex justify-content-end py-0">
          <label
            class="checkbox checkbox-lg checkbox-lg checkbox-single flex-shrink-0 mr-4"
          >
            <input type="checkbox" v-model="chucDanh.active" :value="chucDanh.active" :id="chucDanh.id"/>
            <span></span>
          </label>
        </div>
        <div class="col-12 col-sm-4 mt-0 py-0">
          <div class="form-group">
            <input type="text" class="form-control" v-model="chucDanh.job_title_name">
            <p class="text-danger" v-show="validateErrors[index].ten_chuc_danh">{{ validateErrors[index].ten_chuc_danh }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0"></div>
        <div class="col-12 col-sm-4 mt-0 py-0">
          <div class="form-group">
            <select
              v-model="chucDanh.job_title_type"
              class="form-control">
              <option value="">Chọn nhóm chức danh</option>
              <option value="manager">Quản lý</option>
              <option value="staff">Nhân viên</option>
              <option value="other">Khác</option>
            </select>
            <p class="text-danger" v-show="validateErrors[index].nhom_chuc_danh">{{ validateErrors[index].nhom_chuc_danh }}</p>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0">
        </div>
      </div>
    </div>
    
    <div slot="modal-footer">
      <button type="button"
              class="btn btn-outline-secondary"
              @click="$bvModal.hide('editToChuc')"
              data-dismiss="modal"
      >
        Hủy bỏ
      </button>
      
      <button type="submit" class="btn btn-outline-primary" @click="updateJobTitle">
        <span v-if="loadingUpdateChucDanh" class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
        Cập nhật
      </button>
    </div>
  </b-modal>
</template>

<style scoped>
.form-group {
  margin-bottom: 0.3rem;
}
</style>

<script>
import Swal from "sweetalert2";
import JobTitle from "@/models/job-title/job-title";

export default {
  props: [
    'editToChuc'
  ],
  
  data() {
    return {
      validateErrors: [
        {
          ten_chuc_danh: '',
          nhom_chuc_danh: '',
        }
      ],
      checked: true,
      loadingUpdateChucDanh: false,
    }
  },
  watch: {
  
  },
  computed: {
    listChucDanh: function () {
      let listChucDanh = [];
      this.editToChuc.job_titles.forEach((chucDanh, index) => {
        this.validateErrors[index] = {
          ten_chuc_danh: '',
          nhom_chuc_danh: '',
        };
        if (chucDanh.active_status == 'active') {
          chucDanh.active = true;
        } else {
          chucDanh.active = false;
        }
        listChucDanh.push(chucDanh);
      });
      return listChucDanh;
    }
  },
  
  methods: {
    updateJobTitle() {
      let checkError = false;
      this.loadingUpdateChucDanh = true;
      let arrayPromise = [];
      this.listChucDanh.forEach((chucDanh, index) => {
        if (!chucDanh.job_title_name) {
          this.validateErrors[index].ten_chuc_danh = 'Vui lòng nhập tên chức danh';
          checkError = true;
        }
        if (!chucDanh.job_title_type) {
          checkError = true;
          this.validateErrors[index].nhom_chuc_danh = 'Vui lòng nhập nhóm chức danh';
        }
        let promise = new Promise((resolve, reject) => {
          let updateData = {
            store_id: this.editToChuc.id,
            active_status: chucDanh.active == true ? "active" : "inactive",
            job_title_name: chucDanh.job_title_name,
            job_title_type: chucDanh.job_title_type,
          };
          let jobTitle = new JobTitle;
          jobTitle.updateJobTitle(chucDanh.id, updateData)
            .then(response => {
              resolve(response);
            })
            .catch(error => {
              reject(error);
            })
        });
        arrayPromise.push(promise);
      });
      
      if (!checkError) {
        Promise.all(arrayPromise).then((arrResponse) => {
          this.loadingUpdateChucDanh = false;
          let checkError = false;
          arrResponse.forEach((response) => {
            if (!response.success) {
              checkError = true;
            }
          });
          if (!checkError) {
            this.$emit('chucDanhUpdated');
            Swal.fire(
              'Thành công!',
              'Đã cập nhật chức danh thành công',
              'success'
            )
          } else {
            this.$emit('chucDanhUpdatedFail');
            Swal.fire(
              'Không thành công!',
              'Đã xảy ra lỗi, vui lòng liên hệ admin',
              'error'
            )
          }
        });
      } else {
        this.loadingUpdateChucDanh = false;
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
