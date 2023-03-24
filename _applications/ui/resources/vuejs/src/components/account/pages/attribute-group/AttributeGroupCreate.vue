<template>
  <div class="card">
    <div class="card-body">
      <h4 class="card-title text-center">Thêm mới nhóm thuộc tính</h4>
      <div class="row">
        <div class="col-1 col-sm-1">
          &nbsp;
        </div>
        <div class="col-10 col-sm-10">
          <div class="row">
            <div class="col-2 col-sm-2">
              <div class="form-group">
                <label class="form-label required">
                  Mã nhóm
                  <span class="text-danger">*</span>
                </label>
              </div>
            </div>
            <div class="col-10 col-sm-10">
              <div class="form-group">
                <input type="text" class="form-control mb-5" placeholder="Nhập mã nhóm"
                       v-model="maNhomThuocTinh"/>
                <p v-if="validateErrors.attribute_group_cd" class="text-danger">{{ validateErrors.attribute_group_cd }}</p>
              </div>
            </div>
            <div class="col-2 col-sm-2">
              <div class="form-group">
                <label class="form-label required">
                  Tên nhóm
                  <span class="text-danger">*</span>
                </label>
              </div>
            </div>
            <div class="col-10 col-sm-10">
              <div class="form-group">
                <input type="text" class="form-control mb-5" placeholder="Nhập tên nhóm"
                       v-model="tenNhomThuocTinh"/>
                <p v-if="validateErrors.attribute_group_name" class="text-danger">{{ validateErrors.attribute_group_name }}</p>
              </div>
            </div>
            <div class="col-2 col-sm-2">
              <div class="form-group">
                <label class="form-label required">
                  Loại sản phẩm
                  <span class="text-danger">*</span>
                </label>
              </div>
            </div>
            <div class="col-10 col-sm-10">
              <div class="form-group">
                <treeselect
                  :multiple="true"
                  :options="listLoaiSanPham"
                  :flat="true"
                  placeholder="Chọn loại sản phẩm"
                  v-model="listSelectedLoaiSanPham"
                />
                <p v-if="validateErrors.product_catalog_id" class="text-danger">{{ validateErrors.product_catalog_id }}</p>
              </div>
            </div>
          </div>
          <div class="row">
            <h5 class="card-title">Danh sách thuộc tính</h5>
          </div>
          <div class="thuoc_tinh_container"
               v-for="(thuocTinh, indexThuocTinh) in listThuocTinh"
          >
            <div class="row">
              <div class="col-2 col-sm-2">
                <div class="form-group">
                  <label class="form-label required">
                    Mã thuộc tính
                    <span class="text-danger">*</span>
                  </label>
                </div>
              </div>
              <div class="col-10 col-sm-10">
                <div class="form-group">
                  <input type="text" class="form-control mb-5" placeholder="Nhập mã thuộc tính"
                         v-model="thuocTinh.maThuocTinh"/>
                  <p v-if="validateErrors['product_attribute_list.' + indexThuocTinh + '.attribute_cd']" class="text-danger">{{ validateErrors['product_attribute_list.' + indexThuocTinh + '.attribute_cd'] }}</p>
                </div>
              </div>
              <div class="col-2 col-sm-2">
                <div class="form-group">
                  <label class="form-label required">
                    Tên thuộc tính
                    <span class="text-danger">*</span>
                  </label>
                </div>
              </div>
              <div class="col-10 col-sm-10">
                <div class="form-group">
                  <input type="text" class="form-control mb-5" placeholder="Nhập tên thuộc tính"
                         v-model="thuocTinh.tenThuocTinh"/>
                  <p v-if="validateErrors['product_attribute_list.' + indexThuocTinh + '.attribute_display_name']" class="text-danger">{{ validateErrors['product_attribute_list.' + indexThuocTinh + '.attribute_display_name'] }}</p>
                </div>
              </div>
              <div class="col-2 col-sm-2">
                <div class="form-group">
                  <label class="form-label required">
                    Loại thuộc tính
                    <span class="text-danger">*</span>
                  </label>
                </div>
              </div>
              <div class="col-10 col-sm-10">
                <div class="form-group">
                  <treeselect
                    :options="listLoaiThuocTinh"
                    placeholder="Chọn loại thuộc tính"
                    v-model="thuocTinh.loaiThuocTinh"
                  />
                  <p v-if="validateErrors['product_attribute_list.' + indexThuocTinh + '.attribute_type_id']" class="text-danger">{{ validateErrors['product_attribute_list.' + indexThuocTinh + '.attribute_type_id'] }}</p>
                </div>
              </div>
              <div class="col-12"
                   v-for="(giaTri, indexGiaTri) in thuocTinh.listGiaTriThuocTinh"
              >
                <div class="gia_tri_container row">
                  <div class="col-2 col-sm-2 pb-0">
                    <div class="form-group pt-5 mt-3">
                      <label class="form-label required">
                        {{ 'Giá trị ' + (indexGiaTri + 1) }}
                        <span class="text-danger">*</span>
                      </label>
                    </div>
                  </div>
                  <div class="col-10 col-sm-10 pb-0">
                    <div class="form-group">
                      <v-menu
                        class="input_value"
                        v-if="thuocTinh.loaiThuocTinh == '2'"
                        v-model="showDatePicker"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            :value="formatDate(giaTri.value)"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          class="input_value"
                          v-model="giaTri.value"
                          @input="showDatePicker = false"
                          locale="vi-vn"
                        ></v-date-picker>
                      </v-menu>
                      <v-text-field
                        class="input_value"
                        v-else-if="thuocTinh.loaiThuocTinh == '4'"
                        v-model="giaTri.value"
                        type="number"
                      ></v-text-field>
                      <v-text-field
                        class="input_value"
                        v-else
                        v-model="giaTri.value"
                      ></v-text-field>
                      <p v-if="validateErrors['product_attribute_list.' + indexThuocTinh + '.value.' + indexGiaTri]" class="text-danger">{{ validateErrors['product_attribute_list.' + indexThuocTinh + '.value.' + indexGiaTri] }}</p>
                    </div>
                  </div>
                  <span v-if="thuocTinh.loaiThuocTinh == '1'" @click="deleteValue(indexThuocTinh, indexGiaTri)" class="xoa_gia_tri svg-icon svg-icon-primary svg-icon-2x pt-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"/>
                        <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                        <path d="M12.0355339,10.6213203 L14.863961,7.79289322 C15.2544853,7.40236893 15.8876503,7.40236893 16.2781746,7.79289322 C16.6686989,8.18341751 16.6686989,8.81658249 16.2781746,9.20710678 L13.4497475,12.0355339 L16.2781746,14.863961 C16.6686989,15.2544853 16.6686989,15.8876503 16.2781746,16.2781746 C15.8876503,16.6686989 15.2544853,16.6686989 14.863961,16.2781746 L12.0355339,13.4497475 L9.20710678,16.2781746 C8.81658249,16.6686989 8.18341751,16.6686989 7.79289322,16.2781746 C7.40236893,15.8876503 7.40236893,15.2544853 7.79289322,14.863961 L10.6213203,12.0355339 L7.79289322,9.20710678 C7.40236893,8.81658249 7.40236893,8.18341751 7.79289322,7.79289322 C8.18341751,7.40236893 8.81658249,7.40236893 9.20710678,7.79289322 L12.0355339,10.6213203 Z" fill="#000000"/>
                      </g>
                    </svg>
                  </span>
                </div>
              </div>
              <div v-if="thuocTinh.loaiThuocTinh == '1'" class="col-2 col-sm-2">
                <button type="button" class="btn btn-outline-primary" @click="addValue(indexThuocTinh)">
                  <span class="them_gia_tri svg-icon svg-icon-primary svg-icon-1x">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                        <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                      </g>
                    </svg>
                  </span>
                  Thêm giá trị
                </button>
              </div>
              <div v-if="thuocTinh.loaiThuocTinh == '1'" class="col-10 col-sm-10">
                &nbsp;
              </div>
              <div class="col-2 col-sm-2">
                <div class="form-group">
                  <label class="form-label required">
                    Thuộc tính mặc định
                  </label>
                </div>
              </div>
              <div class="col-10 col-sm-10">
                <div class="form-group">
                  <label
                    class="checkbox checkbox-lg checkbox-lg checkbox-single flex-shrink-0 mr-4"
                  >
                    <input type="checkbox" v-model="thuocTinh.macDinh"/>
                    <span></span>
                  </label>
                  <p class="mt-3">(Khi được chọn là thuộc tính mặc định, thuộc tính này sẽ được áp dụng cho tất cả các loại sản phẩm)</p>
                </div>
              </div>
              <div class="col-2 col-sm-2">
                <div class="form-group">
                  <label class="form-label required">
                    Bắt buộc
                  </label>
                </div>
              </div>
              <div class="col-10 col-sm-10">
                <div class="form-group">
                  <label
                    class="checkbox checkbox-lg checkbox-lg checkbox-single flex-shrink-0 mr-4"
                  >
                    <input type="checkbox" v-model="thuocTinh.batBuoc"/>
                    <span></span>
                  </label>
                  <p class="mt-3">(Khi chọn bắt buộc, thuộc tính không được thay đổi khi thêm sản phẩm)</p>
                </div>
              </div>
              <hr>
            </div>
          </div>
          <div class="col-2 col-sm-2">
            <button type="button" class="btn btn-outline-primary" @click="addAttribute">
              <span class="them_thuoc_tinh svg-icon svg-icon-primary svg-icon-1x">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                  </g>
                </svg>
              </span>
              Thêm thuộc tính
            </button>
          </div>
          <div class="col-10 col-sm-10">
            &nbsp;
          </div>
        </div>
        <div class="col-1 col-sm-1">
          &nbsp;
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row justify-content-end">
        <button type="submit" class="btn btn-outline-primary" @click="storeAttributeGroup">
                    <span v-if="loadingStoreNhomThuocTinh" class="spinner-border spinner-border-sm mr-2" role="status"
                          aria-hidden="true"></span>
          Tạo mới
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
@import "~vuetify/dist/vuetify.min.css";
.xoa_gia_tri {
  cursor: pointer;
  z-index: 100;
  position: absolute;
  top: 25%;
  right: -3%;
}
hr {
  height: 3px;
  width: 100%;
}
.input_value {
  font-size: 1rem !important;
}
</style>

