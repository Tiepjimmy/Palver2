<template>
    <!-- thong tin phieu nhap -->
    <v-card outlined v-if="canShowAdditionBlock">
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin bổ sung</v-card-title>

        <v-card-text :is="currentExportType" :invoice="invoice"> </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import { default as ExportTypeSellBlock } from "./ExportTypeSellBlock";
import { default as ExportTypeBalanceBlock } from "./ExportTypeBalanceBlock";
import GoodsIssue from "@/models/inventory/export/goods_issues";

export default {
    name: "AdditionBlock",
    props: {
        invoice: GoodsIssue,
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        type() {
            return this.invoice.type;
        },

        /**
         * Determines if type exists.
         *
         * @return     {boolean}  True if type exists, False otherwise.
         */
        isTypeExists() {
            return !!this.type;
        },

        /**
         * Determines ability to show addition block.
         */
        canShowAdditionBlock() {
            return this.isTypeExists;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentExportType() {
            switch (this.type) {
                case this.invoice.types().SELL:
                    return ExportTypeSellBlock;

                case this.invoice.types().INTERNAL:
                    return "";

                case this.invoice.types().CANCEL:
                    return "";

                case this.invoice.types().BALANCE:
                    return ExportTypeBalanceBlock;
            }
        },
    },

    mounted() {},
};
</script>

<style></style>
