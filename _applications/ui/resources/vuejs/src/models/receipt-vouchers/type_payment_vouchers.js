import Model from '@/core/model';
import ApiService from '@/core/api.service';

class TypePaymentVouchers extends Model {
    constructor(data) {
        super();

        this.id = null;
        this.type_code = null;
        this.type_name = null;
        this.is_business_result = null;
        this.is_active = null;
        this.note = null;
        this.created_at = null;
        this.updated_at = null;
        this.deleted_at = null;

        this.bind(data);
    }

    typeOfNumber() {
        return ['id', 'is_business_result', 'is_active'];
    }

    /**
     * { function_description }
     *
     * @return     {string}
     */
    apiGroup() {
        return 'receipt-vouchers';
    }
}

export default TypePaymentVouchers;
