<template>
    <v-card class="om-wp">
        <v-card-title primary-title> Danh sách trạng thái Đơn hàng </v-card-title>
        <v-card-text>
            <div class="row">
                <div class="col-5 mr-auto">
                    <label class="form-label font-weight-bold">Trạng thái</label>
                    <v-text-field
                        placeholder="Tìm trạng thái đơn hàng"
                        @input="debouceKeyword"
                        dense
                        outlined
                        hide-details
                    ></v-text-field>
                </div>

                <div class="col-3">
                    <label class="form-label font-weight-bold">Phân loại</label>
                    <v-select
                        v-model="filter.type"
                        :items="types"
                        placeholder="Tất cả phân loại"
                        outlined
                        dense
                        hide-details
                        item-text="name"
                        item-value="id"
                    ></v-select>
                </div>

                <div class="col-3">
                    <label class="form-label font-weight-bold">Level</label>
                    <v-select
                        v-model="filter.level"
                        :items="levels"
                        placeholder="Tất cả level"
                        outlined
                        dense
                        hide-details
                        item-text="name"
                        item-value="id"
                    ></v-select>
                </div>
            </div>
            <div class="d-flex form-inline mt-3">
                <select class="form-control" width="" v-model="filter.limit">
                    <option v-for="value of rowPerPageOptions" :value="value">{{ value }}</option>
                </select>
                <div class="flex-grow-1 d-flex justify-content-end">
                    <v-btn color="blue white--text" @click.stop="onClickBtnAddNew"> Thêm mới </v-btn>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="table table-bordered mb-0 mt-3">
                    <thead>
                        <tr>
                            <th>Tiện ích</th>
                            <th>STT</th>
                            <th>Level</th>
                            <th>Trạng thái</th>
                            <th>Phân loại</th>
                            <th>Chức năng</th>
                            <th>Tính doanh thu</th>
                            <th>Hiệu lực</th>
                        </tr>
                    </thead>
                    <tbody>
                        <IndexTableRow
                            v-for="(status, idx) in statusCollection"
                            :key="idx"
                            :idx="stt(idx)"
                            :status="status"
                            @click-update="handleUpdateRow"
                            @click-delete="handleDeleteRow"
                        ></IndexTableRow>
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

            <modal :name="MODAL_CREATE" height="auto" width="600" :shiftY="0.1">
                <create @close="onCreateClose" @cancel="onCreateCancel" @created="onCreated" :show-close-btn="true">
                </create>
            </modal>

            <modal :name="MODAL_UPDATE" height="auto" width="600" :shiftY="0.1">
                <update
                    :status-model="updateModel"
                    @close="onUpdateClose"
                    @cancel="onUpdateCancel"
                    @updated="onUpdated"
                    :show-close-btn="true"
                >
                </update>
            </modal>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import Swal from "sweetalert2";
import Collection from "@/core/collection";
import { OrderStatusFilter } from "./filter";
import OrderStatus from "@/models/order/order_status";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";

import { default as IndexTableRow } from "./IndexTableRow";
import { default as Create } from "./Create";
import { default as Update } from "./Update";

import * as Request from "@/components/om/utils/Request";
import * as MessageConst from "@/components/om/utils/MessageConst";

