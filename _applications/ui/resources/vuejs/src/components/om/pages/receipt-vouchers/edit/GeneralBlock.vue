<template>
    <v-card>
        <v-card-title class="text-h5 d-flex">
            <div class="flex-grow-1 text-h6 font-weight-bold">Thông tin chung</div>
        </v-card-title>
        <v-card-text>
            <div class="container px-0">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <FieldLoaiChungTu
                                    v-model="receiptModel.type_voucher"
                                    :receipt-model="receiptModel"
                                    disabled
                                ></FieldLoaiChungTu>

                                <FieldLoaiChungTuThu
                                    v-model="receiptModel.type_collect_voucher_id"
                                    :receipt-model="receiptModel"
                                    disabled
                                ></FieldLoaiChungTuThu>
                            </div>
                            <div class="col-12 col-sm-6">
                                <FieldDoiTuongNop
                                    v-model="receiptModel.type_object"
                                    :receipt-model="receiptModel"
                                ></FieldDoiTuongNop>
                                <FieldNguoiNop
                                    v-model="receiptModel.customer_id"
                                    :receipt-model="receiptModel"
                                ></FieldNguoiNop>
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

import FieldLoaiChungTu from '../shared/FieldLoaiChungTu';
import FieldLoaiChungTuThu from '../shared/FieldLoaiChungTuThu';
import FieldDoiTuongNop from '../shared/FieldDoiTuongNop';
import FieldNguoiNop from '../shared/FieldNguoiNop';

export default {
    name: 'GeneralBlock',

    mixins: [PopupMessagesMixin, EmitsMixin],

    components: { FieldLoaiChungTu, FieldLoaiChungTuThu, FieldDoiTuongNop, FieldNguoiNop },

    props: {
        receiptModel: ReceiptVouchers,
    },

    data: () => ({}),

    computed: {},

    methods: {},

    mounted() {},
};
</script>
