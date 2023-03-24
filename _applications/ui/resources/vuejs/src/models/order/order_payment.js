import Model from '@/core/model';
import User from "@/models/user/user";
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

/**
 * OrderPayment constructor
 */
class OrderPayment extends Model {
  constructor(data) {
    super()

    this.id = null
    this.store_id = null
    this.order_id = null
    this.invoice_id = null
    this.payment_method_id = null
    this.payment_amount = 0
    this.note = null
    this.remain = 0
    this.created_by = null
    this.confirmed_by = null
    this.user_created = new User()
    this.user_confirmed = new User()
    this.payment_method = null
    this.receipt_detail = null
    this.updated_by = null
    this.payment_at = null
    this.created_at = null
    this.updated_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'order-payment'
  }

  async confirmPayment(id) {
    return await ApiService.post(ApiService.routes(this.apiGroup())['confirm-payment'].replace('{id}', id),);
  }

  async confirmMutilPayment(params) {
    return await ApiService.post(ApiService.routes(this.apiGroup())['confirm-multi-payment'], params);
  }

  async cancelConfirmPayment(params, id) {
    return await ApiService.delete(ApiService.routes(this.apiGroup())['reject-payment'].replace('{id}', id), params);
  }

  async getListPaymentByOrder(orderId) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['list-payment-by-order'].replace('{id}', orderId));

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }
}

export default OrderPayment
