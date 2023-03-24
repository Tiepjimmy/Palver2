<template>
    <v-card-text>
        <!-- search -->
        <div id="search-products-wrapper">
            <v-autocomplete
                v-model="productIDs"
                :items="allProducts"
                :disabled="disabledSelectProduct"
                item-text="name"
                item-value="product_id"
                multiple
                auto-select-first
                dense
                label="Tìm kiếm sản phẩm theo mã sản phẩm, tên sản phẩm "
            >
                <template v-slot:prepend-inner>
                    <v-img width="24" height="24" src="/media/svg/icons/General/Search.svg"></v-img>
                </template>
                <template v-slot:item="data">
                    <template v-if="typeof data.item !== 'object'">
                        <v-list-item-content v-text="data.item"></v-list-item-content>
                    </template>
                    <template v-else>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ data.item.name }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                Đơn vị: <b>{{ data.item.unit }}</b>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </template>
            </v-autocomplete>
        </div>
        <div id="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="2">STT</th>
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
                        :all-lots="allLots"
                        @remove="deleteProduct(product.product_id, idx)"
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
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';
import { GET_PROVIDER_BY_STORE_ID, GET_PROVIDER_BY_ID, GET_PROVIDER } from '@/store/inventory/getter-const';
import * as getters from '@/store/inventory/export/goods-issue/create/getter-const';
import * as actions from '@/store/inventory/export/goods-issue/create/action-const';
import { default as ProductRow } from './ProductRow';

export default {
    name: 'ProdutsDefaultBlock',

    components: { ProductRow },

    props: {
        providerId: 0,
    },

    data() {
        return {
            fetchingProducts: false,
            fetchingLots: false,
            productIDs: [],
            allProducts: [],
            allLots: [],
        };
    },

    computed: {
        ...mapGetters('inventory/export/goods_issue/create', []),
        ...mapGetters('inventory', [GET_PROVIDER, GET_PROVIDER_BY_STORE_ID]),
        ...mapState('inventory/export/goods_issue/create', {
            model: state => state.model,
            model_sell: state => state.model_sell,
            model_internal: state => state.model_internal,
        }),

        /**
         * Determines ability to select product.
         *
         * @return     {boolean}  True if able to select product, False otherwise.
         */
        disabledSelectProduct() {
            return this.model.type === 'sell';
        },

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

    watch: {
        /**
         * { function_description }
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         * @return     {<type>}  { description_of_the_return_value }
         */
        productIDs(n, o) {
            return n.length > o.length ? this.handleAddProduct(n, o) : this.handleRemoveProduct(n, o);
        },
        /**
         * { function_description }
         *
         * @param      {<type>}   n       { parameter_description }
         * @param      {<type>}   o       { parameter_description }
         * @return     {Promise}  { description_of_the_return_value }
         */
        'GET_MODEL.provider_id': async function (n, o) {
            try {
                const products = await this.fetchProductsByProviderID(n);
                this.allProducts = products.map(p => ({
                    product_id: p.id,
                    name: p.product_name,
                    code: p.product_cd,
                    unit: p.unit,
                    lot_id: 0,
                    quantity: 0,
                    price: p.product_entities.find(pe => pe.entity_prices)?.entity_prices.prices || 0,
                    storage_location: '',
                }));
                this.allLots = await this.fetchLotsByProviderID(n);
            } catch (e) {
                console.log(e);
            }
        },
    },

    methods: {
        ...mapActions('inventory/export/goods_issue/create', {
            UPDATE_MODEL: actions.UPDATE_MODEL,
            UPDATE_MODEL_SELL: actions.UPDATE_MODEL_SELL,
            UPDATE_MODEL_INTERNAL: actions.UPDATE_MODEL_INTERNAL,
        }),
        /**
         * Fetches products.
         *
         * @return     {Promise}  The products.
         */
        async fetchProductsByProviderID(providerID) {
            try {
                this.$emit('fetching-products');
                const response = await InteractAPIService.fetchProducts({ provider_id: providerID });
                this.$emit('fetch-products-success');

                return response.data;
            } catch (e) {
                this.$emit('fetch-products-error');
                console.log(e);
            }
        },

        /**
         * Fetches lots.
         *
         * @return     {Promise}  The lots.
         */
        async fetchLotsByProviderID(providerID) {
            try {
                this.$emit('fetching-lots');
                const response = await InteractAPIService.fetchLots({ provider_id: providerID, without_paginate: 1 });
                this.$emit('fetch-lots-success');

                return response.data;
            } catch (e) {
                this.$emit('fetch-lots-error');
                console.log(e);
            }
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  productID  The product id
         * @param      {<type>}  idx        The index
         */
        deleteProduct(productID, idx) {
            this.productIDs.splice(idx, 1);
            this.MODEL_REMOVE_PRODUCT(productID);
        },

        /**
         * { function_description }
         *
         * @param      {Array}   newIDs  The new i ds
         * @param      {<type>}  oldIDs  The old i ds
         */
        handleRemoveProduct(newIDs, oldIDs) {
            oldIDs.map(function (oldID) {
                if (!newIDs.includes(oldID)) {
                    this.MODEL_REMOVE_PRODUCT(oldID);
                }
            }, this);
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  newIDs  The new i ds
         * @param      {Array}   oldIDs  The old i ds
         */
        handleAddProduct(newIDs, oldIDs) {
            newIDs.map(function (newID) {
                if (!oldIDs.includes(newID)) {
                    this.MODEL_ADD_PRODUCT(this.allProducts.find(p => p.product_id === newID));
                }
            }, this);
        },
    },

    mounted() {},
};
</script>

<style lang="scss">
#table-container {
    overflow-x: auto;
}
</style>
