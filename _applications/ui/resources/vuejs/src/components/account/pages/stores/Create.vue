<template>
    <b-modal
            title="Thêm mới tổ chức"
            size="lg"
            name="addStores"
            id="addStores"
            @keydown.esc="clearModal"
            @click.left="clearModal"
    >
        <div class="card-body">
            <div class="select-tree">
                <div class="mb-15">
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">Đơn vị trực thuộc<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" disabled="disabled"  v-model="items.store_name" class="form-control" placeholder="Đơn vị trực thuộc">
                            <p class="text-danger" v-show="validation.parent_id && validation.parent_id !== 'undefined'">{{ validation.parent_id }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">Tên tổ chức<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text"  v-model="stores.store_name" class="form-control"  placeholder="Tên tổ chức">
                            <p class="text-danger" v-show="validation.store_name && validation.store_name !== 'undefined'">{{ validation.store_name }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">Mã tổ chức<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text"  v-model="stores.store_cd" class="form-control" placeholder="Mã tổ chức">
                            <p class="text-danger" v-show="validation.store_cd && validation.store_cd !== 'undefined'">{{ validation.store_cd }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">SĐT hotline<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text"  v-model="stores.hotline" class="form-control" placeholder="SDT hotline">
                            <p class="text-danger" v-show="validation.hotline && validation.hotline !== 'undefined'">{{ validation.hotline }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">Chọn địa chỉ chi tiết<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <input type="text" v-model="stores.address" class="form-control" placeholder="Chọn địa chỉ chi tiết">
                            <p class="text-danger" v-show="validation.address && validation.address !== 'undefined'">{{ validation.address }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">Chọn Thành phố/tỉnh<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <treeselect
                                    :options="optionsProvince"
                                    :searchable="true"
                                    placeholder="Chọn Thành phố/tỉnh"
                                    v-model="stores.province_id"
                                    @select="onChangeProvince($event)"
                            />
                            <p class="text-danger" v-show="validation.province_id && validation.province_id !== 'undefined'">{{ validation.province_id }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">Chọn Quận/huyện<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <treeselect
                                    :options="optionsDistrict"
                                    :searchable="true"
                                    placeholder="Chọn Quận/huyện"
                                    v-model="stores.district_id"
                                    @select="onChangeDistrict($event)"
                            />
                            <p class="text-danger" v-show="validation.district_id && validation.district_id !== 'undefined'">{{ validation.district_id }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 col-md-4 col-form-label">Chọn Phường/Xã<span class="text-danger">*</span></label>
                        <div class="col-lg-8 col-md-8">
                            <treeselect
                                    :options="optionsWard"
                                    :searchable="true"
                                    placeholder="Chọn Phường/Xã"
                                    v-model="stores.ward_id"
                            />
                            <p class="text-danger" v-show="validation.ward_id && validation.ward_id !== 'undefined'">{{ validation.ward_id }}</p>
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
                    @click="$bvModal.hide('addStores')"
                    data-dismiss="modal"
            >
                Hủy bỏ
            </button>
            <button type="submit" @click="saveStores" class="btn btn-primary" v-if="!loadingAjax">Lưu</button>
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
    import Districts from "../../../../models/master/districts/districts";
    import Wards from "../../../../models/master/wards/wards";
    export default {
        props: ['storesModel','items','province'],
        data() {
            return {
                stores: {
                },
                disabled: false,
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
                loadingAjax:false,
                districtModel: new Districts(),
                wardModel : new Wards(),
                validation: {
                    parent_id: '',
                    store_name: '',
                    store_cd:'',
                    province_id:'',
                    district_id:'',
                    ward_id:'',
                    hotline:'',
                    address:'',
                    active_status:''
                },
            }
        },
        watch: {
            //theo dõi sự thay đổi của biến
            province:function(){
                this.address.province = this.province
            },
            items:function(){
                this.stores.parent_id = this.items.id;
                this.stores.active_status = 'active';
            }

        },
        components: {
            Treeselect
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
        methods: {
            //Sự kiện thay đổi tỉnh để lấy huyện tương ứng
            onChangeProvince(event){
                this.address.district =[{
                    id:'',
                    label:'Chọn Quận/huyện'
                }];
                this.items.district_id = null;
                this.items.ward_id = null;
                this.districtModel.districts({'province_id': event.id }).then((response) => {
                    this.address.district = response
                }).catch(error => console.log(error));
            },
            //Sự kiện thay đổi huyện để lấy xã tương ứng
            onChangeDistrict(event){
                this.address.ward = [{
                    id:'',
                    label:'Chọn Phường/Xã'
                }];
                this.items.ward_id = null;
                this.wardModel.wards({'district_id': event.id }).then((response) => {
                    this.address.ward = response
                }).catch(error => console.log(error));
            },
            //Xóa những validation bắt buộc
            removeError(){
                this.validation = {
                    parent_id: '',
                    store_name: '',
                    store_cd:'',
                    province_id:'',
                    district_id:'',
                    ward_id:'',
                    hotline:'',
                    address:'',
                    active_status:''
                };
            },
            saveStores(){
                this.removeError();
                this.loadingAjax = true;
                this.storesModel.store(this.stores).then((response) => {
                    if (response.status_code === 201) {
                        Swal.fire(
                            'Thành công!',
                            'Thêm tổ chức thành công!',
                            'success'
                        );
                        //Gọi sự kiện đổ lại danh sách tổ chức
                        this.$emit('refreshStores');
                        this.$bvModal.hide('addStores');
                        this.clearModal();
                        this.loadingAjax = false;
                    }
                }).catch((error) => {
                    let response = error.response.data;
                    if (response.status_code === 422 && response.errors.code === 'E000003') {
                        this.loadingAjax = false;
                        Swal.fire(
                            'Thất bại!',
                            'Cập nhật tổ chức không thành công!',
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
            //Xóa form modal
            clearModal() {
                this.stores = {};
                this.validation = [];
            }
        }
    };
</script>