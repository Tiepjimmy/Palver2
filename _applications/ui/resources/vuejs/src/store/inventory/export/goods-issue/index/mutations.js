import Vue from 'vue';
import * as mutations from './mutation-const';

export default {
    /**
     * { function_description }
     *
     * @param      {<type>}  value   The value
     */
    [mutations.UPDATE_FILTER](state, payload) {
        const props = ['keyword', 'created_at', 'created_by', 'providers', 'types', 'stores', 'warehouses'];
        if (props.includes(payload.key)) {
            return Vue.set(state.filter, payload.key, payload.value);
        }
    },

    /**
     * { function_description }
     *
     * @class      REPLACE_INVOICES (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  payload  The payload
     */
    [mutations.REPLACE_INVOICES](state, payload) {
        Vue.set(state.invoices, payload.status, payload.data);
    },

    /**
     * { function_description }
     *
     * @class      CLEAR_INVOICES (name)
     * @param      {<type>}  state   The state
     */
    [mutations.CLEAR_INVOICES](state, payload) {
        Vue.set(state.invoices, payload, {});
    },
};
