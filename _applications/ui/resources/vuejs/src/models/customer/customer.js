import Model from '@/core/model';

class Customer extends Model {
  /**
   * Customer constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.store_id = null
    this.created_store_id = null
    this.name = null
    this.mobile = null
    this.email = null
    this.customer_group_id = null
    this.code = null
    this.gender = null
    this.facebook = null
    this.zone_id = null
    this.address = null
    this.type = null
    this.source_id = null
    this.organization_name = null
    this.organization_information = null
    this.bank_name = null
    this.bank_account_name = null
    this.bank_account_number = null
    this.imported_account_id = null
    this.imported_code = null
    this.total_revenue = null
    this.image_url = null
    this.assigned_user_id = null
    this.inviter_id = null
    this.contact_id = null
    this.created_by = null
    this.updated_by = null
    this.birth_date = null
    this.imported_at = null
    this.created_at = null
    this.updated_at = null
    this.deleted_at = null
    this.channel_id = null
    this.sub_channel_id = null
    this.district_id = null
    this.province_id = null
    this.ward_id = null
    this.extra_mobile = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'customer'
  }
}

export default Customer
