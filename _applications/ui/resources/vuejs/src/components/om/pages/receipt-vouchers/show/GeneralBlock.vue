<template>
    <v-card>
        <v-card-title class="text-h5 d-flex">
            <div class="flex-grow-1 text-h6 font-weight-bold">Thông tin chung</div>
            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn color="primary" v-bind="attrs" v-on="on" depressed dense small>
                        Thao tác với chứng từ thu
                    </v-btn>
                </template>
                <v-list dense>
                    <v-list-item-group color="primary">
                        <v-list-item v-for="(action, i) in actions" :key="i" @click="onSelectOption(action)">
                            <v-list-item-icon>
                                <v-icon v-text="action.icon"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="action.text"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
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
                                    disabled
                                ></FieldDoiTuongNop>
                                <FieldNguoiNop
                                    v-model="receiptModel.customer_id"
                                    :receipt-model="receiptModel"
                                    disabled
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

    data: () => ({
        actions: [
            { name: 'delete', icon: 'mdi-delete', text: 'Hủy' },
            { name: 'edit', icon: 'mdi-pencil', text: 'Sửa' },
            { name: 'copy', icon: 'mdi-content-copy', text: 'Sao chép' },
        ],
    }),

    computed: {},

    methods: {
        onSelectOption(action) {
            this.$emit('SELECTED_ACTION', action.name);
        },
    },

    mounted() {},
};
</script>
