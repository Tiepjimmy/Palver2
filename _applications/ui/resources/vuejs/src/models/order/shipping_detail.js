import Model from '@/core/model'
import Provinces from "@/models/master/provinces/provinces";
import Districts from "@/models/master/districts/districts";
import Wards from "@/models/master/wards/wards";

class ShippingDetail extends Model {
  /**
   * ShippingDetail constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null,
    this.store_id = null,
    this.order_id = null,
    this.shipping_status_id = null,
    this.warehouse_id = null,
    this.bill_of_lading_code = null,
    this.shipping_type = null,
    this.shipping_provider_account_id = null,
    this.shipping_partner_id = null,
    this.shipping_provider_id = null,
    this.created_by = null,
    this.updated_by = null,
    this.delivering_at = null,
    this.created_at = null,
    this.updated_at = null,
    this.deleted_at = null,

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'shipping-detail'
  }
}

export default ShippingDetail
