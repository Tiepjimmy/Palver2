<template>
    <!-- duyệt phiếu -->
    <div class="mt-3">
        <button type="button" class="btn btn-warning btn-sm" @click="onClickBtnCancel"> Hủy phiếu </button>
        <button type="button" class="btn btn-primary btn-sm px-5" @click="onClickBtnImport"> Nhập kho </button>
    </div>
</template>
<script type="text/javascript">
import Swal from 'sweetalert2';
import { GOODS_RECEIPT_STATUS_IMPORTED, GOODS_RECEIPT_STATUS_CANCELED } from '@/components/inventory/utils/ModelConst';
import { ERROR_TITLE, ERROR_MESSAGE, SUCCESS_TITLE, SUCCESS_MESSAGE } from '@/components/inventory/utils/MessageConst';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';

export default {
    name: 'AcceptBtnBlock',
    props: {
        detail: {},
    },

    methods: {
        /**
         * Called on click button cancel.
         */
        onClickBtnCancel() {
            this.updateStatus(GOODS_RECEIPT_STATUS_CANCELED);
        },

        /**
         * Called on click button resolve.
         */
        onClickBtnImport() {
            this.updateStatus(GOODS_RECEIPT_STATUS_IMPORTED);
        },

        /**
         * { function_description }
         *
         * @param      {<type>}   status  The status
         * @return     {Promise}  { description_of_the_return_value }
         */
        async updateStatus(status) {
            try {
                const response = await InteractAPIService.updateManyGoodsReceiptStatus([this.$route.params.id], status);
                Swal.fire(SUCCESS_TITLE, SUCCESS_MESSAGE, 'success');
            } catch (e) {
                Swal.fire(ERROR_TITLE, ERROR_MESSAGE, 'error');
            }
        },
    },
};
</script>

<style lang="scss"></style>
