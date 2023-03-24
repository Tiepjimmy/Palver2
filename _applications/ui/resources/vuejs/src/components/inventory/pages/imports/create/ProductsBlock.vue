<template>
    <!-- thong tin san pham -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin sản phẩm </v-card-title>
        <v-card-text>
            <!-- search -->
            <div id="search-products-wrapper">
                <v-autocomplete
                    v-model="goodsReceipt.details"
                    :items="allDetails"
                    item-text="name"
                    item-value="product_id"
                    multiple
                    auto-select-first
                    outlined
                    placeholder="Tìm kiếm sản phẩm theo mã sản phẩm, tên sản phẩm "
                    return-object
                    hide-details
                    dense
                    :disabled="!hasSelectedStore"
                >
                    <template v-slot:prepend-inner>
                        <v-img width="24" height="24" src="/media/svg/icons/General/Search.svg"></v-img>
                    </template>

                    <template v-slot:item="data">
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ data.item.name }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                Đơn vị: <b>{{ data.item.unit }}</b>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </template>
                </v-autocomplete>
            </div>
            <div id="table-container" class="mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2">STT</th>
                            <th>Mã SP</th>
                            <th>Tên SP</th>
                            <th>Đơn vị</th>
                            <th>Lô (*)</th>
                            <th>Hạn sử dụng</th>
                            <th>Số lượng (*)</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                            <th>Vị trí lưu kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <detail-row
                            as="tr"
                            v-for="(detail, idx) in goodsReceipt.details"
                            :idx="idx"
                            :key="idx"
                            :detail="detail"
                            :all-lots="allLots"
                            @remove="removeDetail(idx)"
                        ></detail-row>
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
import { mapGetters, mapState, mapActions } from "vuex";
import { default as DetailRow } from "./DetailRow";
import GoodsReceiptsModel from "@/models/inventory/import/goods_receipts";
import ProductModel from "@/models/inventory/common/product";
import LotModel from "@/models/inventory/common/lot";
import Collection from "@/core/collection";
import GoodsReceiptsDetail from "@/models/inventory/import/goods_receipt_details";

export default {
    name: "ProdutsBlock",

    components: { DetailRow },

    props: {
        goodsReceipt: GoodsReceiptsModel,
    },

    data() {
        return {
            storeID: 1, //mock
            ProductModel: new ProductModel(),
            LotModel: new LotModel(),
            allDetails: [],
            allLots: [],
        };
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalAmount() {
            return this.goodsReceipt.details.reduce(function (res, product) {
                return (res += (Number(product.price) || 0) * (Number(product.quantity) || 0));
            }, 0);
        },

        /**
         * Determines if selected store.
         *
         * @return     {boolean}  True if selected store, False otherwise.
         */
        hasSelectedStore() {
            return !!this.goodsReceipt.store_id;
        },
    },

    watch: {
        /**
         * { function_description }
         *
         * @param      {<type>}   n       { parameter_description }
         * @param      {<type>}   o       { parameter_description }
         * @return     {Promise}  { description_of_the_return_value }
         */
        "goodsReceipt.provider_id": async function (n, o) {
            try {
                this.allDetails = (await this.fetchProductsByProviderID(n)).map(p => ({
                    product_id: p.id,
                    name: p.product_entity.retail_product.product_name,
                    code: p.sku,
                    unit: p.product_entity.retail_product.unit,
                    lot_id: 0,
                    quantity: 0,
                    price: p.product_entity.retail_entity_prices?.prices,
                    storage_location: "",
                }));

                this.allLots = (await this.fetchLotsByProviderID(n)).data;
            } catch (e) {
                console.log(e);
            }
        },
    },

    methods: {
        /**
         * Fetches a products by provider id.
         *
         * @param      {<type>}   providerID  The provider id
         * @return     {Promise}  The products by provider id.
         */
        async fetchProductsByProviderID(providerID) {
            return await this.ProductModel.fetchRetailProductsByProviderIDAndStoreID(this.storeID, providerID);
        },

        /**
         * Fetches lots.
         *
         * @return     {Promise}  The lots.
         */
        async fetchLotsByProviderID(providerID) {
            return await this.LotModel.fetchList({ provider_id: providerID, without_paginate: 1 });
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  productID  The product id
         * @param      {<type>}  idx        The index
         */
        removeDetail(idx) {
            this.goodsReceipt.details.splice(idx, 1);
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
