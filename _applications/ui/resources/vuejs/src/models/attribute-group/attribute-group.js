import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Collection from '@/core/collection'

class AttributeGroup extends Model {
  id

  /**
   * AttributeGroup constructor
   * @param data
   */
  constructor (data) {
    super()

    this.id = null
    this.group_name = null
    this.group_cd = null

    this.bind(data)
  }

  async getList() {
    return ApiService.get(ApiService.routes(this.apiGroup())['list']).then(response => {
      return response;
    });
  }

  async getCreateInfo() {
    return ApiService.get(ApiService.routes(this.apiGroup())['create']).then(response => {
      return response;
    });
  }

  async storeNewAttributeGroup(data = null) {
    return ApiService.post(ApiService.routes(this.apiGroup())['store'], data || this.reduces()).then(response => {
      return response;
    });
  }

  async getCurrentAttributeGroup(attributeGroupId) {
    return ApiService.get(ApiService.routes(this.apiGroup())['show'] + `/${attributeGroupId}`).then(response => {
      return response;
    });
  }

  async updateAttributeGroup(attributeGroupId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['update'] + `/${attributeGroupId}`, data).then(response => {
      return response;
    });
  }

  async changeAttributeGroupStatus(attributeGroupId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['change-status'] + `/${attributeGroupId}`, data).then(response => {
      return response;
    });
  }

  apiGroup () {
    return 'attribute-group'
  }

}

export default AttributeGroup
