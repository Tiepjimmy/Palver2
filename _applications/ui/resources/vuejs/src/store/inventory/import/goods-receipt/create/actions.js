import * as names from './action-const';
import {} from './mutation-const';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';

export default {
    [names.INIT_MODEL]({ commit }, payload) {
        commit('INIT_MODEL', payload);
    },

    [names.MODEL_REMOVE_PRODUCT]({ commit }, productID) {
        commit('MODEL_REMOVE_PRODUCT', productID);
    },
    /**
     * { function_description }
     *
     * @class      MODEL_ADD_PRODUCT (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    product      The product
     */
    [names.MODEL_ADD_PRODUCT]({ commit }, product) {
        commit('MODEL_ADD_PRODUCT', product);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_ADD_RAW_PRODUCT (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  product      The product
     */
    [names.MODEL_ADD_RAW_PRODUCT]({ commit }, product) {
        // commit('MODEL_ADD_PRODUCT'), product, {root: true});
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_STORE_ID (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_STORE_ID]({ commit }, value) {
        commit('MODEL_UPDATE_STORE_ID', value);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PRODUCT_QUANTITY (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_PRODUCT_QUANTITY]({ commit }, value) {
        commit('MODEL_UPDATE_PRODUCT_QUANTITY', value);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PRODUCT_STORE_LOCATION (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_PRODUCT_STORE_LOCATION]({ commit }, value) {
        commit('MODEL_UPDATE_PRODUCT_STORE_LOCATION', value);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PRODUCT_LOT_ID (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_PRODUCT_LOT_ID]({ commit }, value) {
        commit('MODEL_UPDATE_PRODUCT_LOT_ID', value);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_WAREHOUSE_ID (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_WAREHOUSE_ID]({ commit }, value) {
        commit('MODEL_UPDATE_WAREHOUSE_ID', value);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PROVIDE_ID (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_PROVIDER_ID]({ commit }, value) {
        commit('MODEL_UPDATE_PROVIDER_ID', value);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_TYPE (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_TYPE]({ commit }, value) {
        commit('MODEL_UPDATE_TYPE', value);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_NOTE (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.MODEL_UPDATE_NOTE]({ commit }, value) {
        commit('MODEL_UPDATE_NOTE', value);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_LOADING_DIALOG (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.UPDATE_LOADING_DIALOG]({ commit }, value) {
        commit('UPDATE_LOADING_DIALOG', value);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_ERROR_DIALOG (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.UPDATE_ERROR_DIALOG]({ commit }, value) {
        commit('UPDATE_ERROR_DIALOG', value);
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_STORE_ID (name)
     * @param      {Object}    arg1         The argument 1
     * @param      {Function}  arg1.commit  The commit
     * @param      {<type>}    value        The value
     */
    [names.UPDATE_STORE_ID]({ commit }, value) {
        commit('UPDATE_STORE_ID', value);
    },

    /**
     * Adds a loading message.
     *
     * @class      ADD_LOADING_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.ADD_LOADING_MESSAGE]({ commit }, value) {
        commit('ADD_LOADING_MESSAGE', value);
    },

    /**
     * Removes a loading message.
     *
     * @class      REMOVE_LOADING_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.REMOVE_LOADING_MESSAGE]({ commit }, value) {
        commit('REMOVE_LOADING_MESSAGE', value);
    },

    /**
     * Adds an error message.
     *
     * @class      ADD_ERROR_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.ADD_ERROR_MESSAGE]({ commit }, value) {
        commit('ADD_ERROR_MESSAGE', value);
    },

    /**
     * Removes an error message.
     *
     * @class      REMOVE_ERROR_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.REMOVE_ERROR_MESSAGE]({ commit }, value) {
        commit('REMOVE_ERROR_MESSAGE', value);
    },
};
