<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Ngày ghi nhận (*)</label>
        <AcknowledgementDate
            v-model="vmodel"
            :rules="rules"
            v-bind="$attrs"
            append-icon="mdi-calendar"
            placeholder="Ngày ghi nhận"
            outlined
            dense
        ></AcknowledgementDate>
    </div>
</template>

<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import AcknowledgementDate from '@/components/om/shared/buttons/AcknowledgementDate';

export default {
    name: 'FieldNgayGhiNhan',

    mixins: [EmitsMixin],

    components: { AcknowledgementDate },

    props: {
        receiptModel: ReceiptVouchers,
    },

    data: () => ({
        vmodel: null,
        rules: [v => !!v || 'Ngày ghi nhận là bắt buộc'],
    }),

    computed: {
        vmodelComputed() {
            return this.vmodel;
        },
    },

    watch: {
        vmodel(n, o) {
            console.log(n);
            n !== o && this.$emit('input', n);
        },
    },
};
</script>
