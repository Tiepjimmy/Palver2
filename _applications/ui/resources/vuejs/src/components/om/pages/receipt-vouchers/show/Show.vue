<template>
    <v-form ref="form" v-if="hasData">
        <div class="container px-0">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <GeneralBlock
                        elevation="1"
                        :receipt-model="ReceiptVouchers"
                        @SELECTED_ACTION="onSelectAction"
                    ></GeneralBlock>
                    <ValueBlock class="mt-6" elevation="1" :receipt-model="ReceiptVouchers"></ValueBlock>
                </div>
                <div class="col-12 col-sm-4">
                    <InformationBlock elevation="1" :receipt-model="ReceiptVouchers"></InformationBlock>
                </div>
            </div>
        </div>
    </v-form>
</template>
<script type="text/javascript">
import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';
import ReceiptVouchers from '@/models/receipt-vouchers/receipt_vouchers';
import FetchStatusMixin from '@/components/om/utils/mixins/FetchStatusMixin';
import PopupMessagesMixin from '@/components/om/utils/mixins/PopupMessagesMixin';
import EmitsMixin from '@/components/om/utils/mixins/EmitsMixin';

import GeneralBlock from './GeneralBlock';
import ValueBlock from './ValueBlock';
import InformationBlock from './InformationBlock';

export default {
    name: 'Show',

    mixins: [FetchStatusMixin, PopupMessagesMixin, EmitsMixin],

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
            if (!this.$refs.form.validate()) {
                return;
            }

            this.emitCreating();

            try {
                await this.save();

                if (this.isCreateSuccess) {
                    this.emitCreated();
                    this.showPopupSuccess({
                        text: 'Tạo chứng từ thu thành công !',
                        timer: 1500,
                        onDestroy: () => alert('ok'),
                    });
                }
            } catch (e) {
                this.handleException(e);
                return this.emitError();
            }
        },

        /**
         * Lưu thông tin chứng từ
         *
         * @return     {Promise}
         */
        async save() {
            const postData = this.prepareStoreData(this.ReceiptVouchers);

            return await this.ReceiptVouchers.storeAsync(postData);
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
                await this.ReceiptVouchers.loadById(this.$route.params.id);
                this.setFetchStatusSuccess();
            } catch (e) {
                this.handleException(e);
                return this.setFetchStatusError();
            }
        },

        onSelectAction(actionName) {
            switch (actionName) {
                case 'edit':
                    return this.$router.push({ name: 'om.receipt_vouchers.edit' });

                case 'delete':
                    return this.handleDelete();

                case 'copy':
                    return this.$router.push({
                        name: 'om.receipt_vouchers.create',
                        query: { copy_from: this.ReceiptVouchers.id },
                    });
            }
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async handleDelete() {
            try {
                const options = {
                    html: 'Bạn chắc chắn muốn xóa chứng từ thu `<b>' + this.ReceiptVouchers.code + '</b>` ?',
                };
                const result = await this.showPopupConfirm(options);

                if (result.isConfirmed) {
                    const response = await this.ReceiptVouchers.deleteAsync();
                    return this.gotoIndex();
                }
            } catch (e) {
                console.log(e);
                this.messageError(e);
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
            { title: 'Chi tiết' },
        ]);

        this.loadDetail();
    },
};
</script>
