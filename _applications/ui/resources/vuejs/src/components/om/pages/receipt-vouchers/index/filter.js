import Filter from '@/components/om/base_filter';

/**
 * This class describes an order status filter.
 *
 * @class      OrderStatusFilter (name)
 */
export default class FormFilter extends Filter {
    page = 1;
    /**
     * Constructs a new instance.
     *
     * @param      {<type>}  data             The data
     * @param      {<type>}  ignoreCheckType  The ignore check type
     */
    constructor(data, ignoreCheckType) {
        super(data, ignoreCheckType);
        this.keyword = null;
        this.is_active = null;
        this.created_date = null;
        this.updated_date = null;
        this.bind(data);
    }
}
