<template>
    <!-- thong tin phieu nhap -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin phiếu nhập </v-card-title>

        <v-card-text>
            <v-container class="p-0">
                <v-row>
                    <v-col cols="12">
                        <label>Mã phiếu nhập</label>
                        <v-text-field disabled dense outlined hide-details class="blue-grey lighten-5"> </v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <label>Chi nhánh nhập (*)</label>
                        <v-select
                            :items="[
                                { id: 1, name: 'Chi nhánh 1' },
                                { id: 2, name: 'Chi nhánh 2' },
                                { id: 3, name: 'Chi nhánh 3' },
                            ]"
                            v-model="goodsReceipt.store_id"
                            item-text="name"
                            item-value="id"
                            placeholder="Chọn chi nhánh"
                            hide-details
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <label>Kho nhập (*)</label>
                        <v-select
                            :items="[
                                { id: 1, name: 'Kho 1' },
                                { id: 2, name: 'Kho 2' },
                                { id: 3, name: 'Kho 3' },
                            ]"
                            v-model="goodsReceipt.warehouse_id"
                            item-text="name"
                            item-value="id"
                            placeholder="Chọn kho"
                            hide-details
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <label>Loại phiếu nhập (*)</label>
                        <v-select
                            :items="[
                                { id: 'buy', name: 'Nhập mua' },
                                { id: 'internal', name: 'Nhập nội bộ' },
                                { id: 'balance', name: 'Nhập cân bằng' },
                            ]"
                            v-model="goodsReceipt.type"
                            item-text="name"
                            item-value="id"
                            placeholder="Chọn loại phiếu"
                            hide-details
                            dense
                            outlined
                        ></v-select>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from "vuex";
import GoodsReceipts from "@/models/inventory/import/goods_receipts";

export default {
    name: "ReceiptBlock",

    props: {
        goodsReceipt: GoodsReceipts,
    },
};
</script>

<style></style>
