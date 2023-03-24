import ApiService from '@/core/api.service'
import Model from '@/core/model'

class ProviderGroup extends Model {
  /**
   * ProviderGroup constructor
   * @param data
   */
  constructor (data) {
    super()
    this.id = null
    this.bind(data)
  }

  apiGroup () {
    return 'provider-group'
  }

  async store(data = null) {
    return ApiService.post(ApiService.routes(this.apiGroup())['store'], data || this.reduces()).then(response => {
      return response;
    });
  }

}

export default ProviderGroup
