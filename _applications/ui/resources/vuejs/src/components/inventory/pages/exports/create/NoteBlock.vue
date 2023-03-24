<template>
    <!-- thong tin khac -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin khác </v-card-title>

        <v-card-text>
            <div class="form-group">
                <label>Ghi chú</label>
                <v-textarea
                    placeholder="Ghi chú"
                    v-model="invoice.note"
                    dense
                    hide-details
                    outlined
                    rows="2"
                ></v-textarea>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import GoodsIssue from "@/models/inventory/export/goods_issues";
export default {
    name: "NoteBlock",
    props: {
        invoice: GoodsIssue,
    },
};
</script>

<style></style>
