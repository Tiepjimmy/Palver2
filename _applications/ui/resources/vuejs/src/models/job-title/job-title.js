import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Collection from '@/core/collection'

class JobTitle extends Model {
  id

  /**
   * JobTitle constructor
   * @param data
   */
  constructor (data) {
    super()

    this.id = null

    this.bind(data)
  }

  async search(keyword, limit, offset) {
    return ApiService.get(ApiService.routes(this.apiGroup())['list'] + `?keyword=${keyword}&limit=${limit}&offset=${offset}`).then(response => {
      return response;
    });
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

  async storeJobTitle(data = null) {
    return ApiService.post(ApiService.routes(this.apiGroup())['store'], data || this.reduces()).then(response => {
      return response;
    });
  }

  async updateJobTitle(jobTitleId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['update'] + `/${jobTitleId}`, data).then(response => {
      return response;
    });
  }

  apiGroup () {
    return 'job-title'
  }

}

export default JobTitle
