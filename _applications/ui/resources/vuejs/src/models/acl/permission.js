import Model from '@/core/model'
import Api from "@/core/api.service";
import Collection from "@/core/collection";

class Permission extends Model {
  /**
   * Permission constructor
   * @param data
   */
  constructor(data) {
    super()
    this.key = null
    this.name = null
    this.status = null
    this.entity_id = null
    this.router = null
    this.type = null
    this.entity = null
    this.is_default = null
    this.selected = false

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'permission'
  }
    async getDataPermission(params, callback) {
        let response = await Api.getAsync(Api.routes(this.apiGroup())['data-permission'], params);

        if (!response.isSuccess()) {
            throw response.message || 'Exception';
        }

        if (typeof callback === 'function') {
            callback.call(null, response.data);
        }
        const collection = new Collection(this.constructor);
        collection.mapResponse(response);

        return collection;

        // return response;
    }
}

export default Permission
