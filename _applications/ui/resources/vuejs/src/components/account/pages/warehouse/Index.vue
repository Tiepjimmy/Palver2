<template>
    <div>
        <div class="card">
            <!-- Search -->
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <b-form-input v-model="keyword" placeholder="Tìm kiếm theo tên kho, mã kho, địa chỉ chi tiết" v-on:keyup.enter="searchWarehouse"></b-form-input>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary btn-active-primary fw-bolder w-100" @click="searchWarehouse">
                            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                <inline-svg src="media/svg/icons/General/Search.svg" />
                            </span>
                            Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card-body table-responsive" v-if="warehouses.length && loading">
                <table class="table table-row-bordered">
                    <thead>
                    <tr class="fw-bolder fs-6 text-gray-800">
                        <th class="text-center">STT</th>
                        <th class="text-center"></th>
                        <th class="text-center">Loại kho</th>
                        <th class="text-center">Tên kho</th>
                        <th class="text-center">Mã kho</th>
                        <th class="text-center">Tổ chức đăng ký</th>
                        <th class="text-center">Địa chỉ</th>
                        <th class="text-center">SĐT hotline</th>
                        <th class="text-center">Trạng thái</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(warehouse, index) in warehouses" :key="warehouse.id" >
                        <td class="pt-5 text-center">{{index + 1}}</td>
                        <td class="text-center" >
                            <button type="button" @click="getIdWarehouse(warehouse.id)"  class="btn btn-primary btn-icon edit-test btn-active-color-white btn-sm me-1">
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                        <td class="pt-5 text-center">{{ warehouse.warehouse_type.warehouse_type_name }}</td>
                        <td class="pt-5 text-center">{{ warehouse.warehouse_name }}</td>
                        <td class="text-center pt-5">{{ warehouse.warehouse_cd }}</td>
                        <td class="text-center pt-5">
                            <p  v-for="(val,key) in warehouse.warehouse_stores" :key="key">{{ val.store_name }}</p>
                        </td>
                        <td class="pt-5 text-center">{{ warehouse.address }}</td>
                        <td class="pt-5 text-center">{{ warehouse.hotline }}</td>
                        <td class="text-dark fw-bolder mb-1 fs-6 text-center pt-5" style="text-transform: capitalize;">
                            <b-badge pill :variant="warehouse.active_status == 'active' ? 'success' : 'warning'">{{ warehouse.active_status }}</b-badge>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="row justify-content-between align-items-center">
                    <div>
                        <label class="fs-6 fw-bold mr-3">Hiển thị</label>
                        <select class="form-control w-auto d-inline-block" v-model="itemPerPage" @change="searchWarehouse">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="overflow-auto mt-10">
                        <b-pagination-nav v-model="currentPage" :link-gen="linkGen" :number-of-pages="totalPage" use-router></b-pagination-nav>
                    </div>
                </div>
            </div>
            <div class="popup-container">
                <create :warehouseModel="warehouseModel" :selectProvince="selectProvince" :selectProductType="selectProductType" :selectStore="selectStore"  @refreshWarehouse="refreshWarehouse"></create>
                <edit :items="items" :selectProvince="selectProvince" :selectProductType="selectProductType" :selectStore="selectStore"  @refreshWarehouse="refreshWarehouse"></edit>
            </div>
            <!-- No result -->
            <p class="text-danger text-center mt-4" v-if="!warehouses.length && loading">Không có kết quả tìm kiếm.</p>
            <!-- Loading -->
            <div style="display: flex;align-items: center;justify-content: center;" v-if="!loading">
                <div class="spinner-border mt-5 mb-5" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Swal from "sweetalert2";
    import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
    import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
    import Edit from './Edit';
    import Create from './Create';
    import Stores from "../../../../models/stores/stores";
    import Provinces from "../../../../models/master/provinces/provinces";
    import Warehouse from "../../../../models/warehouse/warehouse";

    export default {
        data() {
            return {
                keyword: '',
                currentPage: 1,
                totalPage: 1,
                itemPerPage: 10,
                warehouses: [],
                items:{},
                loading: false,
                provinces:[],
                stores:[],
                productType:[],
                selectStore:[],
                selectProductType:[],
                selectProvince:[],
                warehouseModel: new Warehouse(),
                storesModel: new Stores(),
                provincesModel: new Provinces(),
            };
        },
        components:{
            Create,
            Edit,
        },
        created() {
            this.warehouseModel.listdata().then((response) => {
                    this.warehouses = response.items;
                    this.totalPage = Math.ceil(response.total / this.itemPerPage);
            }).catch(error => console.log(error));
            this.warehouseModel.create().then((response) => {
                this.productType = response.warehousesType;
            }).catch(error => console.log(error));
            //Lấy tất cả danh sách tỉnh

            this.provincesModel.listdata().then((response) => {
                this.provinces = response;
            }).catch(error => console.log(error));
            //Lấy tổng công ty và tổ chức Active
            this.storesModel.create().then((response) => {
                this.stores = response.stores;
            }).catch(error => console.log(error));

        },
        watch: {
            //theo dõi sự thay đổi của biến
            currentPage: function () {
                this.paginationWarehouse();
            },
            stores:function(){
                this.selectStore = this.selectTreeStores(this.stores);
            },
            productType:function(){
                Array.from(this.productType).forEach((value,index) => {
                    this.selectProductType.push({
                        id:value.id,
                        label: value.warehouse_type_name,
                    })
                });
            },
            provinces:function(){
                Array.from(this.provinces).forEach((value,index) => {
                    this.selectProvince.push({
                        id:value.id,
                        label: value.province_name,
                    })
                });
                this.loading = true;
            },
        },
        mounted() {
            this.$store.dispatch(SET_BREADCRUMB, [
                {title: "Quản lý cấu hình kho", route: "/cau-hinh-doanh-nghiep/kho"}
            ]);
            this.$store.dispatch(SET_ACTION, [
                {type: "modal", param: "addWarehouse", text: 'Thêm mới'}
            ]);
        },
        methods: {
            getIdWarehouse(id){
                this.items = id;
            },
            //Đệ quy select tổ chức map theo cha con
            selectTreeStores(stores, childrent = null) {
                let selectTree = [];
                Array.from(stores).forEach((value,index) => {
                    if(value.parent_id === childrent) {
                        stores.slice(index)
                        selectTree.push(
                            {
                                id:value.id,
                                label: value.store_name,
                                children: this.selectTreeStores(stores,value.id)
                            });
                    }
                });
                return selectTree.length ? selectTree : null;
            },
            refreshWarehouse(){
                //Lấy tất cả danh sách danh mục
                this.loading = false;
                this.warehouseModel.listdata().then((response) => {
                        this.warehouses = response.items;
                        this.totalPage = Math.ceil(response.total / this.itemPerPage) === 0 ? 1 : Math.ceil(response.total / this.itemPerPage);
                        this.loading = true;
                    }).catch(error => console.log(error));
            },
            paginationWarehouse() {
                this.loading = false;
                let offset = parseInt(this.itemPerPage) * (parseInt(this.currentPage) - 1);
                let param = {
                    'keyword':this.keyword,
                    'limit':this.itemPerPage,
                    'offset':offset
                };
                this.warehouseModel.listdata(param).then((response) => {
                    this.warehouses = response.items;
                    this.totalPage = Math.ceil(response.total / this.itemPerPage) === 0 ? 1 : Math.ceil(response.total / this.itemPerPage);
                    this.loading = true;
                }).catch(error => console.log(error))
            },
            searchWarehouse() {
                this.loading = false;
                let offset = 0
                let param = {
                    'keyword':this.keyword,
                    'limit':this.itemPerPage,
                    'offset':offset
                };
                this.warehouseModel.listdata(param).then((response) => {
                        this.warehouses = response.items;
                        this.totalPage = Math.ceil(response.total / this.itemPerPage) === 0 ? 1 : Math.ceil(response.total / this.itemPerPage);
                        this.loading = true;
                }).catch(error => console.log(error))
            },
            linkGen() {}
        }
    }
</script>