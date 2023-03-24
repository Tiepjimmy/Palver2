import * as actions from './action-const';
import * as mutations from './mutation-const';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';

export default {
    /**
     * { function_description }
     *
     * @method      UPDATE_FILTER (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    payload      The payload
     */
    [actions.UPDATE_FILTER]({ commit }, payload) {
        commit(mutations.UPDATE_FILTER, payload);
    },

    /**
     * { function_description }
     *
     * @method      REPLACE_INVOICES (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    payload      The payload
     */
    [actions.REPLACE_INVOICES]({ commit }, payload) {
        commit(mutations.REPLACE_INVOICES, payload);
    },

    /**
     * Xóa danh sách phiếu xuất
     *
     * @class      CLEAR_INVOICES (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    payload      The payload
     */
    [actions.CLEAR_INVOICES]({ commit }, payload) {
        commit(mutations.CLEAR_INVOICES, payload);
    },
};
