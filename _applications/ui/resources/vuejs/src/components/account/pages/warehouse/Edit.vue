<template>
    <b-modal
            title="Cập nhật kho"
            size="lg"
            name="editWarehouse"
            id="editWarehouse"
            @keydown.esc="clearModal"
            @click.left="clearModal"
    >
        <div class="card-body">
            <div style="display: flex;align-items: center;justify-content: center; text-align:center" v-if="!loading">
                <div class="spinner-border mt-5 mb-5" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="select-tree" v-if="loading">
                <div class="mb-15">
                    <div class="row g-9">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Loại kho<span class="text-danger">*</span></label>
                            <treeselect
                                    :options="selectProductType"
                                    :searchable="true"
                                    placeholder="Chọn loại kho"
                                    v-model="warehouse.warehouse_type_id"
                            />
                            <p class="text-danger" v-if="validation.warehouse_type_id && validation.warehouse_type_id !== 'undefined'">{{ validation.warehouse_type_id }}</p>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Thành Phố/tỉnh<span class="text-danger">*</span></label>
                            <treeselect
                                    :options="selectProvince"
                                    :searchable="true"
                                    placeholder="Chọn Thành phố/tỉnh"
                                    v-model="warehouse.province_id"
                                    @select="onChangeProvince($event)"
                            />
                            <p class="text-danger" v-if="validation.province_id && validation.province_id !== 'undefined'">{{ validation.province_id }}</p>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row g-9">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Tên kho<span class="text-danger">*</span></label>
                            <input type="text" autocomplete="off" class="form-control" v-model="warehouse.warehouse_name" placeholder="Tên kho" />
                            <p class="text-danger" v-if="validation.warehouse_name && validation.warehouse_name !== 'undefined'">{{ validation.warehouse_name }}</p>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Quận/huyện<span class="text-danger">*</span></label>
                            <treeselect
                                    :options="optionsDistrict"
                                    :searchable="true"
                                    placeholder="Chọn Quận/huyện"
                                    v-model="warehouse.district_id"
                                    @select="onChangeDistrict($event)"
                            />
                            <p class="text-danger" v-if="validation.district_id && validation.district_id !== 'undefined'">{{ validation.district_id }}</p>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row g-9">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Mã kho<span class="text-danger">*</span></label>
                            <input type="text" autocomplete="off" class="form-control" v-model="warehouse.warehouse_cd" placeholder="Mã kho" />
                            <p class="text-danger" v-if="validation.warehouse_cd && validation.warehouse_cd !== 'undefined'">{{ validation.warehouse_cd }}</p>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Phường/Xã<span class="text-danger">*</span></label>
                            <treeselect
                                    :options="optionsWard"
                                    :searchable="true"
                                    placeholder="Chọn Phường/Xã"
                                    v-model="warehouse.ward_id"
                            />
                            <p class="text-danger" v-if="validation.ward_id && validation.ward_id !== 'undefined'">{{ validation.ward_id }}</p>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row g-9">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Tổ chức đăng ký</label>
                            <treeselect
                                    :options="selectStore"
                                    :multiple="true"
                                    :flat="true"
                                    :show-count="true"
                                    :searchable="true"
                                    :default-expand-level="10"
                                    placeholder="Chọn tổ chức"
                                    v-model="warehouse.store_id"
                            />
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">SĐT hotline<span class="text-danger">*</span></label>
                            <input type="text" autocomplete="off" class="form-control" v-model="warehouse.hotline" placeholder="SĐT hotline" />
                            <p class="text-danger" v-if="validation.hotline && validation.hotline !== 'undefined'">{{ validation.hotline }}</p>
                        </div>

                        <!--end::Col-->
                    </div>
                    <div class="row g-9">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2"> Địa chỉ chi tiết<span class="text-danger">*</span></label>
                            <textarea class="form-control"  cols="100" rows="3"  v-model="warehouse.address"></textarea>
                            <p class="text-danger" v-show="validation.address && validation.address !== 'undefined'">{{ validation.address }}</p>
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Nội dung</label>
                            <textarea class="form-control"  cols="100" rows="3"  v-model="warehouse.note"></textarea>
                            <p class="text-danger" v-if="validation.note && validation.note !== 'undefined'">{{ validation.note }}</p>
                        </div>
                        <!--end::Col-->
                    </div>
                    <div class="row g-9">
                        <!--begin::Col-->
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-bold mb-2">Trạng thái</label>
                            <treeselect
                                    :options="selectStatus"
                                    placeholder="Chọn trạng thái"
                                    v-model="warehouse.active_status"
                            />
                            <p class="text-danger" v-show="validation.active_status && validation.active_status !== 'undefined'">{{ validation.active_status }}</p>
                        </div>
                        <!--end::Col-->
                    </div>
                </div>
                <!--begin: Code-->
            </div>
        </div>
        <!--end: Code-->
        <div slot="modal-footer">
            <button type="button"
                    class="btn btn-secondary"
                    @click="$bvModal.hide('editWarehouse')"
                    data-dismiss="modal"
            >
                Hủy bỏ
            </button>
            <button type="submit" @click="updateWarehouse" class="btn btn-primary" v-if="!loadingAjax">Lưu</button>
            <button type="button" class="btn mr-3 btn-primary active" v-else>
                <span>Loading...</span>
            </button>
        </div>
    </b-modal>
