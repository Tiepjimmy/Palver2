import Model from '@/core/model'
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

class Task extends Model {
  /**
   * Task constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.name = null
    this.is_default = null
    this.is_active = null
    this.created_by = null
    this.updated_by = null
    this.created_at = null
    this.updated_at = null
    this.checked = false

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'task'
  }

  async getAllTask() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['get-all']);

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }
}


export default Task
