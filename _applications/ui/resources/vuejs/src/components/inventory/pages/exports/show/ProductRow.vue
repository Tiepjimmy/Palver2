<template>
    <tr>
        <td>{{ idx + 1 }}</td>
        <td>{{ product.product_cd }}</td>
        <td>{{ product.product_name }}</td>
        <td>{{ product.unit }}</td>
        <td>
            {{ lot.code }}
        </td>
        <td>{{ lot.expired_date }}</td>
        <td>
            {{ detail.quantity }}
        </td>
        <td>{{ detail.price }}</td>
        <td>{{ totalAmount }}</td>
        <td>{{ detail.storage_location }}</td>
    </tr>
</template>
<script type="text/javascript">
import axios from '@/core/plugins/axios';

export default {
    name: 'ProdutRow',
    props: {
        idx: 0,
        detail: {},
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        product() {
            return this.detail.product || {};
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        lot() {
            return this.detail.lot;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalAmount() {
            return this.detail.price * this.detail.quantity;
        },
    },
};
</script>

<style lang="scss"></style>
