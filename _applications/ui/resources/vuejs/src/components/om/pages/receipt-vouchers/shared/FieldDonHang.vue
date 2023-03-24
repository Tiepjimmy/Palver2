<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Đơn hàng (*)</label>
        <v-autocomplete
            v-model="vmodel"
            :items="itemsComputed"
            item-text="text"
            item-value="order"
            outlined
            dense
            chips
            clearable
            deletable-chips
            multiple
            small-chips
            placeholder="Đơn hàng"
            v-bind="$attrs"
            :rules="rulesComputed"
            :loading="isListFetching"
            class="om-autocomplete-placeholder"
        >
            <template v-slot:selection="{ item, index }">
                <v-chip v-if="index === 0">
                    <span>{{ item.code }}</span>
                </v-chip>
                <span v-if="index === 1" class="grey--text text-caption"> (+{{ vmodel.length - 1 }} others) </span>
            </template>
        </v-autocomplete>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import Order from '@/models/order/order';
import OrderPayment from '@/models/order/order_payment';
import Collection from '@/core/collection';
import TypeCollectVouchers from '@/models/type-collect-vouchers/type_collect_vouchers';
import FetchListStatusMixin from '@/components/om/utils/mixins/FetchListStatusMixin';

export default {
    name: 'FieldDonHang',

    mixins: [EmitsMixin, FetchListStatusMixin],

    props: {
        receiptVoucher: ReceiptVouchers,
        value: Array,
    },

    data: () => ({
        rules: [v => !!v || 'Đơn hàng là bắt buộc'],
        items: Array,
        TypeCollectVouchers: new TypeCollectVouchers(),
        typeCollectVouchersCollection: new Collection(TypeCollectVouchers),
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
         * @return     {Array}
         */
        rulesComputed() {
            return [...this.rules];
        },
        /**
         * { function_description }
         *
         * @return     {<type>}
         */
        itemsComputed() {
            return this.items.map(function (order) {
                const payments = order.payments || [];
                const total_amount = _.sumBy(payments, 'payment_amount');

                return {
                    text: order.code + '<space>' + total_amount,
                    code: order.code,
                    total_amount: total_amount,
                    order: order,
                };
            });
        },
    },

    watch: {
        /**
         * { function_description }
         *
         * @param      {<type>}  n
         * @param      {<type>}  o
         */
        vmodel(n, o) {
            n !== o && this.$emit('input', n);
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  n
         * @param      {<type>}  o
         * @return     {<type>}
         */
        'receiptVoucher.type_voucher': function (n, o) {
            return this.reloadOrderPayments();
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  n
         * @param      {<type>}  o
         * @return     {<type>}
         */
        'receiptVoucher.customer_id': function (n, o) {
            return this.reloadOrderPayments();
        },
    },

    methods: {
        /**
         * { function_description }
         */
        reloadOrderPayments() {
            if (!this.receiptVoucher.customer_id || !this.receiptVoucher.type_voucher) {
                return;
            }

            this.resetModel();
            this.fetchOrders();
        },

        /**
         * { function_description }
         */
        resetModel() {
            this.items = new Collection(Order);
            this.vmodel.splice(0, this.vmodel.length);
        },

        /**
         * Fetches all type collect vouchers.
         *
         * @return     {Promise}  All type collect vouchers.
         */
        async fetchOrders() {
            try {
                this.setFetchListStatusFetching();

                const params = {
                    customer_id: this.receiptVoucher.customer_id,
                    type_voucher: this.receiptVoucher.type_voucher,
                };
                const response = await this.receiptVoucher.getOrderPayments(params);

                this.items.addRange(response.data);

                this.setFetchListStatusSuccess();
            } catch (e) {
                this.setFetchListStatusError();
                this.messageError(e);
                console.log(e);
            }
        },
    },

    mounted() {
        this.$watch(
            vm => [vm.type_voucher, vm.customer_id],
            val => {
                console.log(this.type_voucher + ' ' + this.customer_id);
            },
            {
                immediate: true, // run immediately
                deep: true, // detects changes inside objects. not needed here, but maybe in other cases
            }
        );
    },

    created() {
        this.items = this.receiptVoucher.orders;
    },
};
</script>
