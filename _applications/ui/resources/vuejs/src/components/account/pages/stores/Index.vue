<template>
    <div class="row">
        <div class="col-md-6">
        <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <h2 class="card-title">Cơ cấu tổ chức</h2>
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
                <edit :storesModel="storesModel" :items="items" :province="province" :converSelect="converSelect" @refreshStores="refreshStores"></edit>
                <create :storesModel="storesModel" :items="items" :province="province"  @refreshStores="refreshStores"></create>
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
import Stores from "../../../../models/stores/stores";
import Provinces from "../../../../models/master/provinces/provinces";
export default {
    data() {
        return {
            stores:[],
            items:{},
            province:[],
            converSelect:[],
            loading:false,
            storesModel : new Stores(),
            provincesModel : new Provinces()
        };
    },
    components: {
        MultilevelAccordion,
        Create,
        Edit,
        
    },
    created() {
        this.storesModel.listdata().then((response) => {
            this.stores = response;
            this.loading = true;
        }).catch(error => console.log(error));
        this.storesModel.create().then((response) => {
            this.items = response.generalCompany;
        }).catch(error => console.log(error));
        //Lấy tất cả danh sách tỉnh
        this.provincesModel.listdata().then((response) => {
            this.province = response;
        }).catch(error => console.log(error));
    },
    mounted() {
        //Thanh menu trên
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: "Dashboard", route: "/" },
            { title: "Cơ cấu tổ chức", route: "to-chuc" },
        ]);
        this.$store.dispatch(SET_ACTION, [
            {type: "modal", param: "addStores", text: 'Thêm mới'}
        ]);
    },
    watch: {
        stores:function () {
            this.converSelect = this.selectTree(this.stores);
        },

    },
    computed: {
        //Gọi hàm đệ quy
        converTree(){
            let response = {
                text:"Root",
                children:[]
            };
            response.children = this.tree(this.stores);
            return response;
        },
    },
    methods: {
        //Xử lý đệ quy hiển thị map theo cha con
        tree(stores, childrent = null) {
            let tree = [];
            Array.from(stores).forEach((value,index) => {
                if(value.parent_id === childrent) {
                    stores.slice(index)
                    tree.push(
                        {
                            id:value.id,
                            text: value.store_name,
                            children: this.tree(stores,value.id)
                        });
                }
            });
            return tree.length ? tree : null;
        },
        //Đệ quy select map theo cha con
        selectTree(parent_id, childrent = null) {
            let selectTree = [];
            Array.from(parent_id).forEach((value,index) => {
                if(value.parent_id === childrent) {
                    parent_id.slice(index)
                    selectTree.push(
                        {
                            id:value.id,
                            label: value.store_name,
                            children: this.selectTree(parent_id,value.id)
                        });
                }
            });
            return selectTree.length ? selectTree : null;
        },
        //Lấy tất cả danh sách tổ chức
        refreshStores(){
            this.loading = false;
            this.storesModel.listdata().then((response) => {
                this.stores = response;
                this.loading = true;
            }).catch(error => console.log(error));
        },
        changeItem(){
            this.items = {};
            let idStore = event.target.getAttribute('data-id');
            this.storesModel.show(idStore).then((response) => {
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
