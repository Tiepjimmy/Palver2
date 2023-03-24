<template>
    <!-- thong tin san pham -->
    <v-card outlined class="mt-3">
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin sản phẩm </v-card-title>
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
                            :detail="product"
                        ></product-row>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11">
                                Tổng tiền: <b>{{ totalAmount }}</b>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import { default as ProductRow } from './ProductRow';

export default {
    name: 'ProdutsBlock',

    components: { ProductRow },

    props: {
        detail: {},
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        products() {
            return this.detail.details || [];
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
};
</script>

<style lang="scss"></style>
