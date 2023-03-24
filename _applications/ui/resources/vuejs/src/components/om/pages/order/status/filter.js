import Filter from '@/core/filter';

/**
 * This class describes an order status filter.
 *
 * @class      OrderStatusFilter (name)
 */
export class OrderStatusFilter extends Filter {
    /**
     * Constructs a new instance.
     *
     * @param      {<type>}  data             The data
     * @param      {<type>}  ignoreCheckType  The ignore check type
     */
    constructor(data, ignoreCheckType) {
        super(data, ignoreCheckType);
        this.keyword = '';
        this.type = 0;
        this.level = 0;
        this.bind(data);
    }
}
