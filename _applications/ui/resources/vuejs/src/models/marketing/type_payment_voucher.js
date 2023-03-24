import Model from '@/core/model'
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

class TypePaymentVoucher extends Model {
  /**
   * PaymentVoucher constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.is_business_result = null
    this.is_active = null
    this.type_name = ''
    this.type_code = ''
    this.note = ''
    this.created_at = null

    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'type-payment-voucher'
  }
}


export default TypePaymentVoucher
