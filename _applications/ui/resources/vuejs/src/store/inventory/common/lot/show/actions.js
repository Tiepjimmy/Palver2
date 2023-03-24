import * as actions from './action-const';
import * as mutations from './mutation-const';

export default {
    /**
     * { function_description }
     *
     * @class      UPDATE_STORE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  payload      The payload
     */
    [actions.UPDATE_STORE]({ commit }, payload) {
        commit(mutations.UPDATE_STORE, payload);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_MODEL (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  payload      The payload
     */
    [actions.UPDATE_MODEL]({ commit }, payload) {
        commit(mutations.UPDATE_MODEL, payload);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_MODEL_SELL (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  payload      The payload
     */
    [actions.UPDATE_MODEL_SELL]({ commit }, payload) {
        commit(mutations.UPDATE_MODEL_SELL, payload);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_MODEL_INTERNAL (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  payload      The payload
     */
    [actions.UPDATE_MODEL_INTERNAL]({ commit }, payload) {
        commit(mutations.UPDATE_MODEL_INTERNAL, payload);
    },
};
