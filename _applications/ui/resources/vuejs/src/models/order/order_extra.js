import Model from '@/core/model'

class OrderExtra extends Model {
	/**
	 * Module constructor
	 * @param data
	 */
	constructor(data) {
		super()
		
		this.id = null;
		this.name = null;
		this.order_id = null;
		this.update_successed_user = null;
		this.update_successed_time = null;
		this.update_returned_time = null;
		this.update_paid_time = null;
		this.update_returned_to_warehouse_time = null;
		
		this.bind(data)
	}
	
	typeOfNumber() {
		return ['id']
	}
	
	apiGroup() {
		return 'order_extra'
	}
	
	/**
	 * @public
	 * @param params
	 * @param callback
	 * @returns {*}
	 */

}

export default OrderExtra
