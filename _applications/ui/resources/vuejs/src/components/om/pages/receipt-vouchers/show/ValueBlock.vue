<template>
    <v-card>
        <v-card-title class="text-h5 d-flex">
            <div class="flex-grow-1 text-h6 font-weight-bold">Giá trị ghi nhận</div>
        </v-card-title>
        <v-card-text>
            <div class="container px-0">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <FieldDonHang
                                    v-model="receiptModel.orders"
                                    :receipt-voucher="receiptModel"
                                    v-if="canShowPaymentsSelector"
                                    disabled
                                ></FieldDonHang>
                                <FieldGiaTri
                                    :receipt-voucher="receiptModel"
                                    v-model="receiptModel.amount"
                                    disabled
                                ></FieldGiaTri>
                            </div>
                            <div class="col-12 col-sm-6">
                                <FieldGhiChu v-model="receiptModel.note" disabled> </FieldGhiChu>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <v-checkbox
                                    v-model="receiptModel.type_payment_voucher.is_business_result"
                                    label="Hạch toán kết quả kinh doanh"
                                    hide-details
                                    disabled
                                ></v-checkbox>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import PopupMessagesMixin from '@/components/om/utils/mixins/PopupMessagesMixin';
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';

import FieldDonHang from '../shared/FieldDonHang';
import FieldGiaTri from '../shared/FieldGiaTri';
import FieldGhiChu from '../shared/FieldGhiChu';

export default {
    name: 'ValueBlock',

    mixins: [PopupMessagesMixin, EmitsMixin],

    components: { FieldDonHang, FieldGiaTri, FieldGhiChu },

    props: {
        receiptModel: ReceiptVouchers,
    },

    computed: {
        /**
         * Determines ability to show payments selector.
         *
         * @return     {boolean}  True if able to show payments selector, False otherwise.
         */
        canShowPaymentsSelector() {
            return (
                this.isEmptyCustomer ||
                this.isEmptyTypeObject ||
                this.receiptModel.isTypeOpjectKhachLe() ||
                this.receiptModel.isTypeOpjectKhachBuon()
            );
        },

        /**
         * Determines if empty type object.
         *
         * @return     bool  True if empty type object, False otherwise.
         */
        isEmptyTypeObject() {
            return !this.receiptModel.type_object;
        },

        /**
         * Determines if empty customer.
         *
         * @return     bool  True if empty customer, False otherwise.
         */
        isEmptyCustomer() {
            return !this.receiptModel.customer_id;
        },

        /**
         * Disables the order selector.
         *
         * @return     bool
         */
        disableOrderSelector() {
            return this.isEmptyTypeObject || this.isEmptyCustomer;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        amount() {
            return this.receiptModel.amount;
        },
    },

    methods: {},

    mounted() {},
};
</script>
