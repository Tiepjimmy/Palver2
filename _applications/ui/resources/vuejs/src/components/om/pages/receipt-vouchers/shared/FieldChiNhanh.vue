<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Chi nhánh (*)</label>
        <v-text-field v-model="vmodel" dense outlined placeholder="Chi nhánh" :rules="rules" v-bind="$attrs">
        </v-text-field>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';

export default {
    name: 'FieldChiNhanh',

    mixins: [EmitsMixin],

    props: {
        value: Number,
        items: [],
        receiptModel: ReceiptVouchers,
    },

    data: () => ({
        rules: [v => !!v || 'Chi nhánh là bắt buộc'],
    }),

    computed: {
        vmodel: {
            get() {
                return this.receiptModel.store.store_name || 'Chi nhanh';
            },

            set(val) {
                this.$emit('input', val);
            },
        },
    },
};
</script>
