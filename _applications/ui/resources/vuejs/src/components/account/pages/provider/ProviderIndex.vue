<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-10">
            <b-form-input v-model="keyword" placeholder="Tìm kiếm theo tên nhà cung cấp"></b-form-input>
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-primary btn-active-primary fw-bolder w-100" @click="searchProviderByKeyword">
              <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"></path>
                  </g>
                </svg>
              </span>
              Tìm kiếm
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <div v-if="loadingListNhaCungCap" class="row my-10">
      <div class="col-12 text-center">
        <span class="spinner spinner-primary"></span>
      </div>
    </div>
    <div v-else class="card my-5">
      <p class="text-danger text-center mt-4" v-if="!listNhaCungCap.length">Không có kết quả tìm kiếm.</p>
      <div v-else class="card-header">
        <div class="row">
          <div class="table-responsive text-center render-filter">
            <table class="table table-row-bordered table-row-gray-300 gy-7">
              <thead>
              <tr class="fw-bolder fs-6 text-gray-800">
                <th class="min-w-50px">Sửa</th>
                <th class="min-w-125px">Mã NCC</th>
                <th class="min-w-200px">Tên NCC</th>
                <th class="min-w-200px">Nhóm NCC</th>
                <th class="min-w-150px">Tổ chức nhận hàng</th>
                <th class="min-w-125px">SĐT hotline</th>
                <th class="min-w-125px">Email</th>
                <th class="min-w-125px">Trạng thái</th>
                <th class="min-w-75px align-middle">Chi tiết</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="nhaCungCap in listNhaCungCap">
                <td class="w-50px align-items-center align-middle">
                  <span v-b-modal.editNhaCungCap class="svg-icon svg-icon-primary svg-icon-3 sua_nha_cung_cap" @click="providerUpdate(nhaCungCap.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)"></path>
                      <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                    </svg>
                  </span>
                </td>
                <td class="align-middle">
                  <p>{{ nhaCungCap.provider_cd }}</p>
                </td>
                <td class="align-middle min-w-200px">
                  <p>{{ nhaCungCap.provider_name }}</p>
                </td>
                <td class="align-middle min-w-200px">
                  <p v-for="nhomNcc in nhaCungCap.provider_groups">{{ nhomNcc.group_name }}</p>
                </td>
                <td class="align-middle min-w-150px">
                  <p v-for="toChuc in nhaCungCap.stores">{{ toChuc.store_name }}</p>
                </td>
                <td class="align-middle">
                  <p>{{ nhaCungCap.phone }}</p>
                </td>
                <td class="align-middle">
                  <p>{{ nhaCungCap.email }}</p>
                </td>
                <td class="align-middle">
                  <span class="badge" :class="{ 'badge-success': nhaCungCap.active_status == 'active', 'badge-warning': nhaCungCap.active_status == 'inactive' }">{{ nhaCungCap.active_status == 'active' ? 'Đang giao dịch' : 'Ngừng giao dịch' }}</span>
                </td>
                <td class="min-w-75px align-items-center align-middle">
                  <span v-b-modal.viewNhaCungCap class="svg-icon svg-icon-primary svg-icon-2hx chi_tiet_nha_cung_cap" @click="providerShow(nhaCungCap.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
                      <rect x="11" y="11" width="2" height="2" rx="1" fill="black"/>
                      <rect x="15" y="11" width="2" height="2" rx="1" fill="black"/>
                      <rect x="7" y="11" width="2" height="2" rx="1" fill="black"/>
                    </svg>
                  </span>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <div class="popup-container">
      <provider-create
        @nhaCungCapAdded="refreshProviderIndex"
        @nhaCungCapAddedFail="refreshProviderIndex"
      />
      <provider-show
        :id="idShowProvider"
      />
      <provider-edit
        :id="idEditProvider"
        @nhaCungCapUpdated="refreshProviderIndex"
        @nhaCungCapUpdatedFail="refreshProviderIndex"
      />
    </div>
    
    <div v-if="listNhaCungCap.length > 0" class="card">
      <div class="card-header">
        <div class="row justify-content-between align-items-center">
          <div>
            <label class="fs-6 fw-bold mr-3">Hiển thị</label>
            <select class="form-control w-auto d-inline-block" v-model="itemPerPage" @change="searchProviderByKeyword">
              <option value="10">10</option>
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="40">40</option>
              <option value="50">50</option>
            </select>
          </div>
          <div class="overflow-auto">
            <b-pagination-nav
              v-model="currentPage"
              :link-gen="linkGen"
              :number-of-pages="totalPage"
              use-router></b-pagination-nav>
          </div>
        </div>
      </div>
    </div>
  
  </div>
