<template>
    <!-- duyệt phiếu -->
    <div>
        <!-- BTN Hủy Phiếu -->
        <button v-if="!isCancelStatus" type="button" class="btn btn-warning btn-sm" @click.stop="onClickBtnCancel">
            Hủy phiếu
        </button>

        <!-- BTN Từ Chối -->
        <button v-if="isCreateStatus" type="button" class="btn btn-danger btn-sm" @click.stop="onClickBtnReject">
            Từ chối
        </button>

        <!-- BTN Duyệt Phiếu -->
        <button
            v-if="isRejectStatus || isCreateStatus"
            type="button"
            class="btn btn-primary btn-sm px-5"
            @click.stop="onClickBtnResolve"
        >
            Duyệt phiếu
        </button>

        <!-- BTN Đóng Hàng -->
        <button v-if="isResolveStatus" type="button" class="btn btn-primary btn-sm px-5" @click.stop="onClickBtnPack">
            Đóng hàng
        </button>

        <!-- BTN Xuất Kho -->
        <button v-if="isPackStatus" type="button" class="btn btn-primary btn-sm px-5" @click.stop="onClickBtnExport">
            Xuất kho
        </button>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="text-h5">{{ dialog_title }}</span>
                </v-card-title>
                <v-card-text>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Lý do</label>
                                    <textarea class="form-control form-control-sm" v-model="dialog_reason"></textarea>
                                </div>
                                <div class="mt-3 text-danger">
                                    <b>Bạn có chắc chắn muốn {{ dialog_name }} phiếu xuất kho</b>
                                    <p class="m-0" v-if="isDialogCancel">
                                        Chú ý: Việc hủy phiếu xuất kho có trạng thái đã xuất kho sẽ ảnh hưởng tới số
                                        lượng sản phẩm tồn trong kho
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="grey darken-1" text @click="onClickCloseBtnDialog"> Không đồng ý </v-btn>
                    <v-btn color="blue darken-1" text @click="onClickApplyBtnDialog"> Đồng ý </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from "vuex";
import Swal from "sweetalert2";
import { InteractAPIService } from "@/components/inventory/services/InteractAPIService";
import * as MessageConst from "@/components/inventory/utils/MessageConst";
import * as ModelConst from "@/components/inventory/utils/ModelConst";
import * as HttpCodes from "@/components/inventory/utils/HttpCodes";

import * as actions from "@/store/inventory/export/goods-issue/show/action-const";

