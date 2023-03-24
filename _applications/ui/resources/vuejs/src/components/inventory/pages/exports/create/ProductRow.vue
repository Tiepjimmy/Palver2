<template>
    <tr>
        <td>{{ idx + 1 }}</td>
        <td>{{ product.code }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.unit }}</td>
        <td>
            {{ product.lot_id }}
        </td>
        <td>{{ lotExpired }}</td>
        <td
            >{{ product.quantity }} / 1000
            <v-icon small color="cyan accent-3" @click="onClickRefreshQuantity"> mdi-refresh </v-icon>
        </td>
        <td>{{ product.price }}</td>
        <td>{{ totalAmount }}</td>
        <td>{{ storageLocation }}</td>
    </tr>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';

export default {
    name: 'ProdutRow',
    props: {
        idx: 0,
        product: {},
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        productID() {
            return this.product.product_id;
        },

        quantity() {
            return this.product.quantity;
        },

        storageLocation() {
            return '';
        },

        lotID() {
            return this.product.lot_id;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalAmount() {
            return this.product.price * this.product.quantity;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        lotExpired() {
            return this.product.expired_date;
        },
    },

    methods: {
        onClickRefreshQuantity() {
            // todo
        },
    },

    mounted() {},
};
</script>

<style lang="scss"></style>
