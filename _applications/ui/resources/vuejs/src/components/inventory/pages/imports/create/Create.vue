<template>
    <v-card elevation="0">
        <v-container>
            <v-row>
                <v-col cols="3" class="pl-0 pt-0">
                    <!-- thong tin phieu nhap -->
                    <receipt-block :goods-receipt="GoodsReceiptsModel"></receipt-block>
                </v-col>

                <v-col cols="9" class="p-0">
                    <!-- thong tin nha cung cap -->
                    <v-card outlined>
                        <v-card-title primary-title class="text-h6 text-uppercase">
                            Thông tin nhà cung cấp
                        </v-card-title>

                        <v-card-text>
                            <v-autocomplete
                                v-model="ProviderModel"
                                :items="providers"
                                item-text="provider_name"
                                return-object
                                auto-select-first
                                placeholder="Tìm kiếm nhà cung cấp theo tên nhà cung cấp, mã nhà cung cấp, số điện thoại,..."
                                outlined
                                hide-details
                                dense
                                :disabled="!hasSelectedStore"
                            >
                                <template v-slot:item="data">
                                    <v-list-item-avatar>
                                        <v-sheet color="grey darken-2" height="46" outlined width="46"></v-sheet>
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                        <v-list-item-title v-html="data.item.provider_name"></v-list-item-title>
                                        <v-list-item-subtitle v-html="data.item.phone"></v-list-item-subtitle>
                                    </v-list-item-content>
                                </template>
                            </v-autocomplete>

                            <div class="provider-wrapper" v-if="!!hasProvider">
                                <div class="text-h5">{{ ProviderModel.provider_name }}</div>
                                <div class="">
                                    Địa chỉ: <b>{{ ProviderModel.address }}</b>
                                </div>
                                <div class="">
                                    SDT: <b>{{ ProviderModel.phone }}</b>
                                </div>
                                <div class="">
                                    Email: <b>{{ ProviderModel.email }}</b>
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>

                    <!-- thong tin san pham -->
                    <products-block class="mt-3" :goods-receipt="GoodsReceiptsModel"></products-block>

                    <!-- thong tin khacs -->
                    <v-card outlined class="mt-3">
                        <v-card-title primary-title class="text-h6 text-uppercase">
                            Thông tin khác {{ storeID }}
                        </v-card-title>
                        <v-card-text>
                            <label>Ghi chú</label>
                            <v-textarea rows="3" v-model="GoodsReceiptsModel.note" outlined dense> </v-textarea>
                        </v-card-text>
                    </v-card>

                    <div class="mt-3">
                        <v-btn color="warning" depressed @click="onClickBtnCancel">Hủy</v-btn>
                        <v-btn color="primary" class="px-5" depressed @click="onClickBtnSave">Lưu</v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from "vuex";
import { default as ProviderBlock } from "./ProviderBlock";
import { default as ProductsBlock } from "./ProductsBlock";
import { default as ReceiptBlock } from "./ReceiptBlock";
import { InteractAPIService } from "@/components/inventory/services/InteractAPIService";
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";

import Collection from "@/core/collection";
import Provider from "@/models/inventory/common/provider";
import GoodsReceipts from "@/models/inventory/import/goods_receipts";
import GoodsReceiptsDetail from "@/models/inventory/import/goods_receipt_details";

import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import CreateStatusMixin from "@/components/inventory/utils/mixins/CreateStatusMixin";

export default {
    name: "Create",
    mixins: [EmitsMixin, PopupMessagesMixin, CreateStatusMixin],
    components: {
        ProviderBlock,
        ProductsBlock,
        ReceiptBlock,
    },

    data: () => ({
        storeID: 1,
        ProviderModel: new Provider(),
        GoodsReceiptsModel: new GoodsReceipts(),
        providers: new Collection(Provider),
    }),

    computed: {
        /**
         * Determines if provider.
         *
         * @return     {boolean}  True if provider, False otherwise.
         */
        hasProvider() {
            return Number.isInteger(this.ProviderModel.id);
        },

        /**
         * Determines if selected store.
         *
         * @return     {boolean}  True if selected store, False otherwise.
         */
        hasSelectedStore() {
            return !!this.GoodsReceiptsModel.store_id;
        },
    },

    watch: {
        "ProviderModel.id": function (n, o) {
            this.GoodsReceiptsModel.provider_id = n;
        },
    },

    methods: {
        /**
         * Called on click button cancel.
         */
        onClickBtnCancel() {
            return this.gotoIndexPage();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async onClickBtnSave() {
            try {
                await this.GoodsReceiptsModel.storeAsync();

                return this.showPopupCreateSuccess({
                    html: `Thêm phiếu nhập kho <b>${this.GoodsReceiptsModel.code}</b> thành công!`,
                    showConfirmButton: false,
                    timer: 1500,
                    onDestroy: () => {
                        this.initModel();
                        this.gotoIndexPage();
                    },
                });
            } catch (e) {
                console.log(e);
                return this.messageError(e);
            }
        },

        /**
         * Initializes the model.
         */
        initModel() {
            this.GoodsReceiptsModel = new GoodsReceipts();
        },

        /**
         * { function_description }
         */
        gotoIndexPage() {
            this.$router.push({ name: "inv.import.goods-receipt.index" });
        },

        /**
         * Loads providers.
         */
        async loadProviders() {
            this.loadingStart();
            try {
                await this.ProviderModel.getListAsync({ store_id: this.storeID }, response =>
                    this.providers.addRange(response)
                );
            } catch (e) {
                console.log(e);
                this.handleException(e);
            }
            this.loadingClose();
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Phiếu nhập kho" }, { title: "Tạo phiếu" }]);
    },

    created() {
        this.loadProviders();
    },
};
</script>

<style></style>
