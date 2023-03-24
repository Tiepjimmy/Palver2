import Model from '@/core/model';
import User from "@/models/user/user";
import Collection from "@/core/collection";

class UserGroup extends Model {
  /**
   * UserGroup constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.group_id = null
    this.provider = null
    this.name = null
    this.leader_user_id = null
    this.created_at = null
    this.updated_at = null
    this.user_leader = new User()
    this.user_created = new User()
    this.user_updated = new User()
    this.users = new Collection(User)
    this.users_count = null
    this.created_user_id = null
    this.updated_user_id = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'user-group'
  }
}

export default UserGroup
