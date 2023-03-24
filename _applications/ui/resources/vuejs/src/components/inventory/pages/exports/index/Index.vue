<template>
    <v-card class="white">
        <!-- Tabs -->
        <v-tabs v-model="tab">
            <v-tab>Tất cả phiếu xuất</v-tab>
            <v-tab>Phiếu chờ duyệt</v-tab>
            <v-tab>Phiếu bị từ chối</v-tab>
            <v-tab>Phiếu đã duyệt</v-tab>
            <v-tab>Phiếu đã đóng hàng</v-tab>
            <v-tab>Phiếu đã xuất kho</v-tab>
        </v-tabs>

        <!-- Filter block -->
        <filter-block class="mt-3" :filter="filter" :loading="loading"></filter-block>

        <!-- Action block -->
        <v-container>
            <div class="d-flex mt-4">
                <div class="flex-grow-1">
                    <row-per-page :filter="filter"></row-per-page>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <v-btn
                        color="primary"
                        class="font-weight-bold font-size-base text-uppercase"
                        @click="onClickBtnAdd"
                        depressed
                    >
                        Thêm phiếu <v-icon right> mdi-plus </v-icon>
                    </v-btn>

                    <approve-btn
                        class="ml-1"
                        :show="canShowApproveBtn"
                        :selected="currentSelected"
                        @success="onApproveSuccess"
                    ></approve-btn>

                    <pack-btn
                        class="ml-1"
                        :show="canShowPackBtn"
                        :selected="currentSelected"
                        @success="onPackSuccess"
                    ></pack-btn>

                    <export-btn
                        class="ml-1"
                        :show="canShowExportBtn"
                        :selected="currentSelected"
                        @success="onExportSuccess"
                    ></export-btn>
                </div>
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
                <tab-packed
                    :refresh="reloadTab"
                    :filter="filter"
                    @update:selected="onUpdateSelected"
                    :loading="loading"
                ></tab-packed>
            </v-tab-item>

            <v-tab-item>
                <tab-exported
                    :refresh="reloadTab"
                    :filter="filter"
                    @update:selected="onUpdateSelected"
                    :loading="loading"
                ></tab-exported>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
</template>

<script type="text/javascript">
import Filter from "@/components/inventory/base_filter.js";
import FilterBlock from "./FilterBlock";
import TabDefault from "./TabDefault";
import TabWaiting from "./TabWaiting";
import TabReject from "./TabReject";
import TabResolve from "./TabResolve";
import TabPacked from "./TabPacked";
import TabExported from "./TabExported";
import RowPerPage from "./RowPerPage";
import ApproveBtn from "./ApproveBtn";
import ExportBtn from "./ExportBtn";
import PackBtn from "./PackBtn";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";

import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import FetchListStatusMixin from "@/components/inventory/utils/mixins/FetchListStatusMixin";

export default {
    name: "InventoryGoodsIssueIndex",
    mixins: [EmitsMixin, PopupMessagesMixin, FetchListStatusMixin],
    components: {
        FilterBlock,
        TabDefault,
        TabWaiting,
        TabReject,
        TabResolve,
        TabPacked,
        TabExported,
        RowPerPage,
        ApproveBtn,
        ExportBtn,
        PackBtn,
    },

    data: () => ({
        TAB_DEFAULT: 0,
        TAB_WAITING: 1,
        TAB_REJECT: 2,
        TAB_RESOLVE: 3,
        TAB_PACKED: 4,
        TAB_EXPORTED: 5,

        filter: new Filter({ limit: 10 }),
        loading: false,
        tab: null,
        selected: {},
        reloadTab: 0,
    }),

    computed: {
        /**
         * Determines ability to show approve button.
         */
        canShowApproveBtn() {
            return ![this.TAB_REJECT, this.TAB_RESOLVE, this.TAB_PACKED, this.TAB_EXPORTED].includes(this.tab);
        },

        /**
         * Determines ability to show pack button.
         *
         * @return     {Array}  True if able to show pack button, False otherwise.
         */
        canShowPackBtn() {
            return [this.TAB_RESOLVE, this.TAB_DEFAULT].includes(this.tab);
        },

        /**
         * Determines ability to show export button.
         */
        canShowExportBtn() {
            return ![this.TAB_WAITING, this.TAB_REJECT, this.TAB_RESOLVE, this.TAB_EXPORTED].includes(this.tab);
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentSelected() {
            return this.selected[this.tab] || [];
        },

        /**
         * Determines ability to export.
         */
        canExport() {
            return this.currentSelected.length;
        },

        /**
         * Determines ability to pack.
         *
         * @return     {boolean}  True if able to pack, False otherwise.
         */
        canPack() {
            return this.currentSelected.length;
        },
    },

    methods: {
        /**
         * Called on click button add.
         */
        onClickBtnAdd() {
            this.$router.push({ name: "inv.export.goods-issue.create" });
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
        onPackSuccess() {
            console.log("ssss");
            this.reload();
        },

        /**
         * { function_description }
         */
        onExportSuccess() {
            this.reload();
        },

        /**
         * { function_description }
         */
        reload() {
            this.reloadTab++;
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Phiếu xuất kho" }, { title: "Danh sách" }]);
    },
};
</script>

<style lang="scss" scoped></style>
