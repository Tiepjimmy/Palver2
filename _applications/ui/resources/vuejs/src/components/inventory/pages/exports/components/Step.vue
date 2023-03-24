<template>
    <div class="card-header">
        <v-stepper v-model="step" alt-labels :elevation="0" class="flex-grow-1">
            <v-stepper-header>
                <v-stepper-step step="1" :complete="!!model.id"> Tạo phiếu </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="2" :complete="accomplished(ModelConst.GOODS_ISSUE_STATUS_RESOLVED)">
                    Duyệt phiếu
                </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="3" :complete="accomplished(ModelConst.GOODS_ISSUE_STATUS_PACKED)">
                    Đóng hàng
                </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="4" :complete="accomplished(ModelConst.GOODS_ISSUE_STATUS_EXPORTED)">
                    Xuất kho
                </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step
                    step="5"
                    :rules="[() => !accomplished(ModelConst.GOODS_ISSUE_STATUS_CANCELED)]"
                    :complete="accomplished(ModelConst.GOODS_ISSUE_STATUS_CANCELED)"
                >
                    Hủy phiếu
                </v-stepper-step>
            </v-stepper-header>
        </v-stepper>
    </div>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import * as ModelConst from '@/components/inventory/utils/ModelConst';

import { default as StepCancel } from './StepCancel';

export default {
    name: 'Step',

    components: {
        StepCancel,
    },

    computed: {
        ...mapState('inventory/export/goods_issue/show', {
            model: state => state.model,
        }),

        step() {},

        /**
         * { function_description }
         *
         * @class      ModelConst (name)
         * @return     {<type>}  { description_of_the_return_value }
         */
        ModelConst() {
            return ModelConst;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        statuses() {
            return this.model.statuses || [];
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        statusHistory() {
            return this.statuses.map(e => e.status);
        },

        /**
         * Determines if create status.
         *
         * @return     {boolean}  True if create status, False otherwise.
         */
        isCreateStatus() {
            return true;
        },

        /**
         * Determines if cancel status.
         *
         * @return     {boolean}  True if cancel status, False otherwise.
         */
        isCancelStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_CANCELED;
        },

        /**
         * Determines if reject status.
         *
         * @return     {boolean}  True if reject status, False otherwise.
         */
        isRejectStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_REJECTED;
        },

        /**
         * Determines if resolve status.
         *
         * @return     {boolean}  True if resolve status, False otherwise.
         */
        isResolveStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_RESOLVED;
        },

        /**
         * Determines if pack status.
         *
         * @return     {boolean}  True if pack status, False otherwise.
         */
        isPackStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_PACKED;
        },

        /**
         * Determines if export status.
         *
         * @return     {boolean}  True if export status, False otherwise.
         */
        isExportStatus() {
            return this.model.status === ModelConst.GOODS_ISSUE_STATUS_EXPORTED;
        },
    },

    methods: {
        /**
         * { function_description }
         *
         * @param      {<type>}  status  The status
         * @return     {<type>}  { description_of_the_return_value }
         */
        accomplished(status) {
            return this.statusHistory.includes(status);
        },
    },
};
</script>

<style></style>
