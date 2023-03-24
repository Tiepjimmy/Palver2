<template>
    <div>
        <label class="font-size-lg mb-1 text-dark">Loại chứng từ thu (*)</label>
        <v-select
            v-model="vmodel"
            :items="itemsComputed"
            item-text="type_name"
            item-value="id"
            dense
            outlined
            placeholder="Loại chứng từ thu"
            :rules="rulesComputed"
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
import TypeCollectVouchers from '@/models/type-collect-vouchers/type_collect_vouchers';
import FetchListStatusMixin from '@/components/om/utils/mixins/FetchListStatusMixin';

export default {
    name: 'FieldLoaiChungTuThu',

    mixins: [EmitsMixin, FetchListStatusMixin],

    props: {
        items: [],
        receiptModel: ReceiptVouchers,
        value: Number,
    },

    data: () => ({
        rules: [v => !!v || 'Loại chứng từ thu là bắt buộc'],
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
         * @return     {Array}  { description_of_the_return_value }
         */
        rulesComputed() {
            return [...this.rules];
        },
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        itemsComputed() {
            return !_.isEmpty(this.items) ? this.items : this.typeCollectVouchersCollection;
        },
    },

    watch: {
        vmodel(n, o) {
            n !== o && this.$emit('input', n);
        },
    },

    methods: {
        /**
         * Fetches all type collect vouchers.
         *
         * @return     {Promise}  All type collect vouchers.
         */
        async fetchAllTypeCollectVouchers() {
            try {
                this.setFetchListStatusFetching();
                this.typeCollectVouchersCollection = await this.TypeCollectVouchers.getListAsync({
                    per_page: 100000,
                });
                this.setFetchListStatusSuccess();
            } catch (e) {
                this.setFetchListStatusError();
                this.messageError(e);
            }
        },
    },

    created() {
        this.fetchAllTypeCollectVouchers();
        setTimeout(() => (this.FETCH_LIST_STATUS = Request.ERROR), 1000);
    },
};
</script>
