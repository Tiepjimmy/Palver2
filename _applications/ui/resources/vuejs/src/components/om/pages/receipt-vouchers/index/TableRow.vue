<template>
    <tr style="cursor: pointer">
        <td>{{ stt }}</td>
        <td>{{ typeVoucher }} </td>
        <td>{{ receiptVoucher.code }} </td>
        <td>{{ typeCollectVoucher }} </td>
        <td>{{ subject }}</td>
        <td class="text-right">{{ amountFormatted }} đ</td>
        <td>{{ createdAtFormatted }}</td>
        <td>{{ createdByName }}</td>
        <td>{{ statusName }}</td>
    </tr>
</template>
<script type="text/javascript">
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import moment from 'moment';
import * as Fn from '@/helpers/fn';

export default {
    name: 'TableRow',

    mixins: [EmitsMixin],

    props: {
        idx: 0,
        receiptVoucher: ReceiptVouchers,
    },

    computed: {
        /**
         * { function_description }
         */
        typeCollectVoucher() {
            return this.receiptVoucher.type_collect_voucher.type_name;
        },

        /**
         * { function_description }
         */
        typeVoucher() {
            return this.receiptVoucher.typeNameOfDocument();
        },

        /**
         * Determines if default.
         *
         * @return     {boolean}  True if default, False otherwise.
         */
        isDefault() {
            return this.receiptVoucher.is_default;
        },

        /**
         * Determines if active.
         *
         * @return     {boolean}  True if active, False otherwise.
         */
        isActive() {
            return this.receiptVoucher.is_active;
        },

        /**
         * { function_description }
         *
         * @return     string
         */
        stt() {
            return this.idx + 1;
        },

        /**
         * { function_description }
         */
        createdAtFormatted() {
            return moment(this.receiptVoucher.created_at).format('DD/MM/YYYY hh:mm:ss');
        },

        /**
         * { function_description }
         */
        createdByName() {
            return this.receiptVoucher.user_create?.full_name;
        },

        /**
         * { function_description }
         *
         * @return     string
         */
        subject() {
            return this.receiptVoucher.typeObjectName();
        },

        /**
         * { function_description }
         *
         * @return     string
         */
        amountFormatted() {
            return Fn.numberFormat(this.receiptVoucher.amount, 0, 0, '.', ',');
        },

        /**
         * { function_description }
         *
         * @return     string
         */
        statusName() {
            return this.receiptVoucher.statusName();
        },
    },

    methods: {
        /**
         * Called on click button remove.
         */
        onClickRow() {
            // this.emitClickRow({ receiptVoucher: this.receiptVoucher });
        },
    },
};
</script>

<style lang="scss"></style>
