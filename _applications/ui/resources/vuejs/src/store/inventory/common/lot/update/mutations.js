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
        Vue.set(state, 'model', {});
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_MODEL (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  payload  The payload
     */
    [mutations.UPDATE_MODEL](state, payload) {
        const props = ['id', 'code', 'expired_date', 'note', 'status'];
        MutationHelpers.UPDATE(state.model, props, payload);
    },
};
