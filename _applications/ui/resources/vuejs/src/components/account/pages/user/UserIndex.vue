<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-10">
            <b-form-input
                v-model="keyword"
                placeholder="Tìm kiếm theo tên user, sđt, email"
            />
          </div>
          <div class="col-2">
            <button
                type="submit"
                class="btn btn-primary btn-active-primary fw-bolder w-100"
                @click="searchUserByKeyword"
            >
              <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24"></rect>
                    <path
                        d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z"
                        fill="#000000">
                    </path>
                  </g>
                </svg>
              </span>
              Tìm kiếm
            </button>
          </div>
        </div>
      </div>
    </div>

    <div
        class="row my-10"
        v-if="loadingListUser"
    >
      <div class="col-12 text-center">
        <span class="spinner spinner-primary"></span>
      </div>
    </div>
    <div class="card my-5"
         v-else
    >
      <p class="text-danger text-center mt-4"
         v-if="!listUser.length"
      >
        Không có kết quả tìm kiếm.
      </p>
      <div v-else
           class="card-header">
        <div class="row">
          <div class="table-responsive text-center render-filter">
            <table class="table table-row-bordered table-row-gray-300 gy-7">
              <thead>
              <tr class="fw-bolder fs-6 text-gray-800">
                <th class="min-w-50px">Sửa</th>
                <th class="min-w-50px"></th>
                <th class="min-w-125px">Tên user</th>
                <th class="min-w-200px">Cơ cấu tổ chức</th>
                <th class="min-w-200px">Chức danh</th>
                <th class="min-w-150px">Nhóm chức danh</th>
                <th class="min-w-125px">Trạng thái</th>
                <th class="min-w-125px">Nhóm quyền</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="user in listUser">
                <td class="w-50px align-items-center align-middle">
                  <router-link :to="{ name: 'account.user_update', params: { id: user.id } }">
                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                      <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="24px" height="24px"
                          viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <rect x="0" y="0" width="24" height="24"/>
                          <path
                              d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                              fill="#000000"/>
                        </g>
                      </svg>
                    </span>
                  </router-link>
                </td>
                <td class="align-middle">
                  <b-img
                      v-bind="avatarProps"
                      :src="user.avatar"
                      rounded="circle"
                      center
                      alt="avatar"
                  />
                </td>
                <td class="align-middle">
                  <p>{{ user.full_name }}</p>
                  <p>
                    <span class="svg-icon svg-icon-primary svg-icon-2x"><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24px" height="24px"
                        viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <path
                            d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                            fill="#000000"/>
                      </g>
                    </svg>
                    </span>
                    {{ user.email }}
                  </p>
                  <p>
                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                      <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="24px" height="24px"
                          viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <rect x="0" y="0" width="24" height="24"/>
                          <path
                              d="M13.0799676,14.7839934 L15.2839934,12.5799676 C15.8927139,11.9712471 16.0436229,11.0413042 15.6586342,10.2713269 L15.5337539,10.0215663 C15.1487653,9.25158901 15.2996742,8.3216461 15.9083948,7.71292558 L18.6411989,4.98012149 C18.836461,4.78485934 19.1530435,4.78485934 19.3483056,4.98012149 C19.3863063,5.01812215 19.4179321,5.06200062 19.4419658,5.11006808 L20.5459415,7.31801948 C21.3904962,9.0071287 21.0594452,11.0471565 19.7240871,12.3825146 L13.7252616,18.3813401 C12.2717221,19.8348796 10.1217008,20.3424308 8.17157288,19.6923882 L5.75709327,18.8875616 C5.49512161,18.8002377 5.35354162,18.5170777 5.4408655,18.2551061 C5.46541191,18.1814669 5.50676633,18.114554 5.56165376,18.0596666 L8.21292558,15.4083948 C8.8216461,14.7996742 9.75158901,14.6487653 10.5215663,15.0337539 L10.7713269,15.1586342 C11.5413042,15.5436229 12.4712471,15.3927139 13.0799676,14.7839934 Z"
                              fill="#000000"/>
                          <path
                              d="M14.1480759,6.00715131 L13.9566988,7.99797396 C12.4781389,7.8558405 11.0097207,8.36895892 9.93933983,9.43933983 C8.8724631,10.5062166 8.35911588,11.9685602 8.49664195,13.4426352 L6.50528978,13.6284215 C6.31304559,11.5678496 7.03283934,9.51741319 8.52512627,8.02512627 C10.0223249,6.52792766 12.0812426,5.80846733 14.1480759,6.00715131 Z M14.4980938,2.02230302 L14.313049,4.01372424 C11.6618299,3.76737046 9.03000738,4.69181803 7.1109127,6.6109127 C5.19447112,8.52735429 4.26985715,11.1545872 4.51274152,13.802405 L2.52110319,13.985098 C2.22450978,10.7517681 3.35562581,7.53777247 5.69669914,5.19669914 C8.04101739,2.85238089 11.2606138,1.72147333 14.4980938,2.02230302 Z"
                              fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        </g>
                      </svg>
                    </span>
                    {{ user.phone }}
                  </p>
                </td>
                <td class="align-middle">
                  <p v-if="!user.danh_sach_to_chuc" v-for="boNhiem in user.assigns">{{ boNhiem.store.store_name }}</p>
                </td>
                <td class="align-middle">
                  <p v-for="boNhiemChucDanh in user.assigns">
                    {{ boNhiemChucDanh.job_title.job_title_name }}</p>
                </td>
                <td class="align-middle">
                  <p v-for="boNhiemChucDanh in user.assigns">
                    {{ getJobTitleGroup(boNhiemChucDanh.job_title.job_title_type) }}</p>
                </td>
                <td class="align-middle">
                  <p>
                    <span class="badge"
                          :class="{ 'badge-success': user.active_status == 'active', 'badge-warning': user.active_status == 'inactive' }">
                        {{
                        user.active_status == 'active' ? 'Active' : 'Inactive'
                      }}
                    </span>
                  </p>
                </td>
                <td class="align-middle">
                  <p v-for="nhomQuyen in user.assigns[0].permission_groups">
                    {{ nhomQuyen.group_name }}
                  </p>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="card" v-show="!loadingListUser">
      <div class="card-header">
        <div class="row justify-content-between align-items-center">
          <div>
            <label class="fs-6 fw-bold mr-3">Hiển thị</label>
            <select class="form-control w-auto d-inline-block"
                    v-model="itemPerPage"
                    @change="searchUserByKeyword"
            >
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
                use-router
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "~vuetify/dist/vuetify.min.css";
</style>

