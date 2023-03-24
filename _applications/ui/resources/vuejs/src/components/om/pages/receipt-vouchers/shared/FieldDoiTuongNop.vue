<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Đối tượng nộp (*)</label>
        <v-select
            v-model="vmodel"
            :items="itemsComputed"
            item-text="name"
            item-value="value"
            dense
            outlined
            placeholder="Đối tượng nộp"
            :rules="rules"
            v-bind="$attrs"
        >
        </v-select>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';

export default {
    name: 'FieldDoiTuongNop',

    mixins: [EmitsMixin],

    props: {
        value: String,
        items: [],
        receiptModel: ReceiptVouchers,
    },

    data: () => ({
        rules: [v => !!v || 'Đối tượng nộp là bắt buộc'],
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
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        itemsComputed() {
            return _.map(this.receiptModel.typeObjectNames(), (v, i) => ({ value: i, name: v }));
        },
    },
};
</script>
