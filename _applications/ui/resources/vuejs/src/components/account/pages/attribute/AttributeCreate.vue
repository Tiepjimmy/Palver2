<template>
  <b-modal
    title="Thêm mới thuộc tính"
    size="xl"
    name="createThuocTinh"
    id="createThuocTinh"
    @hide="clearModal"
  >
    
    <div class="px-5">
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
                   v-model="maThuocTinh"/>
            <p v-if="validateErrors.attribute_cd" class="text-danger">{{ validateErrors.attribute_cd }}</p>
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
                   v-model="tenThuocTinh"/>
            <p v-if="validateErrors.attribute_display_name" class="text-danger">{{ validateErrors.attribute_display_name }}</p>
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
              v-model="loaiThuocTinh"
            />
            <p v-if="validateErrors.attribute_type_id" class="text-danger">{{ validateErrors.attribute_type_id }}</p>
          </div>
        </div>
        <div class="col-12"
             v-for="(giaTri, indexGiaTri) in listGiaTriThuocTinh"
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
                  v-if="loaiThuocTinh == '2'"
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
                  v-else-if="loaiThuocTinh == '4'"
                  v-model="giaTri.value"
                  type="number"
                ></v-text-field>
                <v-text-field
                  class="input_value"
                  v-else
                  v-model="giaTri.value"
                ></v-text-field>
                <p v-if="validateErrors['value.' + indexGiaTri]" class="text-danger">{{ validateErrors['value.' + indexGiaTri] }}</p>
              </div>
            </div>
            <span v-if="loaiThuocTinh == '1'" @click="deleteAttributeValue(indexGiaTri)" class="xoa_gia_tri svg-icon svg-icon-primary svg-icon-2x pt-5">
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
        <div v-if="loaiThuocTinh == '1'" class="col-2 col-sm-2">
          <button type="button" class="btn btn-outline-primary" @click="addAttributeValue">
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
        <div v-if="loaiThuocTinh == '1'" class="col-10 col-sm-10">
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
              <input type="checkbox" v-model="macDinh"/>
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
              <input type="checkbox" v-model="batBuoc"/>
              <span></span>
            </label>
            <p class="mt-3">(Khi chọn bắt buộc, thuộc tính không được thay đổi khi thêm sản phẩm)</p>
          </div>
        </div>
        <hr>
      </div>
    </div>
    
    <div slot="modal-footer">
      <button type="button"
              class="btn btn-outline-secondary"
              @click="$bvModal.hide('createThuocTinh')"
              data-dismiss="modal"
      >
        Hủy bỏ
      </button>
      
      <button type="submit" class="btn btn-outline-primary" @click="storeAttribute">
        <span v-if="loadingStoreThuocTinh" class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
        Tạo mới
      </button>
    </div>
  </b-modal>
</template>

<style>
.form-group {
  margin-bottom: 0.3rem;
}
.xoa_gia_tri {
  cursor: pointer;
  z-index: 100;
  position: absolute;
  top: 18%;
  right: -2%;
}
.modal-backdrop {
  background-color: rgba(1,1,1,0.1) !important;
}
.modal {
  left: 130px;
}
.input_value {
  font-size: 1rem !important;
}
</style>

<script>
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import Treeselect from '@riophae/vue-treeselect'
import Swal from "sweetalert2";
import Attribute from "@/models/attribute/attribute";

export default {
  props: [
    'idNhomThuocTinh',
    'createInfo'
  ],
  data() {
    return {
      validateErrors: {
        "attribute_cd": '',
        "attribute_display_name": '',
        "attribute_type_id": '',
        "value.0": '',
      },
      loadingStoreThuocTinh: false,
      listLoaiThuocTinh: [],
      maThuocTinh: '',
      tenThuocTinh: '',
      loaiThuocTinh: null,
      listGiaTriThuocTinh: [
        { value: '' },
      ],
      macDinh: false,
      batBuoc: false,
      showDatePicker: false
    }
  },
  watch: {
    createInfo() {
      if (this.createInfo) {
        this.listLoaiThuocTinh = this.createInfo.attribute_type.map(attributeType => {
          return {
            id: attributeType.id,
            label: attributeType.attribute_name
          }
        });
      }
    }
  },
  computed: {
  },
  components: {
    Treeselect
  },
  beforeCreate() {
  },
  methods: {
    storeAttribute() {
      this.loadingStoreThuocTinh = true;
      let attribute = new Attribute();
      let newData = {
        attribute_group_id: this.idNhomThuocTinh,
        attribute_cd: this.maThuocTinh,
        attribute_display_name: this.tenThuocTinh,
        attribute_type_id: this.loaiThuocTinh,
        is_default: this.macDinh,
        is_require: this.batBuoc,
        value: this.listGiaTriThuocTinh.map(giaTri => { return giaTri.value })
      };
      attribute.storeNewAttribute(newData)
        .then(response => {
          this.loadingStoreThuocTinh = false;
          if (response.success) {
            this.$emit('thuocTinhAdded');
            Swal.fire(
              'Thành công!',
              'Đã thêm mới thuộc tính thành công',
              'success'
            );
          }
        })
        .catch(error => {
          this.loadingStoreThuocTinh = false;
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
            this.$emit('thuocTinhAddedFail');
            Swal.fire(
              'Không thành công!',
              'Đã xảy ra lỗi, vui lòng liên hệ admin',
              'error'
            )
          }
        })
    },
    addAttributeValue() {
      this.listGiaTriThuocTinh.push(
        {
          value: ''
        }
      );
    },
    deleteAttributeValue(indexAttributeValue) {
      this.listGiaTriThuocTinh.splice(indexAttributeValue, 1);
    },
    clearModal() {
      this.validateErrors = {
        "attribute_cd": '',
        "attribute_display_name": '',
        "attribute_type_id": '',
        "value.0": '',
      };
    },
    formatDate(date) {
      if (!date) return ""
      const [year, month, day] = date.split('-')
      return `${month}/${day}/${year}`
    }
  }
};
</script>
