import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Collection from '@/core/collection'

class User extends Model {
  id
  group_id
  name = 'Nguyen Van A'

  /**
   * User constructor
   * @param data
   */
  constructor (data) {
    super()

    this.id = null
    this.u_id = null
    this.provider = null
    this.group_id = null
    this.full_name = null
    this.name = null
    this.phone = null
    this.mobile = null
    this.address = null
    this.weight = null
    this.extension = null
    this.shop_name = null
    this.status = null
    this.is_active = null
    this.image_url = null
    this.user_group = null
    this.statuses = []
    this.username = null
    this.selected = false
    this.user_group_id = null
    this.subUsers = []
    this.group = null
    this.zone_id = null
    this.zone_name = null
    this.acl = new Collection(Object)
    this.is_owner = false
    this.is_admin = false
    this.roles = new Collection(Object)
    this.sub_system = null
    this.store = null
    this.current_info = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id', 'is_admin', 'is_active']
  }

  apiGroup () {
    return 'user'
  }

  getAvatar() {
    return this.image_url || `${window.location.origin}/images/avt.jpg`;
  }

  /**
   * @public
   * @returns {*}
   */
  async profile() {
    return ApiService.get(ApiService.routes(this.apiGroup())['profile']).then(response => {
      this.bind(response.data);
      return this;
    });
  }

  canAccess(to) {
    let hasAccessPermission = false

    if (typeof to.meta !== 'undefined') {
      if (to.meta.permissions === '*') {
        hasAccessPermission = true
      } else if(to.meta.permissions instanceof Array) {
        let permission = this.acl.find(i => to.meta.permissions.includes(i.permission))
        hasAccessPermission = permission != null
      }
    }

    return hasAccessPermission
  }

  hasPermission(permission) {
    if (permission === '*') {
      return true
    }

    if (permission instanceof Array) {
      return this.acl.find(i => permission.includes(i.permission))
    }

    return this.acl.find(i => i.permission === permission) != null
  }

  isAdmin() {
    return this.is_admin === 1
  }

  hasAdminRole() {
    return this.roles.filter(i => i.key_name === 'admin').length > 0
  }

  async getListUser(keyword, limit, offset) {
    return ApiService.get(ApiService.routes(this.apiGroup())['list'] + `?keyword=${keyword}&limit=${limit}&offset=${offset}`)
      .then(response => {
        return response;
      })
      .catch(error => {
        return error;
      });
  }

  async getCreateInfo() {
    return ApiService.get(ApiService.routes(this.apiGroup())['create']).then(response => {
      this.bind(response.data);
      return this;
    });
  }

  async storeNewUser(data = null) {
    return ApiService.post(ApiService.routes(this.apiGroup())['store'], data || this.reduces()).then(response => {
      return response;
    });
  }

  async updateUser(userId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['update'] + `/${userId}`, data).then(response => {
      return response;
    });
  }

  async updateStatus(userId, data) {
    return ApiService.patch(ApiService.routes(this.apiGroup())['update-status'] + `/${userId}`, data).then(response => {
      return response;
    });
  }

  async getCurrentUser(userId) {
    return ApiService.get(ApiService.routes(this.apiGroup())['show'] + `/${userId}`).then(response => {
      this.current_info = response.data;
      return this;
    });
  }
}

export default User
