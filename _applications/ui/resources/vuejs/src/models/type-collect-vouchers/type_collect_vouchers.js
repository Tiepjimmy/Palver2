import Model from '@/core/model';
import ApiService from '@/core/api.service';

class TypeCollectVouchers extends Model {
  constructor(data) {
    super();

    this.id = null;
    this.type_code = null;
    this.type_name = null;
    this.is_active = null;
    this.is_business_result = null;
    this.note = null;
    this.created_at = null;
    this.updated_at = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ['id', 'is_active', 'is_business_result'];
  }

  /**
   * { function_description }
   *
   * @return     {string}  { description_of_the_return_value }
   */
  apiGroup() {
    return 'type-collect-vouchers';
  }
}

export default TypeCollectVouchers;
