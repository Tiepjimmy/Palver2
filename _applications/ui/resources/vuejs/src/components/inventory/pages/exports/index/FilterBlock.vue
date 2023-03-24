<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <filter-keyword-bar
                    v-model="filter.keyword"
                    placeholder="Nhập mã phiếu xuất để tìm kiếm"
                    aria-label="Nhập mã phiếu xuất để tìm kiếm"
                    hide-details
                    outlined
                    dense
                ></filter-keyword-bar>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Bộ lọc ngày tạo -->
                <filter-created-at-btn :range="filterCreatedAtRange" @update:selected="onUpdateCreatedAt">
                    Ngày tạo
                </filter-created-at-btn>

                <!-- Bộ lọc cửa hàng -->
                <filter-stores-btn :items="stores" @update:selected="onUpdateStores" :searchable="true">
                    Chi nhánh
                </filter-stores-btn>

                <!-- Bộ lọc kho -->
                <filter-warehouses-btn
                    :items="mock_warehouses"
                    @update:selected="onUpdateWarehouses"
                    :searchable="true"
                >
                    Kho
                </filter-warehouses-btn>

                <!-- Bộ lọc loại phiếu -->
                <filter-types-btn :items="types" @update:selected="onUpdateTypes"> Loại phiếu </filter-types-btn>

                <!-- Bộ lọc người lập -->
                <filter-created-by-btn :items="mock_users" @update:selected="onUpdateCreatedBy">
                    Người lập
                </filter-created-by-btn>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import GoodsIssue from "@/models/inventory/export/goods_issues";

import Filter from "@/components/inventory/base_filter.js";
import { default as FilterKeywordBar } from "./FilterKeywordBar";
import { default as FilterCreatedAtBtn } from "./FilterCreatedAtBtn";
import { default as FilterStoresBtn } from "./FilterStoresBtn";
import { default as FilterWarehousesBtn } from "./FilterWarehousesBtn";
import { default as FilterTypesBtn } from "./FilterTypesBtn";
import { default as FilterCreatedByBtn } from "./FilterCreatedByBtn";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
export default {
    name: "InventoryGoodsReceiptIndex",
    components: {
        FilterKeywordBar,
        FilterCreatedAtBtn,
        FilterStoresBtn,
        FilterWarehousesBtn,
        FilterTypesBtn,
        FilterCreatedByBtn,
    },

    props: {
        loading: false,
        filter: Filter,
    },

    data: () => ({
        GoodsIssueModel: new GoodsIssue(),
        filterCreatedAtRange: true,
        mock_warehouses: {
            1: "NCC 1",
            23: "Ncc so 2",
            33: "NCC ha noi",
            45: "NCC hcm",
            34: "Da nang",
            21: "Can tho",
        },
        mock_users: { 1: "Nam", 2: "Hiền", 3: "Thành", 4: "Tuấn" },
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        stores() {
            return _.get(this.$store.getters.currentPermission, "stores", []).reduce(function (res, store) {
                res[store.id] = store.store_name;
                return res;
            }, {});
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        types() {
            return this.GoodsIssueModel.typeNames();
        },
    },

    methods: {
        /**
         * { function_description }
         *
         * @param      {<type>}  value   The value
         */
        onUpdateWarehouses(value) {
            this.$set(this.filter, "warehouses", value);
            this.resetPage();
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  value   The value
         */
        onUpdateTypes(value) {
            this.$set(this.filter, "types", value);
            this.resetPage();
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  value   The value
         */
        onUpdateCreatedBy(value) {
            this.$set(this.filter, "created_by", value);
            this.resetPage();
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  value   The value
         */
        onUpdateStores(value) {
            this.$set(this.filter, "stores", value);
            this.resetPage();
        },

        /**
         * Called on update expired at.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateCreatedAt(val) {
            this.resetPage();

            if (this.filterCreatedAtRange) {
                this.$set(this.filter, "created_at", null);
                this.$set(this.filter, "created_at_from", _.first(val) || "");
                return this.$set(this.filter, "created_at_to", _.last(val) || "");
            }

            return this.$set(this.filter, "created_at", val);
        },

        /**
         * Called on update statuses.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateStatuses(val) {
            this.resetPage();
            this.$set(this.filter, "statuses", val);
        },

        /**
         * Called on update statuses.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateKeyword(val) {
            this.resetPage();
            this.$set(this.filter, "keyword", val);
        },

        /**
         * { function_description }
         */
        resetPage() {
            this.filter.p = 1;
        },
    },
};
</script>
