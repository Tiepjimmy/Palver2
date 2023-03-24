<template>
    <v-card class="white">
        <filter-block :loading="isListFetching" :filter="filter"></filter-block>

        <v-container class="mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <v-select
                                :items="rowPerPageOptions"
                                v-model="filter.limit"
                                dense
                                outlined
                                hide-details
                                :style="{ width: 'min-content' }"
                            >
                            </v-select>
                        </div>
                        <v-btn color="primary" @click.stop="onClickBtnAddNew">
                            Thêm mới <v-icon right> mdi-plus </v-icon>
                        </v-btn>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="inv-table-wrapper">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Lô</th>
                                    <th>Hạn sử dụng</th>
                                    <th>Trạng thái</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                <lot-list-row
                                    v-for="(lot, index) of lots"
                                    :key="index"
                                    :lot="lot"
                                    @edit:lot="onUpdateLot"
                                    @delete:lot="onDeleteLot"
                                ></lot-list-row>
                            </tbody>
                            <tfoot v-if="canShowPaginate">
                                <tr>
                                    <td colspan="8" class="p-0">
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
                                                @input="paginate"
                                            ></v-pagination>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </v-container>

        <modal :name="MODAL_CREATE" height="auto" :adaptive="true" :shiftY="0.1">
            <create
                @[EMITS.CLOSE]="onCreateClose"
                @[EMITS.CANCEL]="onCreateCancel"
                @[EMITS.CREATING]="onCreating"
                @[EMITS.CREATE_AND_CONTINUE]="onCreateAndContinue"
                @[EMITS.CREATED]="onCreated"
                @[EMITS.ERROR]="onCreateError"
                :show-close-btn="true"
            ></create>
        </modal>

        <modal :name="MODAL_EDIT" height="auto" :adaptive="true" :shiftY="0.1">
            <edit
                :lot-id="lotEditID"
                @[EMITS.CLOSE]="onUpdateClose"
                @[EMITS.CANCEL]="onUpdateCancel"
                @[EMITS.UPDATING]="onUpdating"
                @[EMITS.UPDATED]="onUpdated"
                @[EMITS.ERROR]="onUpdateError"
                :show-close-btn="true"
            >
            </edit>
        </modal>
    </v-card>
</template>

<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';
import { default as Edit } from '../edit/Edit';
import { default as Create } from '../create/Create';
import { default as FilterBlock } from './FilterBlock';
import { default as LotListRow } from './LotListRow';

import * as Request from '@/components/inventory/utils/Request';
import * as HttpCodes from '@/components/inventory/utils/HttpCodes';
import EmitsMixin from '@/components/inventory/utils/mixins/EmitsMixin';
import PopupMessagesMixin from '@/components/inventory/utils/mixins/PopupMessagesMixin';
import FetchListStatusMixin from '@/components/inventory/utils/mixins/FetchListStatusMixin';

import Collection from '@/core/collection';
import Filter from '@/components/inventory/base_filter.js';
import LotModel from '@/models/inventory/common/lot';

