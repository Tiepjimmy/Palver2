import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Collection from '@/core/collection'

class Provider extends Model {
  /**
   * Provider constructor
   * @param data
   */
  constructor (data) {
    super()

    this.id = null

    this.bind(data)
  }

  apiGroup () {
    return 'provider'
  }

  async getList(keyword, limit, offset) {
    return ApiService.get(ApiService.routes(this.apiGroup())['list'] + `?keyword=${keyword}&limit=${limit}&offset=${offset}`)
      .then(response => {
        return response;
      });
  }

  async show(providerId) {
    return ApiService.get(ApiService.routes(this.apiGroup())['show'] + `/${providerId}`).then(response => {
      return response;
    });
  }

  async getCreateInfo() {
    return ApiService.get(ApiService.routes(this.apiGroup())['create']).then(response => {
      return response;
    });
  }

  async store(data = null) {
    return ApiService.post(ApiService.routes(this.apiGroup())['store'], data || this.reduces()).then(response => {
      return response;
    });
  }

  async update(providerId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['update'] + `/${providerId}`, data).then(response => {
      return response;
    });
  }

  async updateStatus(providerId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['update-status'] + `/${providerId}`, data).then(response => {
      return response;
    });
  }

  async getListProvince() {
    return ApiService.get(ApiService.routes(this.apiGroup())['province']).then(response => {
      return response;
    });
  }

  async getListDistrict(provinceId) {
    return ApiService.get(ApiService.routes(this.apiGroup())['district'] + `?province_id=${provinceId}`).then(response => {
      return response;
    });
  }

  async getListWard(districtId) {
    return ApiService.get(ApiService.routes(this.apiGroup())['ward'] + `?district_id=${districtId}`).then(response => {
      return response;
    });
  }

}

export default Provider
