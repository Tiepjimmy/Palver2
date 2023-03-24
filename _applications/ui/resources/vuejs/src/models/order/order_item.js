/**
 * OderItem class definition
 */

import Model from '@/core/model';

/**
 * OderItem constructor
 */
class OderItem extends Model {
	constructor(data) {
		super()

		this.id             	= null
		this.u_id           	= null
		this.customer_id    	= null
		this.product_id     	= null
		this.product_name   	= null
		this.price          	= null
		this.qty            	= 1
		this.discount_amount 	= 0
		this.maxDiscountItem  = 0
		this.product_price  	= null
		this.quantity       	= null
		this.total_price    	= null
    this.new_total_price  = 0

		this.bind(data)
	}

	typeOfNumber() {
		return ['id']
	}

	apiGroup() {
		return 'order_item'
	}
}

export default OderItem
