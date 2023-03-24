import Model from '@/core/model'
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

class LeadStatus extends Model {
  /**
   * LeadStatus constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.store_id = null
    this.name = null
    this.code = null
    this.color = null
    this.is_default = null
    this.is_active = null
    this.created_by = null
    this.updated_by = null
    this.level = null
    this.created_at = null
    this.updated_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'lead-status'
  }

  async getAllStatus() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['get-all']);

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }
}


export default LeadStatus
