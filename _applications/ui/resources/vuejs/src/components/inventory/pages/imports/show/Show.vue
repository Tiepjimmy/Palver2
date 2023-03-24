<template>
    <v-card elevation="0">
        <div class="container">
            <div class="row">
                <div class="col-3 pl-0 pt-0">
                    <!-- thong tin phieu nhap -->
                    <invoice-block :detail="GoodsReceiptsModel"></invoice-block>
                </div>

                <div class="col-9 p-0">
                    <!-- thong tin nha cung cap -->
                    <provider-block :detail="GoodsReceiptsModel"></provider-block>

                    <!-- thong tin san pham -->
                    <products-block :detail="GoodsReceiptsModel"></products-block>

                    <!-- thong tin khacs -->
                    <more-block :detail="GoodsReceiptsModel"></more-block>

                    <!-- duyệt phiếu -->
                    <action-btn-block
                        :detail="GoodsReceiptsModel"
                        @[EMITS.SUCCESS]="onActionSuccess"
                    ></action-btn-block>
                </div>
            </div>
        </div>
    </v-card>
</template>

<script type="text/javascript">
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import CreateStatusMixin from "@/components/inventory/utils/mixins/CreateStatusMixin";
import GoodsReceipts from "@/models/inventory/import/goods_receipts";

import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import ProviderBlock from "./ProviderBlock";
import ProductsBlock from "./ProductsBlock";
import InvoiceBlock from "./InvoiceBlock";
import MoreBlock from "./MoreBlock";
import ActionBtnBlock from "./ActionBtnBlock";

export default {
    name: "InventoryGoodsReceiptShow",
    mixins: [EmitsMixin],
    components: { ProviderBlock, ProductsBlock, InvoiceBlock, MoreBlock, ActionBtnBlock },

    data() {
        return {
            GoodsReceiptsModel: new GoodsReceipts(),
        };
    },

    computed: {},

    methods: {
        /**
         * Called on action success.
         */
        onActionSuccess() {
            this.fetchDetail();
        },

        /**
         * Fetches a detail.
         *
         * @return     {Promise}  The detail.
         */
        async fetchDetail() {
            try {
                const response = await this.GoodsReceiptsModel.loadById(this.$route.params.id);
            } catch (e) {
                Swal.fire(ERROR_TITLE, ERROR_MESSAGE, "error");
            }
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Phiếu nhập kho" }, { title: "Duyệt phiếu" }]);
        this.fetchDetail();
    },
};
</script>

<style scoped></style>
