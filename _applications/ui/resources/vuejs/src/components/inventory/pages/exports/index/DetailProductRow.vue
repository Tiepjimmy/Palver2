<template>
    <tr>
        <td>{{ idx + 1 }}</td>
        <td>{{ detail.product.product_cd }}</td>
        <td>{{ detail.product.product_name }}</td>
        <td>{{ detail.product.unit }}</td>
        <td>{{ detail.lot.code }}</td>
        <td>{{ lotExpired }}</td>
        <td>{{ detail.quantity }}</td>
        <td>{{ detail.price }}</td>
        <td>{{ totalAmount }}</td>
        <td>{{ detail.storage_location }}</td>
    </tr>
</template>
<script type="text/javascript">
export default {
    name: 'DetailProductRow',
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
        totalAmount() {
            return this.detail.price * this.detail.quantity;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        lotExpired() {
            return this.detail.lot.expired_date;
        },
    },
};
</script>

<style lang="scss"></style>
