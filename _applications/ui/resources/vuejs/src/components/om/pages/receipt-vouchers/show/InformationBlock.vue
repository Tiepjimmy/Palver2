<template>
    <v-card>
        <v-card-title class="text-h5 d-flex">
            <div class="flex-grow-1 text-h6 font-weight-bold">Thông tin mở rộng</div>
        </v-card-title>
        <v-card-text>
            <div class="container px-0">
                <div class="row">
                    <div class="col-12">
                        <FieldChiNhanh
                            v-model="receiptModel.store_id"
                            :receipt-model="receiptModel"
                            disabled
                        ></FieldChiNhanh>

                        <FieldNgayGhiNhan
                            v-model="receiptModel.confirmed_at"
                            :receipt-model="receiptModel"
                            readonly
                            readonly-panel
                        ></FieldNgayGhiNhan>

                        <FieldMoTa
                            v-model="receiptModel.description"
                            :receipt-model="receiptModel"
                            disabled
                        ></FieldMoTa>
                    </div>
                </div>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import FieldNgayGhiNhan from '../shared/FieldNgayGhiNhan';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';

import FieldChiNhanh from '../shared/FieldChiNhanh';
import FieldMoTa from '../shared/FieldMoTa';
export default {
    name: 'InformationBlock',

    mixins: [EmitsMixin],

    components: { FieldNgayGhiNhan, FieldChiNhanh, FieldMoTa },

    props: {
        receiptModel: ReceiptVouchers,
    },

    data: () => ({}),

    computed: {},

    methods: {},

    mounted() {},
};
</script>
