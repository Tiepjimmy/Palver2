<template>
    <div>
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Tên sản phẩm (*)</label>
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
                                    @select="selectLoaiSanPham"
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
                            <h3>Thuộc tính</h3>
                            <span class="switch switch-sm">
                                <label style="margin-left: 10px;">
                                    <input type="checkbox" v-model="input.showThuocTinh" />
                                    <span v-if="input.showThuocTinh">On</span>
                                    <span v-else>Off</span>
                                </label>
                            </span>
                            <div class="col-12 col-sm-12 row" v-if="input.showThuocTinh">
                                <div class="col-md-6" v-show="input.listThuocTinhChose.length > 0">
                                    <label>Tên thuộc tính</label>
                                    <select class="form-control" v-for="(ds, index) in input.listThuocTinhChose" :key="index" v-model="ds.key" @change="thuocTinhChange(index, $event)">
                                        <option v-for="(thuocTinh, index) in input.danhSachNhomThuocTinh" :key="index" :value="index">{{ thuocTinh.name }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6" v-show="input.listThuocTinhChose.length > 0">
                                    <label>Giá trị thuộc tính</label>
                                    <b-form-tags 
                                        input-id="tags-basic" 
                                        v-for="ds in input.listThuocTinhChose" :key="ds.id" 
                                        v-model="ds.value" 
                                        disabled
                                        placeholder=""
                                    >
                                    </b-form-tags>
                                </div>

                                <button class="btn btn-sm btn-primary mt-5" 
                                    v-if="input.listThuocTinhChose.length > 0 && input.danhSachNhomThuocTinh.length > input.listThuocTinhChose.length"
                                    @click="themThuocTinh()"
                                >Thêm mới thuộc tính</button>

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
    .switch.switch-sm input:empty~span {
        width: 65px;
        text-align: end;
        background-color: #ebedf3;
        line-height: 24px;
        padding-right: 5px;
    }
    input[type=checkbox] {
        transform: scale(1.5);
    }
</style>

<script>
import Swal from "sweetalert2";
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import axios from "axios";

export default {
    data() {
        return {
            data: {
                danhMuc: [],
                donViKhoiLuong: [],
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
                showThuocTinh:true,
                danhSachNhomThuocTinh: [],
                listThuocTinh: [],
                listThuocTinhChose: [],
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
                product_image_url: '',
                providers: '',
                minimum_inventory: '',
                tax_percent: ''
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
        bangThuocTinh: function() {
            let bangThuocTinh = [];
            if ( this.input.listThuocTinhChose.length <= 1) {
                this.input.listThuocTinhChose.forEach(thuocTinh => {
                    thuocTinh.value.forEach((value, key) => {
                        bangThuocTinh.push({
                            name: this.input.product_name + ' - ' + value,
                            text: [value],
                            prices: 0,
                            cost_prices: 0,
                            product_entity_cd: '',
                            sku_entity: '',
                            is_overwrite_prices: false,
                            minimum_inventory: 0,
                            value_type: [thuocTinh.value_type[key].type],
                            value_id: [thuocTinh.value_type[key].attribute_id],
                            error_prices: '',
                            error_cost_prices: '',
                            error_product_entity_cd: '',
                            error_sku_entity: '',
                            error_minimum_inventory: ''
                            // has_options: false
                        })
                    });
                });
            } else {
                this.input.listThuocTinhChose[0].value.forEach((value, key) => {
                    bangThuocTinh.push({
                        name: this.input.product_name + ' - ' + value,
                        text: [value],
                        prices: 0,
                        cost_prices: 0,
                        product_entity_cd: '',
                        sku_entity: '',
                        is_overwrite_prices: false,
                        minimum_inventory: 0,
                        value_type: [this.input.listThuocTinhChose[0].value_type[key].type],
                        value_id: [this.input.listThuocTinhChose[0].value_type[key].attribute_id],
                        error_prices: '',
                        error_cost_prices: '',
                        error_product_entity_cd: '',
                        error_sku_entity: '',
                        error_minimum_inventory: ''
                        // has_options: false
                    })
                });
                for (let j = 1; j < this.input.listThuocTinhChose.length; j++) {
                    bangThuocTinh = this.looper(bangThuocTinh, this.input.listThuocTinhChose[j].value_type);
                }
            }
            
            return bangThuocTinh;
        }
    },
    methods: {
        looper(array, arrayData) {
            let result = [];
            array.forEach(valueI => {
                arrayData.forEach(valueII => {
                    result.push({
                        name: valueI.name + ' - ' + valueII.value,
                        text: valueI.text.concat([valueII.value]),
                        prices: 0,
                        cost_prices: 0,
                        product_entity_cd: '',
                        sku_entity: '',
                        is_overwrite_prices: false,
                        minimum_inventory: 0,
                        value_type: valueI.value_type.concat([valueII.type]),
                        value_id: valueI.value_id.concat([valueII.attribute_id]),
                        error_prices: '',
                        error_cost_prices: '',
                        error_product_entity_cd: '',
                        error_sku_entity: '',
                        error_minimum_inventory: ''
                        // has_options: false
                    });
                });
            });

            return result;
        },
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
            this.errorsValidate.product_image_url = '';
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
                    _that.errorsValidate.product_image_url = 'Ảnh sản phẩm phải là ảnh tối đa 2MB';
                });
            }).catch(function(_ref){
                _that.page.loadingUploadAnhSanPham = false;
                _that.page.loadingAjax = false;
                _that.errorsValidate.product_image_url = 'Ảnh sản phẩm phải là ảnh tối đa 2MB';
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
            formData.append('minimum_inventory', this.input.minimum_inventory);
            formData.append('product_type', 'single');
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

            //Bảng acc_t_product_entities
            //Bảng acc_t_product_entity_prices
            if (this.input.showThuocTinh) {
                this.bangThuocTinh.forEach(thuocTinh => {
                    formData.append('product_entity_cd[]', thuocTinh.product_entity_cd);
                    formData.append('sku_entity[]', thuocTinh.sku_entity);
                    formData.append('is_overwrite_prices[]', thuocTinh.is_overwrite_prices ? 1 : 0);
                    formData.append('minimum_inventory_entity[]', thuocTinh.minimum_inventory);
                    // formData.append('has_options[]', thuocTinh.has_options);
                    formData.append('prices[]', thuocTinh.prices);
                    formData.append('wholesale_prices[]', this.input.old_wholesale_prices);
                    formData.append('cost_prices[]', thuocTinh.cost_prices);
                    formData.append('product_entity_attribute_id[]', thuocTinh.value_id);
                    formData.append('product_entity_attribute_value[]', thuocTinh.text);
                    formData.append('product_entity_attribute_type[]', thuocTinh.value_type);
                });
                formData.append('old_prices', this.input.old_prices);
                formData.append('old_wholesale_prices', this.input.old_wholesale_prices);
                formData.append('old_cost_prices', this.input.old_cost_prices);
            }

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
        selectLoaiSanPham: function (node) {
            let attributes_group = this.data.danhMuc.filter(word => word.id == node.id)[0].attributes_group;
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

            this.themThuocTinh();
        },
        thuocTinhChange: function(index, e) {
            let ary_value = [];
            let value_type = [];
            let chose = this.input.danhSachNhomThuocTinh[e.target.value];
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
            this.input.listThuocTinhChose[index].value = ary_value;
            this.input.listThuocTinhChose[index].value_type = value_type;
            this.input.listThuocTinhChose[index].name = chose.name;
        },
        themThuocTinh: function() {
            this.input.listThuocTinhChose.push({
                value: [],
                value_type: [],
                name: '',
                key: null
            });
        }
    }
}
</script>