import Filter from "@/core/filter";

/**
 * This class describes an order status filter.
 *
 * @class      OrderStatusFilter (name)
 */
export default class BaseFilter extends Filter {
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
        this.expired_date = null;
        this.expired_date_from = null;
        this.expired_date_to = null;

        this.created_at = null;
        this.created_at_from = null;
        this.created_at_to = null;

        this.warehouses = null;
        this.types = null;
        this.created_by = null;
        this.stores = null;

        this.bind(data);
    }
}
