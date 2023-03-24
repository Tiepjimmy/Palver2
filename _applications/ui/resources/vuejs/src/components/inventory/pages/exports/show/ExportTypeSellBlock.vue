<template>
    <v-card-text>
        <div class="form-group">
            <label>Mã đơn hàng</label>
            <b>{{ model_sell.order_id }}</b>
        </div>

        <div class="form-group">
            <label>Người nhận</label>
            <b>{{ recipient }}</b>
        </div>

        <div class="form-group">
            <label>Thông tin liên hệ</label>
            <b>{{ contact }}</b>
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <b>{{ address }}</b>
        </div>
    </v-card-text>
</template>
<script type="text/javascript">
import Swal from 'sweetalert2';

import { mapGetters, mapState, mapActions } from 'vuex';
import * as actions from '@/store/inventory/export/goods-issue/show/action-const';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';

import { GOODS_ISSUE_TYPE_NAMES } from '@/components/inventory/utils/ModelConst';

import { ERROR_TITLE, ERROR_MESSAGE_FETCH } from '@/components/inventory/utils/MessageConst';

export default {
    name: 'ExportTypeSellBlock',
    data: () => ({
        recipient: '',
        contact: '',
        address: '',
    }),

    computed: {
        ...mapState('inventory/export/goods_issue/show', {
            model: state => state.model,
            model_sell: state => state.model_sell,
            model_internal: state => state.model_internal,
        }),
    },

    watch: {},

    methods: {
        ...mapActions('inventory/export/goods_issue/show', {
            UPDATE_MODEL: actions.UPDATE_MODEL,
            UPDATE_MODEL_SELL: actions.UPDATE_MODEL_SELL,
            UPDATE_MODEL_INTERNAL: actions.UPDATE_MODEL_INTERNAL,
        }),
    },

    mounted() {
        // mock
        this.recipient = 'Trần Văn A';
        this.contact = 'tranvana@gmail.com/0922334212';
        this.address = '121 đường Kim Giang, Thanh XUân, Hà nội ';
    },
};
</script>

<style></style>