<script>
import {SET_BREADCRUMB, SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import Swal from "sweetalert2";
import User from '@/models/user/user';

export default {
  data() {
    return {
      itemPerPage: 10,
      currentPage: 1,
      totalPage: 1,
      keyword: '',
      loadingListUser: true,
      listUser: [],
      avatarProps: {
        width: 50, height: 50, class: 'avatar'
      },
    };
  },
  components: {},
  computed: {},
  watch: {
    currentPage() {
      this.searchUser();
    }
  },
  beforeCreate() {
    let userData = new User();
    let keyword = '';
    let limit = 10;
    let offset = 0;
    userData.getListUser(keyword, limit, offset)
        .then(response => {
          this.listUser = response.data.items;
          this.totalPage = Math.ceil(response.data.total / 10) == 0 ? 1 : Math.ceil(response.data.total / 10);
          this.loadingListUser = false;
        })
        .catch(error => {
          Swal.fire(
              'Không thành công!',
              'Đã xảy ra lỗi, vui lòng liên hệ admin',
              'error'
          );
        });
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      {title: "Dashboard", route: "/"},
      {title: "Quản lý user", route: "user"}
    ]);
    this.$store.dispatch(SET_ACTION, [
      {type: "link", param: "/account/user/create", text: 'Thêm mới'}
    ]);
  },
  methods: {
    searchUserByKeyword() {
      this.currentPage = 1;
      this.searchUser();
    },
    searchUser() {
      this.loadingListUser = true;
      let userData = new User();
      let keyword = this.keyword;
      let limit = this.itemPerPage;
      let offset = parseInt(this.itemPerPage) * (parseInt(this.currentPage) - 1);
      userData.getListUser(keyword, limit, offset)
          .then(response => {
            this.listUser = response.data.items;
            this.totalPage = Math.ceil(response.data.total / this.itemPerPage) == 0 ? 1 : Math.ceil(response.data.total / this.itemPerPage);
            this.loadingListUser = false;
          })
          .catch(error => {
            Swal.fire(
                'Không thành công!',
                'Đã xảy ra lỗi, vui lòng liên hệ admin',
                'error'
            );
            this.loadingListUser = false;
          });
    },
    linkGen() {},
    getJobTitleGroup(jobTitleGroup) {
      if (jobTitleGroup == "manager") {
        return "Nhóm Quản lý"
      } else if (jobTitleGroup == "staff") {
        return "Nhóm Nhân viên"
      } else {
        return "Nhóm khác"
      }
    }
  }
};
</script>
