<template>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-12 col-sm-12">
          <h3 class="text-center">Nhóm thuộc tính</h3>
          <p class="text-center">(Ứng với loại sản phẩm)</p>
        </div>
      </div>
      <div class="row">
        <div class="col-3 col-sm-3 pt-3">
          <div v-if="loadingListNhomThuocTinh" class="row my-10">
            <div class="col-12 text-center">
              <span class="spinner spinner-primary"></span>
            </div>
          </div>
          <div v-else>
            <div v-if="!listNhomThuocTinh.length" class="col-12">
              <p class="text-danger text-center my-4">Không có kết quả tìm kiếm.</p>
            </div>
            <div v-else>
              <v-app>
                <div class="row justify-content-between mt-0 mb-3 p-6 nhom_thuoc_tinh"
                     v-for="(nhomThuocTinh, indexNhomThuocTinh) in listNhomThuocTinh"
                     @click="clickAttributeGroup(nhomThuocTinh)"
                     :class="{ 'active': nhomThuocTinh.picked }"
                >
                  <div>
                    <span class="ten_nhom_thuoc_tinh">{{ nhomThuocTinh.ten_nhom_thuoc_tinh }}</span>
                  </div>
                  <div class="d-flex align-items-center justify-content-center">
                    <router-link :to="{ name: 'account.attribute-group.update', params: { id: nhomThuocTinh.id } }">
                      <span class="svg-icon svg-icon-primary svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                            <path d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                          </g>
                        </svg>
                      </span>
                    </router-link>
                    <v-switch
                      v-model="nhomThuocTinh.checked"
                      color="success"
                      inset
                      hide-details
                      @click="changeAttributeGroupStatus(nhomThuocTinh)"
                    ></v-switch>
                  </div>
                </div>
              </v-app>
            </div>
          </div>
        </div>
        <div class="col-9 col-sm-9">
          <div v-if="loadingListNhomThuocTinh" class="row my-10">
            <div class="col-12 text-center">
              <span class="spinner spinner-primary"></span>
            </div>
          </div>
          <div v-if="!listThuocTinh.length" class="col-12">
            <p v-show="!loadingListNhomThuocTinh" class="text-danger text-center my-4">Không có kết quả tìm kiếm.</p>
          </div>
          <div v-else class="row">
            <div class="col-12 col-sm-12">
              <v-app>
                <v-card>
                  <v-card-title>
                    <v-spacer>
                      Danh sách thuộc tính
                      <button v-b-modal.createThuocTinh class="ml-5 btn btn-sm btn-outline-primary">Thêm thuộc tính</button>
                    </v-spacer>
                    <v-text-field
                      v-model="search"
                      append-icon="search"
                      label=""
                      single-line
                      hide-details
                    ></v-text-field>
                  </v-card-title>
                  <v-data-table
                    :headers="headers"
                    :items="listThuocTinh"
                    :search="search"
                    :footer-props="{
                        'items-per-page-all-text': 'Tất cả',
                        'items-per-page-text': 'Hiển thị',
                        'page-text': '{0}-{1} trong tổng số {2}'
                    }"
                  >
                    <template class="hehe" v-slot:item.thao_tac="{ item }">
                      <v-switch
                        v-model="item.active"
                        color="success"
                        inset
                        hide-details
                        @click="changeAttributeStatus(item)"
                      ></v-switch>
                      <span v-b-modal.editThuocTinh @click="editAttribute(item.id)" class="sua_thuoc_tinh svg-icon svg-icon-primary svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                            <path d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                          </g>
                        </svg>
                      </span>
                      <span @click="deleteAttribute(item)" class="xoa_thuoc_tinh svg-icon svg-icon-primary svg-icon-2x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z" fill="#000000" fill-rule="nonzero"/>
                            <path d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                          </g>
                        </svg>
                      </span>
                    </template>
                  </v-data-table>
                </v-card>
              </v-app>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
    
    </div>
    
    <div class="popup-container">
      <attribute-create
        :idNhomThuocTinh="currentIdNhomThuocTinh"
        :createInfo="createInfo"
        @thuocTinhAdded="refreshAttributeGroupIndex"
        @thuocTinhAddedFail="refreshAttributeGroupIndex"
      />
      <attribute-edit
        :idNhomThuocTinh="currentIdNhomThuocTinh"
        :createInfo="createInfo"
        :thuocTinh="currentEditThuocTinh"
        @thuocTinhUpdated="refreshAttributeGroupIndex"
        @thuocTinhUpdatedFail="refreshAttributeGroupIndex"
      />
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "~vuetify/dist/vuetify.min.css";

