<template>
    <!-- thong tin phieu nhap -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin phiếu nhập </v-card-title>

        <v-card-text>
            <div class="form-group">
                <label>Mã phiếu nhập</label>
                <v-text-field
                    :value="detail.code"
                    disabled
                    dense
                    outlined
                    hide-details
                    class="blue-grey lighten-5"
                    disabled
                >
                </v-text-field>
            </div>

            <div class="form-group">
                <label>Chi nhánh nhập</label>
                <v-text-field
                    :value="store.store_name"
                    disabled
                    dense
                    outlined
                    hide-details
                    class="blue-grey lighten-5"
                    disabled
                >
                </v-text-field>
            </div>

            <div class="form-group">
                <label>Kho nhập</label>
                <v-text-field
                    :value="warehouse.warehouse_name"
                    disabled
                    dense
                    outlined
                    hide-details
                    class="blue-grey lighten-5"
                    disabled
                >
                </v-text-field>
            </div>

            <div class="form-group">
                <label>Loại phiếu nhập</label>
                <v-text-field
                    :value="typeName"
                    disabled
                    dense
                    outlined
                    hide-details
                    class="blue-grey lighten-5"
                    disabled
                >
                </v-text-field>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import CreateStatusMixin from "@/components/inventory/utils/mixins/CreateStatusMixin";
import GoodsReceipts from "@/models/inventory/import/goods_receipts";

export default {
    name: "InvoiceBlock",
    props: {
        detail: GoodsReceipts,
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        store() {
            return this.detail.store || {};
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        warehouse() {
            return this.detail.warehouse || {};
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        typeName() {
            return this.detail.typeName();
        },
    },
};
</script>

<style lang="scss"></style>
