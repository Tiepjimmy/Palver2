import Model from '@/core/model';

/**
 * OrderNote constructor
 */
class OrderNote extends Model {
  constructor(data) {
    super()

    this.id = null
    this.store_id = null
    this.order_id = null
    this.customer_id = null
    this.type = null
    this.note = null
    this.created_by = null
    this.updated_by = null
    this.payment_at = null
    this.created_at = null
    this.updated_at = null
    this.updated_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'order_note'
  }
}

export default OrderNote