export default {
    name: 'List',
    mixins: [EmitsMixin, PopupMessagesMixin, FetchListStatusMixin],
    components: { FilterBlock, Create, LotListRow, Edit },

    data: () => ({
        rowPerPageOptions: [10, 15, 20, 50, 100],

        MODAL_CREATE: 'modal-create',
        MODAL_EDIT: 'modal-edit',

        filter: new Filter({ limit: 10 }),

        lots: new Collection(LotModel),

        storeID: 1,
        lotEditID: 0,
    }),

    computed: {
        /**
         * Determines ability to show paginate.
         *
         * @return     {boolean}  True if able to show paginate, False otherwise.
         */
        canShowPaginate() {
            return this.totalPage > 0;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        page: {
            set(v) {
                this.filter.page = v;
            },
            get() {
                return this.lots.page;
            },
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        totalPage() {
            return this.lots.totalPage;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        total() {
            return this.lots.total;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        currentRange() {
            let start = (this.lots.page - 1) * this.lots.limit + 1;
            let end = this.lots.page * this.lots.limit;
            end = end > this.total ? this.total : end;

            return start + '-' + end;
        },
    },

    watch: {
        filter: {
            immediate: true,
            deep: true,
            handler: function (n, o) {
                this.fetchList();
            },
        },
    },

    methods: {
        onClickBtnAddNew() {
            this.showCreateModal();
        },

        /**
         * Called on create close.
         *
         * @param      {<type>}  event   The event
         */
        onCreateClose(event) {
            this.hideCreateModal();
        },

        /**
         * Called on create cancel.
         *
         * @param      {<type>}  event   The event
         */
        onCreateCancel(event) {
            this.hideCreateModal();
        },

        /**
         * Called on create save.
         *
         * @param      {<type>}  event   The event
         */
        onCreating(event) {
            // this.hideCreateModal();
        },

        /**
         * Called when create saved.
         *
         * @param      {<type>}  event   The event
         */
        onCreated(event) {
            this.hideCreateModal();
            this.fetchList();
        },

        /**
         * Called on create saved error.
         *
         * @param      {<type>}  event   The event
         */
        onCreateError(event) {
            // this.hideCreateModal();
        },

        /**
         * Called on create save and continue.
         *
         * @param      {<type>}  event   The event
         */
        onCreateAndContinue(event) {
            this.fetchList();
        },

        /**
         * Called on edit close.
         *
         * @param      {<type>}  event   The event
         */
        onUpdateClose(event) {
            this.hideEditModal();
        },

        /**
         * Called on edit cancel.
         *
         * @param      {<type>}  event   The event
         */
        onUpdateCancel(event) {
            this.hideEditModal();
        },

        /**
         * Called on edit save.
         *
         * @param      {<type>}  event   The event
         */
        onUpdating(event) {
            // this.hideEditModal();
        },

        /**
         * Called when updated.
         *
         * @param      {<type>}  event   The event
         */
        onUpdated(event) {
            this.hideEditModal();
            this.updateLotsByLotID(this.lotEditID);
        },

        /**
         * Hides the dialog create.
         */
        hideCreateModal() {
            this.$modal.hide(this.MODAL_CREATE);
        },

        /**
         * Shows the dialog create.
         */
        showCreateModal() {
            this.$modal.show(this.MODAL_CREATE);
        },

        /**
         * Hides the dialog create.
         */
        hideEditModal() {
            this.$modal.hide(this.MODAL_EDIT);
        },

        /**
         * Shows the dialog Edit.
         */
        showEditModal() {
            this.$modal.show(this.MODAL_EDIT);
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  lotID   The lot id
         */
        async updateLotsByLotID(lotID) {
            try {
                this.loadingStart();
                this.lots.map(function (oldLot, index) {
                    oldLot.id === lotID && oldLot.loadById(lotID);
                }, this);
                this.loadingClose();
            } catch (e) {
                console.log(e);
            }
        },

        /**
         * Called on edit saved error.
         *
         * @param      {<type>}  event   The event
         */
        onUpdateError(event) {
            // this.modalEdit = false;
        },

        /**
         * Called on delete lot.
         *
         * @param      {<type>}  lotID   The lot id
         */
        onDeleteLot(lotID) {
            //
        },

        /**
         * Called on edit lot.
         *
         * @param      {<type>}  lotID   The lot id
         */
        onUpdateLot(lotID) {
            this.lotEditID = lotID;
            this.showEditModal();
        },

        /**
         * Fetches the object.
         *
         * @return     {Promise}
         */
        async fetchList() {
            if (this.isListFetching) {
                return;
            }

            this.setFetchListStatusFetching();

            try {
                this.lots = await new LotModel().getListAsync(this.filter.reduces());

                this.setFetchListStatusSuccess();
            } catch (e) {
                this.setFetchListStatusError();

                return this.messageError(e);
            }
        },

        /**
         * Phân trang
         *
         * @return     {Promise}
         */
        async paginate() {
            this.filter.offset = (this.page - 1) * this.filter.limit;

            await this.fetchList();
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: 'Danh mục lô' }, { title: 'Danh sách' }]);
    },
};
</script>

<style lang="scss" scoped></style>
