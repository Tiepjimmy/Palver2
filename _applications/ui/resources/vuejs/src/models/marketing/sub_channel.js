import Model from '@/core/model'
import Channel from "@/models/marketing/channel";
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

class SubChannel extends Model {
  /**
   * Channel constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.channel_id = null
    this.name = null
    this.code = null
    this.is_active = null
    this.content = null
    this.created_by = null
    this.updated_by = null
    this.channel = new Channel()
    this.created_at = null
    this.updated_at = null
    this.deleted_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'sub-channel'
  }

  async getAllSubChannel() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['get-all']);

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }

  async checkUniqueCode(params) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['check-unique-code'], params);

    return response
  }
}


export default SubChannel
