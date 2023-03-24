import Vue from 'vue';
import * as mutations from './mutation-const';
import { MutationHelpers } from '@/store/inventory/mutation-helpers';

export default {
    /**
     * { function_description }
     *
     * @param      {<type>}  value   The value
     */
    [mutations.UPDATE_FILTER](state, payload) {
        const props = ['keyword', 'expired_at', 'statuses'];
        MutationHelpers.UPDATE(state.filter, props, payload);
    },

    /**
     * { function_description }
     *
     * @class      REPLACE_LOTS (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  payload  The payload
     */
    [mutations.REPLACE_LOTS](state, payload) {
        Vue.set(state, 'lots', payload);
    },

    /**
     * { function_description }
     *
     * @class      CLEAR_LOTS (name)
     * @param      {<type>}  state   The state
     */
    [mutations.CLEAR_LOTS](state) {
        MutationHelpers.UPDATE(state, ['lots'], {});
    },
};
