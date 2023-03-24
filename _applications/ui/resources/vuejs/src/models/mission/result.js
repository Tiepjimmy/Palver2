import Model from '@/core/model'
import Collection from "@/core/collection";
import Task from "@/models/mission/task";
import ApiService from "@/core/api.service";

class Result extends Model {
  /**
   * Result constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.name = null
    this.lead_status_id = null
    this.tasks = new Collection(Task)
    this.is_active = null
    this.created_by = null
    this.updated_by = null
    this.created_at = null
    this.updated_at = null
    this.task_ids = []

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'result'
  }

  async getAllResult(params) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['get-all'], params);

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }
}


export default Result