export default {
    name: "OrderStatusIndex",

    components: {
        IndexTableRow,
        Create,
        Update,
    },

    data: () => ({
        rowPerPageOptions: [10, 15, 20, 50, 100],
        filter: Object,
        OrderStatusModel: new OrderStatus(),
        statusCollection: new Collection(OrderStatus),

        updateModel: OrderStatus,
        deleteModel: OrderStatus,
        deleteStatus: false,

        MODAL_CREATE: "modal-create",
        MODAL_UPDATE: "modal-update",
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        types() {
            const types = this.OrderStatusModel.types();

            return Object.keys(types).reduce(
                function (res, id) {
                    return _.tap(res, res => res.push({ id: id, name: types[id].name }));
                },
                [{ id: 0, name: "Tất cả " }]
            );
        },

        /**
         * { function_description }
         */
        levels() {
            let raw = {};

            if (!this.filter.type) {
                raw = _.reduce(
                    this.OrderStatusModel.types(),
                    function (res, item) {
                        return { ...res, ...item.levels };
                    },
                    {}
                );
            } else {
                raw = _.get(this.OrderStatusModel.types(), `${this.filter.type}.levels`, []);
            }

            return [{ id: 0, name: "Tất cả " }, ..._.map(raw, (e, i) => ({ id: i, name: "Level " + e }))];
        },

        /**
         * Determines if deleting.
         *
         * @return     {boolean}  True if deleting, False otherwise.
         */
        isDeleting() {
            return this.deleteStatus === Request.DELETING;
        },

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
         * @return     {<type>}  { description_of_the_return_value }
         */
        page: {
            set(v) {
                this.filter.p = v;
            },
            get() {
                return this.statusCollection.page;
            },
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalPage() {
            return this.statusCollection.totalPage;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        total() {
            return this.statusCollection.total;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentRange() {
            let start = (this.statusCollection.page - 1) * this.statusCollection.limit + 1;
            let end = this.statusCollection.page * this.statusCollection.limit;
            end = end > this.total ? this.total : end;

            return start + "-" + end;
        },

        /**
         * Determines if deleted.
         *
         * @return     {boolean}  True if deleted, False otherwise.
         */
        isDeleted() {
            return this.deleteStatus === Request.SUCCESS;
        },
    },

    watch: {
        "filter.type": function (n, o) {
            this.filter.level = 0;
            this.filter.setPage();
        },

        "filter.limit": function (n, o) {
            this.filter.setPage();
        },

        "filter.keyword": function (n, o) {
            this.filter.setPage();
        },

        "filter.level": function (n, o) {
            this.filter.setPage();
        },

        filter: {
            deep: true,
            handler: function (n, o) {
                this.loadOrderStatuses();
            },
        },
    },

    methods: {

        /**
         * { function_description }
         *
         * @param      {number}  idx     The index
         */
        stt(idx) {
            return (this.statusCollection.page - 1) * this.statusCollection.limit + idx;
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
        async handleUpdateRow(id) {
            try {
                await this.setUpdateModel(id);
                this.showUpdateDialog();
            } catch (e) {
                this.handleException(e);
            }
        },

        /**
         * Sets the update model.
         *
         * @param      {<type>}  idx     The new value
         */
        async setUpdateModel(id) {
            this.updateModel = await this.loadOrderStatusByID(id);
        },

        /**
         * { function_description }
         */
        async handleDeleteRow(id) {
            console.log(this.deleteStatus);
            if (this.isDeleting) {
                return;
            }

            this.deleteStatus = Request.DELETING;
            this.setDeleteModel(id);

            await this.confirmDelete();

            if (this.isDeleted) {
                this.loadOrderStatuses();
            }
        },

        /**
         * Sets the delete model.
         *
         * @param      {<type>}  idx     The new value
         */
        setDeleteModel(idx) {
            this.deleteModel = this.statusCollection.find(m => m.id == idx);
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async confirmDelete() {
            const result = await this.showConfirmDelete();

            if (result.isDismissed) {
                this.deleteStatus = Request.CANCEL;

                return Swal.close();
            }

            if (result.isConfirmed) {
                return this.delete();
            }
        },

        /**
         * Shows the confirm delete.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async showConfirmDelete() {
            const title = "Bạn có muốn xóa trạng thái <b>" + this.deleteModel.name + "</b>?";

            return Swal.fire({
                title: title,
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "Hủy",
                confirmButtonText: "Đồng ý",
                allowOutsideClick: false,
                customClass: {
                    title: "d-inline",
                },
            });
        },

        /**
         * Called on update cancel.
         */
        onUpdateCancel() {
            this.hideUpdateDialog();
        },

        /**
         * Called on update close.
         */
        onUpdateClose() {
            this.hideUpdateDialog();
        },

        /**
         * Called when updated.
         */
        onUpdated() {
            this.hideUpdateDialog();
            this.messageSuccess(MessageConst.SUCCESS_MESSAGE_UPDATE);
            this.loadOrderStatuses();
        },

        /**
         * Called on create cancel.
         */
        onCreateCancel() {
            this.hideCreateDialog();
        },

        /**
         * Called on create close.
         */
        onCreateClose() {
            this.hideCreateDialog();
        },

        /**
         * Called when create saved.
         */
        onCreated() {
            this.hideCreateDialog();
            this.messageSuccess(MessageConst.SUCCESS_MESSAGE_SAVE);
            this.loadOrderStatuses();
        },

        /**
         * Called on click button add new.
         */
        onClickBtnAddNew() {
            this.showCreateDialog();
        },

        /**
         * Shows the create dialog.
         */
        showCreateDialog() {
            this.$modal.show(this.MODAL_CREATE);
        },

        /**
         * Hides the create dialog.
         */
        hideCreateDialog() {
            this.$modal.hide(this.MODAL_CREATE);
        },

        /**
         * Shows the update dialog.
         */
        showUpdateDialog() {
            this.$modal.show(this.MODAL_UPDATE);
        },

        /**
         * Hides the update dialog.
         */
        hideUpdateDialog() {
            this.$modal.hide(this.MODAL_UPDATE);
        },

        /**
         * Loads an order status by id.
         *
         * @param      {<type>}   ID      { parameter_description }
         * @return     {Promise}  { description_of_the_return_value }
         */
        async loadOrderStatusByID(ID) {
            return await this.OrderStatusModel.loadByIdAsync(ID);
        },

        /**
         * Loads order statuses.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async loadOrderStatuses() {
            try {
                this.loadingStart();

                let filters = _.tap(this.filter.reduces(), function (e) {
                    e.page = e.p;
                    delete e.p;
                });

                this.statusCollection = await this.OrderStatusModel.getListAsync(filters);
            } catch (e) {
                this.handleException(e);
            }
        },

        /**
         * Phân trang
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async paginate() {
            this.filter.offset = (this.page - 1) * this.filter.limit;
        },

        /**
         * Xóa row
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async delete() {
            try {
                await this.deleteModel.deleteAsync();

                this.messageSuccess(MessageConst.SUCCESS_MESSAGE_DELETE);
                this.deleteStatus = Request.SUCCESS;
            } catch (e) {
                this.deleteStatus = Request.ERROR;
                this.handleException(e);
            }
        },
    },

    created() {
        this.filter = new OrderStatusFilter({ limit: 10, store_id: 1, ...this.$route.query });
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Trạng thái đơn hàng" }]);
    },
};
</script>
