<template>
    <v-card class="white">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th><img src="/media/svg/icons/General/Settings-2.svg" /></th>
                    <th>
                        <v-checkbox
                            @change="onSelectAllCheckboxChanged"
                            color="primary"
                            class="m-0 p-0"
                            hide-details
                        ></v-checkbox>
                    </th>
                    <th>STT</th>
                    <th>Mã phiếu nhập</th>
                    <th>Nhà cung cấp</th>
                    <th>Chi nhánh nhập</th>
                    <th>Kho nhập</th>
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
import GoodsReceipt from "@/models/inventory/import/goods_receipts";

import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import FetchListStatusMixin from "@/components/inventory/utils/mixins/FetchListStatusMixin";

export default {
    name: "TabDefault",
    mixins: [EmitsMixin, PopupMessagesMixin, FetchListStatusMixin],
    components: { TabDefaultRow, TabDefaultRowDetail },

    props: { filter: Filter, refresh: 0 },

    /**
     * { function_description }
     *
     * @return     {Object}  { description_of_the_return_value }
     */
    data() {
        return {
            page: 1,
            fetching: false,

            GoodsReceiptModel: new GoodsReceipt(),
            goodsReceiptCollection: new Collection(GoodsReceipt),
            invoicesSelected: [],
            invoiceIDsShowing: [],
        };
    },
    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        invoiceIDsSelected() {
            return this.invoicesSelected.map(e => e.id);
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        invoicesFiltered() {
            return this.goodsReceiptCollection;
        },

        /**
         * { function_description }
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        prepareFilter() {
            return this.filter;
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
            return this.goodsReceiptCollection.totalPage;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        total() {
            return this.goodsReceiptCollection.total;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentRange() {
            let start = (this.page - 1) * this.goodsReceiptCollection.limit + 1;
            let end = this.page * this.goodsReceiptCollection.limit;
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

        /**
         * { function_description }
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         */
        invoicesSelected(n, o) {
            this.$emit("update:selected", n);
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
    },

    methods: {
        /**
         * { function_description }
         */
        reloadTab() {
            this.clearInvoiceIDsShowing();
            this.clearInvoicesSelected();
            this.fetch();
        },

        /**
         * { function_description }
         */
        clearInvoiceIDsShowing() {
            this.invoiceIDsShowing.splice(0, this.invoiceIDsShowing.length);
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

            return this.$router.push({ name: "inv.import.goods-receipt.show", params });
        },

        /**
         * { function_description }
         */
        clearInvoicesSelected() {
            this.invoicesSelected.splice(0, this.invoicesSelected.length);
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
            if (obj.open) {
                return this.invoiceIDsShowing.push(obj.id);
            }

            this.invoiceIDsShowing = this.invoiceIDsShowing.filter(ID => ID != obj.id);
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
         * Fetches the object.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async fetch() {
            try {
                this.goodsReceiptCollection = await this.GoodsReceiptModel.getListAsync({
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
