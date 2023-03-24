import Model from '@/core/model'
import Collection from "@/core/collection";
import Module from "./module";
import Permission from './permission'
import PermissionData from './permission_data'

class Role extends Model {
  /**
   * Role constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.name = null
    this.note = null
    this.group_id = null
    this.status = null
    this.key_name = null
    this.type = null
    this.permissions = new Collection(Permission)
    this.dataPermissions = new Collection(PermissionData)
    this.modules = new Collection(Module)
    this.permissionIds = []

    this.bind(data)
  }

  bind(data, clone = false) {
    super.bind(data, clone);
    if (this.permissions.any()) {
      this.permissionIds.push(...this.permissions.pluck('id'))
    }
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'role'
  }

  reduces(withNullable = true) {
    this.dataPermissions = this.dataPermissions.reduces(false)
    const data = super.reduces(withNullable)
    delete data['permissions']
    return data
  }

  setPermissionData(permissionData = new PermissionData()) {
    let item = this.dataPermissions.find(i =>
      i.entity === permissionData.entity && i.column === permissionData.column && i.value == permissionData.value)

    if (item == null) {
      if (permissionData.permission_id.length > 0) {
        this.dataPermissions.add(permissionData)
      }

      return
    }

    if (permissionData.permission_id.length === 0) {
      this.dataPermissions.remove(item)
    }

    item.permission_id = permissionData.permission_id
  }

  isSystem() {
    return this.type === 1
  }
}

export default Role
