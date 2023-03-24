<template>
    <v-card class="white">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th><img src="/media/svg/icons/General/Settings-2.svg" /></th>
                    <th
                        ><v-checkbox
                            @change="onSelectAllCheckboxChanged"
                            color="primary"
                            class="m-0 p-0"
                            hide-details
                        ></v-checkbox
                    ></th>
                    <th>STT</th>
                    <th>Mã phiếu xuất</th>
                    <th>Chi nhánh xuất</th>
                    <th>Kho xuất</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Người lập</th>
                    <th>Ngày lập</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody v-if="hasItem">
                <template v-for="(invoice, idx) in invoicesFiltered">
                    <tab-default-row
                        :idx="idx"
                        :invoice="invoice"
                        :selected-row="selectedRow(invoice.id)"
                        @update:select-row="selectRow"
                        @toggle-detail="toggleDetail"
                        @dblclick.native="onDblClickProductRow(invoice)"
                    ></tab-default-row>
                    <tab-default-row-detail
                        :idx="idx"
                        :invoice="invoice"
                        v-show="canDetailShow(invoice.id)"
                        @dblclick.native="onDblClickProductRow(invoice)"
                    ></tab-default-row-detail>
                </template>
            </tbody>

            <tbody v-else>
                <tr>
                    <td colspan="12">
                        <div class="p-5 text-center font-weight-bold"> Không có phiếu nào. </div>
                    </td>
                </tr>
            </tbody>

            <tfoot v-if="hasItem">
                <tr>
                    <td colspan="11" class="p-0">
                        <div class="d-flex">
                            <div class="d-flex align-items-center px-3">
                                Hiển thị: <b>{{ currentRange }}</b
                                >, Tổng: <b>{{ total }}</b>
                            </div>
                            <v-pagination
                                class="ml-auto"
                                v-model="page"
                                circle
                                :length="totalPage"
                                :total-visible="6"
                            ></v-pagination>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </v-card>
</template>

<script type="text/javascript">
import Filter from "@/components/inventory/base_filter.js";
import { default as TabDefaultRow } from "./TabDefaultRow";
import { default as TabDefaultRowDetail } from "./TabDefaultRowDetail";

import Collection from "@/core/collection";
import GoodsIssue from "@/models/inventory/export/goods_issues";

import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import FetchListStatusMixin from "@/components/inventory/utils/mixins/FetchListStatusMixin";

export default {
    name: "TabDefault",
    mixins: [EmitsMixin, PopupMessagesMixin, FetchListStatusMixin],
    components: { TabDefaultRow, TabDefaultRowDetail },

    props: {
        filter: Filter,
        refresh: 0,
    },

    /**
     * { function_description }
     *
     * @return     {Object}  { description_of_the_return_value }
     */
    data: () => ({
        page: 1,
        fetching: false,
        GoodsIssueModel: new GoodsIssue(),
        goodsIssueCollection: new Collection(GoodsIssue),
        invoiceIDsShowing: [],
        invoicesSelected: [],
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        status() {
            return this.prepareFilter.statuses || "all";
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        invoicesFiltered() {
            return this.goodsIssueCollection;
        },

        /**
         * Hàm này sẽ bị ghi đè ở các tab kế thừa
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        prepareFilter() {
            return this.filter;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        invoiceIDsSelected() {
            return this.invoicesSelected.map(e => e.id);
        },

        /**
         * Determines if item.
         *
         * @return     {boolean}  True if item, False otherwise.
         */
        hasItem() {
            return this.total > 0;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalPage() {
            return this.goodsIssueCollection.totalPage;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        total() {
            return this.goodsIssueCollection.total;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentRange() {
            let start = (this.page - 1) * this.goodsIssueCollection.limit + 1;
            let end = this.page * this.goodsIssueCollection.limit;
            end = end > this.total ? this.total : end;

            return start + "-" + end;
        },
    },

    watch: {
        /**
         * { function_description }
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         */
        refresh(n, o) {
            this.reloadTab();
        },

        filter: {
            immediate: true,
            deep: true,
            handler: function (n, o) {
                this.page = 1;
                this.reloadTab();
            },
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         */
        page(n, o) {
            this.reloadTab();
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         */
        invoicesSelected(n, o) {
            this.$emit("update:selected", n);
        },
    },

    methods: {
        /**
         * { function_description }
         */
        reloadTab() {
            this.clearInvoiceIDsShowing();
            this.clearInvoicesSelected();
            this.fetchInvoices();
        },

        /**
         * { function_description }
         */
        clearInvoicesSelected() {
            this.invoicesSelected.splice(0, this.invoicesSelected.length);
        },

        /**
         * { function_description }
         */
        clearInvoiceIDsShowing() {
            this.invoiceIDsShowing.splice(0, this.invoiceIDsShowing.length);
        },

        /**
         * Called when select all checkbox changed.
         *
         * @param      {<type>}  event   The event
         */
        onSelectAllCheckboxChanged(event) {
            this.invoicesSelected = event ? this.invoicesFiltered.slice() : [];
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  event   The event
         * @return     {<type>}  { description_of_the_return_value }
         */
        selectRow(obj) {
            if (obj.checked) {
                return this.invoicesSelected.push(obj.invoice);
            }

            this.invoicesSelected = this.invoicesSelected.filter(item => item.id != obj.invoice.id);
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  invoiceID  The invoice id
         * @return     {<type>}  { description_of_the_return_value }
         */
        selectedRow(invoiceID) {
            return this.invoiceIDsSelected.includes(invoiceID);
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  idx     The index
         * @return     {Array}   { description_of_the_return_value }
         */
        toggleDetail(obj) {
            return obj.open ? this.addShowingID(obj.id) : this.removeShowingID(obj.id);
        },

        /**
         * Adds a showing id.
         *
         * @param      {<type>}  ID      { parameter_description }
         * @return     {<type>}  { description_of_the_return_value }
         */
        addShowingID(ID) {
            return this.invoiceIDsShowing.push(ID);
        },

        /**
         * Removes a showing id.
         *
         * @param      {<type>}  ID      { parameter_description }
         */
        removeShowingID(ID) {
            this.invoiceIDsShowing = this.invoiceIDsShowing.filter(_ID => _ID != ID);
        },

        /**
         * Determines ability to detail show.
         *
         * @param      {<type>}   invoiceID  The invoice id
         * @return     {boolean}  True if able to detail show, False otherwise.
         */
        canDetailShow(invoiceID) {
            return this.invoiceIDsShowing.includes(invoiceID);
        },

        /**
         * Called on double click product row.
         */
        onDblClickProductRow(invoice) {
            this.openDetailInvoice(invoice);
        },

        /**
         * Opens a detail invoice.
         *
         * @param      {<type>}  id      The identifier
         */
        openDetailInvoice(invoice) {
            const params = { id: invoice.id };

            return this.$router.push({ name: "inv.export.goods-issue.show", params });
        },

        /**
         * Fetches invoices.
         *
         * @return     {Promise}  The invoices.
         */
        async fetchInvoices() {
            if (this.isListFetching) {
                return;
            }

            this.setFetchListStatusFetching();
            await this.fetchAndUpdateStore();
            this.setFetchListStatusSuccess();
        },

        /**
         * Fetches and update store.
         *
         * @return     {Promise}  And update store.
         */
        async fetchAndUpdateStore() {
            try {
                this.goodsIssueCollection = await this.GoodsIssueModel.getListAsync({
                    ...this.prepareFilter.reduces(),
                    page: this.page,
                });
            } catch (e) {
                this.showPopupError();
                console.log(e);
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
