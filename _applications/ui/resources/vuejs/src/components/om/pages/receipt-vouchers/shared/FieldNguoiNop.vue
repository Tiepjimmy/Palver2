<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Người nộp (*)</label>
        <v-select
            v-model="vmodel"
            :items="itemsComputed"
            item-text="name"
            item-value="id"
            dense
            outlined
            placeholder="Người nộp"
            :rules="rules"
            v-bind="$attrs"
            :loading="isListFetching"
        >
        </v-select>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import Collection from '@/core/collection';
import Customer from '@/models/customer/customer';
import FetchListStatusMixin from '@/components/om/utils/mixins/FetchListStatusMixin';

export default {
    name: 'FieldNguoiNop',

    mixins: [EmitsMixin, FetchListStatusMixin],

    props: {
        items: [],
        receiptModel: ReceiptVouchers,
        value: Number,
    },

    data: () => ({
        rules: [v => !!v || 'Người nộp là bắt buộc'],
        Customer: new Customer({ store_id: 1 }),
        customersCollection: new Collection(Customer),
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
         * @return     {<type>}
         */
        itemsComputed() {
            return !_.isEmpty(this.items) ? this.items : this.customersCollection;
        },
    },

    watch: {
        vmodel(n, o) {
            n !== o && this.$emit('input', n);
        },
    },

    methods: {
        /**
         * Fetches all customers.
         *
         * @return     {Promise}  All customers.
         */
        async fetchAllCustomers() {
            try {
                this.setFetchListStatusFetching();
                this.customersCollection = await this.Customer.getListAsync({
                    per_page: 100000,
                });
                this.setFetchListStatusSuccess();
            } catch (e) {
                this.setFetchListStatusError();
                this.messageError(e);
            }
        },
    },

    mounted() {
        this.fetchAllCustomers();
    },
};
</script>
