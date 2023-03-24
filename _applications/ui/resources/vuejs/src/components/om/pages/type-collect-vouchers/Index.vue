<template>
    <v-card class="om-wp">
        <v-card-title primary-title> Danh sách Loại chứng từ thu </v-card-title>
        <v-card-text>
            <div class="d-flex">
                <RowPerPage :filter="filter"></RowPerPage>
                <div class="flex-grow-1 d-flex justify-content-end">
                    <v-btn color="blue white--text" @click.stop="onClickBtnAddNew"> Thêm mới loại chứng từ thu </v-btn>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="table table-bordered mb-0 mt-3">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Hạch toán kết quả KD ?</th>
                            <th>Hiệu lực ?</th>
                            <th>Mô tả</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Tiện ích</th>
                        </tr>
                    </thead>
                    <tbody v-if="collection">
                        <IndexTableRow
                            v-for="(model, idx) in collection"
                            :key="idx"
                            :idx="idx"
                            :model="model"
                            @[EMITS.CLICK_UPDATE]="handleUpdateRow"
                            @[EMITS.CLICK_DELETE]="handleDeleteRow"
                        ></IndexTableRow>
                    </tbody>

                    <tbody v-else>
                        <tr>
                            <td colspan="12">
                                <div class="p-5 text-center font-weight-bold">Không có phiếu nào.</div>
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
        </v-card-text>

        <modal :name="MODAL_CREATE" height="auto" :adaptive="true">
            <create
                @[EMITS.CLOSE]="onCreateClose"
                @[EMITS.CANCEL]="onCreateCancel"
                @[EMITS.CREATING]="onCreating"
                @[EMITS.CREATED]="onCreated"
                @[EMITS.ERROR]="onCreateError"
                :show-close-btn="true"
            ></create>
        </modal>

        <modal :name="MODAL_EDIT" height="auto" :adaptive="true">
            <edit
                :edit-id="editID"
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
import { SET_BREADCRUMB, SET_ACTION } from "@/core/services/store/breadcrumbs.module";

import Collection from "@/core/collection";
import TypeCollectVouchers from "@/models/type-collect-vouchers/type_collect_vouchers";
import { FormFilter } from "./filter";

import RowPerPage from "@/components/om/shared/buttons/RowPerPage";
import IndexTableRow from "./IndexTableRow";
import Create from "./Create";
import Edit from "./Edit";

import PopupMessagesMixin from "@/components/om/utils/mixins/PopupMessagesMixin";
import EmitsMixin from "@/components/om/utils/mixins/EmitsMixin";

export default {
    name: "Index",

    mixins: [PopupMessagesMixin, EmitsMixin],

    components: {
        Create,
        Edit,
        IndexTableRow,
        RowPerPage,
    },

    data: () => ({
        MODAL_CREATE: "create-modal",
        MODAL_EDIT: "edit-modal",
        editID: 0,
        filter: FormFilter,
        page: 1,
        TypeCollectVouchersModel: new TypeCollectVouchers(),
        collection: new Collection(TypeCollectVouchers),
    }),

    computed: {
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
         * @return     {<type>}
         */
        totalPage() {
            return this.collection.total_page;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        total() {
            return this.collection.total;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        currentRange() {
            let start = (this.page - 1) * this.collection.per_page + 1;
            let end = this.page * this.collection.per_page;
            end = end > this.total ? this.total : end;

            return start + "-" + end;
        },
    },

    watch: {
        page(n, o) {
            this.loadCollections();
        },
        filter: {
            deep: true,
            handler: function (n, o) {
                this.loadCollections();
            },
        },
    },

    methods: {
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
         * Called on click button add new.
         */
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
            this.loadCollections();
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
            this.updateID(this.editID);
        },

        /**
         * Called on update error.
         *
         * @param      {<type>}  event   The event
         */
        onUpdateError(event) {
            // this.hideCreateModal();
        },

        /**
         * { function_description }
         */
        debouceKeyword: _.debounce(function (evt) {
            return (this.filter.keyword = evt);
        }, 500),

        /**
         * { function_description }
         */
        async handleUpdateRow(idx) {
            this.editID = this.collection[idx].id;
            this.showEditModal();
        },

        /**
         * { function_description }
         */
        async handleDeleteRow(idx) {
            try {
                const result = await this.showPopupConfirm({
                    html: "Bạn đồng ý xóa loại chứng từ thu <b>" + this.collection[idx].code + "</b>",
                });

                if (result.isDismissed || !result.isConfirmed) {
                    return;
                }

                const response = await this.collection[idx].deleteAsync();

                this.showPopupDeleteSuccess({
                    text: "Xóa loại chứng từ thành công !",
                    timer: 1500,
                    onDestroy: () => this.loadCollections(),
                });
            } catch (e) {
                this.messageError(e);
            }
        },

        /**
         * Loads order statuses.
         *
         * @return     {Promise}
         */
        async loadCollections() {
            try {
                this.loadingStart();

                this.collection = await this.TypeCollectVouchersModel.getListAsync({
                    ...this.filter.reduces(),
                    page: this.page,
                });
            } catch (e) {
                this.handleException(e);
            }
        },

        /**
         * { function_description }
         *
         * @param      {<type>}   id      The identifier
         * @return     {Promise}  { description_of_the_return_value }
         */
        async updateID(id) {
            try {
                this.loadingStart();
                this.collection.map(function (old, index) {
                    old.id === id && old.loadById(id);
                });
                this.loadingClose();
            } catch (e) {
                console.log(e);
            }
        },
    },

    created() {
        this.filter = new FormFilter({ store_id: 1, ...this.$route.query });
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: "Chứng từ thu" },
            { title: "Loại chứng từ thu" },
            { title: "Danh sách" },
        ]);
    },
};
</script>
