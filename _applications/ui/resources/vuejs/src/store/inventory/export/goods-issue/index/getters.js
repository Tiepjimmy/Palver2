import * as getters from './getter-const';

export default {
    /**
     * { lambda_description }
     *
     * @class      GET_FILTER (name)
     * @param      {<type>}  state   The state
     * @return     {<type>}  { description_of_the_return_value }
     */
    [getters.GET_FILTER]: state => state.filter,

    /**
     * Gets the invoices.
     *
     * @class      GET_INVOICES (name)
     * @param      {<type>}  state   The state
     * @return     {<type>}  The invoices.
     */
    [getters.GET_INVOICES]: state => status => state.invoices[status],
};
