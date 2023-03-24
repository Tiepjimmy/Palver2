import Model from '@/core/model'
import Provinces from "@/models/master/provinces/provinces";
import Districts from "@/models/master/districts/districts";
import Wards from "@/models/master/wards/wards";

class CustomerAddress extends Model {
  /**
   * CustomerAddress constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.store_id = null
    this.customer_id = null
    this.mobile = null
    this.email = null
    this.country_id = null
    this.province_id = null
    this.province = new Provinces()
    this.district_id = null
    this.district = new Districts()
    this.ward_id = null
    this.ward = new Wards()
    this.address = null
    this.is_default = null
    this.created_by = null
    this.updated_by = null
    this.created_at = null
    this.updated_at = null
    this.deleted_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'customer-address'
  }
}


export default CustomerAddress
