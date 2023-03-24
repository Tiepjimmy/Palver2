import Model from '@/core/model'
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

class PaymentVoucher extends Model {
  /**
   * PaymentVoucher constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.store_id = null
    this.note = null
    this.created_by = null
    this.updated_by = null
    this.created_at = 
    this.updated_at = null
    this.typePaymentVoucher = { id: null, type_name: null }
    this.customer = { id: null, name: null }
    this.customerGroup = { id: null, name: null }
    this.voucher_code = null
    this.amount = null;
    this.is_active = null;
    this.description = null;
    this.confirmed_at = null;
    this.type_voucher = null;
    this.type_payment_voucher_id = null;
    this.customer_group_id = null;
    this.customer_id = null;
    this.is_business_result = null;
    this.orderPaymentVoucher = null;
    this.order = [];

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'payment-voucher'
  }

  async changeStatus(id) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['change-status'] + `/${id}`);

    return response.data;
  }

  async createData() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['create']);

    return response.data;
  }
}


export default PaymentVoucher