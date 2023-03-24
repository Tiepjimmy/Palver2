<template>
    <div class="card card-custom">
        <step :status="model.status"></step>
        <div class="card-body">
            <div class="container p-0">
                <div class="row">
                    <div class="col-9">
                        <!-- thong tin san pham -->
                        <products-block></products-block>
                    </div>
                    <div class="col-3">
                        <!-- thong tin phieu xuat -->
                        <invoice-block></invoice-block>

                        <!-- Thông tin bổ sung -->
                        <addition-block class="mt-3"></addition-block>

                        <!-- Thông tin khác -->
                        <note-block class="mt-3"></note-block>

                        <!-- Nút bấm -->
                        <accept-btn-block class="mt-3"></accept-btn-block>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import Swal from 'sweetalert2';
import { ERROR_TITLE, ERROR_MESSAGE, SUCCESS_TITLE, SUCCESS_MESSAGE } from '@/components/inventory/utils/MessageConst';
import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';
import { default as ProductsBlock } from './ProductsBlock';
import { default as InvoiceBlock } from './InvoiceBlock';
import { default as AdditionBlock } from './AdditionBlock';
import { default as AcceptBtnBlock } from './AcceptBtnBlock';
import { default as NoteBlock } from './NoteBlock';
import { default as Step } from '../components/Step';

import * as actions from '@/store/inventory/export/goods-issue/show/action-const';
import * as ModelConst from '@/components/inventory/utils/ModelConst';

export default {
    name: 'Accept',

    components: { ProductsBlock, InvoiceBlock, AdditionBlock, AcceptBtnBlock, NoteBlock, Step },

    data: () => ({}),

    computed: {
        ...mapState('inventory/export/goods_issue/show', {
            model: state => state.model,
            model_sell: state => state.model_sell,
            model_internal: state => state.model_internal,
        }),
    },

    methods: {
        ...mapActions('inventory/export/goods_issue/show', {
            UPDATE_MODEL: actions.UPDATE_MODEL,
            UPDATE_MODEL_SELL: actions.UPDATE_MODEL_SELL,
            UPDATE_MODEL_INTERNAL: actions.UPDATE_MODEL_INTERNAL,
        }),

        /**
         * Fetches a detail and fill store.
         *
         * @return     {Promise}  The detail and fill store.
         */
        async fetchDetailAndFillStore() {
            try {
                const response = await InteractAPIService.fetchGoodsIssue(this.$route.params.id);

                // Tính toán và fill thuộc tính giá cho từng sản phẩm
                response.data.details = response.data.details.map(function (detail) {
                    detail.price = _.get(detail, 'product.product_entities.0.entity_prices.prices', 0);

                    return detail;
                });

                // Fill model sell nếu loại phiếu là sell đồng thời xóa sell prop khỏi data ban đầu
                if (ModelConst.GOODS_ISSUE_TYPE_SELL === response.data.type) {
                    this.UPDATE_MODEL_SELL({ ...response.data.sell });
                    delete response.data.sell;
                }

                // Fill model internal nếu loại phiếu là internal đồng thời xóa internal prop khỏi data ban đầu
                if (ModelConst.GOODS_ISSUE_TYPE_INTERNAL === response.data.type) {
                    this.UPDATE_MODEL_INTERNAL({ ...response.data.internal });
                    delete response.data.internal;
                }

                this.UPDATE_MODEL({ ...response.data });
            } catch (e) {
                Swal.fire(ERROR_TITLE, ERROR_MESSAGE, 'error');
            }
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: 'Phiếu nhập kho' }, { title: 'Duyệt phiếu' }]);
        this.fetchDetailAndFillStore();
    },
};
</script>

<style scoped></style>
