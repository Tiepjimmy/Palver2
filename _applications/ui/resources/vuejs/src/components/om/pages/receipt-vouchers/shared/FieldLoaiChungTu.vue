<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Loại chứng từ (*)</label>
        <v-select
            v-model="vmodel"
            :items="itemsComputed"
            item-text="name"
            item-value="value"
            dense
            outlined
            placeholder="Loại chứng từ"
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
    name: 'FieldLoaiChungTu',

    mixins: [EmitsMixin],

    props: {
        value: String,
        receiptModel: ReceiptVouchers,
    },

    data() {
        return {
            rules: [v => !!v || 'Loại chứng từ là bắt buộc'],
        };
    },

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
            return _.map(this.receiptModel.typeNamesOfDocument(), (v, i) => ({ value: i, name: v }));
        },
    },
};
</script>
