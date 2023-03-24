import Vue from 'vue';
import { REPLACE_STORE_PROVIDERS, REPLACE_STORES } from '@/store/inventory/mutation-const';

export default {
    // Thay thế danh sách nhà cung cấp
    [REPLACE_STORE_PROVIDERS]: function (state, providers) {
        const hashesMap = state.providers.map(e => `${e.storeID}-${e.provider_id}`);

        providers.map(function (provider) {
            const hash = `${provider.store_id}-${provider.id}`;

            let index = hashesMap.indexOf(hash);
            if (index > -1) {
                state.providers.splice(index, 1, provider);
            } else {
                state.providers.push(provider);
            }
        });
    },

    // Thay thế danh sách cửa hàng
    [REPLACE_STORES]: function (state, providers) {
        state.providers = providers;
    },
};
