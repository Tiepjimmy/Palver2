import Model from '@/core/model'
import Collection from "@/core/collection";
import Permission from "./permission";
import Api from "@/core/api.service";

class Module extends Model {
  /**
   * Module constructor
   * @param data
   */
  constructor(data) {
    super()

    this.id = null;
    this.name = null;
    this.key = null;
    this.status = null;
    this.permissions = new Collection(Permission);
    this.permissions_data = null
    this.selected = false

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'entity'
  }

  /**
   * @public
   * @param params
   * @param callback
   * @returns {*}
   */
  loadAll(params, callback) {
    return Api.get(Api.routes(this.apiGroup())['all'], params).then(response => {
      if (!response.isSuccess()) {
        throw response.message || 'Exception';
      }
      this.collection.clear();
      this.collection.mapResponse(response);

      if (typeof callback === 'function') {
        callback.call(null, response.data);
      }

      return this.collection;
    });
  }

  selectAllPermissions() {
    this.permissions.forEach(i => {
      i.selected = true
    })
    this.selected = false
  }

  deSelectAllPermissions() {
    this.permissions.forEach(i => {
      i.selected = false
    })
    this.selected = false
  }

  getSelectedPermissions() {
    return this.permissions.filter(i => i.selected === true)
  }

  getCURDSelectedPermissions() {
    const acceptPermissions = ['view', 'store', 'update', 'delete', 'customer_assignee', 'orders'];
    return this.permissions.filter(i => i.selected === true && acceptPermissions.includes(i.type))
  }

  hasSelectedPermissions() {
    return this.getSelectedPermissions().length > 0
  }

  hasCURDSelectedPermissions() {
    return this.getCURDSelectedPermissions().length > 0
  }
}

export default Module
