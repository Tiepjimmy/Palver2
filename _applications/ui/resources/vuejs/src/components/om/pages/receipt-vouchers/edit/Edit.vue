<template>
    <v-form ref="form">
        <div class="container px-0" v-if="hasData">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <GeneralBlock elevation="1" :receipt-model="ReceiptVouchers"></GeneralBlock>
                    <ValueBlock class="mt-6" elevation="1" :receipt-model="ReceiptVouchers"></ValueBlock>
                </div>
                <div class="col-12 col-sm-4">
                    <InformationBlock elevation="1" :receipt-model="ReceiptVouchers"></InformationBlock>
                    <div class="mt-3 d-flex justify-content-end">
                        <v-btn color="grey darken-1" text @click="onCancelBtnClick" :receipt-model="ReceiptVouchers">
                            Hủy
                        </v-btn>
                        <v-btn color="primary" depressed @click="onSaveBtnClick" :receipt-model="ReceiptVouchers">
                            Lưu
                        </v-btn>
                    </div>
                </div>
            </div>
        </div>
    </v-form>
</template>
<script type="text/javascript">
import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import FetchStatusMixin from '@/components/om/utils/mixins/FetchStatusMixin';
import UpdateStatusMixin from '@/components/om/utils/mixins/UpdateStatusMixin';
import PopupMessagesMixin from '@/components/om/utils/mixins/PopupMessagesMixin';
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';

import GeneralBlock from './GeneralBlock';
import ValueBlock from './ValueBlock';
import InformationBlock from './InformationBlock';

export default {
    name: 'Edit',

    mixins: [FetchStatusMixin, PopupMessagesMixin, EmitsMixin, UpdateStatusMixin],

    components: { GeneralBlock, ValueBlock, InformationBlock },

    data: () => ({
        ReceiptVouchers: new ReceiptVouchers(),
    }),

    computed: {
        hasData() {
            return _.isNumber(this.ReceiptVouchers.id);
        },
    },

    methods: {
        /**
         * Called on cancel click.
         *
         * @param      {<type>}  event   The event
         */
        onCancelBtnClick(event) {
            this.$refs.form.reset();
            this.$refs.form.resetValidation();
            this.emitCancel();
        },

        /**
         * Called on save click.
         *
         * @param      {<type>}  event   The event
         */
        async onSaveBtnClick(event) {
            try {
                if (!this.$refs.form.validate()) {
                    return;
                }

                await this.save();

                if (this.isUpdateError) {
                    throw 'Cập  nhật chứng từ thu thất bại !';
                }

                this.showPopupSuccess({
                    text: 'Cập  nhật chứng từ thu thành công !',
                    timer: 1500,
                    onDestroy: () => this.gotoIndex(),
                });
            } catch (e) {
                this.handleException(e);
            }
        },

        /**
         * Lưu thông tin chứng từ
         *
         * @return     {Promise}
         */
        async save() {
            try {
                this.setUpdateStatusUpdating();
                const postData = this.prepareStoreData(this.ReceiptVouchers);
                const response = await this.ReceiptVouchers.updateAsync(postData);
                this.setUpdateStatusSuccess();

                return response;
            } catch (e) {
                this.setUpdateStatusError();
            }
        },

        /**
         * Chuẩn bị dữ liệu để lưu
         *
         * @return     {<type>}
         */
        prepareStoreData() {
            const postData = this.ReceiptVouchers.reduces();
            const payment_ids = _.flatMap(postData.orders.map(e => e.payments.map(e => e.id)));
            delete postData.orders;

            return { ...postData, payment_ids };
        },

        /**
         * Loads a detail.
         *
         * @return     {Promise}
         */
        async loadDetail() {
            try {
                this.setFetchStatusFetching();
                await this.ReceiptVouchers.loadById(this.$route.params.id);
                this.setFetchStatusSuccess();
            } catch (e) {
                this.handleException(e);
                return this.setFetchStatusError();
            }
        },

        /**
         * Đi đến trang chủ
         *
         * @return     void
         */
        gotoIndex() {
            return this.$router.push({ name: 'om.receipt_vouchers' });
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: 'Chứng từ thu' },
            { title: 'Loại chứng từ thu' },
            { title: 'Cập nhật' },
        ]);

        this.loadDetail();
    },
};
</script>
