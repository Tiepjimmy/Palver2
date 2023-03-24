import Model from '@/core/model'
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

class Channel extends Model {
  /**
   * Channel constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.name = null
    this.code = null
    this.is_active = null
    this.created_by = null
    this.updated_by = null
    this.created_at = null
    this.updated_at = null
    this.deleted_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'channel'
  }

  async getAllChannel() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['get-all']);

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }

  async getListUser() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['user-marketing']);

    return response.data
  }
}


export default Channel