<script>
import {SET_BREADCRUMB, SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import AttributeGroup from "@/models/attribute-group/attribute-group";
import Swal from "sweetalert2";
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

export default {
  data() {
    return {
      itemPerPage: 10,
      currentPage: 1,
      totalPage: 1,
      validateErrors: {
        "ma_nhom": '',
        "ten_nhom": '',
        "loai_san_pham": '',
        "danh_sach_thuoc_tinh.0.ma_thuoc_tinh": '',
        "danh_sach_thuoc_tinh.0.ten_thuoc_tinh": '',
        "danh_sach_thuoc_tinh.0.loai_thuoc_tinh": '',
        "danh_sach_thuoc_tinh.0.gia_tri.0": '',
      },
      loadingStoreNhomThuocTinh: false,
      loadingLoaiSanPham: true,
      maNhomThuocTinh: '',
      tenNhomThuocTinh: '',
      listLoaiSanPham: [],
      listSelectedLoaiSanPham: [],
      listLoaiThuocTinh: [
        {id: '', label: ''}
      ],
      listThuocTinh: [
        {
          maThuocTinh: '',
          tenThuocTinh: '',
          loaiThuocTinh: null,
          listGiaTriThuocTinh: [
            { value: '' },
          ],
          macDinh: false,
          batBuoc: false,
        }
      ],
      showDatePicker: false
    };
  },
  components: {
    Treeselect
  },
  watch: {
  },
  beforeCreate() {
    let attributeGroupInfo = new AttributeGroup();
    attributeGroupInfo.getCreateInfo()
      .then((response) => {
        this.loadingLoaiSanPham = false;
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
        this.listLoaiSanPham = response.data.product_catalog.map(productCatalog => {
          return {
            id: productCatalog.id,
            label: productCatalog.product_catalog_name
          }
        });
        this.listLoaiThuocTinh = response.data.attribute_type.map(attributeType => {
          return {
            id: attributeType.id,
            label: attributeType.attribute_name
          }
        });
      })
      .catch(error => {
        this.loadingLoaiSanPham = false;
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
      {title: "Quản lý nhóm thuộc tính", route: "account.attribute-group.create"}
    ]);
  },
  methods: {
    storeAttributeGroup() {
      this.loadingStoreNhomThuocTinh = true;
      let danhSachThuocTinh = this.listThuocTinh.map(thuocTinh => {
        return {
          attribute_cd: thuocTinh.maThuocTinh,
          attribute_display_name: thuocTinh.tenThuocTinh,
          attribute_type_id: thuocTinh.loaiThuocTinh,
          is_default: thuocTinh.macDinh,
          is_require: thuocTinh.batBuoc,
          value: thuocTinh.listGiaTriThuocTinh.map(giaTri => { return giaTri.value }),
        }
      });
      let newAttributeGroupData = {
        attribute_group_cd: this.maNhomThuocTinh,
        attribute_group_name: this.tenNhomThuocTinh,
        product_catalog_id: this.listSelectedLoaiSanPham,
        product_attribute_list: danhSachThuocTinh,
      };
      let attributeGroupInfo = new AttributeGroup();
      attributeGroupInfo.storeNewAttributeGroup(newAttributeGroupData)
        .then(response => {
          this.loadingStoreNhomThuocTinh = false;
          if (response.success) {
            this.$emit('NhomThuocTinhAdded');
            Swal.fire(
              'Thành công!',
              'Đã thêm mới nhóm thuộc tính thành công',
              'success'
            ).then(confirm => {
              if (!confirm) {
                  this.$router.push({name: 'account.attribute-group'});
              }
              this.$router.push({name: 'account.attribute-group'});
            });
          }
        })
        .catch(error => {
          this.loadingStoreNhomThuocTinh = false;
          let response = error.response.data;
          if (response.errors.code == "E000003") {
            let validateErrors = response.data;
            for (let [key, value] of Object.entries(validateErrors)) {
              this.validateErrors[key] = value[0];
            }
            Swal.fire(
              'Không thành công!',
              'Đã xảy ra lỗi, vui lòng kiểm tra lại',
              'error'
            );
          } else {
            this.$emit('NhomThuocTinhAddedFail');
            Swal.fire(
              'Không thành công!',
              'Đã xảy ra lỗi, vui lòng liên hệ admin',
              'error'
            )
          }
        })
    },
    addValue(indexValue) {
      this.listThuocTinh[indexValue].listGiaTriThuocTinh.push(
        {
          value: ''
        }
      );
    },
    deleteValue(indexAttribute, indexValue) {
      this.listThuocTinh[indexAttribute].listGiaTriThuocTinh.splice(indexValue, 1);
    },
    addAttribute() {
      this.listThuocTinh.push(
        {
          maThuocTinh: '',
          tenThuocTinh: '',
          loaiThuocTinh: null,
          listGiaTriThuocTinh: [
            { value: '' },
          ],
          macDinh: false,
          batBuoc: false,
        }
      );
    },
    formatDate(date) {
      if (!date) return ""
      const [year, month, day] = date.split('-')
      return `${month}/${day}/${year}`
    }
  }
};
</script>