</template>

<style scoped>
.chi_tiet_nha_cung_cap,
.sua_nha_cung_cap {
  cursor: pointer;
}
</style>

<script>
import {SET_BREADCRUMB, SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import Provider from "@/models/provider/provider";
import ProviderShow from "@/components/account/pages/provider/ProviderShow";
import ProviderCreate from "@/components/account/pages/provider/ProviderCreate";
import ProviderEdit from "@/components/account/pages/provider/ProviderEdit";

export default {
  data() {
    return {
      keyword: '',
      viewToChuc: {},
      listViewNhaCungCap: [],
      editToChuc: {},
      listEditNhaCungCap: [],
      itemPerPage: 10,
      currentPage: 1,
      totalPage: 1,
      listNhaCungCap: [],
      nhaCungCap: {},
      viewNhaCungCap: {},
      editNhaCungCap: {},
      idEditNhaCungCap: null,
      loadingListNhaCungCap: true,
      idShowProvider: null,
      idEditProvider: null
    };
  },
  components: {
    ProviderShow,
    ProviderCreate,
    ProviderEdit
  },
  computed: {
    listNhaCungCapDisplay: function () {
      return this.listNhaCungCap.map(nhaCungCap => {
        return {
          "Sửa": "N/A",
          "Mã NCC": nhaCungCap.ma_ncc,
          "Tên NCC": nhaCungCap.ten_ncc,
          "Nhóm NCC": "N/A",
          "Tổ chức nhận hàng": "N/A",
          "SĐT hotline": nhaCungCap.sdt,
          "Email": nhaCungCap.email,
          "Trạng thái": nhaCungCap.trang_thai == 'active' ? 'Active' : 'Inactive',
          "Chi tiết": "N/A",
        }
      });
    }
  },
  watch: {
    currentPage: function () {
      this.getListProvider();
    }
  },
  beforeCreate() {
    let keyword = '';
    let limit = 10;
    let offset = 0;
    let provider = new Provider();
    provider.getList(keyword, limit, offset)
      .then(response => {
          this.listNhaCungCap = response.data.items;
          this.totalPage = Math.ceil(response.data.total / this.itemPerPage) == 0 ? 1 : Math.ceil(response.data.total / this.itemPerPage);
          this.loadingListNhaCungCap = false;
      })
      .catch(error => console.log(error))
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      {title: "Dashboard", route: "/"},
      {title: "Quản lý nhà cung cấp", route: "account.provider"}
    ]);
    this.$store.dispatch(SET_ACTION, [
      {type: "modal", param: "addNhaCungCap", text: 'Thêm mới'}
    ]);
  },
  methods: {
    searchProviderByKeyword() {
      this.currentPage = 1;
      this.getListProvider();
    },
    getListProvider() {
      this.loadingListNhaCungCap = true;
      let keyword = this.keyword ?? '';
      let limit = this.itemPerPage;
      let offset = (this.currentPage - 1) * this.itemPerPage;
      let provider = new Provider();
      provider.getList(keyword, limit, offset)
        .then(response => {
          this.listNhaCungCap = response.data.items;
          this.totalPage = Math.ceil(response.data.total / this.itemPerPage) == 0 ? 1 : Math.ceil(response.data.total / this.itemPerPage);
          this.loadingListNhaCungCap = false;
        })
        .catch(error => console.log(error))
    },
    refreshProviderIndex() {
      this.loadingListNhaCungCap = true;
      this.idShowProvider = null;
      this.idEditProvider = null;
      this.$bvModal.hide('addNhaCungCap');
      this.$bvModal.hide('editNhaCungCap');
      this.$bvModal.hide('viewNhaCungCap');
      this.getListProvider();
    },
    providerShow(providerId) {
      this.idShowProvider = providerId;
    },
    providerUpdate(providerId) {
      this.idEditProvider = providerId;
    },
    linkGen() {
    }
  }
};
</script>
