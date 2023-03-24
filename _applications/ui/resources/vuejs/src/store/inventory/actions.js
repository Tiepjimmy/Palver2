import {
    FETCH_STORE_PROVIDERS,
    FETCH_MANY_STORE_PROVIDERS,
    REPLACE_STORE_PROVIDERS,
    REPLACE_MANY_STORE_PROVIDERS,
    FETCH_STORES,
    REPLACE_STORES,
} from './action-const';

import { REPLACE_PROVIDERS } from '@/store/inventory/mutation-const';
import { InteractAPIService } from '@/components/inventory/services/InteractAPIService';

export default {
    // Fetch danh sách  nhà cung cấp
    [FETCH_STORE_PROVIDERS]: async function ({ commit, dispatch }, storeIDs) {
        try {
            let response = await InteractAPIService.fetchProvidersByStoreIDs(storeIDs);

            let prepared = response.data.map(function (row) {
                row.store_id = row['pivot']['store_id'];
                delete row['pivot'];

                return row;
            }, {});

            commit(REPLACE_STORE_PROVIDERS, prepared);
        } catch (e) {
            console.log(e);
        }
    },

    // Fetch danh sách cửa hàng
    [FETCH_STORES]: async function ({ commit }, storeID) {
        try {
            const response = await InteractAPIService.fetchStoreBranches(storeID);

            commit(REPLACE_STORES, response.data);
        } catch (e) {
            console.log(e);
        }
    },

    // Thay thế danh sách cửa hàng
    [REPLACE_STORES]: ({ commit }, stores) => commit(REPLACE_STORES, stores),
};
