<template>
    <!-- thong tin phieu nhap -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin phiếu xuất </v-card-title>

        <v-card-text>
            <div class="form-group">
                <label>Mã phiếu xuất</label>
                <v-text-field disabled dense outlined hide-details class="blue-grey lighten-5"> </v-text-field>
            </div>

            <label>Chi nhánh xuất</label>
            <v-select
                :items="stores"
                :disabled="canSelectStore"
                v-model="invoice.store_id"
                placeholder="Chọn chi nhánh"
                item-text="name"
                item-value="id"
                outlined
                dense
            >
            </v-select>

            <label>Kho xuất</label>
            <v-select
                :items="warehouses"
                :disabled="canSelectWarehouse"
                v-model="invoice.warehouse_id"
                placeholder="Chọn kho"
                item-text="name"
                item-value="id"
                outlined
                dense
            >
            </v-select>

            <label>Loại phiếu xuất (*)</label>
            <v-select
                :items="typeNames"
                v-model="invoice.type"
                placeholder="Chọn loại phiếu"
                item-text="name"
                item-value="slug"
                outlined
                dense
            >
            </v-select>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import GoodsIssue from "@/models/inventory/export/goods_issues";
export default {
    name: "InvoiceBlock",
    props: {
        invoice: GoodsIssue,
    },

    data: () => ({
        GoodsIssueModel: new GoodsIssue(),
    }),

    computed: {
        stores() {
            return [
                { id: 0, name: "Chọn chi nhánh" },
                { id: 1, name: "Chi nhánh 1" },
                { id: 2, name: "Chi nhánh 2" },
                { id: 3, name: "Chi nhánh 3" },
            ];
        },

        warehouses() {
            return [
                { id: 0, name: "Chọn kho" },
                { id: 1, name: "Kho 1" },
                { id: 2, name: "Kho 2" },
                { id: 3, name: "Kho 3" },
            ];
        },

        /**
         * { lambda_description }
         *
         * @return     {boolean}  { description_of_the_return_value }
         */
        typeNames() {
            return _.map(this.invoice.typeNames(), (name, slug) => ({ slug: slug, name: name }));
        },

        /**
         * Determines ability to select store.
         *
         * @return     {boolean}  True if able to select store, False otherwise.
         */
        canSelectStore() {
            return true;
        },

        /**
         * Determines ability to select warehouse.
         *
         * @return     {boolean}  True if able to select warehouse, False otherwise.
         */
        canSelectWarehouse() {
            return true;
        },
    },

    watch: {},

    methods: {},

    mounted() {},
};
</script>

<style></style>
