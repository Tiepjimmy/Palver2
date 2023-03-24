import { ApiService } from '@/core/api.service';
export class InitProviderService {
    init(providerState) {}

    /**
     * Fetches lots.
     *
     * @return     {Promise}  The lots.
     */
    async fetchLotsByProviderID(providerID) {
        const url = 'http://shop1.v2.com/api/inventory/v1/lot';
        const params = { provider_id: providerID };

        return await axios.get(url, { params });
    }
}
