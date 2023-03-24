/**
 * Param class definition
 */

import stdClass from './stdClass';

/**
 * Params constructor
 */
class Filter extends stdClass {
	p = 1
	c
	s

	constructor(data, ignoreCheckType = ['mobile', 'phone', 'p', 'number']) {
		super();
		this.id = null
		this.keyword = null
		this.page = null
		this.per_page = null
		this.keyword = null
		this.limit = null
		this.offset = null
		this.name = null
		this.code = null
		this.is_active = null
		this.channel_id = null
		this.user_name = null
		this.card_owner = null
		this.account_number = null
		this.bank_name = null
		this.sub_channel_id = null
		this.bundle_id = null
		this.product_catalog_id = null
		this.title = null
		this.time_start = null
		this.time_end = null
		this.time_type = null
		this.user_id = null
		this.is_duplicated = null
		this.type = null
		this.status = null
		this.status_ids = []
		this.mobile = null
		this.assign = null
		this.task_id = null
		this.created_by = null
		this.created_at = null
		this.approved_at = null
		this.delivered_at = null
		this.confirmed_at = null
		this.update_success_at = null
		this.paid_at = null
		this.lading_code = null
		this.order_status_id = null
		this.approved = null
		this.not_approved = null
		this.shipping = null

		if (data instanceof Object) {
			const pattern = /^[\d]+$/
			for(let i in data) {
				if( ignoreCheckType instanceof Array )
				{
					if ( ignoreCheckType.includes(i) ) {
						continue
					}
				}
				if (pattern.test(data[i])) {
					data[i] = Number(data[i])
				}
			}
		}

		this.bind(data);
	}


	typeOfNumber() {
		return ['p', 'c'];
	}

	bind(data, clone = false) {
		if (data != null) {
			try {
				for (let i in data) {
					const p = i.replace(/^\w/, c => c.toLowerCase());
					let _data = !clone ? data[i] : _.cloneDeep(data[i]);

					if (this[p] instanceof Array) {
						if (this[p].name === 'Collection') {
							this[p].addRange(_data);
						} else {
							this[p] = _data || [];
						}
					} else {
						if (~this.typeOfNumber().indexOf(p)) {
							_data = data[i] !== null ? Number(_data) : 0;
						}
						this[p] = _data;
					}
				}
			} catch (e) {
				console.log(e)
			}
		}

		return this;
	}

	reduces(withNullable = false) {
		return super.reduces(withNullable);
	}

	setPage(page) {
		this.p = page || 1
	}

	setCount(number) {
		this.c = number || 10
	}
}

export default Filter
