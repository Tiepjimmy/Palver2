<template>
    <v-card elevation="0">
        <div class="container">
            <div class="row">
                <div class="col-9 p-0">
                    <!-- thong tin nha cung cap -->
                    <provider-block :detail="detail"></provider-block>

                    <!-- thong tin san pham -->
                    <products-block :detail="detail"></products-block>
                </div>

                <div class="col-3 pr-0 pt-0">
                    <!-- thong tin phieu nhap -->
                    <invoice-block :detail="detail"></invoice-block>

                    <!-- thong tin khacs -->
                    <more-block :detail="detail"></more-block>

                    <!-- duyệt phiếu -->
                    <import-btn-block :detail="detail"></import-btn-block>
                </div>
            </div>
        </div>
    </v-card>
</template>

<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import Swal from 'sweetalert2';
import { ERROR_TITLE, ERROR_MESSAGE, SUCCESS_TITLE, SUCCESS_MESSAGE } from '@/components/inventory/utils/MessageConst';
import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';
import { default as ProviderBlock } from './ProviderBlock';
import { default as ProductsBlock } from './ProductsBlock';
import { default as InvoiceBlock } from './InvoiceBlock';
import { default as MoreBlock } from './MoreBlock';
import { default as ImportBtnBlock } from './ImportBtnBlock';

export default {
    name: 'InventoryGoodsReceiptShow',

    components: { ProviderBlock, ProductsBlock, InvoiceBlock, MoreBlock, ImportBtnBlock },

    data: () => ({
        detail: {},
    }),
    computed: {},

    methods: {
        /**
         * Fetches a detail.
         *
         * @return     {Promise}  The detail.
         */
        async fetchDetail() {
            try {
                const response = await InteractAPIService.fetchGoodsReceipt(this.$route.params.id);
                this.detail = response.data;
            } catch (e) {
                Swal.fire(ERROR_TITLE, ERROR_MESSAGE, 'error');
            }
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: 'Phiếu nhập kho' }, { title: 'Nhập kho' }]);
        this.fetchDetail();
    },
};
</script>

<style scoped></style>
