<template>
    <v-card-text>
        <div class="form-group">
            <label>Mã đơn hàng</label>
            <input v-model="order_id" type="text" class="form-control form-control-sm" />
        </div>
    </v-card-text>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import {
    MODEL_UPDATE_STORE_ID,
    MODEL_UPDATE_WAREHOUSE_ID,
    MODEL_UPDATE_TYPE,
} from '@/store/inventory/import/goods-receipt/create/action-const';

export default {
    name: 'ExportTypeBalanceBlock',
    data() {
        return {
            store_id: 0,
            warehouse_id: 0,
            type: '',
        };
    },

    computed: {
        order_id: {
            set(value) {
                //value;
            },

            get() {
                return 0;
            },
        },

        /**
         * { function_description }
         *
         * @return     {string}  { description_of_the_return_value }
         */
        recipient() {
            return '';
        },

        /**
         * { function_description }
         *
         * @return     {string}  { description_of_the_return_value }
         */
        contact() {
            return '';
        },

        /**
         * { function_description }
         *
         * @return     {string}  { description_of_the_return_value }
         */
        address() {
            return '';
        },
    },

    watch: {},

    methods: {},

    mounted() {},
};
</script>

<style></style>
