<template>
    <v-card class="om-wp">
        <v-card-title class="text-h5 d-flex"> Danh sách chứng từ </v-card-title>
        <v-card-text>
            <!-- Filter Block -->
            <v-container class="p-0">
                <v-row>
                    <div class="col-12 col-sm-4">
                        <v-text-field
                            placeholder="Tìm kiếm theo mã chứng từ"
                            dense
                            elevation="0"
                            hide-details="true"
                            outlined
                            clearable
                            @input="debouceKeyword"
                            class="mb-3"
                        >
                        </v-text-field>
                        <v-select
                            :items="statuses"
                            item-text="text"
                            item-value="value"
                            v-model="filter.is_active"
                            placeholder="Chọn trạng thái chứng từ"
                            hide-details
                            outlined
                            dense
                        ></v-select>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="d-flex flex-grow-1 mb-4">
                            <div class="d-flex flex-grow-1 font-weight-bold align-items-center">Ngày tạo </div>
                            <DatePicker :range="true" @update:selected="onUpdateCreatedAt"> Ngày tạo </DatePicker>
                        </div>
                        <div class="d-flex flex-grow-1">
                            <div class="d-flex flex-grow-1 font-weight-bold align-items-center">Ngày cập nhật</div>
                            <DatePicker :range="true" @update:selected="onUpdateUpdatedAt"> Ngày cập nhật</DatePicker>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4"></div>
                </v-row>
            </v-container>
            <!-- /Filter Block -->

            <!-- Action block -->
            <v-container class="p-0">
                <div class="d-flex mt-4">
                    <div class="flex-grow-1">
                        <row-per-page :filter="filter"></row-per-page>
                    </div>
                    <div class="d-flex align-items-center justify-content-end">
                        <v-btn color="blue white--text" @click.stop="onClickBtnAddNew"> Thêm mới chứng từ thu </v-btn>
                    </div>
                </div>
            </v-container>
            <!-- /Action block -->
        </v-card-text>
        <!-- Table block -->
        <v-container class="p-0">
            <div class="row">
                <div class="col-12">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th><img src="/media/svg/icons/General/Settings-2.svg" /></th>
                                <th>Loại chứng từ</th>
                                <th>Mã chứng từ</th>
                                <th>Loại chứng từ thu</th>
                                <th>Đối tượng</th>
                                <th>Giá trị thu</th>
                                <th>Thời gian tạo</th>
                                <th>Người tạo</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody v-if="hasItem">
                            <TableRow
                                v-for="(receiptVoucher, idx) of items"
                                :key="idx"
                                :idx="idx"
                                :receipt-voucher="receiptVoucher"
                                @click.native="onClickRow(receiptVoucher)"
                            ></TableRow>
                        </tbody>

                        <tbody v-else>
                            <tr>
                                <td colspan="12">
                                    <div class="p-5 text-center font-weight-bold"> Không có chứng từ nào. </div>
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
                </div>
            </div>
        </v-container>
        <!-- /Table block -->
    </v-card>
</template>
<script type="text/javascript">
import Collection from '@/core/collection';
import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';
import FormFilter from './filter';
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import PopupMessagesMixin from '@/components/om/utils/mixins/PopupMessagesMixin';

import TableRow from './TableRow';
import RowPerPage from '@/components/om/shared/buttons/RowPerPage';
import DatePicker from '@/components/om/shared/buttons/DatePicker';
export default {
    name: 'Index',

    mixins: [EmitsMixin, PopupMessagesMixin],

    components: {
        TableRow,
        RowPerPage,
        DatePicker,
    },

    data: () => ({
        loading: false,
        reloadTab: 0,
        filter: new FormFilter(),
        page: 1,
        ReceiptVouchers: new ReceiptVouchers(),
        items: new Collection(ReceiptVouchers),
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        statuses() {
            return [
                { value: null, text: 'Tất cả' },
                ..._.map(this.ReceiptVouchers.statusNames(), (text, value) => ({ value: value, text: text })),
            ];
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
         * @return     {Object}
         */
        prepareFilter() {
            return this.filter;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        totalPage() {
            return this.items.total_page;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        total() {
            return this.items.total;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        currentRange() {
            let start = (this.page - 1) * this.items.per_page + 1;
            let end = this.page * this.items.per_page;
            end = end > this.total ? this.total : end;

            return start + '-' + end;
        },
    },

    watch: {
        filter: {
            deep: true,
            handler: function (n, o) {
                this.loadForms();
            },
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         */
        page(n, o) {
            this.loadForms();
        },
    },

    methods: {
        resetPage() {
            this.page = 1;
        },
        /**
         * { function_description }
         */
        debouceKeyword: _.debounce(function (evt) {
            return (this.filter.keyword = evt);
        }, 500),

        /**
         * Called on update updated at.
         *
         * @param      {array}  val     The value
         * @return     {void}
         */
        onUpdateUpdatedAt(val) {
            return this.updateTimeFilter(val, 'updated_date');
        },

        /**
         * Called on update created at.
         *
         * @param      {array}  val     The value
         * @return     {void}
         */
        onUpdateCreatedAt(val) {
            return this.updateTimeFilter(val, 'created_date');
        },

        /**
         * Called on update expired at.
         *
         * @param      {array}   val        The value
         * @param      {string}  fieldName  The field name
         * @return     {void}
         */
        updateTimeFilter(val, fieldName) {
            this.resetPage();

            this.$set(this.filter, fieldName, null);
            this.$set(this.filter, fieldName + '_from', _.first(val) || '');
            this.$set(this.filter, fieldName + '_to', _.last(val) || '');
        },

        /**
         * { function_description }
         */
        async handleUpdateRow(idx) {
            this.$router.push({
                name: 'om.receipt_vouchers.update',
                params: { id: this.formCollection[idx].id },
            });
        },

        /**
         * Called on click button add new.
         */
        onClickBtnAddNew() {
            this.$router.push({ name: 'om.receipt_vouchers.create' });
        },

        /**
         * Called on click delete row.
         *
         * @param      {<type>}  ReceiptVoucher  The receipt voucher
         */
        onClickRow(receiptVoucher) {
            this.$router.push({ name: 'om.receipt_vouchers.show', params: { id: receiptVoucher.id } });
        },

        /**
         * Loads order statuses.
         *
         * @return     {Promise}
         */
        async loadForms() {
            try {
                this.loadingStart();

                this.items = await this.ReceiptVouchers.getListAsync({ ...this.filter.reduces(), page: this.page });
            } catch (e) {
                this.handleException(e);
            }
        },
    },

    created() {
        this.filter = new FormFilter({ store_id: 1, ...this.$route.query });
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: 'Chứng từ thu' }, { title: 'Danh sách' }]);
    },
};
</script>
