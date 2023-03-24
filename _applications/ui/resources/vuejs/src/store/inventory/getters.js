import { GET_PROVIDER, GET_PROVIDER_BY_STORE_ID, GET_PROVIDER_BY_ID } from './getter-const';
export default {
    loader: state => state.loader,

    //
    [GET_PROVIDER]: state => storeId => providerID =>
        state.providers.filter(p => p.store_id == storeId).find(p => p.id === providerID),

    [GET_PROVIDER_BY_STORE_ID]: state => storeId => state.providers.filter(p => p.store_id == storeId),

    [GET_PROVIDER_BY_ID]: state => providerID => state.providers.find(provider => provider.id == providerID),
};
