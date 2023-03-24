<template>
    <div class="row">
        <div class="col-md-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h2 class="card-title">Loại sản phẩm</h2>
                </div>
                <div class="card-body">
                    <div style="display: flex;align-items: center;justify-content: center; text-align:center" v-if="!loading">
                        <div class="spinner-border mt-5 mb-5" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <div class="multilevel" v-if="loading">
                        <multilevel-accordion
                                :tree="converTree"
                                :marginLeft="-1"
                                :level-expanded="2"
                                class="max-w-md mx-auto px-5"
                        >
                            <template slot-scope="{ tree, interleaved, expanded, leaf }">
                                <div

                                        class="
                                    multilevel-tree
                                    mb-3
                                    p-3
                                    border
                                    rounded-lg
                                    cursor-pointer
                                "
                                        style="
                                    transition: box-shadow 0.2s ease-out,
                                    background-color 0.2s ease-out,
                                    transform 0.2s ease-out;
                                "
                                        :class="{
                                    'bg-green-100': interleaved,
                                    'bg-green-200': !interleaved,
                                    'hover:text-blue-600 move-right': leaf,

                                }"
                                        :data-id="tree.id"
                                        @click="changeItem"
                                >
                                    <p :data-id="tree.id" class="mb-0">
                                        <span  :data-id="tree.id"
                                               v-if="!leaf"
                                        >{{ expanded ? "&#8681;" : "&#8680;" }} |
                                        </span>
                                        <span  :data-id="tree.id"
                                               class="txt-to-chuc">{{ tree.text }}</span>
                                    </p>
                                </div>
                            </template>
                        </multilevel-accordion>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h2 class="card-title">Thông tin</h2>
                </div>
                <edit :catalogsModel="catalogsModel" :items="items" :converSelect="converSelect" :converSelectStore="converSelectStore" @refreshCatalog="refreshCatalog"></edit>
                <create :catalogsModel="catalogsModel" :items="items" :converSelectActive="converSelectActive"  :converSelectStore="converSelectStore" @refreshCatalog="refreshCatalog"></create>
            </div>
            <!--end::Card-->
        </div>
    </div>
</template>

<script>
    import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
    import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
    import MultilevelAccordion from "../../../shared/multilevel-accordion/MultilevelAccordion.vue";
    import Edit from './Edit';
    import Create from './Create';
    import ProductCatalogs from "../../../../models/product-catalogs/product-catalogs";
    import Stores from "../../../../models/stores/stores";
    export default {
        data() {
            return {
                catalogs:[],
                catalogsIsActive:[],
                converSelect:[],
                items:{},
                stores:[],
                converSelectActive:[],
                converSelectStore:[],
                loading:false,
                catalogsModel : new ProductCatalogs(),
                storesModel : new Stores()

            };
        },
        components: {
            MultilevelAccordion,
            Create,
            Edit,

        },
        created() {
            this.catalogsModel.listdata().then((response) => {
                this.catalogs = response;
                this.loading = true;
            }).catch(error => console.log(error));

            this.catalogsModel.create().then((response) => {
                this.items = response.productCatalogsItems;
                this.catalogsIsActive = response.productCatalogs;
            }).catch(error => console.log(error));

            this.storesModel.create().then((response) => {
                this.stores = response.stores;
            }).catch(error => console.log(error));
        },
        mounted() {
            //Thanh menu trên
            this.$store.dispatch(SET_BREADCRUMB, [
                { title: "Dashboard", route: "/" },
                { title: "Loại sản phẩm", route: "product-catalogs" },
            ]);
            this.$store.dispatch(SET_ACTION, [
                {type: "modal", param: "addCatalog", text: 'Thêm mới'}
            ]);
        },
        watch: {
            //theo dõi sự thay đổi của biến
            catalogsIsActive:function(){
                this.converSelectActive = this.selectTree(this.catalogsIsActive);
            },
            catalogs:function(){
                this.converSelect = this.selectTree(this.catalogs);
            },
            stores:function(){
                this.converSelectStore = this.selectTreeStore(this.stores);
            }
        },
        computed: {
            //Gọi hàm đệ quy
            converTree(){
                let response = {
                    text:"Root",
                    children:[]
                };
                response.children = this.tree(this.catalogs);
                return response;
            },
        },
        methods: {
            //Xử lý đệ quy hiển thị map theo cha con
            tree(Catalogs, childrent = null) {
                let tree = [];
                Array.from(Catalogs).forEach((value,index) => {
                    if(value.parent_id === childrent) {
                        Catalogs.slice(index)
                        tree.push(
                            {
                                id:value.id,
                                text: value.product_catalog_name,
                                children: this.tree(Catalogs,value.id)
                            });
                    }
                });
                return tree.length ? tree : null;
            },
            //Đệ quy select map theo cha con
            selectTree(catalogs, childrent = null) {
                let selectTree = [];
                Array.from(catalogs).forEach((value,index) => {
                    if(value.parent_id === childrent) {
                        catalogs.slice(index)
                        selectTree.push(
                            {
                                id:value.id,
                                label: value.product_catalog_name,
                                children: this.selectTree(catalogs,value.id)
                            });
                    }
                });
                return selectTree.length ? selectTree : null;
            },
            selectTreeStore(stores, childrent = null) {
                let selectTree = [];
                Array.from(stores).forEach((value,index) => {
                    if(value.parent_id === childrent) {
                        stores.slice(index)
                        selectTree.push(
                            {
                                id:value.id,
                                label: value.store_name,
                                children: this.selectTreeStore(stores,value.id)
                            });
                    }
                });
                return selectTree.length ? selectTree : null;
            },
            //Lấy tất cả danh sách tổ chức
            refreshCatalog(){
                this.loading = false;
                this.catalogsModel.listdata().then((response) => {
                    this.catalogs = response;
                    this.loading = true;
                }).catch(error => console.log(error));
            },
            changeItem(){
                this.items = {};
                let idCatalog = event.target.getAttribute('data-id');
                this.catalogsModel.show(idCatalog).then((response) => {
                    this.items = response;
                }).catch(error => console.log(error));
            }
        },

    };
</script>
<style scoped>
    .txt-to-chuc{
        font-weight: 600;
    }
</style>
