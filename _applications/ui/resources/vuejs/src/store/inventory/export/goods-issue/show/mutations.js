import { mapMutations } from 'vuex';
import * as mutations from './mutation-const';
import { MutationHelpers } from '@/store/inventory/mutation-helpers';

export default {
    /**
     * { function_description }
     *
     * @class      UPDATE_STORE (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  payload  The payload
     */
    [mutations.UPDATE_STORE](state, payload) {
        const props = ['load_order'];
        MutationHelpers.UPDATE(state, props, payload);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_MODEL (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  payload  The payload
     */
    [mutations.UPDATE_MODEL](state, payload) {
        const props = [
            'id',
            'type',
            'code',
            'store_id',
            'store',
            'warehouse_id',
            'warehouse',
            'status',
            'note',
            'details',
            'statuses',
        ];
        MutationHelpers.UPDATE(state.model, props, payload);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_MODEL_SELL (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  payload  The payload
     */
    [mutations.UPDATE_MODEL_SELL](state, payload) {
        console.log(this);
        const props = ['order_id'];
        MutationHelpers.UPDATE(state.model_sell, props, payload);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_MODEL_INTERNAL (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  payload  The payload
     */
    [mutations.UPDATE_MODEL_INTERNAL](state, payload) {
        const props = ['type', 'store_id', 'warehouse_id', 'note'];
        MutationHelpers.UPDATE(state.model_internal, props, payload);
    },
};
