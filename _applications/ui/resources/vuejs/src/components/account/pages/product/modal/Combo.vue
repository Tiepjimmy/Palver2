<template>
  <b-modal
    title="Nhập dữ liệu sản phẩm combo"
    size="md"
    id="modal_import_product_combo"
    hide-footer
  >
    <div class="px-5">
        <p class="text-danger">Chú ý: </p>
        <div class="m-sm-5">
            <p>- Mã sản phẩm phải là duy nhất</p>
            <p>- Chuyển đổi file nhập dưới dạng .XLS trước khi nhập file dữ liệu</p>
            <p>
                - Tải file mẫu sản phẩm 
                <a v-if="currentOwnerShop" href="/download/template-combo">tại đây</a>
                <a v-else href="/download/template-combo-branch">tại đây</a>
            </p>
            <p>File nhập có dung lượng tối đa là 3MB và 7000 bản ghi</p>
            <b-form-file type="file" 
                v-model="input.fileImport" 
                browse-text='Tải exel lên'>
            </b-form-file>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary" @click="handleSave" v-if="!page.loadingAjax">
                <span class="indicator-label">Nhập file</span>
            </button>
            <button class="btn btn-sm btn-primary mt-5" v-else>
                <div class="spinner-border" role="status" style="height: 1.5rem;width: 1.5rem;">
                    <span class="sr-only">Loading...</span>
                </div>
            </button>
        </div>
    </div>
  </b-modal>
</template>

<script>
import Swal from "sweetalert2";
import axios from "axios";

export default {
    data() {
        return {
            page: {
                loadingAjax: false
            },
            input: {
                type: 'combo',
                fileImport: null
            }
        }
    },
    props: {
        currentOwnerShop: Boolean
    },
    methods: {
        handleSave() {
            let _that = this;
            let formData = new FormData();
            this.page.loadingAjax = true;
            formData.append('fileImport', this.input.fileImport);
            formData.append('type', this.input.type);
            axios.post("/import-product",
            formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response){
                _that.page.loadingAjax = false;
                if (response.data.status_code == 200) {
                    Swal.fire(
                        'Thành công!',
                        'Đã tạo mới sản phẩm thành công',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            // _that.$emit('refeshPage');
                        } else if (result.isDenied) {
                            // _that.$emit('refeshPage');
                        }
                    });
                } else {
                    if (response.data.status_code == 422) {
                        Swal.fire(
                            'Thất bại!',
                            response.data.errors.error[0],
                            'error'
                        )
                    } else {
                        Swal.fire(
                            'Thất bại!',
                            'Đã xảy ra lỗi, vui lòng liên hệ admin',
                            'error'
                        )
                    }
                }
            }).catch(function(_ref){
                _that.page.loadingAjax = false;
                let response = _ref.response.data;
                if (response.errors) {
                    Swal.fire(
                        'Thất bại!',
                        'Vui lòng điền đúng thông tin',
                        'error'
                    )
                } else {
                    Swal.fire(
                        'Thất bại!',
                        'Đã xảy ra lỗi, vui lòng liên hệ admin',
                        'error'
                    )
                }
            });
        },
    }
};
</script>
