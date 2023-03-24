<template>
  <b-modal
    title="Chi tiết chức danh"
    size="xl"
    name="viewToChuc"
    id="viewToChuc"
  >
    <div>
      <div class="row my-1">
        <div class="col-12 col-sm-2"></div>
        <div class="col-12 col-sm-4">
          <div class="form-group">
            <label class="form-label">Cơ cấu tổ chức</label>
            <input type="text" class="form-control" v-model="viewToChuc.store_name" readonly>
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
        <div class="col-12 col-sm-4 mt-0 py-0">
          <div class="form-group">
            <label class="form-label">Tên chức danh</label>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0"></div>
        <div class="col-12 col-sm-4 mt-0 py-0">
          <div class="form-group">
            <label class="form-label">Nhóm chức danh</label>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0"></div>
      </div>
      
      <div class="row my-1" v-for="chucDanh in viewToChuc.job_titles">
        <div class="col-12 col-sm-2 py-0">
        </div>
        <div class="col-12 col-sm-4 py-0">
          <div class="form-group">
            <input type="text" class="form-control" v-model="chucDanh.job_title_name" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0"></div>
        <div class="col-12 col-sm-4 py-0">
          <div class="form-group">
            <input type="text" class="form-control" :value="convertJobTitleGroup(chucDanh.job_title_type)" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-1 py-0"></div>
      </div>
    </div>
    
    <div slot="modal-footer">
      <button type="button"
              class="btn btn-outline-secondary"
              @click="$bvModal.hide('viewToChuc')"
              data-dismiss="modal"
      >
        <span>Đóng</span>
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

export default {
  props: [
    'viewToChuc',
  ],
  data() {
    return {
    }
  },
  computed: {
  },
  watch: {
  },
  methods: {
    convertJobTitleGroup(nhomChucDanh) {
      if (nhomChucDanh == "manager") {
        return "Nhóm Quản lý";
      } else if (nhomChucDanh == "staff") {
        return "Nhóm Nhân viên";
      } else {
        return "Khác";
      }
    }
  }
};
</script>