.v-data-table::v-deep .spacer {
  font-family: Poppins, Helvetica, "sans-serif";
}
.v-data-table::v-deep button {
  font-family: Poppins, Helvetica, "sans-serif";
}
.v-data-table::v-deep th {
  font-size: 14px !important;
  font-family: Poppins, Helvetica, "sans-serif";
}
.v-data-table::v-deep td {
  font-size: 13px !important;
  font-family: Poppins, Helvetica, "sans-serif";
}
.v-data-table::v-deep tr td:last-child {
  display: flex;
  align-items: center;
  justify-content: center;
}
.v-input--switch {
  display: inline-block;
  margin: 0;
  transform: scale(0.8);
}
.nhom_thuoc_tinh {
  background-color: #eef;
  cursor: pointer;
  border-radius: 4px;
}
.active {
  background-color: #b1e9d9;
}
.sua_thuoc_tinh,
.xoa_thuoc_tinh {
  cursor: pointer;
}
::v-deep .v-application--wrap {
  min-height: fit-content;
}
.ten_nhom_thuoc_tinh {
  font-size: 14px !important;
  font-family: Poppins, Helvetica, "sans-serif";
}
</style>

<script>
import {SET_BREADCRUMB, SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import AttributeGroup from "@/models/attribute-group/attribute-group";
import Swal from "sweetalert2";
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import AttributeCreate from "@/components/account/pages/attribute/AttributeCreate";
import AttributeEdit from "@/components/account/pages/attribute/AttributeEdit";
import Attribute from "@/models/attribute/attribute";

export default {
  data() {
    return {
      itemPerPage: 10,
      currentPage: 1,
      totalPage: 1,
      search: '',
      currentIdNhomThuocTinh: null,
      currentEditThuocTinh: null,
      loadingListNhomThuocTinh: true,
      listNhomThuocTinh: [],
      headers: [
        { text: 'Mã', value: 'ma_thuoc_tinh', align: 'center', },
        { text: 'Tên', value: 'ten_thuoc_tinh', align: 'center', },
        { text: 'Giá trị mặc định', value: 'gia_tri_thuoc_tinh', align: 'center', },
        { text: 'Bắt buộc', value: 'bat_buoc', align: 'center', },
        { text: 'Thao tác', value: 'thao_tac', align: 'center', },
      ],
      listThuocTinh: [],
      createInfo: null
    };
  },
  components: {
    Treeselect,
    AttributeCreate,
    AttributeEdit
  },
  computed: {
  },
  watch: {
  },
  beforeCreate() {
    this.loadingListNhomThuocTinh = true;
    let attributeGroup = new AttributeGroup();
    attributeGroup.getList()
      .then(response => {
        if (!response.success) {
          Swal.fire(
            "Lỗi!",
            "Có lỗi phát sinh vui lòng liên hệ admin",
            "error",
          ).then(function (result) {
            if (result.value) {
              return window.location.reload();
            }
            window.location.reload()
          });
          return false;
        }
        this.listNhomThuocTinh = response.data.map(nhomThuocTinh => {
          return {
            id: nhomThuocTinh.id,
            ten_nhom_thuoc_tinh: nhomThuocTinh.attribute_group_name,
            trang_thai: nhomThuocTinh.active_status,
            checked: nhomThuocTinh.active_status == 'active' ? true : false,
            danh_sach_thuoc_tinh: nhomThuocTinh.product_attributes,
            picked: false
          }
        });
        if (this.listNhomThuocTinh.length) {
          this.listNhomThuocTinh[0].picked = true;
          this.currentIdNhomThuocTinh = this.listNhomThuocTinh[0].id;
          this.listThuocTinh = this.listNhomThuocTinh[0].danh_sach_thuoc_tinh.map(thuocTinh => {
            return {
              id: thuocTinh.id,
              ma_thuoc_tinh: thuocTinh.attribute_cd,
              ten_thuoc_tinh: thuocTinh.attribute_display_name,
              gia_tri_thuoc_tinh: thuocTinh.attribute_floats.concat(thuocTinh.attribute_ints, thuocTinh.attribute_varchars)[0].value_display_name,
              bat_buoc: thuocTinh.is_require == true ? 'Có' : 'Không',
              active: thuocTinh.active_status == 'active' ? true : false,
            }
          });
        }
        this.loadingListNhomThuocTinh = false;
      })
      .catch(error => {
        this.loadingListNhomThuocTinh = false;
      });
    attributeGroup.getCreateInfo()
      .then((response) => {
        if (!response.success) {
          Swal.fire(
            "Lỗi!",
            "Có lỗi phát sinh vui lòng liên hệ admin",
            "error",
          ).then(function (result) {
            if (result.value) {
              return window.location.reload();
            }
            window.location.reload()
          });
          return false;
        }
        this.createInfo = response.data;
      })
      .catch(error => {
        Swal.fire(
          "Lỗi!",
          "Có lỗi phát sinh vui lòng liên hệ admin",
          "error",
        ).then(function (result) {
          if (result.value) {
            return window.location.reload();
          }
          window.location.reload()
        });
        return false;
      });
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [
      {title: "Dashboard", route: "/"},
      {title: "Quản lý nhóm thuộc tính", route: "/account/attribute-group"}
    ]);
    this.$store.dispatch(SET_ACTION, [
      {type: "link", param: "/account/attribute-group/create", text: 'Thêm mới'}
    ]);
  },
  methods: {
    editAttribute(idThuocTinh) {
      this.listNhomThuocTinh.forEach(nhomThuocTinh => {
        if (nhomThuocTinh.id == this.currentIdNhomThuocTinh) {
          nhomThuocTinh.danh_sach_thuoc_tinh.forEach(thuocTinh => {
            if (thuocTinh.id == idThuocTinh) {
              this.currentEditThuocTinh = thuocTinh;
            }
          });
        }
      });
    },
    deleteAttribute(thuocTinh) {
      if (!confirm('Bạn chắc chắn muốn xóa thuộc tính này?')) {
        return false;
      }
      let idThuocTinh = thuocTinh.id;
      let attribute = new Attribute();
      attribute.deleteAttribute(idThuocTinh)
        .then(response => {
          if (!response.success) {
            Swal.fire(
              "Lỗi!",
              "Có lỗi phát sinh vui lòng liên hệ admin",
              "error",
            ).then(function (result) {
              if (result.value) {
                return window.location.reload();
              }
              window.location.reload()
            });
            return false;
          }
          for (let index = 0; index < this.listThuocTinh.length; index++) {
            if (this.listThuocTinh[index].id == idThuocTinh) {
              this.listThuocTinh.splice(index, 1);
              break;
            }
          }
          Swal.fire(
            'Thành công!',
            'Đã xóa thuộc tính thành công',
            'success'
          );
        })
        .catch(error => {
          Swal.fire(
            "Lỗi!",
            "Có lỗi phát sinh vui lòng liên hệ admin",
            "error",
          ).then(function (result) {
            if (result.value) {
              return window.location.reload();
            }
            window.location.reload()
          });
          return false;
        });
    },
    changeAttributeGroupStatus(nhomThuocTinh) {
      let idNhomThuocTinh = nhomThuocTinh.id;
      let attributeGroup = new AttributeGroup();
      attributeGroup.changeAttributeGroupStatus(idNhomThuocTinh, {
        active_status: nhomThuocTinh.checked == true ? 'active' : 'inactive'
      })
        .then(response => {
          if (!response.success) {
            Swal.fire(
              "Lỗi!",
              "Có lỗi phát sinh vui lòng liên hệ admin",
              "error",
            ).then(function (result) {
              if (result.value) {
                return window.location.reload();
              }
              window.location.reload()
            });
            return false;
          }
          Swal.fire(
            'Thành công!',
            'Đã thay đổi trạng thái nhóm thuộc tính thành công',
            'success'
          );
          this.refreshAttributeGroupIndex();
        })
        .catch(error => {
          Swal.fire(
            "Lỗi!",
            "Có lỗi phát sinh vui lòng liên hệ admin",
            "error",
          ).then(function (result) {
            if (result.value) {
              return window.location.reload();
            }
            window.location.reload()
          });
          return false;
        });
    },
    changeAttributeStatus(thuocTinh) {
      let idThuocTinh = thuocTinh.id;
      let attribute = new Attribute();
      attribute.changeAttributeStatus(idThuocTinh, {
        active_status: thuocTinh.active == true ? 'active' : 'inactive'
      })
        .then(response => {
          if (!response.success) {
            Swal.fire(
              "Lỗi!",
              "Có lỗi phát sinh vui lòng liên hệ admin",
              "error",
            ).then(function (result) {
              if (result.value) {
                return window.location.reload();
              }
              window.location.reload()
            });
            return false;
          }
          Swal.fire(
            'Thành công!',
            'Đã thay đổi trạng thái thuộc tính thành công',
            'success'
          );
        })
        .catch(error => {
          Swal.fire(
            "Lỗi!",
            "Có lỗi phát sinh vui lòng liên hệ admin",
            "error",
          ).then(function (result) {
            if (result.value) {
              return window.location.reload();
            }
            window.location.reload()
          });
          return false;
        });
    },
    clickAttributeGroup(nhomThuocTinh) {
      let idNhomThuocTinh = nhomThuocTinh.id;
      this.currentIdNhomThuocTinh = idNhomThuocTinh;
      this.listThuocTinh = nhomThuocTinh.danh_sach_thuoc_tinh.map(thuocTinh => {
        return {
          id: thuocTinh.id,
          ma_thuoc_tinh: thuocTinh.attribute_cd,
          ten_thuoc_tinh: thuocTinh.attribute_display_name,
          gia_tri_thuoc_tinh: thuocTinh.attribute_floats.concat(thuocTinh.attribute_ints, thuocTinh.attribute_varchars)[0].value_display_name,
          bat_buoc: thuocTinh.is_require == true ? 'Có' : 'Không',
          active: thuocTinh.active_status == 'active' ? true : false,
        }
      });
      this.listNhomThuocTinh.forEach(nhomThuocTinh => {
        if (idNhomThuocTinh == nhomThuocTinh.id) {
          nhomThuocTinh.picked = true;
        } else {
          nhomThuocTinh.picked = false;
        }
      });
    },
    refreshAttributeGroupIndex() {
      this.loadingListNhomThuocTinh = true;
      this.listThuocTinh = [];
      this.$bvModal.hide('createThuocTinh');
      this.$bvModal.hide('editThuocTinh');
      let attributeGroup = new AttributeGroup();
      attributeGroup.getList()
        .then(response => {
          if (!response.success) {
            Swal.fire(
              "Lỗi!",
              "Có lỗi phát sinh vui lòng liên hệ admin",
              "error",
            ).then(function (result) {
              if (result.value) {
                return window.location.reload();
              }
              window.location.reload()
            });
            return false;
          }
          this.listNhomThuocTinh = response.data.map(nhomThuocTinh => {
            return {
              id: nhomThuocTinh.id,
              ten_nhom_thuoc_tinh: nhomThuocTinh.attribute_group_name,
              trang_thai: nhomThuocTinh.active_status,
              checked: nhomThuocTinh.active_status == 'active' ? true : false,
              danh_sach_thuoc_tinh: nhomThuocTinh.product_attributes,
              picked: false
            }
          });
          if (this.listNhomThuocTinh.length) {
            this.listNhomThuocTinh[0].picked = true;
            this.currentIdNhomThuocTinh = this.listNhomThuocTinh[0].id;
            this.listThuocTinh = this.listNhomThuocTinh[0].danh_sach_thuoc_tinh.map(thuocTinh => {
              return {
                id: thuocTinh.id,
                ma_thuoc_tinh: thuocTinh.attribute_cd,
                ten_thuoc_tinh: thuocTinh.attribute_display_name,
                gia_tri_thuoc_tinh: thuocTinh.attribute_floats.concat(thuocTinh.attribute_ints, thuocTinh.attribute_varchars)[0].value_display_name,
                bat_buoc: thuocTinh.is_require == true ? 'Có' : 'Không',
                active: thuocTinh.active_status == 'active' ? true : false,
              }
            });
          }
          this.loadingListNhomThuocTinh = false;
        })
        .catch(error => {
          this.loadingListNhomThuocTinh = false;
        });
    }
  }
};
</script>
