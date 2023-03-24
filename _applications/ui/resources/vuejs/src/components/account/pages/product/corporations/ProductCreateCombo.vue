<template>
    <div>
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Tên combo (*)</label>
                                <input class="form-control" :class="errorsValidate.product_name ? 'is-invalid': ''" type="text" v-model="input.product_name" value="">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.product_name">{{ errorsValidate.product_name }}</p>
                            </div>
                            <div class="col-md-12">
                                <label>Tên hiển thị (*)</label>
                                <input class="form-control" :class="errorsValidate.product_display_name ? 'is-invalid': ''" type="text" v-model="input.product_display_name" value="">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.product_display_name">{{ errorsValidate.product_display_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Mã combo (*)</label>
                                <input class="form-control" :class="errorsValidate.product_cd ? 'is-invalid': ''" type="text" v-model="input.product_cd" value="">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.product_cd">{{ errorsValidate.product_cd }}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Mã SKU (*)</label>
                                <input class="form-control" :class="errorsValidate.sku ? 'is-invalid': ''" type="text" v-model="input.sku" value="">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.sku">{{ errorsValidate.sku }}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Nhà cung cấp (*)</label>
                                <treeselect
                                    v-if="page.loading"
                                    :options="optionLoaiNhaCungCap"
                                    :default-expand-level="2"
                                    v-model="input.providers"
                                    :multiple="true"
                                />

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.providers">{{ errorsValidate.providers }}</p>

                                <!-- Loading -->
                                <div style="display: flex;align-items: center;justify-content: center;" v-if="!page.loading">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Loại sản phẩm (*)</label>
                                <treeselect
                                    v-if="page.loading"
                                    :options="optionLoaiSanPham"
                                    :default-expand-level="2"
                                    placeholder="Chọn loại sản phẩm"
                                    v-model="input.product_catalog_id"
                                />

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.product_catalog_id">{{ errorsValidate.product_catalog_id }}</p>

                                <!-- Loading -->
                                <div style="display: flex;align-items: center;justify-content: center;" v-if="!page.loading">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Khối lượng (*)</label>
                                <b-input-group v-if="page.loading">
                                    <input type="text" class="form-control" :class="errorsValidate.quantity ? 'is-invalid': ''" aria-label="Text input with checkbox" v-model="input.quantity" value="">
                                    <b-input-group-append>
                                        <select class="form-control" v-model="input.volume_unit_id">
                                            <option v-for="donVi in data.donViKhoiLuong" :key="donVi.id" :value="donVi.id">{{ donVi.volume_unit_id }}</option>
                                        </select>
                                    </b-input-group-append>
                                </b-input-group>

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.volume_unit_id">{{ errorsValidate.quantity }}</p>
                                <p class="text-danger" v-show="errorsValidate.volume_unit_id">{{ errorsValidate.volume_unit_id }}</p>

                                <!-- Loading -->
                                <div style="display: flex;align-items: center;justify-content: center;" v-if="!page.loading">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Đơn vị tính (*)</label>
                                <input class="form-control" :class="errorsValidate.unit ? 'is-invalid': ''" type="text" v-model="input.unit" value="">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.unit">{{ errorsValidate.unit }}</p>
                            </div>
                            <div class="col-md-6">
                                <label>Tồn kho tối thiểu (*)</label>
                                <input class="form-control" :class="errorsValidate.minimum_inventory ? 'is-invalid': ''" type="text" v-model="input.minimum_inventory" value="">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.minimum_inventory">{{ errorsValidate.minimum_inventory }}</p>
                            </div>
                            <div class="col-md-12 mb-3">
                                <span v-if="page.show_mo_ta" class="description" @click="page.show_mo_ta = !page.show_mo_ta">Ẩn mô tả</span>
                                <span v-if="!page.show_mo_ta" class="description" @click="page.show_mo_ta = !page.show_mo_ta">Thêm mô tả</span>
                                <b-form-textarea
                                    v-if="page.show_mo_ta"
                                    id="textarea"
                                    v-model="input.description"
                                    placeholder="Mô tả"
                                    rows="3"
                                    max-rows="6"
                                ></b-form-textarea>

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.description">{{ errorsValidate.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <h3 class="mt-3">Giá sản phẩm</h3>
                            <div class="col-md-12">
                                <label>Giá bán lẻ</label>
                                <input class="form-control" :class="errorsValidate.old_prices ? 'is-invalid': ''" type="text" v-model="input.old_prices" value="" data-type="currency">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.old_prices">{{ errorsValidate.old_prices }}</p>
                            </div>
                            <div class="col-md-12">
                                <label>Giá bán buôn</label>
                                <input class="form-control" :class="errorsValidate.old_wholesale_prices ? 'is-invalid': ''" type="text" v-model="input.old_wholesale_prices" value="" data-type="currency">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.old_wholesale_prices">{{ errorsValidate.old_wholesale_prices }}</p>
                            </div>
                            <div class="col-md-12">
                                <label>Giá bán vốn</label>
                                <input class="form-control" :class="errorsValidate.old_cost_prices ? 'is-invalid': ''" type="text" v-model="input.old_cost_prices" value="" data-type="currency">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.old_cost_prices">{{ errorsValidate.old_cost_prices }}</p>
                            </div>
                            <div class="col-md-12">
                                <input type="checkbox" v-model="input.is_sales" class="mr-3"> Cho phép kinh doanh
                            </div>
                            <div class="col-md-12 mb-3">
                                <input type="checkbox" v-model="input.is_enable_tax" class="mr-3"> Áp dụng thuế
                            </div>
                            <div class="col-md-12">
                                <label>Giá trị áp dụng</label>
                                <input class="form-control" type="text" v-model="input.tax_percent" value="" data-type="currency">

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.tax_percent">{{ errorsValidate.tax_percent }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <h3>Ảnh đại diện</h3>
                            <div class="box has-advanced-upload w-100">
                                <div class="box__input">
                                    <b-form-file type="file" 
                                        v-model="input.anhDaiDien" 
                                        @change="handleAnhDaiDien" 
                                        v-if="!page.loadingUploadAnhDaiDien"
                                        placeholder="Chọn ảnh đại diện" no-drop  browse-text='Tải ảnh lên'>
                                    </b-form-file>

                                    <!-- Loading -->
                                    <div style="display: flex;align-items: center;justify-content: center;" v-if="page.loadingUploadAnhDaiDien">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>

                                    <!-- Error -->
                                    <p class="text-danger" v-show="errorsValidate.product_avatar">{{ errorsValidate.product_avatar }}</p>

                                    <div class="card-group card-group-dai-dien">
                                        <div class="card" v-if="!!page.urlAnhDaiDien">
                                            <div class="svg-icon svg-icon-2" style="width: 150px;">
                                                <svg @click="deleteAnhDaiDien" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                                        <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                                    </g>
                                                </svg>
                                            </div>
                                            <img :src="page.urlAnhDaiDien" alt="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <h3>Ảnh sản phẩm</h3>
                            <div class="box has-advanced-upload w-100">
                                <div class="box__input">
                                    <b-form-file type="file" 
                                        v-model="input.anhSanPham" 
                                        @change="handleAnhSanPham"
                                        v-if="!page.loadingUploadAnhSanPham"
                                        placeholder="Chọn ảnh sản phẩm" no-drop  browse-text='Tải ảnh lên'>
                                    </b-form-file>

                                    <!-- Loading -->
                                    <div style="display: flex;align-items: center;justify-content: center;" v-if="page.loadingUploadAnhSanPham">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>

                                    <!-- Error -->
                                    <p class="text-danger" v-show="errorsValidate.product_image_url">{{ errorsValidate.product_image_url }}</p>

                                    <div class="row card-group-san-pham">
                                        <div class="card col-md-2" v-for="(anhSanPham, index) in page.urlAnhSanPham" :key="index">
                                            <div class="svg-icon svg-icon-1" style="width: 150px;margin: auto;">
                                                <svg @click="deleteAnhSanPham(index)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                        <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
                                                        <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
                                                    </g>
                                                </svg>
                                            </div>
                                            <img style="margin:auto" :src="anhSanPham" alt="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h3>Thành phần trong combo sản phẩm</h3>
                            <div class="col-md-12 w-100">
                                <div class="search-san-pham">
                                    <input class="form-control search-input" type="text" placeholder="Tìm kiếm sản phẩm" 
                                        v-model.trim="searchCombo.input"
                                        @keyup="searchSanPham"
                                        @focus="searchCombo.showSearch = true"
                                    >
                                    <div class="list-san-pham" v-show="searchCombo.showSearch && !searchCombo.searchAjax">
                                        <div class="flex-between san-pham" @click="pickCombo(index)" v-for="(sanPham, index) in data.listSanPham" :key="index">
                                            <div class="box-left">
                                                <img :src="sanPham.product.product_avatar" alt="">
                                            </div>
                                            <div class="flex-between box-right">
                                                <div class="content-left">
                                                    <p class="ten-san-pham">
                                                        {{ sanPham.product.product_display_name  }}
                                                        {{ sanPham.entity_attribute_float ? sanPham.entity_attribute_float.float_value : '' }}
                                                        {{ sanPham.entity_attribute_int ? sanPham.entity_attribute_int.float_value : ''  }}
                                                        {{ sanPham.entity_attribute_varchar ? sanPham.entity_attribute_varchar.float_value : '' }}
                                                    </p>
                                                    <p>{{ sanPham.product.product_cd }}</p>
                                                </div>
                                                <div class="content-right">
                                                    <p>{{ sanPham.entity_prices.prices }}</p>
                                                    <p>Số lượng: <b>1</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Loading -->
                                    <div style="display: flex;align-items: center;justify-content: center;margin-top: 10px;" v-if="searchCombo.searchAjax">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered mt-2" v-if="input.sanPhamCombo.length > 0">
                                    <thead>
                                        <tr>
                                            <th>Ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá bán lẻ</th>
                                            <th>Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tr-san-pham" v-for="(combo,index) in input.sanPhamCombo" :key="index">
                                            <td><img style="width:150px" :src="combo.product_avatar" alt=""></td>
                                            <td>{{combo.product_name }}</td>
                                            <td>
                                                <input class="form-control" :class="combo.errors_so_luong ? 'is-invalid': ''" type="text" v-model="combo.so_luong">

                                                <!-- Error -->
                                                <p class="text-danger" v-show="combo.errors_so_luong">{{ combo.errors_so_luong }}</p>
                                            </td>
                                            <td class="gia-ban-le">
                                                <input class="form-control" :class="combo.errors_prices ? 'is-invalid': ''" type="text" v-model="combo.prices">

                                                <!-- Error -->
                                                <p class="text-danger" v-show="combo.errors_prices">{{ combo.errors_prices }}</p>
                                            </td>
                                            <td class="thanh-tien">{{ combo.so_luong * combo.prices }}</td>
                                            <td class="attr_delete" @click="deleteCombo(index)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="float-end" v-if="input.sanPhamCombo.length > 0">
                                    Tổng tiền thành phần: <span class="total_san_pham">{{ this.giaBanLe }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-primary mt-5" @click="handleSave" v-if="!page.loadingAjax">Thêm mới</button>
                                <button class="btn btn-sm btn-primary mt-5" v-else>
                                    <div class="spinner-border" role="status" style="height: 1.5rem;width: 1.5rem;">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>
    img {
        width: 150px;
    }
    svg {
        cursor: pointer;
    }
    .svg-icon svg {
        float: right;
    }
    .card-group > .card {
        flex: 1 0 100%;
        padding: 10px;
    }
    .description {
        color: #3699FF;
        cursor: pointer;
    }
    .flex-between {
        display: flex;
        justify-content: space-between;
    }
    .flex-between:hover {
        background-color: #009EF7;
    }
    .list-san-pham {
        overflow:scroll;
        margin-top: 10px;
        position: absolute;
        width: 100%;
        background-color: white;
        max-height: 200px;
        z-index: 1;
    }
    .search-san-pham {
        position: relative;
    }
    .box-left {
        border-left: 1px solid black;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
    .box-left img {
        width:100px;
        padding:10px;
    }
    .box-right {
        border: 1px solid black;
        width: 100%;
    }
    .content-left {
        padding: 10px;
        width: 60%;
    }
    .content-right {
        padding: 10px;
        width: auto;
    }
    input[type=checkbox] {
        transform: scale(1.5);
    }
</style>

<script>
import Swal from "sweetalert2";
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import axios from "axios";
let timeOut = null;

export default {
    data() {
        return {
            data: {
                danhMuc: [],
                donViKhoiLuong: [],
                listSanPham: [],
                providers: []
            },
            input: {
                product_catalog_id: null,
                volume_unit_id: 1,
                anhDaiDien: null,
                anhSanPham: null,
                product_avatar: null,
                listAnhSanPham: [],
                description: '',
                product_name: '',
                product_display_name: '',
                product_cd: '',
                sku: '',
                quantity: '',
                unit: '',
                old_prices: 0,
                old_wholesale_prices: 0,
                old_cost_prices: 0,
                is_sales: true,
                is_enable_tax: true,
                sanPhamCombo: [],
                providers: [],
                minimum_inventory: 0,
                tax_percent: 0
            },
            page: {
                loading: false,
                loadingAjax: false,
                urlAnhDaiDien: null,
                urlAnhSanPham: [],
                show_mo_ta: false,
                loadingUploadAnhDaiDien:false,
                loadingUploadAnhSanPham:false
            },
            searchCombo: {
                input: '',
                showSearch: false,
                searchAjax: false
            },
            errorsValidate: {
                product_catalog_id: '',
                volume_unit_id: '',
                product_name: '',
                product_cd: '',
                quantity: '',
                unit: '',
                description: '',
                old_prices: '',
                old_wholesale_prices: '',
                old_cost_prices: '',
                is_sales: '',
                is_enable_tax: '',
                ten_thuoc_tinh: '',
                gia_tri_thuoc_tinh: '',
                product_display_name: '',
                sku: '',
                product_avatar: '',
                anh_san_pham: '',
                minimum_inventory: '',
                tax_percent: '',
                providers: ''
            }
        }
    },
    props: {
        accessMedia: Object
    },
    beforeCreate() {
        axios.get("/proxy/account/v1/san-pham/create")
            .then(response => {
                this.data.danhMuc = response.data.data.product_catalog;
                this.data.donViKhoiLuong = response.data.data.volume_unit;
                this.data.providers = response.data.data.providers;
                this.page.loading = true;
            })
            .catch(error => console.log(error))
        axios.get("/proxy/account/v1/search-entity?limit=5")
            .then(response => {
                this.data.listSanPham = response.data.data.items;
            })
            .catch(error => console.log(error))
    },
    computed: {
        optionLoaiNhaCungCap: function () {
            let dsNhaCungCap = [];
            this.data.providers.forEach(provider => {
                dsNhaCungCap.push({
                    id: provider.id,
                    label: provider.provider_name
                });
            });
            return dsNhaCungCap;
        },
        optionLoaiSanPham: function () {
            return this.generateOption(this.data.danhMuc);
        },
        giaBanLe: function() {
            let giaBanLe = 0;
            this.input.sanPhamCombo.forEach(sanPham => {
                giaBanLe += sanPham.prices * sanPham.so_luong;
            });
            return giaBanLe;
        },
        giaBanBuon: function() {
            let giaBanBuon = 0;
            this.input.sanPhamCombo.forEach(sanPham => {
                giaBanBuon += sanPham.wholesale_prices * sanPham.so_luong;
            });
            return giaBanBuon;
        },
        giaVon: function() {
            let giaVon = 0;
            this.input.sanPhamCombo.forEach(sanPham => {
                giaVon += sanPham.cost_prices * sanPham.so_luong;
            });
            return giaVon;
        }
    },
    watch: {
        giaBanLe: function (value) {
            this.input.old_prices = value;
        },
        giaBanBuon: function (value) {
            this.input.old_wholesale_prices = value;
        },
        giaVon: function (value) {
            this.input.old_cost_prices = value;
        }
    },
    methods: {
        generateOption(treeListDanhMuc, idDanhMucCha = null) {
            let branch = [];
            treeListDanhMuc.forEach(danhMuc => {
                if (danhMuc.parent_id == idDanhMucCha) {
                    let children = this.generateOption(treeListDanhMuc, danhMuc.id);
                    if (!!children) {
                        branch.push({
                            id: danhMuc.id,
                            label: danhMuc.product_catalog_name,
                            children: children
                        });
                    } else {
                        branch.push({
                            id: danhMuc.id,
                            label: danhMuc.product_catalog_name
                        });
                    }
                }
            });
            return branch.length ? branch : null;
        },
        handleAnhDaiDien(event) {
            let _that = this;
            const file = event.target.files[0];
            this.page.loadingUploadAnhDaiDien = true;
            this.page.loadingAjax = true;
            this.errorsValidate.product_avatar = '';
            axios.get(this.accessMedia.url_token,
            {
                headers: {
                    'access-key': this.accessMedia.access_key,
                    'secret-key': this.accessMedia.secret_key
                }
            })
            .then(function(response){
                let formData = new FormData();
                formData.append('tuha_file', file);
                formData.append('type', 'file');

                axios.post(_that.accessMedia.url_image,
                formData,
                {
                    headers: {
                        'token': response.data.token
                    }
                })
                .then(function(response){
                    _that.input.product_avatar = response.data.data.origin;
                    _that.page.loadingUploadAnhDaiDien = false;
                    _that.page.loadingAjax = false;
                    _that.page.urlAnhDaiDien = URL.createObjectURL(file);
                }).catch(function(_ref){
                    _that.page.loadingUploadAnhDaiDien = false;
                    _that.page.loadingAjax = false;
                    _that.errorsValidate.product_avatar = 'Ảnh đại diện phải là ảnh tối đa 2MB';
                });
            }).catch(function(_ref){
                _that.page.loadingUploadAnhDaiDien = false;
                _that.page.loadingAjax = false;
                _that.errorsValidate.product_avatar = 'Ảnh đại diện phải là ảnh tối đa 2MB';
            });
        },
        deleteAnhDaiDien() {
            this.page.urlAnhDaiDien = null;
            this.input.anhDaiDien = null;
        },
        handleAnhSanPham(event) {
            let _that = this;
            const file = event.target.files[0];
            this.page.loadingUploadAnhSanPham = true;
            this.page.loadingAjax = true;
            this.errorsValidate.anh_san_pham = '';
            axios.get(this.accessMedia.url_token,
            {
                headers: {
                    'access-key': this.accessMedia.access_key,
                    'secret-key': this.accessMedia.secret_key
                }
            })
            .then(function(response){
                let formData = new FormData();
                formData.append('tuha_file', file);
                formData.append('type', 'file');

                axios.post(_that.accessMedia.url_image,
                formData,
                {
                    headers: {
                        'token': response.data.token
                    }
                })
                .then(function(response){
                    _that.page.loadingUploadAnhSanPham = false;
                    _that.input.listAnhSanPham.push(response.data.data.origin);
                    _that.page.urlAnhSanPham.push(URL.createObjectURL(file));
                    _that.page.loadingAjax = false;
                }).catch(function(_ref){
                    _that.page.loadingUploadAnhSanPham = false;
                    _that.page.loadingAjax = false;
                    _that.errorsValidate.anh_san_pham = 'Ảnh sản phẩm phải là ảnh tối đa 2MB';
                });
            }).catch(function(_ref){
                _that.page.loadingUploadAnhSanPham = false;
                _that.page.loadingAjax = false;
                _that.errorsValidate.anh_san_pham = 'Ảnh sản phẩm phải là ảnh tối đa 2MB';
            });
        },
        deleteAnhSanPham(index) {
            this.input.listAnhSanPham.splice(index, 1);
            this.page.urlAnhSanPham.splice(index, 1);
        },
        handleSave() {
            let _that = this;
            let formData = new FormData();
            this.page.loadingAjax = true;

            //Bảng acc_t_products
            formData.append('product_catalog_id', this.input.product_catalog_id);
            formData.append('volume_unit_id', this.input.volume_unit_id);
            formData.append('product_cd', this.input.product_cd);
            formData.append('product_name', this.input.product_name);
            formData.append('product_display_name', this.input.product_display_name);
            formData.append('quantity', this.input.quantity);
            formData.append('description', this.input.description);
            formData.append('product_avatar', this.input.product_avatar);
            formData.append('is_sales', this.input.is_sales ? 'yes': 'no');
            formData.append('is_enable_tax', this.input.is_enable_tax ? 'yes': 'no');
            formData.append('tax_percent', this.input.tax_percent);
            formData.append('product_type', 'combo');
            formData.append('minimum_inventory', this.input.minimum_inventory);
            formData.append('unit', this.input.unit);
            formData.append('sku', this.input.sku);

            //Bảng acc_t_product_gallery
            this.input.listAnhSanPham.forEach(anh => {
                formData.append('product_image_url[]', anh);
            });

            //Bảng providers
            this.input.providers.forEach(provider => {
                formData.append('providers[]', provider);
            });
            
            formData.append('old_prices', this.input.old_prices);
            formData.append('old_wholesale_prices', this.input.old_wholesale_prices);
            formData.append('old_cost_prices', this.input.old_cost_prices);
            this.input.sanPhamCombo.forEach(sanPham => {
                formData.append('related_product_id[]', sanPham.id);
                formData.append('related_product_quantity[]', sanPham.so_luong);
                formData.append('related_product_prices[]', sanPham.prices);
            });

            axios.post("/proxy/account/v1/san-pham",
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
                            _that.$emit('refeshPage');
                        } else if (result.isDenied) {
                            _that.$emit('refeshPage');
                        }
                    });
                } else {
                    Swal.fire(
                        'Thất bại!',
                        'Đã xảy ra lỗi, vui lòng liên hệ admin',
                        'error'
                    )
                }
            }).catch(function(_ref){
                _that.page.loadingAjax = false;
                let response = _ref.response.data;
                if (response.errors) {
                    if (response.errors.product_catalog_id) {
                        _that.errorsValidate.product_catalog_id = response.errors.product_catalog_id[0];
                    } else {
                        _that.errorsValidate.product_catalog_id = 0;
                    }
                    if (response.errors.volume_unit_id) {
                        _that.errorsValidate.volume_unit_id = response.errors.volume_unit_id[0];
                    } else {
                        _that.errorsValidate.volume_unit_id = '';
                    }
                    if (response.errors.product_name) {
                        _that.errorsValidate.product_name = response.errors.product_name[0];
                    } else {
                        _that.errorsValidate.product_name = '';
                    }
                    if (response.errors.product_cd) {
                        _that.errorsValidate.product_cd = response.errors.product_cd[0];
                    } else {
                        _that.errorsValidate.product_cd = '';
                    }
                    if (response.errors.quantity) {
                        _that.errorsValidate.quantity = response.errors.quantity[0];
                    } else {
                        _that.errorsValidate.quantity = '';
                    }
                    if (response.errors.unit) {
                        _that.errorsValidate.unit = response.errors.unit[0];
                    } else {
                        _that.errorsValidate.unit = '';
                    }
                    if (response.errors.description) {
                        _that.errorsValidate.description = response.errors.description[0];
                    } else {
                        _that.errorsValidate.description = '';
                    }
                    if (response.errors.old_prices) {
                        _that.errorsValidate.old_prices = response.errors.old_prices[0];
                    } else {
                        _that.errorsValidate.old_prices = '';
                    }
                    if (response.errors.old_wholesale_prices) {
                        _that.errorsValidate.old_wholesale_prices = response.errors.old_wholesale_prices[0];
                    } else {
                        _that.errorsValidate.old_wholesale_prices = '';
                    }
                    if (response.errors.old_cost_prices) {
                        _that.errorsValidate.old_cost_prices = response.errors.old_cost_prices[0];
                    } else {
                        _that.errorsValidate.old_cost_prices = '';
                    }
                    if (response.errors.is_sales) {
                        _that.errorsValidate.is_sales = response.errors.is_sales[0];
                    } else {
                        _that.errorsValidate.is_sales = '';
                    }
                    if (response.errors.is_enable_tax) {
                        _that.errorsValidate.is_enable_tax = response.errors.is_enable_tax[0];
                    } else {
                        _that.errorsValidate.is_enable_tax = '';
                    }
                    if (response.errors.ten_thuoc_tinh) {
                        _that.errorsValidate.ten_thuoc_tinh = response.errors.ten_thuoc_tinh[0];
                    } else {
                        _that.errorsValidate.ten_thuoc_tinh = '';
                    }
                    if (response.errors.gia_tri_thuoc_tinh) {
                        _that.errorsValidate.gia_tri_thuoc_tinh = response.errors.gia_tri_thuoc_tinh[0];
                    } else {
                        _that.errorsValidate.gia_tri_thuoc_tinh = '';
                    }
                    if (response.errors.product_display_name) {
                        _that.errorsValidate.product_display_name = response.errors.product_display_name[0];
                    } else {
                        _that.errorsValidate.product_display_name = '';
                    }
                    if (response.errors.sku) {
                        _that.errorsValidate.sku = response.errors.sku[0];
                    } else {
                        _that.errorsValidate.sku = '';
                    }
                    if (response.errors.providers) {
                        _that.errorsValidate.providers = response.errors.providers[0];
                    } else {
                        _that.errorsValidate.providers = '';
                    }
                    if (response.errors.tax_percent) {
                        _that.errorsValidate.tax_percent = response.errors.tax_percent[0];
                    } else {
                        _that.errorsValidate.tax_percent = '';
                    }
                    _that.input.sanPhamCombo.forEach((combo, key) => {
                        if (response.errors["related_product_quantity." + key]) {
                            combo.errors_so_luong = response.errors["related_product_quantity." + key][0];
                        } else {
                            combo.errors_so_luong = '';
                        }
                        if (response.errors["related_product_prices." + key]) {
                            combo.errors_prices = response.errors["related_product_prices." + key][0];
                        } else {
                            combo.errors_prices = '';
                        }
                    });

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
        searchSanPham() {
            let _that = this;
            this.searchCombo.showSearch = false;
            this.searchCombo.searchAjax = true;

            if (timeOut) {
                clearTimeout(timeOut);
            }

            timeOut = setTimeout(function(){
                let search = '';
                if (_that.searchCombo.input) {
                    search = `&search=${_that.searchCombo.input}`;
                }
                axios.get(`/proxy/account/v1/search-entity?limit=5${search}`)
                    .then(response => {
                        _that.data.listSanPham = response.data.data.items;
                        _that.searchCombo.showSearch = true;
                        _that.searchCombo.searchAjax = false;
                    })
                    .catch(error => console.log(error))
            }, 1000);
        },
        pickCombo(index) {
            let sanphamCombo = {};
            sanphamCombo.so_luong = 1;
            sanphamCombo.prices = this.data.listSanPham[index].entity_prices.prices;
            sanphamCombo.errors_so_luong = '';
            sanphamCombo.errors_prices = '';
            sanphamCombo.wholesale_prices = this.data.listSanPham[index].entity_prices.wholesale_prices;
            sanphamCombo.cost_prices = this.data.listSanPham[index].entity_prices.cost_prices;
            sanphamCombo.product_avatar = this.data.listSanPham[index].product.product_avatar;
            let varchar_name = '';
            let float_name = '';
            let int_name = '';
            this.data.listSanPham[index].entity_attribute_varchar.forEach(value => {
                varchar_name += ' - ' + value.varchar_value;
            });
            this.data.listSanPham[index].entity_attribute_float.forEach(value => {
                float_name += ' - ' + value.float_value;
            });
            this.data.listSanPham[index].entity_attribute_int.forEach(value => {
                int_name += ' - ' + value.int_value;
            });
            sanphamCombo.product_name = this.data.listSanPham[index].product.product_display_name + float_name + int_name + varchar_name;
            sanphamCombo.id = this.data.listSanPham[index].id;
            this.input.sanPhamCombo.push(sanphamCombo);
            this.searchCombo.showSearch = false;
        },
        deleteCombo(index) {
            this.input.sanPhamCombo.splice(index, 1);
        }
    }
}
</script>