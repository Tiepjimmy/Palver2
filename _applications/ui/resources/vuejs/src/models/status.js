import Model from '@/core/model'

class Status extends Model {
  /**
   * Status constructor
   * @param data
   */
  constructor(data) {
    super()

    this.id = null
    this.u_id = null
    this.name = null
    this.code = null
    this.color = null
    this.is_active = null
    this.permission_id = null
    this.selected = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'status'
  }
}


export default Status
