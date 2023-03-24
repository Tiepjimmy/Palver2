<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Giá trị (*)</label>
        <v-text-field
            v-model="vmodel"
            placeholder="Giá trị"
            outlined
            dense
            v-bind="$attrs"
            suffix="đ"
            class="text-right-input"
        ></v-text-field>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import * as Fn from '@/helpers/fn';

export default {
    name: 'FieldGiaTri',

    mixins: [EmitsMixin],

    props: {
        value: Number,
        receiptVoucher: ReceiptVouchers,
    },

    data: () => ({}),

    computed: {
        vmodel: {
            get() {
                return Fn.numberFormat(this.value, 0, 0, '.', ',');
            },

            set(val) {
                this.$emit('input', val);
            },
        },
    },
};
</script>
<style scoped lang="scss">
.text-right input {
    text-align: end !important;
}
</style>
