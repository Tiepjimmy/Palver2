import Model from '@/core/model'

class OrderCancelReason extends Model {
  /**
   * OrderCancelReason constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.store_id = null
    this.code = null
    this.content = null
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
    return 'order-cancel-reason'
  }

}

export default OrderCancelReason