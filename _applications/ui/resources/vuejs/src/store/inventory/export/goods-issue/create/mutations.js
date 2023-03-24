import Vue from 'vue';
import { mapMutations } from 'vuex';
import * as mutations from './mutation-const';
import { MutationHelpers } from '@/store/inventory/mutation-helpers';

export default {
    /**
     * { function_description }
     *
     * @class      CLEAN_MODEL (name)
     * @param      {<type>}  state    The state
     */
    [mutations.CLEAN_MODEL](state) {
        const props = ['load_order'];
        Vue.set(state, 'model', {});
    },

    /**
     * { function_description }
     *
     * @class      CLEAN_MODEL_SELL (name)
     * @param      {<type>}  state    The state
     */
    [mutations.CLEAN_MODEL_SELL](state) {
        const props = ['load_order'];
        Vue.set(state, 'model_sell', {});
    },

    /**
     * { function_description }
     *
     * @class      CLEAN_MODEL_INTERNAL (name)
     * @param      {<type>}  state    The state
     */
    [mutations.CLEAN_MODEL_INTERNAL](state) {
        const props = ['load_order'];
        Vue.set(state, 'model_internal', {});
    },

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
        const props = ['type', 'store_id', 'warehouse_id', 'note', 'products'];
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
