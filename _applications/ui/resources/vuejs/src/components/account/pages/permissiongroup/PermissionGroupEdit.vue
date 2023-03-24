<template>
    <div>
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Tên nhóm quyền</label>
                        <input type="text" class="form-control" v-model="tenNhomQUyen">

                        <!-- Error -->
                        <p class="text-danger" v-show="errorsValidate.group_name">{{ errorsValidate.group_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label for="to_chuc">Chọn cơ cấu tổ chức</label>
                        <treeselect
                            v-if="loading"
                            :multiple="true"
                            :options="optionToChuc"
                            :flat="true"
                            :default-expand-level="2"
                            placeholder="Chọn cơ cấu tổ chức"
                            v-model="selectedToChuc"
                            @select="selectToChuc"
                            @deselect="deselectToChuc"
                        />

                        <!-- Error -->
                        <p class="text-danger" v-show="errorsValidate.store_id">{{ errorsValidate.store_id }}</p>

                        <!-- Loading -->
                        <div style="display: flex;align-items: center;justify-content: center;" v-if="!loading">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="">Trạng thái</label>
                        <select v-model="trangThai" class="form-control" v-if="loading">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <!-- Error -->
                        <p class="text-danger" v-show="errorsValidate.active_status">{{ errorsValidate.active_status }}</p>

                        <!-- Loading -->
                        <div style="display: flex;align-items: center;justify-content: center;" v-if="!loading">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body" v-if="loading">
                <div class="row">
                    <div class="col-xl-2 col-md-4 pt-6">Chọn quyền trong phân hệ: </div>
                    <div class="col-md-2">
                        <select class="form-control" v-model="selectedPhanHe">
                            <option v-for="phanHe in listPhanHe" :key="phanHe.id" :value="phanHe.id" >{{ phanHe.subsystem_name }}</option>
                        </select>
                    </div>

                    <!-- Error -->
                    <p class="text-danger" v-show="errorsValidate.subsystem_id">{{ errorsValidate.subsystem_id }}</p>
                </div>
                <div v-for="(phanHe, index) in listPhanHe" :key="index" v-show="selectedPhanHe == phanHe.id">
                    <div v-for="chucNang in phanHe.features" :key="chucNang.id" class="m-sm-5">
                        <div class="form-check">
                            <input type="checkbox" :id="'chuc-nang-' + chucNang.id" @change="selectAll($event, phanHe.id, chucNang.id)" :value="chucNang.id" v-model="selectedChucNang">
                            <label class="form-check-label" :for="'chuc-nang-' + chucNang.id">{{ chucNang.feature_name }}</label>
                        </div>
                        <div class="row m-sm-5">
                            <div v-for="quyen in chucNang.permissions" :key="quyen.id" class="col-md-4">
                                <span class="form-check" v-if="!pickedTongCty && quyen.private == 'yes'">
                                    <input v-if="phanHe.id == 1" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe1">
                                    <input v-if="phanHe.id == 2" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe2">
                                    <input v-if="phanHe.id == 3" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe3">
                                    <input v-if="phanHe.id == 4" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe4">
                                    <input v-if="phanHe.id == 5" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe5">
                                    <label class="form-check-label" :for="'quyen-' + quyen.id">{{ quyen.permission_name }}</label>
                                    <v-tooltip top :open-on-hover="false" :open-on-click="true" v-if="!!quyen.tooltip">
                                        <template v-slot:activator="{ on }">
                                            <span class="svg-icon svg-icon-3" @click="on.click" >
                                                <inline-svg src="media/svg/icons/Code/Question-circle.svg" />
                                            </span>
                                        </template>
                                        <span>{{ quyen.tooltip }}</span>
                                    </v-tooltip>
                                </span>
                                <span class="form-check" v-if="quyen.private == 'no'">
                                    <input v-if="phanHe.id == 1" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe1">
                                    <input v-if="phanHe.id == 2" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe2">
                                    <input v-if="phanHe.id == 3" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe3">
                                    <input v-if="phanHe.id == 4" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe4">
                                    <input v-if="phanHe.id == 5" :id="'quyen-' + quyen.id" type="checkbox" :value="quyen.id" v-model="selectedQuyen.phanHe5">
                                    <label class="form-check-label" :for="'quyen-' + quyen.id">{{ quyen.permission_name }}</label>
                                    <v-tooltip top :open-on-hover="false" :open-on-click="true" v-if="!!quyen.tooltip">
                                        <template v-slot:activator="{ on }">
                                            <span class="svg-icon svg-icon-3" @click="on.click" >
                                                <inline-svg src="media/svg/icons/Code/Question-circle.svg" />
                                            </span>
                                        </template>
                                        <span>{{ quyen.tooltip }}</span>
                                    </v-tooltip>
                                </span>
                                
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <!-- Error -->
                <p class="text-danger" v-show="errorsValidate.permission_id">{{ errorsValidate.permission_id }}</p>

                <button class="float-right btn btn-primary" @click="actionSubmit" v-if="!loadingAjax">Cập nhật</button>
                <button class="float-right btn btn-sm btn-secondary" v-else>
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </button>
            </div>

            <!-- Loading -->
            <div class="card-body" style="display: flex;align-items: center;justify-content: center;" v-if="!loading">
                <div class="spinner-border mt-5 mb-5" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .v-tooltip {
        display: unset !important;
    }
    .v-tooltip__content {
        top: -40px !important;
        width: max-content;
    }
</style>
<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import Swal from "sweetalert2";
import '@riophae/vue-treeselect/dist/vue-treeselect.css';
import axios from '@/core/plugins/axios';

export default {
    data() {
        return {
            loading: false,
            loadingAjax: false,
            listPhanHe: [],
            listToChuc: [],
            tongCty: {},
            tenNhomQUyen: '',
            trangThai: 'active',
            selectedToChuc: [],
            selectedPhanHe: 1,
            selectedChucNang: [],
            selectedQuyen: {
                phanHe1: [],
                phanHe2: [],
                phanHe3: [],
                phanHe4: [],
                phanHe5: []
            },
            pickedTongCty: false,
            pickedChiNhanh: false,
            errorsValidate: {
                group_name: '',
                store_id: '',
                permission_id: '',
                subsystem_id: '',
                active_status: ''
            }
        };
    },
    props: {
        
    },
    computed: {
        optionToChuc: function () {
            return this.generateOption(this.listToChuc);
        }
    },
    watch: {
        
    },
    beforeCreate() {
        axios.get(`/proxy/account/v1/nhom-quyen/${this.$route.params.id}/edit`)
            .then(response => {
                this.listPhanHe = response.data.data.sub_system;
                this.listToChuc = response.data.data.store;
                this.tongCty = response.data.data.header_store;
                this.tenNhomQUyen = response.data.data.detail.group_name;
                this.selectedPhanHe = response.data.data.detail.subsystem_id;
                this.trangThai = response.data.data.detail.active_status;
                if ( response.data.data.detail.stores[0].id == response.data.data.header_store.id ) {
                    this.pickedTongCty = false;
                    this.pickedChiNhanh = true;
                } else {
                    this.pickedTongCty = true;
                    this.pickedChiNhanh = false;
                }
                response.data.data.detail.stores.forEach(toChuc => {
                    this.selectedToChuc.push(toChuc.id);
                });
                response.data.data.detail.permissions.forEach(quyen => {
                    switch (response.data.data.detail.subsystem_id) {
                        case 1:
                            this.selectedQuyen.phanHe1.push(quyen.id);
                            break;
                        case 2:
                            this.selectedQuyen.phanHe2.push(quyen.id);
                            break;
                        case 3:
                            this.selectedQuyen.phanHe3.push(quyen.id);
                            break;
                        case 4:
                            this.selectedQuyen.phanHe4.push(quyen.id);
                            break;

                        default:
                            this.selectedQuyen.phanHe5.push(quyen.id);
                            break;
                    }
                });
                this.loading = true;
            })
            .catch(error => console.log(error))
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            {title: "Quản lý nhóm quyền", route: "/account/permissiongroup"},
            {title: "Cập nhật nhóm quyền", route: `/account/permissiongroup/update/${this.$route.params.id}`}
        ]);
        this.$store.dispatch(SET_ACTION, []);
    },
    methods: {
        actionSubmit: function() {
            let quyen = [];
            let _that = this;
            this.loadingAjax = true;
            switch (this.selectedPhanHe) {
                case 1:
                    quyen = this.selectedQuyen.phanHe1;
                    break;
                case 2:
                    quyen = this.selectedQuyen.phanHe2;
                    break;
                case 3:
                    quyen = this.selectedQuyen.phanHe3;
                    break;
                case 4:
                    quyen = this.selectedQuyen.phanHe4;
                    break;

                default:
                    quyen = this.selectedQuyen.phanHe5;
                    break;
            }
            axios.patch(`/proxy/account/v1/nhom-quyen/${this.$route.params.id}`, {
                store_id: this.selectedToChuc,
                group_name: this.tenNhomQUyen,
                permission_id: quyen,
                subsystem_id: this.selectedPhanHe,
                group_type: 'single',
                active_status: this.trangThai
            })
            .then(function(response){
                _that.loadingAjax = false;
                let checkError = false;
                let checkSystemError = false;
                if (response.data.status_code == 200) {
                    Swal.fire(
                        'Thành công!',
                        'Đã Cập nhật nhóm quyền thành công',
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            _that.$router.push({ name: "account.permissiongroup" });
                            
                        } else if (result.isDenied) {
                            _that.$router.push({ name: "account.permissiongroup" });
                        }
                    });
                } else {
                    checkError = true;
                    checkSystemError = true;
                }
                if (checkError) {
                    if (checkSystemError) {
                        Swal.fire(
                            'Thất bại!',
                            'Đã xảy ra lỗi, vui lòng liên hệ admin',
                            'error'
                        )
                    } else {
                        Swal.fire(
                            'Thất bại!',
                            'Vui lòng điền đúng thông tin',
                            'error'
                        )
                    }
                }
            }).catch(function(_ref){
                _that.loadingAjax = false;
                let response = _ref.response;
                console.log(response);
                let checkValidate = true;
                if (response.data.status_code == 422) {
                    if (response.data.errors.group_name) {
                        _that.errorsValidate.group_name = response.data.errors.group_name.msg;
                    } else {
                        _that.errorsValidate.group_name = '';
                    }
                    if (response.data.errors.store_id) {
                        _that.errorsValidate.store_id = response.data.errors.store_id.msg;
                    } else {
                        _that.errorsValidate.store_id = '';
                    }
                    if (response.data.errors.permission_id) {
                        _that.errorsValidate.permission_id = response.data.errors.permission_id.msg;
                    } else {
                        _that.errorsValidate.permission_id = '';
                    }
                    if (response.data.errors.subsystem_id) {
                        _that.errorsValidate.subsystem_id = response.data.errors.subsystem_id.msg;
                    } else {
                        _that.errorsValidate.subsystem_id = '';
                    }
                    checkValidate = false;
                }
                if (checkValidate) {
                    Swal.fire(
                        'Thất bại!',
                        'Đã xảy ra lỗi, vui lòng liên hệ admin',
                        'error'
                    )
                } else {
                    Swal.fire(
                        'Thất bại!',
                        'Vui lòng điền đúng thông tin',
                        'error'
                    )
                }
            });
        },
        selectToChuc: function (node) {
            let pickedToChuc = node.id;
            if ( pickedToChuc == this.tongCty.id ) {
                this.pickedTongCty = false;
                this.pickedChiNhanh = true;
            } else {
                this.pickedTongCty = true;
                this.pickedChiNhanh = false;
                if ( this.selectedToChuc.length == 0 ) {
                    this.reSelectAll();
                }
            }
        },
        deselectToChuc: function (node) {
            let pickedToChuc = node.id;
            this.pickedTongCty = false;
            this.pickedChiNhanh = false;
            if ( pickedToChuc != this.tongCty.id && this.selectedToChuc.length > 1 ) {
                this.pickedTongCty = true;
            }
        },
        generateOption(treeListToChuc, idTrucThuoc = null) {
            let branch = [];
            treeListToChuc.forEach(toChuc => {
                if (toChuc.parent_id == idTrucThuoc) {
                    let children = this.generateOption(treeListToChuc, toChuc.id);
                    if (!!children) {
                        branch.push({
                            id: toChuc.id,
                            label: toChuc.store_name,
                            children: children,
                            isDisabled: toChuc.id == this.tongCty.id ? this.pickedTongCty : this.pickedChiNhanh
                        });
                    } else {
                        branch.push({
                            id: toChuc.id,
                            label: toChuc.store_name,
                            isDisabled: toChuc.id == this.tongCty.id ? this.pickedTongCty : this.pickedChiNhanh
                        });
                    }
                }
            })
            return branch.length ? branch : null;
        },
        selectAll: function(e ,idPhanHe, idChucNang) {
            let _that = this;
            let selectedQuyen = null;
            switch (idPhanHe) {
                case 1:
                    selectedQuyen = this.selectedQuyen.phanHe1;
                    break;
                case 2:
                    selectedQuyen = this.selectedQuyen.phanHe2;
                    break;
                case 3:
                    selectedQuyen = this.selectedQuyen.phanHe3;
                    break;
                case 4:
                    selectedQuyen = this.selectedQuyen.phanHe4;
                    break;
                
                default:
                    selectedQuyen = this.selectedQuyen.phanHe5;
                    break;
            }
            this.listPhanHe.map(function(phanHe) { 
                if (phanHe.id == idPhanHe) {
                    phanHe.features.map(function(chucNang) { 
                        if (chucNang.id == idChucNang) {
                            chucNang.permissions.map(function(quyen) {
                                if (e.target.checked) {
                                    if (_that.pickedTongCty) {
                                        if (!selectedQuyen.includes(quyen.id) && quyen.private == 'no') {
                                            selectedQuyen.push(quyen.id);
                                        }
                                    } else {
                                        if (!selectedQuyen.includes(quyen.id)) {
                                            selectedQuyen.push(quyen.id);
                                        }
                                    }
                                } else {
                                    let position = selectedQuyen.indexOf(quyen.id);
                                    if (position != -1) {
                                        selectedQuyen.splice(position, 1);
                                    }
                                }
                            });
                        }
                    });
                }
            });
        },
        reSelectAll() {
            let _that = this;
            this.selectedQuyen.phanHe1 = [];
            this.selectedQuyen.phanHe2 = [];
            this.selectedQuyen.phanHe3 = [];
            this.selectedQuyen.phanHe4 = [];
            this.selectedQuyen.phanHe5 = [];

            this.listPhanHe.map(function(phanHe) {
                let selectedQuyen = null;
                switch (phanHe.id) {
                    case 1:
                        selectedQuyen = _that.selectedQuyen.phanHe1;
                        break;
                    case 2:
                        selectedQuyen = _that.selectedQuyen.phanHe2;
                        break;
                    case 3:
                        selectedQuyen = _that.selectedQuyen.phanHe3;
                        break;
                    case 4:
                        selectedQuyen = _that.selectedQuyen.phanHe4;
                        break;
                
                    default:
                        selectedQuyen = _that.selectedQuyen.phanHe5;
                        break;
                }
                phanHe.features.map(function(chucNang) { 
                    if (_that.selectedChucNang.includes(chucNang.id)) {
                        chucNang.permissions.map(function(quyen) {
                            if (_that.pickedTongCty) {
                                if (!selectedQuyen.includes(quyen.id) && quyen.private == 'no') {
                                    selectedQuyen.push(quyen.id);
                                }
                            } else {
                                if (!selectedQuyen.includes(quyen.id)) {
                                    selectedQuyen.push(quyen.id);
                                }
                            }
                        });
                    }
                });
            });
        }
    }
}
</script>