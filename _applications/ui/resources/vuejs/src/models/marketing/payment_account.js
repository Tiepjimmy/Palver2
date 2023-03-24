import Model from '@/core/model'
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";
import User from "@/models/user/user";

class PaymentAccount extends Model {
  /**
   * PaymentAccount constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.bank_name = null
    this.card_type = null
    this.card_number = null
    this.account_number = null
    this.card_owner = null
    this.is_active = null
    this.created_by = null
    this.updated_by = null
    this.user_modifield_id = null
    this.user_modifield = null
    this.created_at = null
    this.updated_at = null
    this.user_assign_ids = []
    this.users = new Collection(User)

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'payment-account'
  }

  async getAllPaymentAccount() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['get-all']);

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }
}


export default PaymentAccount
