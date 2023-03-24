import Model from '@/core/model'

class PermissionData extends Model {
  /**
   * PermissionData constructor
   * @param data
   */
  constructor(data) {
    super()

    this.id = null
    this.role_id = null
    this.permission_id = []
    this.entity = null
    this.column = null
    this.value_type = null
    this.value = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'permission'
  }
}

export default PermissionData
