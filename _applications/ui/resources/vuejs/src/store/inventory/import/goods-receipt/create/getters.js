import { GET_MODEL, GET_STORE_ID, GET_MODEL_PRODUCTS } from './getter-const';

export default {
    [GET_MODEL]: state => state.model,
    [GET_STORE_ID]: state => state.storeID,
    [GET_MODEL_PRODUCTS]: state => state.model.products || [],
};
