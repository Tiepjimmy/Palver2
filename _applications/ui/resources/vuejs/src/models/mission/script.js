import Model from '@/core/model'
import Collection from "@/core/collection";
import Task from "@/models/mission/task";
import Result from "@/models/mission/result";
import ApiService from "@/core/api.service";

class Script extends Model {
  /**
   * Script constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.task_id = null
    this.task = new Collection(Task)
    this.result_id = null
    this.result = new Collection(Result)
    this.next_task_id = null
    this.next_task = new Task()
    this.next_task_end_at = null
    this.created_by = null
    this.updated_by = null
    this.created_at = null
    this.updated_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'script'
  }

  async loadScript(params) {
    this.reset();
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['script-detail'],params);
    this.bind(response.data);
    return this;
  }
}


export default Script
