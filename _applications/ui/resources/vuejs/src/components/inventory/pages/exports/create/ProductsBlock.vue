<template>
    <!-- thong tin san pham -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin sản phẩm </v-card-title>
        <v-card-text :is="currentProductsBlock" :invoice="invoice"> </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import GoodsIssue from "@/models/inventory/export/goods_issues";
import { default as ProductsSellBlock } from "./ProductsSellBlock";
import { default as ProductsDefaultBlock } from "./ProductsDefaultBlock";

export default {
    name: "ProdutsBlock",

    components: { ProductsSellBlock, ProductsDefaultBlock },

    props: {
        invoice: GoodsIssue,
    },

    data: () => ({
        GoodsIssueModel: GoodsIssue,
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentProductsBlock() {
            switch (this.invoice.type) {
                case "sell":
                    return ProductsSellBlock;

                case "internal":
                    return ProductsDefaultBlock;

                case "cancel":
                    return ProductsDefaultBlock;

                case "balance":
                    return ProductsDefaultBlock;
            }
        },
    },

    watch: {},

    methods: {},

    mounted() {},
};
</script>

<style lang="scss"></style>
