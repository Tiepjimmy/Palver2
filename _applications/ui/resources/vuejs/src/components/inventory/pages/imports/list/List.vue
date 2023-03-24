<template>
    <v-card class="white">
        <!-- Tabs -->
        <v-tabs v-model="tab">
            <v-tab>Tất cả phiếu nhập</v-tab>
            <v-tab>Phiếu chờ duyệt</v-tab>
            <v-tab>Phiếu từ chối</v-tab>
            <v-tab>Phiếu đã duyệt</v-tab>
            <v-tab>Phiếu nhập kho</v-tab>
        </v-tabs>

        <!-- Filter block -->
        <filter-block class="mt-3" :filter="filter" :loading="loading"></filter-block>

        <v-container>
            <div class="d-flex mt-4">
                <div class="flex-grow-1">
                    <row-per-page :filter="filter"></row-per-page>
                </div>
                <v-btn color="primary" depressed @click.native="onClickBtnAdd">
                    Thêm phiếu <v-icon right> mdi-plus </v-icon>
                </v-btn>

                <approve-btn
                    class="ml-1"
                    :show="canShowApproveBtn"
                    :selected="currentSelected"
                    outlined
                    depressed
                    color="primary"
                    :confirm="false"
                    @success="onApproveSuccess"
                ></approve-btn>

                <import-btn
                    class="ml-1"
                    :show="canShowImportBtn"
                    :selected="currentSelected"
                    outlined
                    depressed
                    color="primary"
                    :confirm="false"
                    @success="onImportSuccess"
                ></import-btn>
                <!-- <v-btn outlined color="grey darken-1" class="ml-2">In phiếu <v-icon right> mdi-print </v-icon></v-btn>
        <v-btn outlined color="grey darken-1" class="ml-2">Import phiếu <v-icon right>mdi-tray-arrow-up</v-icon></v-btn>
        <v-btn outlined color="grey darken-1" class="ml-2">
          Export phiếu <v-icon right>mdi-tray-arrow-down</v-icon>
        </v-btn> -->
            </div>
        </v-container>
        <!-- tab contents -->
        <v-tabs-items v-model="tab">
            <v-tab-item>
                <tab-default
                    :refresh="reloadTab"
                    :filter="filter"
                    @update:selected="onUpdateSelected"
                    :loading="loading"
                ></tab-default>
            </v-tab-item>

            <v-tab-item>
                <tab-waiting
                    :refresh="reloadTab"
                    :filter="filter"
                    @update:selected="onUpdateSelected"
                    :loading="loading"
                ></tab-waiting>
            </v-tab-item>

            <v-tab-item>
                <tab-reject
                    :refresh="reloadTab"
                    :filter="filter"
                    @update:selected="onUpdateSelected"
                    :loading="loading"
                ></tab-reject>
            </v-tab-item>

            <v-tab-item>
                <tab-resolve
                    :refresh="reloadTab"
                    :filter="filter"
                    @update:selected="onUpdateSelected"
                    :loading="loading"
                ></tab-resolve>
            </v-tab-item>

            <v-tab-item>
                <tab-done
                    :refresh="reloadTab"
                    :filter="filter"
                    @update:selected="onUpdateSelected"
                    :loading="loading"
                ></tab-done>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
</template>

<script type="text/javascript">
import Filter from "@/components/inventory/base_filter.js";
import FilterBlock from "./FilterBlock";
import RowPerPage from "./RowPerPage";
import ImportBtn from "../shared/ImportBtn";
import ApproveBtn from "../shared/ApproveBtn";

import TabDefault from "./TabDefault";
import TabDone from "./TabDone";
import TabReject from "./TabReject";
import TabResolve from "./TabResolve";
import TabWaiting from "./TabWaiting";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";

export default {
    name: "InventoryGoodsReceiptIndex",

    components: {
        FilterBlock,
        TabDefault,
        TabDone,
        TabReject,
        TabResolve,
        TabWaiting,
        RowPerPage,
        ImportBtn,
        ApproveBtn,
    },

    data() {
        return {
            TAB_DEFAULT: 0,
            TAB_WAITING: 1,
            TAB_REJECT: 2,
            TAB_RESOLVE: 3,
            TAB_IMPORTED: 4,

            filter: new Filter(),
            loading: false,
            tab: null,
            selected: {},
            reloadTab: 0,
        };
    },

    computed: {
        /**
         * Determines ability to show approve button.
         */
        canShowApproveBtn() {
            return ![this.TAB_REJECT, this.TAB_RESOLVE, this.TAB_PACKED, this.TAB_IMPORTED].includes(this.tab);
        },

        /**
         * Determines ability to show export button.
         */
        canShowImportBtn() {
            return ![this.TAB_WAITING, this.TAB_REJECT, this.TAB_IMPORTED].includes(this.tab);
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentSelected() {
            return this.selected[this.tab] || [];
        },
    },

    methods: {
        /**
         * Called on click button add.
         */
        onClickBtnAdd() {
            this.$router.push({ name: "inv.import.goods-receipt.create" });
        },

        /**
         * Called on update selected i ds.
         *
         * @param      {<type>}  tab     The tab
         * @return     {<type>}  { description_of_the_return_value }
         */
        onUpdateSelected(n) {
            this.$set(this.selected, this.tab, n);
        },

        /**
         * { function_description }
         */
        onApproveSuccess() {
            this.reload();
        },

        /**
         * { function_description }
         */
        onImportSuccess() {
            this.reload();
        },

        /**
         * { function_description }
         */
        reload() {
            this.reloadTab++;
        },
    },

    watch: {
        tab(n, o) {
            console.log(n);
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Phiếu nhập kho" }, { title: "Danh sách" }]);
    },
};
</script>

<style lang="scss" scoped></style>
