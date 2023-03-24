<template>
  <b-modal
    title="Chi tiết nhà cung cấp"
    size="xl"
    name="viewNhaCungCap"
    id="viewNhaCungCap"
    @hide="clearModal"
  >
    <div v-if="loadingChiTietNhaCungCap" class="row my-5">
      <div class="col-12 text-center">
        <span class="spinner spinner-primary"></span>
      </div>
    </div>
    <div v-if="!loadingChiTietNhaCungCap && nhaCungCap" class="p-5">
      <div class="row d-flex justify-content-between">
        <h3 class="card-title">
          <span class="card-label fw-bolder fs-3 mb-1">
            Nhà cung cấp <span class="text-primary">{{ nhaCungCap.provider_name }}</span>
          </span>
        </h3>
        <div class="btn-group me-3">
          <span :class="{ 'text-success': nhaCungCap.active_status == 'active', 'text-warning': nhaCungCap.active_status == 'inactive' }">{{ nhaCungCap.active_status == 'active' ? 'Đang giao dịch' : 'Ngừng giao dịch' }}</span>
        </div>
      </div>
      <div class="row my-5">
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Nhóm nhà cung cấp</label>
            <input v-for="nhomNhaCungCap in nhaCungCap.provider_groups" type="text" class="form-control mb-5" v-model="nhomNhaCungCap.group_name" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" v-model="nhaCungCap.address" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Mã nhà cung cấp</label>
            <input type="text" class="form-control" v-model="nhaCungCap.provider_cd" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Mã số thuế</label>
            <input type="text" class="form-control" v-model="nhaCungCap.tax_cd" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" v-model="nhaCungCap.phone" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Mô tả</label>
            <input type="text" class="form-control" v-model="nhaCungCap.description" readonly>
          </div>
        </div>
        <div class="col-12 col-sm-6">
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" v-model="nhaCungCap.email" readonly>
          </div>
        </div>
      </div>
    </div>
    
    <div slot="modal-footer">
      <button type="button"
              class="btn btn-outline-secondary"
              @click="$bvModal.hide('viewNhaCungCap')"
              data-dismiss="modal"
      >
        Đóng
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
import Provider from "@/models/provider/provider";

export default {
  props: [
    'id'
  ],
  data() {
    return {
      nhaCungCap: null,
      loadingChiTietNhaCungCap: true
    }
  },
  watch: {
    id() {
      this.loadingChiTietNhaCungCap = true;
      let provider = new Provider();
      provider.show(this.id).then(response => {
        this.nhaCungCap = response.data;
        this.loadingChiTietNhaCungCap = false;
      });
    }
  },
  computed: {},
  methods: {
    clearModal() {
    }
  }
};
</script>
