<template>
    <b-modal
            title="Thêm mới loại sản phẩm"
            size="lg"
            name="addCatalog"
            id="addCatalog"
            @keydown.esc="clearModal"
            @click.left="clearModal"
    >
        <div class="card-body">
            <div class="select-tree">
                <div class="mb-15">
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-form-label">Loại sản phẩm cha</label>
                        <div class="col-lg-8 col-md-8">
                            <treeselect
                                    v-model="catalog.parent_id"
                                    :options="converSelectActive"
                                    :searchable="true"
                                    :show-count="true"
                                    :default-expand-level="10"
                                    placeholder="Loại sản phẩm cha"
                            />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-form-label">Tên loại sản phẩm<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text"  v-model="catalog.product_catalog_name" class="form-control"  placeholder="Tên loại sản phẩm">
                            <p class="text-danger" v-if="validation.product_catalog_name && validation.product_catalog_name !== 'undefined'">{{ validation.product_catalog_name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-form-label">Mã loại sản phẩm<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text"  v-model="catalog.product_cd_prefix" class="form-control" placeholder="Mã loại sản phẩm">
                            <p class="text-danger" v-if="validation.product_cd_prefix && validation.product_cd_prefix !== 'undefined'">{{ validation.product_cd_prefix }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-md-3 col-form-label require">Tổ chức được bán<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <treeselect
                                    v-model="catalog.store_id"
                                    :multiple="true"
                                    :flat="true"
                                    :options="converSelectStore"
                                    :searchable="true"
                                    :show-count="true"
                                    :default-expand-level="10"
                                    placeholder="Chọn Tổ chức được bán"
                            />
                            <p class="text-danger" v-if="validation.store_id && validation.store_id !== 'undefined'">{{ validation.store_id }}</p>
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
                        <label class="col-lg-3 col-md-3 col-form-label">Ghi chú</label>
                        <div class="col-lg-8 col-md-8">
                            <textarea class="form-control"  cols="100" rows="3"  v-model="catalog.note"></textarea>
                        </div>
                    </div>
                </div>
                <!--begin: Code-->
            </div>
        </div>
        <!--end: Code-->
        <div slot="modal-footer">
            <button type="button"
                    class="btn btn-secondary"
                    @click="$bvModal.hide('addCatalog')"
                    data-dismiss="modal"
            >
                Hủy bỏ
            </button>
            <button type="submit" @click="saveCatalog" class="btn btn-primary" v-if="!loadingAjax">Lưu</button>
            <button type="button" class="btn mr-3 btn-primary active" v-else>
                <span>Loading...</span>
            </button>
        </div>
    </b-modal>
</template>

<script>
    import Swal from "sweetalert2";
    import  Treeselect  from  '@riophae/vue-treeselect';
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';
    export default {
        props: ['catalogsModel','items','converSelectActive','converSelectStore'],
        data() {
            return {
                catalog:{},
                loading:false,
                loadingAjax:false,
                validation: {
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
                this.catalog.parent_id = this.items.id;
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
            saveCatalog() {
                this.loadingAjax = true;
                this.removeError();
                this.catalogsModel.store(this.catalog).then((response) => {
                    if (response.status_code === 201) {
                        Swal.fire(
                            'Thành công!',
                            'Thêm loại sản phẩm thành công!',
                            'success'
                        );
                        //Gọi sự kiện đổ lại danh sách tổ chức
                        this.$emit('refreshCatalog');
                        this.$bvModal.hide('addCatalog');
                        this.clearModal();
                        this.loadingAjax = false;
                    }
                }).catch((error) => {
                    let response = error.response.data;
                    if (response.status_code === 422 && response.errors.code === 'E000003') {
                        this.loadingAjax = false;
                        Swal.fire(
                            'Thất bại!',
                            'Thêm loại sản phẩm không thành công!',
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
        }
    };
</script>