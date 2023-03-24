import Vue from 'vue';
import * as names from './mutation-const';

export default {
    /**
     * { function_description }
     *
     * @class      INIT_MODEL (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  productID The productID
     */
    [names.INIT_MODEL](state, payload) {
        state.model = payload;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_REMOVE_PRODUCT (name)
     * @param      {<type>}  state    The state
     * @param      {<type>}  productID The productID
     */
    [names.MODEL_REMOVE_PRODUCT](state, productID) {
        for (let i = 0; i < state.model.products.length; i++) {
            if (state.model.products[i].product_id === productID) {
                return state.model.products.splice(i, 1);
            }
        }
    },

    /**
     * { function_description }
     *
     * @class      MODEL_ADD_PRODUCT (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  product     The product
     */
    [names.MODEL_ADD_PRODUCT](state, product) {
        state.model.products.push(product);
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PRODUCT_QUANTITY (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  payload       The payload
     */
    [names.MODEL_UPDATE_PRODUCT_QUANTITY](state, payload) {
        state.model.products.find(p => p.product_id == payload.id).quantity = payload.value;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PRODUCT_STORE_LOCATION (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  payload       The payload
     */
    [names.MODEL_UPDATE_PRODUCT_STORE_LOCATION](state, payload) {
        state.model.products.find(p => p.product_id == payload.id).storage_location = payload.value;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PRODUCT_LOT_ID (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  payload       The payload
     */
    [names.MODEL_UPDATE_PRODUCT_LOT_ID](state, payload) {
        state.model.products.find(p => p.product_id == payload.id).lot_id = payload.value;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_STORE_ID (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  value       The value
     */
    [names.MODEL_UPDATE_STORE_ID](state, value) {
        state.model.store_id = value;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_WAREHOUSE_ID (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  value       The value
     */
    [names.MODEL_UPDATE_WAREHOUSE_ID](state, value) {
        state.model.warehouse_id = value;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_PROVIDER_ID (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  value       The value
     */
    [names.MODEL_UPDATE_PROVIDER_ID](state, value) {
        state.model.provider_id = value;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_TYPE (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  value       The value
     */
    [names.MODEL_UPDATE_TYPE](state, value) {
        state.model.type = value;
    },

    /**
     * { function_description }
     *
     * @class      MODEL_UPDATE_NOTE (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  value       The value
     */
    [names.MODEL_UPDATE_NOTE](state, value) {
        state.model.note = value;
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_LOADING_DIALOG (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  value       The value
     */
    [names.UPDATE_LOADING_DIALOG](state, value) {
        state.loadingDialog = value;
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_ERROR_DIALOG (name)
     * @param      {Object}  arg1        The argument 1
     * @param      {<type>}  arg1.state  The state
     * @param      {<type>}  value       The value
     */
    [names.UPDATE_ERROR_DIALOG](state, value) {
        state.errorDialog = value;
    },

    /**
     * { function_description }
     *
     * @class      UPDATE_STORE_ID (name)
     * @param      {<type>}  state   The state
     * @param      {<type>}  value   The value
     */
    [names.UPDATE_STORE_ID](state, value) {
        state.storeID = value;
    },

    /**
     * Adds a loading message.
     *
     * @class      ADD_LOADING_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.ADD_LOADING_MESSAGE](state, payload) {
        state.loadingMessageStack[payload.key] = payload.value;
    },

    /**
     * Removes a loading message.
     *
     * @class      REMOVE_LOADING_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.REMOVE_LOADING_MESSAGE](state, key) {
        delete state.loadingMessageStack[key];
    },

    /**
     * Adds an error message.
     *
     * @class      ADD_ERROR_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.ADD_ERROR_MESSAGE](state, value) {
        state.errorMessageStack[payload.key] = payload.value;
    },

    /**
     * Removes an error message.
     *
     * @class      REMOVE_ERROR_MESSAGE (name)
     * @param      {Object}  arg1         The argument 1
     * @param      {<type>}  arg1.commit  The commit
     * @param      {<type>}  value        The value
     */
    [names.REMOVE_ERROR_MESSAGE](state, key) {
        delete state.errorMessageStack[key];
    },
};
