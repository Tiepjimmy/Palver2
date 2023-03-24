<template>
    <div id="editToChuc">
        <!--begin::Form-->
        <div style="display: flex;align-items: center;justify-content: center; text-align:center" v-if="!loading">
            <div class="spinner-border mt-5 mb-5" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <form class="form" @submit.prevent="checkIsActiveCatalog" v-if="loading" >
            <div class="card-body">
                <div class="select-tree">
                    <div class="mb-15">
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">Loại sản phẩm cha</label>
                            <div class="col-lg-8 col-md-8">
                                <treeselect
                                        v-model="items.parent_id"
                                        :options="converSelect"
                                        :searchable="true"
                                        :show-count="true"
                                        :default-expand-level="10"
                                        placeholder="Loại sản phẩm cha"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">Tên loại sản phẩm<span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8">
                                <input type="text"  v-model="items.product_catalog_name" class="form-control"  placeholder="Tên loại sản phẩm">
                                <p class="text-danger" v-show="validation.product_catalog_name && validation.product_catalog_name !== 'undefined'">{{ validation.product_catalog_name }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">Mã loại sản phẩm<span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8">
                                <input type="text"  v-model="items.product_cd_prefix" class="form-control" placeholder="Mã loại sản phẩm">
                                <p class="text-danger" v-show="validation.product_cd_prefix && validation.product_cd_prefix !== 'undefined'">{{ validation.product_cd_prefix }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">Tổ chức được bán<span class="text-danger">*</span></label>
                            <div class="col-lg-7 col-md-7">
                                <treeselect
                                        v-model="items.store_id"
                                        :multiple="true"
                                        :flat="true"
                                        :options="converSelectStore"
                                        :searchable="true"
                                        :show-count="true"
                                        :default-expand-level="10"
                                        placeholder="Chọn Tổ chức được bán"
                                />
                                <p class="text-danger" v-show="validation.store_id && validation.store_id !== 'undefined'">{{ validation.store_id }}</p>
                            </div>
                            <div class="col-lg-1 col-md-1 mt-3">
                                <v-tooltip top :open-on-hover="false" :open-on-click="true">
                                    <template v-slot:activator="{ on }">
                                        <span class="svg-icon svg-icon-3 cursor-pointer" @click="on.click" >
                                            <i class="fas fa-exclamation"></i>
                                        </span>
                                    </template>
                                    <span>Tổ chức được chọn sẽ được bán loại sản phẩm tương ứng.</span>
                                </v-tooltip>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">Ghi chú</label>
                            <div class="col-lg-8 col-md-8">
                                <textarea class="form-control"  cols="100" rows="3"  v-model="items.note"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-md-4 col-form-label">Trạng thái<span class="text-danger">*</span></label>
                            <div class="col-lg-8 col-md-8">
                                <treeselect
                                        :options="selectStatus"
                                        placeholder="Chọn trạng thái"
                                        v-model="items.active_status"
                                />
                                <p class="text-danger" v-show="validation.active_status && validation.active_status !== 'undefined'">{{ validation.active_status }}</p>
                            </div>
                        </div>
                        <div class="form-group row text-left">
                            <label class="col-lg-4 col-md-4 col-form-label"></label>
                            <div class="col-lg-8 col-md-8">
                                <b-button v-b-modal.addCatalog  variant="primary">Thêm mới</b-button>
                                <button type="submit" class="btn mr-3 btn-primary active" v-if="!loadingAjax">Lưu</button>
                                <button type="button" class="btn mr-3 btn-primary active" v-else>
                                    <span>Loading...</span>
                                </button>
                            </div>
                        </div>

                    </div>
                    <!--begin: Code-->
                </div>
                <!--end: Code-->
            </div>
        </form>
        <!--end::Form-->
    </div>
</template>
<script>
    import Swal from "sweetalert2";
    import  Treeselect  from  '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';
    export default {
        props: ['catalogsModel','items','converSelect','converSelectStore'],
        data() {
            return {
                selectStatus:[
                    {
                        id:'active',
                        label:'Active'
                    },
                    {
                        id:'inactive',
                        label:'Inactive'
                    },
                ],

                loading:false,
                loadingAjax:false,
                validation: {
                    parent_id: '',
                    product_catalog_cd: '',
                    product_catalog_name:'',
                    note:'',
                    product_cd_prefix:'',
                    active_status:'',
                    store_id:'',
                },

            }
        },
        components: {
            Treeselect
        },
        created() {


        },
        watch: {
            //theo dõi sự thay đổi của biến
            items:function() {
                this.loading = false;
                this.items.store_id = [];
                if (typeof  this.items.stores !== 'undefined') {
                    Array.from(this.items.stores).forEach((value,index) => {
                        this.items.store_id.push(value.id);
                    });
                    this.loading = true;
                }
            }
        },
        computed: {

        },
        methods: {
            removeError(){
                this.validation = {
                    parent_id: '',
                    product_catalog_cd: '',
                    product_catalog_name:'',
                    note:'',
                    product_cd_prefix:'',
                    active_status:'',
                    store_id:'',
                };
            },
            //Cập nhật lại tổ chức
            updateCatalog() {
                this.loadingAjax = true;
                this.removeError();
                this.catalogsModel.updateCatalog(this.items.id,this.items).then((response) => {
                    if (response.status_code === 201) {
                        Swal.fire(
                            'Thành công!',
                            'Cập nhật loại sản phẩm thành công!',
                            'success'
                        );
                        //Gọi sự kiện đổ lại danh sách tổ chức
                        this.$emit('refreshCatalog');
                        this.loadingAjax = false;
                    }
                }).catch((error) => {
                    let response = error.response.data;
                    if (response.status_code === 422 && response.errors.code === 'E000003') {
                        this.loadingAjax = false;
                        Swal.fire(
                            'Thất bại!',
                            'Cập nhật loại sản phẩm không thành công!',
                            'error'
                        );
                        Object.entries(response.data).forEach(([key, val]) => {
                            this.validation[key] = val[0];
                        });
                        return false;
                    } else if (response.status_code === 422) {
                        this.loadingAjax = false;
                        Swal.fire(
                            "Lỗi!",
                            response.errors.message,
                            "error",
                        );
                        return false;

                    } else {
                        this.loadingAjax = false;
                        Swal.fire(
                            "Lỗi!",
                            "Có lỗi phát sinh vui lòng liên hệ admin!",
                            "error",
                        )
                        window.location.reload();
                        return false;

                    }
                });

            },
            //Check trạng thái inactive và bắn noti cho khách hàng
            checkIsActiveCatalog(e){
                e.preventDefault();
                var _this = this;
                if (this.items.active_status === 'inactive') {
                    Swal.fire({
                        text: "Bạn chắc chắn muốn inactive loại sản phẩm này?",
                        icon: "warning",
                        confirmButtonText: "Đồng ý",
                        showCancelButton: true,
                        cancelButtonText: "Hủy bỏ",
                    }).then(function(result) {
                        if (result.value) {
                            //Gọi sự kiện cập nhật lại tổ  chức
                            _this.updateCatalog();
                        }
                        return false;

                    });
                    return false;
                }
                //Gọi sự kiện cập nhật lại tổ  chức
                _this.updateCatalog();

            },
        }
    };
</script>