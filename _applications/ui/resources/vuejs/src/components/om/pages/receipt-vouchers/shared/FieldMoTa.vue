<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Mô tả</label>
        <v-textarea v-model="vmodel" dense outlined placeholder="Mô tả" :rules="rules" v-bind="$attrs"> </v-textarea>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';

export default {
    name: 'FieldMoTa',

    mixins: [EmitsMixin],

    props: {
        receiptModel: ReceiptVouchers,
        value: String,
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
