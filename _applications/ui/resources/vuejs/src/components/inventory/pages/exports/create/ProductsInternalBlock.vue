<template>
    <v-card-text>
        <div id="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã SP</th>
                        <th>Tên SP</th>
                        <th>Đơn vị</th>
                        <th>Lô</th>
                        <th>Hạn sử dụng</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Vị trí lưu kho</th>
                    </tr>
                </thead>
                <tbody>
                    <product-row
                        as="tr"
                        v-for="(product, idx) in products"
                        :idx="idx"
                        :key="idx"
                        :product="product"
                        @remove="deleteProduct(product.product_id, idx)"
                    ></product-row>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            Tổng tiền: <b>{{ totalAmount }}</b>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </v-card-text>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';
import { default as ProductRow } from './ProductRow';

export default {
    name: 'ProdutsSellBlock',

    components: { ProductRow },

    props: {},

    data() {
        return {};
    },

    computed: {
        ...mapState('inventory/export/goods_issue/create', {
            model: state => state.model,
            model_sell: state => state.model_sell,
            model_internal: state => state.model_internal,
        }),

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        products() {
            return this.model.products || [];
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalAmount() {
            return this.products.reduce(function (res, product) {
                return (res += (Number(product.price) || 0) * (Number(product.quantity) || 0));
            }, 0);
        },
    },

    methods: {},

    mounted() {},
};
</script>

<style lang="scss"></style>
