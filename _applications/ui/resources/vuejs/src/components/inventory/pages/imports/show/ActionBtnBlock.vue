<template>
    <!-- duyệt phiếu -->
    <div class="mt-3 d-flex justify-content-end">
        <cancle-btn
            class="ml-1"
            :show="canShowCancleBtn"
            :selected="[detail]"
            :outlined="false"
            :depressed="true"
            :confirmWithNote="true"
            @success="onCancleSuccess"
        ></cancle-btn>

        <reject-btn
            class="ml-1"
            :show="canShowRejectBtn"
            :selected="[detail]"
            :outlined="false"
            :depressed="true"
            :confirmWithNote="true"
            @success="onRejectSuccess"
        ></reject-btn>

        <approve-btn
            class="ml-1"
            :show="canShowApproveBtn"
            :selected="[detail]"
            :outlined="false"
            :depressed="true"
            :confirm="true"
            @success="onApproveSuccess"
        ></approve-btn>

        <import-btn
            class="ml-1"
            :show="canShowImportBtn"
            :selected="[detail]"
            :outlined="false"
            :depressed="true"
            :confirm="true"
            @success="onImportSuccess"
        ></import-btn>
    </div>
</template>
<script type="text/javascript">
import GoodsReceipts from "@/models/inventory/import/goods_receipts";
import ApproveBtn from "../shared/ApproveBtn";
import CancleBtn from "../shared/CancleBtn";
import RejectBtn from "../shared/RejectBtn";
import ImportBtn from "../shared/ImportBtn";

import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";

export default {
    name: "AcceptBtnBlock",
    mixins: [EmitsMixin],
    components: { ApproveBtn, CancleBtn, RejectBtn, ImportBtn },
    props: {
        detail: GoodsReceipts,
    },
    computed: {
        /**
         * Determines ability to show cancle button.
         */
        canShowCancleBtn() {
            return !this.detail.isCanceled();
        },

        /**
         * Determines ability to show reject button.
         */
        canShowRejectBtn() {
            return this.detail.isWaiting();
        },

        /**
         * Determines ability to show approve button.
         */
        canShowApproveBtn() {
            return this.detail.isWaiting() || this.detail.isRejected();
        },

        /**
         * Determines ability to show import button.
         *
         * @return     {boolean}  True if able to show import button, False otherwise.
         */
        canShowImportBtn() {
            return this.detail.isResolved();
        },
    },

    methods: {
        /**
         * Called on approve success.
         */
        onApproveSuccess() {
            this.emitSuccess();
        },

        /**
         * Called on cancle success.
         */
        onCancleSuccess() {
            this.emitSuccess();
        },

        /**
         * Called on reject success.
         */
        onRejectSuccess() {
            this.emitSuccess();
        },

        /**
         * Called on import success.
         */
        onImportSuccess() {
            this.emitSuccess();
        },
    },
};
</script>

<style lang="scss"></style>
