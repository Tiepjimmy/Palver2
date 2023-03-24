<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-10">
            <b-form-input v-model="keyword" placeholder="Tìm kiếm theo tên"></b-form-input>
          </div>
          <div class="col-2">
            <button type="submit" class="btn btn-primary btn-active-primary fw-bolder w-100" @click="searchJobTitleByKeyword">
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
    
    <div v-if="loadingListChucDanh" class="row my-10">
      <div class="col-12 text-center">
        <span class="spinner spinner-primary"></span>
      </div>
    </div>
    <div v-else class="row mt-0">
      <div v-if="!listToChuc.length" class="col-12">
        <p class="text-danger text-center my-4">Không có kết quả tìm kiếm.</p>
      </div>
      <div v-else class="col-md-4 my-4" v-for="(toChuc, indexToChuc) in listToChuc" :key="toChuc.id">
        <div class="card card-flush h-md-100">
          <div class="card-header">
            <div class="card-title mb-0">
              <h2>{{ toChuc.store_name }}</h2>
            </div>
            <span v-if="!toChuc.parent_id" class="svg-icon svg-icon-warning svg-icon-2x tong_cong_ty_icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <polygon points="0 0 24 0 24 24 0 24"/>
                  <path d="M12,18 L7.91561963,20.1472858 C7.42677504,20.4042866 6.82214789,20.2163401 6.56514708,19.7274955 C6.46280801,19.5328351 6.42749334,19.309867 6.46467018,19.0931094 L7.24471742,14.545085 L3.94038429,11.3241562 C3.54490071,10.938655 3.5368084,10.3055417 3.92230962,9.91005817 C4.07581822,9.75257453 4.27696063,9.65008735 4.49459766,9.61846284 L9.06107374,8.95491503 L11.1032639,4.81698575 C11.3476862,4.32173209 11.9473121,4.11839309 12.4425657,4.36281539 C12.6397783,4.46014562 12.7994058,4.61977315 12.8967361,4.81698575 L14.9389263,8.95491503 L19.5054023,9.61846284 C20.0519472,9.69788046 20.4306287,10.2053233 20.351211,10.7518682 C20.3195865,10.9695052 20.2170993,11.1706476 20.0596157,11.3241562 L16.7552826,14.545085 L17.5353298,19.0931094 C17.6286908,19.6374458 17.263103,20.1544017 16.7187666,20.2477627 C16.5020089,20.2849396 16.2790408,20.2496249 16.0843804,20.1472858 L12,18 Z" fill="#000000"/>
                </g>
              </svg>
            </span>
          </div>
          <div class="card-body">
            <div class="fw-bolder text-gray-600 mb-5">Tổng số chức danh: {{ toChuc.job_titles.length }}</div>
            <div class="d-flex flex-column text-gray-600">
              
              <div v-if="index < 5" class="d-flex align-items-center py-2" v-for="(chucDanh, index) in toChuc.job_titles" :key="chucDanh.id">
                <div>
                  <span class="bullet bg-secondary me-3 mr-2"></span>
                  <span :class="{
                        'text-success': chucDanh.job_title_type == 'manager',
                        'text-dark': chucDanh.job_title_type == 'staff',
                        'text-primary': chucDanh.job_title_type == 'other'
                  }"
                  >
                    {{ chucDanh.job_title_name }}
                  </span>
                </div>
              </div>
              
              <div class="d-flex align-items-center py-2" v-if="toChuc.job_titles.length > 5">
                <span class="bullet bg-primary me-3 mr-2"></span>
                <b-button variant="link"
                          v-b-modal.viewToChuc
                          @click="get(indexToChuc)"
                >
                  <span>Xem thêm chức danh</span>
                </b-button>
              </div>
            </div>
          </div>
          <div class="card-footer flex-wrap d-flex justify-content-md-center justify-content-xl-end">
            <b-button v-b-modal.viewToChuc @click="get(indexToChuc)" class="btn-light btn-active-primary my-1 me-2 px-md-4 py-md-3">Chi tiết</b-button>
            <b-button v-b-modal.editToChuc @click="get(indexToChuc)" class="btn-light btn-active-success my-1 me-2 px-md-4 py-md-3 ml-3">Chỉnh sửa</b-button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="popup-container">
      <job-title-create :createToChuc="createToChuc" @chucDanhAdded="refreshJobTitleIndex" @chucDanhAddedFail="refreshJobTitleIndex"/>
      <job-title-show :viewToChuc="viewToChuc"/>
      <job-title-edit :editToChuc="editToChuc" @chucDanhUpdated="refreshJobTitleIndex" @chucDanhUpdatedFail="refreshJobTitleIndex"/>
    </div>
    
    <div class="card">
      <div class="card-header">
        <div class="row justify-content-between align-items-center">
          <div>
            <label class="fs-6 fw-bold mr-3">Hiển thị</label>
            <select class="form-control w-auto d-inline-block" v-model="itemPerPage" @change="searchJobTitleByKeyword">
              <option value="6">6</option>
              <option value="12">12</option>
              <option value="18">18</option>
              <option value="24">24</option>
              <option value="30">30</option>
            </select>
          </div>
          <div class="overflow-auto">
            <b-pagination-nav
              v-model="currentPage"
              :link-gen="linkGen"
              :number-of-pages="totalPage"
              use-router
            />
          </div>
        </div>
      </div>
    </div>
  
  </div>
