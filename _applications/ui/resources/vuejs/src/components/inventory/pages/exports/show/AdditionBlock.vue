<template>
    <!-- thong tin phieu nhap -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin bổ sung</v-card-title>

        <v-card-text v-bind:is="currentExportType"> </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import {} from '@/store/inventory/export/goods-issue/show/action-const';
import { default as ExportTypeSellBlock } from './ExportTypeSellBlock';
import { default as ExportTypeBalanceBlock } from './ExportTypeBalanceBlock';

export default {
    name: 'AdditionBlock',

    data: () => ({}),

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
        type() {
            return this.model.type;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentExportType() {
            switch (this.type) {
                case 'sell':
                    return ExportTypeSellBlock;

                case 'internal':
                    return '';

                case 'cancel':
                    return '';

                case 'balance':
                    return ExportTypeBalanceBlock;
            }
        },
    },

    mounted() {
        // console.log(this.model);
    },
};
</script>

<style></style>
