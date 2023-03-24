import Model from '@/core/model';

/**
 * OrderProduct constructor
 */
class OrderProduct extends Model {
  constructor(data) {
    super()

    this.id = null
    this.store_id = null
    this.order_id = null
    this.product_id = null
    this.product_name = null
    this.product_code = null
    this.product_sku = null
    this.product_price = 0
    this.product_base_price = null
    this.product_unit_id = null
    this.discount_amount = 0
    this.quantity = 1
    this.discount_item = 0
    this.discount_type = null
    this.sub_total = 0
    this.total = 0
    this.created_at = null
    this.updated_at = null
    this.product_unit = null
    this.lot_id = null
    this.maxDiscount = 0

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'order_product'
  }
}

export default OrderProduct
