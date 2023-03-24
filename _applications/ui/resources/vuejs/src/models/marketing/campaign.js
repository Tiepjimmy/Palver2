import Model from '@/core/model'
import Channel from "@/models/marketing/channel";
import SubChannel from "@/models/marketing/sub_channel";
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";
import PaymentAccount from "@/models/marketing/payment_account";
import User from "@/models/user/user";

class Campaign extends Model {
  /**
   * Campaign constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.title = null
    this.code = null
    this.advertisement_id = null
    this.channel_id = null
    this.channel = new Channel()
    this.sub_channel = new SubChannel()
    this.sub_channel_id = null
    this.product_catalog_id = null
    this.product_catalog = null
    this.link_token = null
    this.assigned_user_id = null
    this.user = null
    this.created_by = null
    this.updated_by = null
    this.payment_accounts = new Collection(PaymentAccount)
    this.estimated_amount = null
    this.estimated_revenue = null
    this.estimated_data = null
    this.actual_amount = null
    this.actual_data = null
    this.actual_revenue = null
    this.reference_source = null
    this.reference_source_files = []
    this.is_active = null
    this.start_at = null
    this.end_at = null
    this.created_at = null
    this.updated_at = null
    this.payment_account_ids = []
    this.user_assign = new User()

    this.bind(data)
  }

  typeOfNumber() {
    return [
      'id',
      'estimated_amount',
      'estimated_data',
      'estimated_revenue',
      'actual_amount',
      'actual_revenue',
      'actual_data'
    ]
  }

  apiGroup() {
    return 'campaign'
  }

  async getListBundle() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['list-bundle']);

    return response.data
  }
}


export default Campaign
