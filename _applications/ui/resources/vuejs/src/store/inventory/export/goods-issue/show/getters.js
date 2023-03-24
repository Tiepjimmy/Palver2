import * as getters from './getter-const';

export default {
    /**
     * Gets the model.
     *
     * @class      GET_MODEL (name)
     * @param      {<type>}  state   The state
     * @return     {<type>}  The model.
     */
    [getters.GET_MODEL]: state => state.get_model,

    /**
     * Gets the model sell.
     *
     * @class      GET_MODEL_SELL (name)
     * @param      {<type>}  state   The state
     * @return     {<type>}  The model sell.
     */
    [getters.GET_MODEL_SELL]: state => state.get_model_sell,

    /**
     * Gets the model internal.
     *
     * @class      GET_MODEL_INTERNAL (name)
     * @param      {<type>}  state   The state
     * @return     {<type>}  The model internal.
     */
    [getters.GET_MODEL_INTERNAL]: state => state.get_model_internal,
};