export default {
    name: "AcceptBtnBlock",

    data: () => ({
        status: 0,
        dialog: false,
        dialog_reason: "",
    }),

    computed: {
        ...mapState("inventory/export/goods_issue/show", {
            model: state => state.model,
            model_sell: state => state.model_sell,
            model_internal: state => state.model_internal,
        }),
        /**
         * { function_description }
         *
         * @return     {string}  { description_of_the_return_value }
         */
        dialog_title() {
            switch (this.status) {
                case ModelConst.GOODS_ISSUE_STATUS_CANCELED:
                    return "Hủy phiếu nhập kho";

                case ModelConst.GOODS_ISSUE_STATUS_REJECTED:
                    return "Từ chối phiếu nhập kho";
            }
        },

        /**
         * { function_description }
         *
         * @return     {string}  { description_of_the_return_value }
         */
        dialog_name() {
            switch (this.status) {
                case ModelConst.GOODS_ISSUE_STATUS_CANCELED:
                    return "hủy";

                case ModelConst.GOODS_ISSUE_STATUS_REJECTED:
                    return "từ chối";
            }
        },

        /**
         * Determines if dialog cancel.
         *
         * @return     {boolean}  True if dialog cancel, False otherwise.
         */
        isDialogCancel() {
            return this.status === ModelConst.GOODS_ISSUE_STATUS_CANCELED;
        },

        /**
         * Determines if create status.
         *
         * @return     {boolean}  True if create status, False otherwise.
         */
        isCreateStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_WAITING;
        },

        /**
         * Determines if cancel status.
         *
         * @return     {boolean}  True if cancel status, False otherwise.
         */
        isCancelStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_CANCELED;
        },

        /**
         * Determines if reject status.
         *
         * @return     {boolean}  True if reject status, False otherwise.
         */
        isRejectStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_REJECTED;
        },

        /**
         * Determines if resolve status.
         *
         * @return     {boolean}  True if resolve status, False otherwise.
         */
        isResolveStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_RESOLVED;
        },

        /**
         * Determines if pack status.
         *
         * @return     {boolean}  True if pack status, False otherwise.
         */
        isPackStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_PACKED;
        },

        /**
         * Determines if export status.
         *
         * @return     {boolean}  True if export status, False otherwise.
         */
        isExportStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_EXPORTED;
        },
    },

    methods: {
        ...mapActions("inventory/export/goods_issue/show", {
            UPDATE_MODEL: actions.UPDATE_MODEL,
            UPDATE_MODEL_SELL: actions.UPDATE_MODEL_SELL,
            UPDATE_MODEL_INTERNAL: actions.UPDATE_MODEL_INTERNAL,
        }),
        /**
         * Called on click close button dialog.
         */
        onClickCloseBtnDialog() {
            this.hideDialog();
            this.clearReason();
        },

        /**
         * Called on click apply button dialog.
         */
        onClickApplyBtnDialog() {
            this.hideDialog();
            this.updateStatus();
        },

        /**
         * { function_description }
         */
        clearReason() {
            this.dialog_reason = "";
        },

        /**
         * Hides the dialog.
         */
        hideDialog() {
            this.dialog = false;
        },

        /**
         * Shows the dialog.
         */
        showDialog() {
            this.dialog = true;
        },

        /**
         * Called on click button cancel.
         */
        onClickBtnCancel() {
            this.status = ModelConst.GOODS_ISSUE_STATUS_CANCELED;
            this.showDialog();
        },

        /**
         * Called on click button reject.
         */
        onClickBtnReject() {
            this.status = ModelConst.GOODS_ISSUE_STATUS_REJECTED;
            this.showDialog();
        },

        /**
         * Called on click button resolve.
         */
        onClickBtnResolve() {
            this.status = ModelConst.GOODS_ISSUE_STATUS_RESOLVED;
            this.updateStatus();
        },

        /**
         * Called on click button pack.
         */
        onClickBtnPack() {
            this.status = ModelConst.GOODS_ISSUE_STATUS_PACKED;
            this.updateStatus();
        },

        /**
         * Called on click button export.
         */
        onClickBtnExport() {
            this.status = ModelConst.GOODS_ISSUE_STATUS_EXPORTED;
            this.updateStatus();
        },

        /**
         * { function_description }
         *
         * @param      {<type>}   status  The status
         * @return     {Promise}  { description_of_the_return_value }
         */
        async updateStatus(status) {
            try {
                this.showLoading();

                const response = await InteractAPIService.updateManyGoodsIssueStatus({
                    data: [{ goods_issue_id: this.$route.params.id, status: this.status, note: this.dialog_reason }],
                });

                if (response.status_code === HttpCodes.HTTP_OK && response.success == true) {
                    this.updateModel();

                    return this.showPopupSuccess();
                }
            } catch (e) {
                console.log(e);
            }

            Swal.fire(MessageConst.ERROR_TITLE, MessageConst.ERROR_MESSAGE, "error");
        },

        /**
         * Shows the loading.
         */
        showLoading() {
            Swal.fire({
                title: MessageConst.MESSAGE_UPDATING,
                onOpen: () => {
                    Swal.showLoading();
                },
            });
        },

        /**
         * Shows the popup success.
         */
        showPopupSuccess() {
            Swal.fire({
                title: MessageConst.SUCCESS_TITLE,
                text: MessageConst.SUCCESS_MESSAGE_SAVE,
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
                onDestroy: () => this.onPopupSuccessDestroy(),
            });
        },

        /**
         * Called on popup success destroy.
         */
        onPopupSuccessDestroy() {
            // this.cleanModel();
            // this.$router.push({ name: 'inv.export.goods-issue.index' });
        },

        updateModel() {
            this.UPDATE_MODEL({
                status: this.status,
                statuses: [
                    ...this.model.statuses,
                    {
                        goods_issue_id: this.model.id,
                        status: this.status,
                        note: this.dialog_reason,
                    },
                ],
            });
        },
    },
};
</script>

<style lang="scss"></style>