</template>

<style scoped>
.tong_cong_ty_icon {
  position: absolute;
  top: 5%;
  right: 5%;
}
</style>

<script>
import {SET_BREADCRUMB, SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import JobTitle from "@/models/job-title/job-title";
import JobTitleCreate from "@/components/account/pages/job-title/JobTitleCreate";
import JobTitleShow from "@/components/account/pages/job-title/JobTitleShow";
import JobTitleEdit from "@/components/account/pages/job-title/JobTitleEdit";

export default {
  data() {
    return {
      totalPage: 1,
      itemPerPage: 6,
      currentPage: 1,
      createToChuc: [],
      toChuc: {},
      keyword: '',
      editToChuc: {
        job_titles: []
      },
      viewToChuc: {},
      listEditChucDanh: [],
      listViewChucDanh: [],
      listToChuc: [],
      loadingListChucDanh: true,
    };
  },
  components: {
    JobTitleCreate,
    JobTitleShow,
    JobTitleEdit
  },
  computed: {},
  beforeCreate() {
    let promiseListChucDanh = new Promise((resolve, reject) => {
      let jobTitle = new JobTitle();
      jobTitle.getList()
        .then(response => {
          resolve(response);
          this.listToChuc = response.data.items;
          this.totalPage = Math.ceil(response.data.total / this.itemPerPage) == 0 ? 1 : Math.ceil(response.data.total / this.itemPerPage);
        })
        .catch(error => {
          reject(error);
        })
    });
    let promiseCreateInfo = new Promise((resolve, reject) => {
      let jobTitle = new JobTitle();
      jobTitle.getCreateInfo()
        .then(response => {
            resolve(response);
            this.createToChuc = response.data.list_store;
            this.loadingListChucDanh = false;
        })
        .catch(error => {
            reject(error);
        })
    });
    Promise.all([promiseListChucDanh, promiseCreateInfo]).then((listResponse) => {
      this.loadingListChucDanh = false;
    });
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      {title: "Dashboard", route: "/"},
      {title: "Quản lý chức danh", route: "chuc-danh"}
    ]);
    this.$store.dispatch(SET_ACTION, [
      {type: "modal", param: "addChucDanh", text: 'Thêm mới'}
    ]);
  },
  watch: {
    currentPage() {
      this.searchJobTitle();
    }
  },
  methods: {
    refreshJobTitleIndex() {
      this.loadingListChucDanh = true;
      this.$bvModal.hide('addChucDanh');
      this.$bvModal.hide('editToChuc');
      this.$bvModal.hide('viewToChuc');
      this.searchJobTitle();
    },
    get(indexToChuc) {
      this.viewToChuc = this.listToChuc[indexToChuc];
      this.editToChuc = this.listToChuc[indexToChuc];
    },
    searchJobTitleByKeyword() {
      this.currentPage = 1;
      this.searchJobTitle();
    },
    searchJobTitle() {
      this.loadingListChucDanh = true;
      let offset = parseInt(this.itemPerPage) * (parseInt(this.currentPage) - 1);
      let jobTitle = new JobTitle();
      jobTitle.search(this.keyword, this.itemPerPage, offset)
          .then(response => {
              this.listToChuc = response.data.items;
              this.totalPage = Math.ceil(response.data.total / this.itemPerPage) == 0 ? 1 : Math.ceil(response.data.total / this.itemPerPage);
              this.loadingListChucDanh = false;
          })
          .catch(error => {
              this.loadingListChucDanh = false;
          })
    },
    linkGen() {
    }
  }
};
</script>
