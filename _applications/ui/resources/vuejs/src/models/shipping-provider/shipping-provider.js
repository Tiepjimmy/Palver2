import Model from '@/core/model'

class ShippingProvider extends Model {
  /**
   * ShippingProvider constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.store_id = null
    this.account_name = null
    this.verify_id = null
    this.verify_secret = null
    this.options = null
    this.shop_name = null
    this.prefix = null
    this.shipping_provider_id = null
    this.is_default = null
    this.is_active = null
    this.created_by = null
    this.updated_by = null
    this.created_at = null
    this.updated_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'shipping-provider'
  }

}

export default ShippingProvider