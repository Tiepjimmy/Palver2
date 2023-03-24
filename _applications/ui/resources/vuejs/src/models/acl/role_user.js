import Model from '@/core/model'
import Collection from "@/core/collection";
import Role from "./role";

class RoleUser extends Model {
  /**
   * RoleUser constructor
   * @param data
   */
  constructor(data) {
    super()
    this.username = null;
    this.full_name = null;
    this.roleIds = [];
    this.listRole = '';
    this.roles = new Collection(Role);
    this.userRole = [];

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'role_user'
  }
}

export default RoleUser
