<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Ghi chú</label>
        <v-textarea v-model="vmodel" dense outlined placeholder="Ghi chú" :rules="rules" v-bind="$attrs"> </v-textarea>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';

export default {
    name: 'FieldGhiChu',

    mixins: [EmitsMixin],

    props: {
        value: String,
        receiptModel: ReceiptVouchers,
    },

    data: () => ({
        rules: [v => !v || v.length < 200 || 'Độ dài tối đa là 200 kí tự'],
    }),

    computed: {
        vmodel: {
            get() {
                return this.value;
            },

            set(val) {
                this.$emit('input', val);
            },
        },
    },
};
</script>
