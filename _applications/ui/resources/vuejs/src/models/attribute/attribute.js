import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Collection from '@/core/collection'

class Attribute extends Model {
  id

  /**
   * Attribute constructor
   * @param data
   */
  constructor (data) {
    super()

    this.id = null
    this.group_name = null
    this.group_cd = null

    this.bind(data)
  }

  async storeNewAttribute(data = null) {
    return ApiService.post(ApiService.routes(this.apiGroup())['store'], data || this.reduces()).then(response => {
      return response;
    });
  }


  async updateAttribute(attributeId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['update'] + `/${attributeId}`, data).then(response => {
      return response;
    });
  }

  async deleteAttribute(attributeId) {
    return ApiService.delete(ApiService.routes(this.apiGroup())['delete'] + `/${attributeId}`).then(response => {
      return response;
    });
  }

  async changeAttributeStatus(attributeId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['change-status'] + `/${attributeId}`, data).then(response => {
      return response;
    });
  }

  apiGroup () {
    return 'attribute'
  }

}

export default Attribute
