import * as actions from './action-const';
import * as mutations from './mutation-const';

export default {
    /**
     * { function_description }
     *
     * @class      CLEAN_MODEL (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  payload      The payload
     */
    [actions.CLEAN_MODEL]({ commit }, payload) {
        commit(mutations.CLEAN_MODEL);
        commit(mutations.UPDATE_MODEL, payload);
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
};
