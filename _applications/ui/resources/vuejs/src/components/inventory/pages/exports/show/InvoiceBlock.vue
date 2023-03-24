<template>
    <!-- thong tin phieu nhap -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin phiếu nhập </v-card-title>

        <v-card-text>
            <div class="form-group">
                <label>Mã phiếu nhập</label>
                <input type="text" :value="code" class="form-control form-control-sm" disabled />
            </div>

            <div class="form-group">
                <label>Chi nhánh nhập</label>
                {{ store.store_name }}
            </div>

            <div class="form-group">
                <label>Kho nhập</label>
                {{ warehouse.warehouse_name }}
            </div>

            <div class="form-group">
                <label>Loại phiếu nhập</label>
                {{ model.type }}
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
export default {
    name: 'InvoiceBlock',

    computed: {
        ...mapState('inventory/export/goods_issue/show', {
            model: state => state.model,
            model_sell: state => state.model_sell,
            model_internal: state => state.model_internal,
        }),

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        code() {
            return this.model.code;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        store() {
            return this.model.store || {};
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        warehouse() {
            return this.model.warehouse || {};
        },
    },
};
</script>

<style lang="scss"></style>
