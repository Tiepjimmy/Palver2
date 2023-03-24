<template>
    <div>
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Sản phẩm hệ thống (*)</label>
                                <div class="search-san-pham">
                                    <input class="form-control search-input" :class="errorsValidate.product_name ? 'is-invalid': ''" type="text" placeholder="Tìm kiếm sản phẩm"
                                           v-model.trim="searchCombo.input"
                                           @keyup="searchSanPham"
                                           @focus="searchCombo.showSearch = true"
                                    >
                                    <div class="list-san-pham" v-show="searchCombo.showSearch && !searchCombo.searchAjax">
                                        <div class="flex-between san-pham" @click="pickCombo(index)" v-for="(sanPham, index) in data.listSanPham" :key="index">
                                            <div class="box-left">
                                                <img :src="sanPham.product_avatar" alt="">
                                            </div>
                                            <div class="flex-between box-right">
                                                <div class="content-left">
                                                    <p class="ten-san-pham">{{ sanPham.product_display_name }}</p>
                                                    <p>{{ sanPham.product_cd }}</p>
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
                                <label>Mã sản phẩm (*)</label>
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
                                    <input type="text" class="form-control" :class="errorsValidate.quantity ? 'is-invalid': ''" aria-label="Text input with checkbox" v-model="input.quantity" value="" disabled>
                                    <b-input-group-append>
                                        <select class="form-control" v-model="input.volume_unit_id" disabled>
                                            <option v-for="donVi in donViKhoiLuong" :key="donVi.id" :value="donVi.id">{{ donVi.ten_don_vi_quantity }}</option>
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
                            <div class="col-md-6">
                                <label>Tổ chức (*)</label>
                                <select class="form-control" v-model="input.store_id">
                                    <option v-for="store in providers" :key="store.id" :value="store.id">{{ store.provider_name }}</option>
                                </select>

                                <!-- Error -->
                                <p class="text-danger" v-show="errorsValidate.store_id">{{ errorsValidate.store_id }}</p>
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
                                        disabled
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
                                <input type="checkbox" v-model="input.choPhepKinhDoanh" class="mr-3"> Cho phép kinh doanh
                            </div>
                            <div class="col-md-12 mb-3">
                                <input type="checkbox" v-model="input.apDungThue" class="mr-3"> Áp dụng thuế
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
                                    <p class="text-danger" v-show="errorsValidate.anh_dai_dien">{{ errorsValidate.anh_dai_dien }}</p>

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
                                    <p class="text-danger" v-show="errorsValidate.anh_san_pham">{{ errorsValidate.anh_san_pham }}</p>

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
                            <div class="col-12 col-sm-12 row">
                                <div class="col-md-12 table-responsive">
                                    <label>Danh sách phân loại hàng</label>
                                    <table class="table table-row-bordered">
                                        <thead>
                                        <tr>
                                            <th>Tên phiên bản</th>
                                            <th v-for="chose in input.listThuocTinhChose" :key="chose.id">{{ chose.name }}</th>
                                            <th>Giá bán</th>
                                            <th>Giá vốn</th>
                                            <th>Mã sản phẩm</th>
                                            <th>Mã SKU</th>
                                            <th>Không thay đổi giá</th>
                                            <th>Tồn kho tối thiểu</th>
                                            <!-- <th>Ẩn</th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(bang, index) in bangThuocTinh" :key="index">
                                            <td>{{ bang.name }}</td>
                                            <td v-for="(text, key) in bang.text" :key="key">{{ text }}</td>
                                            <td>
                                                <input type="text" class="form-control" :class="bang.error_prices ? 'is-invalid': ''" v-model="bang.prices" />

                                                <!-- Error -->
                                                <p class="text-danger" v-show="bang.error_prices">{{ bang.error_prices }}</p>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" :class="bang.error_cost_prices ? 'is-invalid': ''" v-model="bang.cost_prices" />

                                                <!-- Error -->
                                                <p class="text-danger" v-show="bang.error_cost_prices">{{ bang.error_cost_prices }}</p>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" :class="bang.error_product_entity_cd ? 'is-invalid': ''" v-model="bang.product_entity_cd" />

                                                <!-- Error -->
                                                <p class="text-danger" v-show="bang.error_product_entity_cd">{{ bang.error_product_entity_cd }}</p>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" :class="bang.error_sku_entity ? 'is-invalid': ''" v-model="bang.sku_entity" />

                                                <!-- Error -->
                                                <p class="text-danger" v-show="bang.error_sku_entity">{{ bang.error_sku_entity }}</p>
                                            </td>
                                            <td><input type="checkbox" v-model="bang.is_overwrite_prices" /></td>
                                            <td>
                                                <input type="text" class="form-control" :class="bang.error_minimum_inventory ? 'is-invalid': ''" v-model="bang.minimum_inventory" />

                                                <!-- Error -->
                                                <p class="text-danger" v-show="bang.error_minimum_inventory">{{ bang.error_minimum_inventory }}</p>
                                            </td>
                                            <!-- <td><input type="checkbox" v-model="bang.has_options" /></td> -->
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-primary mt-5" @click="handleSave" v-if="!page.loadingAjax">Cập nhật</button>
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
                    listSanPham: []
                },
                input: {
                    product_id: null,
                    product_catalog_id: null,
                    volume_unit_id: null,
                    anhDaiDien: null,
                    anhSanPham: null,
                    listAnhDaiDien: null,
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
                    choPhepKinhDoanh: true,
                    apDungThue: true,
                    minimum_inventory: 0,
                    tax_percent: 0,
                    danhSachNhomThuocTinh: [],
                    listThuocTinhChose: [],
                    store_id: null
                },
                searchCombo: {
                    input: '',
                    showSearch: false,
                    searchAjax: false
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
                    cho_phep_kinh_doanh: '',
                    ap_dung_thue: '',
                    ten_thuoc_tinh: '',
                    gia_tri_thuoc_tinh: '',
                    product_display_name: '',
                    sku: '',
                    anh_dai_dien: '',
                    anh_san_pham: '',
                    minimum_inventory: '',
                    tax_percent: '',
                    store_id: ''
                },
                bangThuocTinh: []
            }
        },
        props: {
            accessMedia: Object,
            sanPham: Object,
            danhMuc: Array,
            donViKhoiLuong: Array,
            providers: Array
        },
        mounted() {
            this.input.listThuocTinhChose = [];
            this.bangThuocTinh = [];
            this.searchCombo.input = this.sanPham.product_name;
            this.input.store_id = this.sanPham.store_id;
            this.input.product_id = this.sanPham.id;
            this.input.product_catalog_id = this.sanPham.product_catalog_id;
            this.input.volume_unit_id = this.sanPham.volume_unit_id;
            this.input.description = this.sanPham.description;
            this.input.product_name = this.sanPham.product_name;
            this.input.product_display_name = this.sanPham.product_display_name;
            this.input.product_cd = this.sanPham.product_cd;
            this.input.sku = this.sanPham.sku;
            this.input.quantity = this.sanPham.quantity;
            this.input.unit = this.sanPham.unit;
            this.input.old_prices = this.sanPham.retail_product_entities[0].retail_entity_price.old_prices;
            this.input.old_wholesale_prices = this.sanPham.retail_product_entities[0].retail_entity_price.old_wholesale_prices;
            this.input.old_cost_prices = this.sanPham.retail_product_entities[0].retail_entity_price.old_cost_prices;
            this.input.product_avatar = this.sanPham.product_avatar;
            this.page.urlAnhDaiDien = this.sanPham.product_avatar;
            this.sanPham.product_galleries.forEach(anh => {
                this.input.listAnhSanPham.push(anh.product_image_url);
                this.page.urlAnhSanPham.push(anh.product_image_url);
            });

            this.selectLoaiSanPham(this.sanPham.product_catalog_id);

            let aryProductAttribute = [];

            this.sanPham.retail_product_entities.forEach(entitie => {
                let name = this.input.product_name;
                let text = [];
                let value_type = [];
                let value_id = [];
                entitie.product_entity.entity_attribute_float.forEach(value => {
                    name += ' - ' + value.float_value;
                    text.push(value.float_value);
                    value_type.push('float');
                    value_id.push(value.attribute_id);
                    if (aryProductAttribute.indexOf(value.attribute_id) === -1) {
                        aryProductAttribute.push(value.attribute_id);
                    }
                });
                entitie.product_entity.entity_attribute_int.forEach(value => {
                    name += ' - ' + value.int_value;
                    text.push(value.int_value);
                    value_type.push('int');
                    value_id.push(value.attribute_id);
                    if (aryProductAttribute.indexOf(value.attribute_id) === -1) {
                        aryProductAttribute.push(value.attribute_id);
                    }
                });
                entitie.product_entity.entity_attribute_varchar.forEach(value => {
                    name += ' - ' + value.varchar_value;
                    text.push(value.varchar_value);
                    value_type.push('varchar');
                    value_id.push(value.attribute_id);
                    if (aryProductAttribute.indexOf(value.attribute_id) === -1) {
                        aryProductAttribute.push(value.attribute_id);
                    }
                });
                this.bangThuocTinh.push({
                    id: entitie.id,
                    product_entity_id: entitie.product_entity_id,
                    name: name,
                    text: text,
                    prices: entitie.retail_entity_price.prices,
                    cost_prices: entitie.retail_entity_price.cost_prices,
                    product_entity_cd: entitie.product_entity.product_entity_cd,
                    sku_entity: entitie.sku,
                    is_overwrite_prices: entitie.is_overwrite_prices,
                    minimum_inventory: entitie.minimum_inventory,
                    value_type: value_type,
                    value_id: value_id,
                    error_prices: '',
                    error_cost_prices: '',
                    error_product_entity_cd: '',
                    error_sku_entity: '',
                    error_minimum_inventory: ''
                    // has_options: false
                })
            });
            this.input.danhSachNhomThuocTinh.forEach((chose, index) => {
                if (aryProductAttribute.indexOf(chose.attribute_id) !== -1) {
                    let ary_value = [];
                    let value_type = [];
                    chose.value_floats.forEach(value => {
                        ary_value.push(value.value);
                        value_type.push({
                            attribute_id: chose.attribute_id,
                            type: 'float',
                            value: value.value
                        });
                    });
                    chose.value_ints.forEach(value => {
                        ary_value.push(value.value);
                        value_type.push({
                            attribute_id: chose.attribute_id,
                            type: 'int',
                            value: value.value
                        });
                    });
                    chose.value_varchars.forEach(value => {
                        ary_value.push(value.value);
                        value_type.push({
                            attribute_id: chose.attribute_id,
                            type: 'varchar',
                            value: value.value
                        });
                    });
                    this.input.listThuocTinhChose.push({
                        value: ary_value,
                        value_type: value_type,
                        name: chose.name,
                        key: index
                    });
                }
            });

            this.page.loading = true;
        },
        computed: {
            optionLoaiSanPham: function () {
                return this.generateOption(this.danhMuc);
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
                                isDisabled: true,
                                children: children
                            });
                        } else {
                            branch.push({
                                id: danhMuc.id,
                                isDisabled: true,
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
                this.errorsValidate.anh_dai_dien = '';
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
                                _that.input.listAnhDaiDien = response.data.data.origin;
                                _that.page.loadingUploadAnhDaiDien = false;
                                _that.page.loadingAjax = false;
                                _that.page.urlAnhDaiDien = URL.createObjectURL(file);
                            }).catch(function(_ref){
                            _that.page.loadingUploadAnhDaiDien = false;
                            _that.page.loadingAjax = false;
                            _that.errorsValidate.anh_dai_dien = 'Ảnh đại diện phải là ảnh tối đa 2MB';
                        });
                    }).catch(function(_ref){
                    _that.page.loadingUploadAnhDaiDien = false;
                    _that.page.loadingAjax = false;
                    _that.errorsValidate.anh_dai_dien = 'Ảnh đại diện phải là ảnh tối đa 2MB';
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
                formData.append('product_id', this.input.product_id);
                formData.append('store_id', this.input.store_id);
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
                formData.append('minimum_inventory', this.input.minimum_inventory);
                formData.append('product_type', 'single');
                formData.append('unit', this.input.unit);
                formData.append('sku', this.input.sku);

                //Bảng acc_t_product_gallery
                this.input.listAnhSanPham.forEach(anh => {
                    formData.append('product_image_url[]', anh);
                });

                //Bảng acc_t_product_entities
                //Bảng acc_t_product_entity_prices
                this.bangThuocTinh.forEach(thuocTinh => {
                    formData.append('entity_id[]', thuocTinh.id);
                    formData.append('product_entity_cd[]', thuocTinh.product_entity_cd);
                    formData.append('product_entity_id[]', thuocTinh.product_entity_id);
                    formData.append('sku_entity[]', thuocTinh.sku_entity);
                    formData.append('is_overwrite_prices[]', thuocTinh.is_overwrite_prices ? 1 : 0);
                    formData.append('minimum_inventory_entity[]', thuocTinh.minimum_inventory);
                    // formData.append('has_options[]', thuocTinh.has_options);
                    formData.append('prices[]', thuocTinh.prices);
                    formData.append('wholesale_prices[]', this.input.old_wholesale_prices);
                    formData.append('cost_prices[]', thuocTinh.cost_prices);
                });
                formData.append('old_prices', this.input.old_prices);
                formData.append('old_wholesale_prices', this.input.old_wholesale_prices);
                formData.append('old_cost_prices', this.input.old_cost_prices);

                axios.post(`/proxy/account/v1/san-pham/${this.sanPham.id}?_method=PATCH`,
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
                        if (response.errors.store_id) {
                            _that.errorsValidate.store_id = response.errors.store_id[0];
                        } else {
                            _that.errorsValidate.store_id = '';
                        }
                        _that.bangThuocTinh.forEach((thuocTinh, key) => {
                            if (response.errors["product_entity_cd." + key]) {
                                thuocTinh.error_product_entity_cd = response.errors["product_entity_cd." + key][0];
                            } else {
                                thuocTinh.error_product_entity_cd = '';
                            }
                            if (response.errors["cost_prices." + key]) {
                                thuocTinh.error_cost_prices = response.errors["cost_prices." + key][0];
                            } else {
                                thuocTinh.error_cost_prices = '';
                            }
                            if (response.errors["sku_entity." + key]) {
                                thuocTinh.error_sku_entity = response.errors["sku_entity." + key][0];
                            } else {
                                thuocTinh.error_sku_entity = '';
                            }
                            if (response.errors["minimum_inventory_entity." + key]) {
                                thuocTinh.error_minimum_inventory = response.errors["minimum_inventory_entity." + key][0];
                            } else {
                                thuocTinh.error_minimum_inventory = '';
                            }
                            if (response.errors["prices." + key]) {
                                thuocTinh.error_prices = response.errors["prices." + key][0];
                            } else {
                                thuocTinh.error_prices = '';
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
                    axios.get(`/proxy/account/v1/search-product?limit=5${search}`)
                        .then(response => {
                            _that.data.listSanPham = response.data.data.items;
                            _that.searchCombo.showSearch = true;
                            _that.searchCombo.searchAjax = false;
                        })
                        .catch(error => console.log(error))
                }, 1000);
            },
            pickCombo(index) {
                this.input.listThuocTinhChose = [];
                this.bangThuocTinh = [];
                this.searchCombo.input = this.data.listSanPham[index].product_name;
                this.input.product_id = this.data.listSanPham[index].id;
                this.input.product_catalog_id = this.data.listSanPham[index].product_catalog_id;
                this.input.volume_unit_id = this.data.listSanPham[index].volume_unit_id;
                this.input.description = this.data.listSanPham[index].description;
                this.input.product_name = this.data.listSanPham[index].product_name;
                this.input.product_display_name = this.data.listSanPham[index].product_display_name;
                this.input.product_cd = this.data.listSanPham[index].product_cd;
                this.input.sku = this.data.listSanPham[index].sku;
                this.input.quantity = this.data.listSanPham[index].quantity;
                this.input.unit = this.data.listSanPham[index].unit;
                this.input.old_prices = this.data.listSanPham[index].product_entities[0].entity_prices.old_prices;
                this.input.old_wholesale_prices = this.data.listSanPham[index].product_entities[0].entity_prices.old_wholesale_prices;
                this.input.old_cost_prices = this.data.listSanPham[index].product_entities[0].entity_prices.old_cost_prices;
                this.data.listSanPham[index].product_galleries.forEach(anh => {
                    this.input.listAnhSanPham.push(anh.product_image_url);
                });

                this.selectLoaiSanPham(this.data.listSanPham[index].product_catalog_id);

                let aryProductAttribute = [];

                this.data.listSanPham[index].product_entities.forEach(entitie => {
                    let name = this.input.product_name;
                    let text = [];
                    let value_type = [];
                    let value_id = [];
                    entitie.entity_attribute_float.forEach(value => {
                        name += ' - ' + value.float_value;
                        text.push(value.float_value);
                        value_type.push('float');
                        value_id.push(value.attribute_id);
                        if (aryProductAttribute.indexOf(value.attribute_id) === -1) {
                            aryProductAttribute.push(value.attribute_id);
                        }
                    });
                    entitie.entity_attribute_int.forEach(value => {
                        name += ' - ' + value.int_value;
                        text.push(value.int_value);
                        value_type.push('int');
                        value_id.push(value.attribute_id);
                        if (aryProductAttribute.indexOf(value.attribute_id) === -1) {
                            aryProductAttribute.push(value.attribute_id);
                        }
                    });
                    entitie.entity_attribute_varchar.forEach(value => {
                        name += ' - ' + value.varchar_value;
                        text.push(value.varchar_value);
                        value_type.push('varchar');
                        value_id.push(value.attribute_id);
                        if (aryProductAttribute.indexOf(value.attribute_id) === -1) {
                            aryProductAttribute.push(value.attribute_id);
                        }
                    });
                    this.bangThuocTinh.push({
                        id: 0,
                        product_entity_id: entitie.id,
                        name: name,
                        text: text,
                        prices: entitie.entity_prices.prices,
                        cost_prices: entitie.entity_prices.cost_prices,
                        product_entity_cd: entitie.product_entity_cd,
                        sku_entity: entitie.sku,
                        is_overwrite_prices: entitie.is_overwrite_prices,
                        minimum_inventory: entitie.minimum_inventory,
                        value_type: value_type,
                        value_id: value_id,
                        error_prices: '',
                        error_cost_prices: '',
                        error_product_entity_cd: '',
                        error_sku_entity: '',
                        error_minimum_inventory: ''
                        // has_options: false
                    })
                });
                this.input.danhSachNhomThuocTinh.forEach((chose, index) => {
                    if (aryProductAttribute.indexOf(chose.attribute_id) !== -1) {
                        let ary_value = [];
                        let value_type = [];
                        chose.value_floats.forEach(value => {
                            ary_value.push(value.value);
                            value_type.push({
                                attribute_id: chose.attribute_id,
                                type: 'float',
                                value: value.value
                            });
                        });
                        chose.value_ints.forEach(value => {
                            ary_value.push(value.value);
                            value_type.push({
                                attribute_id: chose.attribute_id,
                                type: 'int',
                                value: value.value
                            });
                        });
                        chose.value_varchars.forEach(value => {
                            ary_value.push(value.value);
                            value_type.push({
                                attribute_id: chose.attribute_id,
                                type: 'varchar',
                                value: value.value
                            });
                        });
                        this.input.listThuocTinhChose.push({
                            value: ary_value,
                            value_type: value_type,
                            name: chose.name,
                            key: index
                        });
                    }
                });
                this.searchCombo.showSearch = false;
            },
            selectLoaiSanPham: function (value) {
                let attributes_group = this.danhMuc.filter(word => word.id == value)[0].attributes_group;
                let array = [];
                attributes_group.forEach(element => {
                    element.product_attributes.forEach(value => {
                        array.push({
                            attribute_id: value.id,
                            name: value.attribute_display_name,
                            value_floats: value.attribute_floats,
                            value_ints: value.attribute_ints,
                            value_varchars: value.attribute_varchars
                        })
                    })
                });

                this.input.danhSachNhomThuocTinh = array;
                this.input.listThuocTinhChose = [];
            }
        }
    }
</script>