import * as actions from './action-const';
import * as mutations from './mutation-const';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';

export default {
    /**
     * Cập nhật filter
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
     * Thay thế danh sách lô
     *
     * @method      REPLACE_LOTS (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    payload      The payload
     */
    [actions.REPLACE_LOTS]({ commit }, payload) {
        commit(mutations.REPLACE_LOTS, payload);
    },

    /**
     * Xóa danh sách lô
     *
     * @class      CLEAR_LOTS (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    payload      The payload
     */
    [actions.CLEAR_LOTS]({ commit }, payload) {
        commit(mutations.CLEAR_LOTS, payload);
    },
};
