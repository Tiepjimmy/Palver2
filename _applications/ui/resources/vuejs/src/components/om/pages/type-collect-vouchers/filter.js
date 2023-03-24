import Filter from "@/components/om/base_filter";

/**
 * This class describes an order status filter.
 *
 * @class      OrderStatusFilter (name)
 */
export class FormFilter extends Filter {
    /**
     * Constructs a new instance.
     *
     * @param      {<type>}  data             The data
     * @param      {<type>}  ignoreCheckType  The ignore check type
     */
    constructor(data, ignoreCheckType) {
        super(data, ignoreCheckType);

        this.bind(data);
    }
}
