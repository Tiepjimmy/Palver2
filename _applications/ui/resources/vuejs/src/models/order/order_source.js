import Model from '@/core/model'

class OrderSource extends Model {
	/**
	 * Customer constructor
	 * @param data
	 */
	constructor(data) {
		super()

		this.id               = null
		this.u_id             = null
		this.provider         = null
		this.default_select   = null
		this.name             = null
		this.created_time     = null
		this.created_acc_id   = null
		
		
		
		this.bind(data)
	}
	
}

export default OrderSource