</template>

<script>
    import Swal from "sweetalert2";
    import '@riophae/vue-treeselect/dist/vue-treeselect.css';
    import Districts from "../../../../models/master/districts/districts";
    import Wards from "../../../../models/master/wards/wards";
    import  Treeselect  from  '@riophae/vue-treeselect';
    import Warehouse from "../../../../models/warehouse/warehouse";
    export default {
        props: ['items','selectProvince','selectProductType','selectStore'],
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
                warehouse:{},
                address:{
                    province:[{
                        id:'',
                        label:'Chọn Thành phố/tỉnh'
                    }],
                    district:[{
                        id:'',
                        label:'Chọn Quận/huyện'
                    }],
                    ward:[{
                        id:'',
                        label:'Chọn Phường/Xã'
                    }]
                },
                districtModel:new Districts(),
                warehouseModel:new Warehouse(),
                wardModel:new Wards(),
                validation : {
                    warehouse_type_id: '',
                    province_id:'',
                    district_id:'',
                    ward_id:'',
                    note:'',
                    address:'',
                    hotline:'',
                    warehouse_name:'',
                    store_id:'',
                    warehouse_cd:''
                },
                loading:false,
                loadingAjax:false,
            }
        },
        watch: {
            items:function(){
                this.loading = false;
                this.$bvModal.show('editWarehouse');
                this.warehouseModel.show(this.items).then((response) => {
                        this.warehouse = response;
                        this.warehouse.store_id = [];
                        if (this.warehouse.warehouse_stores.length > 0) {
                            Array.from(this.warehouse.warehouse_stores).forEach((value,index) => {
                                this.warehouse.store_id.push(value.id);
                            });
                        }
                        if (this.warehouse.province_id > 0) {
                            this.districtModel.districts({'province_id': this.warehouse.province_id }).then((response) => {
                                this.address.district = response;
                            }).catch(error => console.log(error));
                            this.wardModel.wards({'district_id': this.warehouse.district_id }).then((response) => {
                                this.address.ward = response;
                                this.loading = true;
                            }).catch(error => console.log(error));
                        }
                    })
            }
        },
        computed:{
            optionsProvince: function () {
                return this.address.province.map(val => {
                    return {
                        id:val.id,
                        label: val.province_name,
                    }
                });
            },
            optionsDistrict: function () {
                return this.address.district.map(val => {
                    return {
                        id:val.id,
                        label: val.district_name,
                    }
                });
            },
            optionsWard: function () {
                return this.address.ward.map(val => {
                    return {
                        id:val.id,
                        label: val.ward_name,
                    }
                });
            },
        },
        components: { Treeselect },
        methods: {
            //Sự kiện thay đổi tỉnh để lấy huyện tương ứng
            onChangeProvince(event){
                this.address.district =[{
                    id:'',
                    label:'Chọn Quận/huyện'
                }];
                this.warehouse.district_id = null;
                this.warehouse.ward_id = null;
                this.districtModel.districts({'province_id': event.id }).then((response) => {
                    this.address.district = response;
                }).catch(error => console.log(error));
            },
            //Sự kiện thay đổi huyện để lấy xã tương ứng
            onChangeDistrict(event){
                this.address.ward = [{
                    id:'',
                    label:'Chọn Phường/Xã'
                }];
                this.warehouse.ward_id = null;
                this.wardModel.wards({'district_id': event.id }).then((response) => {
                    this.address.ward = response
                }).catch(error => console.log(error));
            },
            removeError(){
                this.validation = {
                    warehouse_type_id: '',
                    province_id:'',
                    district_id:'',
                    ward_id:'',
                    note:'',
                    address:'',
                    hotline:'',
                    warehouse_name:'',
                    store_id:'',
                    warehouse_cd:''
                };
            },
            updateWarehouse(){
                this.removeError();
                this.loadingAjax = true;
                this.warehouseModel.updateWarehouse(this.warehouse.id,this.warehouse).then((response) => {
                    if (response.status_code === 201) {
                        this.loadingAjax = false;
                        Swal.fire(
                            'Thành công!',
                            'Cập nhật kho thành công!',
                            'success'
                        );
                        this.clearModal();
                        this.$bvModal.hide('editWarehouse');
                        this.$emit('refreshWarehouse');
                    }
                }).catch((error) =>{
                    let response = error.response.data;
                    if (response.status_code === 422 && response.errors.code === 'E000003') {
                        this.loadingAjax = false;
                        Swal.fire(
                            'Thất bại!',
                            'Cập nhật kho không thành công!',
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
                        Swal.fire(
                            "Lỗi!",
                            "Có lỗi phát sinh vui lòng liên hệ admin",
                            "error",
                        )
                        // window.location.reload();
                        return false;

                    }
                });
            },
            clearModal() {
                this.warehouse = {};
                this.validation = [];
            }
        }
    };
</script>