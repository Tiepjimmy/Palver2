<template>
    <v-form ref="form">
        <div class="container px-0" v-if="!waitCopy">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <GeneralBlock elevation="1" :receipt-model="ReceiptVouchers"></GeneralBlock>
                    <ValueBlock class="mt-6" elevation="1" :receipt-model="ReceiptVouchers"></ValueBlock>
                </div>
                <div class="col-12 col-sm-4">
                    <InformationBlock elevation="1" :receipt-model="ReceiptVouchers"></InformationBlock>
                    <div class="mt-3 d-flex justify-content-end">
                        <v-btn
                            color="grey darken-1"
                            text
                            @click="onCancelBtnClick"
                            :receipt-model="ReceiptVouchers"
                            :disabled="isCreating"
                        >
                            Hủy
                        </v-btn>
                        <v-btn
                            color="primary"
                            depressed
                            @click="onSaveBtnClick"
                            :receipt-model="ReceiptVouchers"
                            :disabled="isCreating"
                        >
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
import CreateStatusMixin from '@/components/om/utils/mixins/CreateStatusMixin';
import PopupMessagesMixin from '@/components/om/utils/mixins/PopupMessagesMixin';
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';

import GeneralBlock from './GeneralBlock';
import ValueBlock from './ValueBlock';
import InformationBlock from './InformationBlock';

export default {
    name: 'Create',

    mixins: [CreateStatusMixin, FetchStatusMixin, PopupMessagesMixin, EmitsMixin],

    components: { GeneralBlock, ValueBlock, InformationBlock },

    data: () => ({
        ReceiptVouchers: new ReceiptVouchers({ store_id: 1 }),
    }),

    computed: {
        waitCopy() {
            return _.isNumber(this.$route.query.copy_from) && this.isFetching;
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

                if (this.isCreateError) {
                    throw 'Tạo chứng từ thu thất bại !';
                }

                this.showPopupSuccess({
                    text: 'Tạo chứng từ thu thành công !',
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
                this.setCreateStatusCreating();
                const postData = this.prepareStoreData(this.ReceiptVouchers);
                const response = await this.ReceiptVouchers.storeAsync(postData);
                this.setCreateStatusSuccess();

                return response;
            } catch (e) {
                this.setCreateStatusError();
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
         * @return     {Promise}  { description_of_the_return_value }
         */
        async loadDetail() {
            try {
                this.setFetchStatusFetching();
                await this.ReceiptVouchers.loadById(this.$route.query.copy_from);
                this.setFetchStatusSuccess();
            } catch (e) {
                this.handleException(e);
                return this.setFetchStatusError();
            }
        },

        /**
         * Loads a model if copy.
         */
        loadModelIfCopy() {
            return this.$route.query.copy_from && this.loadDetail();
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
            { title: 'Thêm mới' },
        ]);

        this.loadModelIfCopy();
    },
};
</script>
