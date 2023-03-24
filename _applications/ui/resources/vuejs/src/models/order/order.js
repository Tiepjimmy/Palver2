import Model from "@/core/model";
import Collection from "@/core/collection";
import OrderProduct from "@/models/order/order_product";
import OrderPayment from "@/models/order/order_payment";
import OrderNote from "@/models/order/order_note";
import ApiService from "@/core/api.service";
import Warehouse from "@/models/warehouse/warehouse";
import User from "@/models/user/user";
import Lead from "@/models/marketing/leads";
import OrderAddress from "@/models/order/order_address";
import ShippingDetail from "@/models/order/shipping_detail";
import OrderStatus from "@/models/order/order_status";

class Order extends Model {
	/**
	 * Order constructor
	 * @param data
	 */
	constructor(data) {
		super();
		this.id = null;
		this.store_id = null;
		this.lead_id = null;
		this.customer_id = null;
		this.customer_name = null;
		this.customer_mobile = null;
		this.customer_email = null;
		this.customer_group_id = null;
		this.code = null;
		this.order_status_id = null;
		this.shipping_status = null;
		this.sub_status_id = null;
		this.shipping_address_id = null;
		this.billing_address_id = null;
		this.product_catalog_id = null;
		this.sub_total = 0;
		this.grand_total = 0;
		this.discount_amount = 0;
		this.shipping_amount = 0;
		this.tax_amount = 0;
		this.created_by = null;
		this.updated_by = null;
		this.confirmed_user_id = null;
		this.assigned_user_d = null;
		this.delivered_user_id = null;
		this.created_at = null;
		this.updated_at = null;
		this.confirmed_at = null;
		this.delivered_at = null;
		this.type = null;
		this.source_id = null;
		this.source_name = null;
		this.payment_id = null;
		this.printed_at = null;
		this.approved_at = null;
		this.detail = false;
		this.upsale_user_id = null;
		this.warehouse_id = null;
		this.surcharge = 0;
		this.insurance = 0;
		this.payment = new OrderPayment();
		this.products = new Collection(OrderProduct);
		this.payments = new Collection(OrderPayment);
		this.notes = new Collection(OrderNote);
		this.user_created = new User();
		this.user_upsale = new User();
		this.user_approved = new User();
		this.order_address = new OrderAddress()
		this.shipping_detail = new ShippingDetail()
		this.order_status = new OrderStatus()
		this.lead = new Lead();
		this.user_created_lead_id = null;
		this.discount_type = null;
		this.customer_address_id = null;
		this.order_product_delete = null;

		this.bind(data);
	}

	typeOfNumber() {
		return ['id', 'shipping_address_id'];
	}

	apiGroup() {
		return "order";
	}

	#api = ApiService.routes(this.apiGroup());

	reduces(withNullable = true) {
		let data = super.reduces(withNullable);

		if (data.items instanceof Array) {
			data.items.forEach((item, index) => {
				if (typeof item.product_id === "undefined" || item.product_id <= 0) {
					data.items.splice(index, 1);
				}
			});
		}

		return data;
	}

	/**
	 * Call api duyệt đơn
	 *
	 * @param      Array      orderIDs  Danh sách ID đơn hàng
	 * @return     {Promise}
	 */
	async approveOrder(orderIDs) {
		return await ApiService.patchAsync(this.#api["bulk-approve"], { ids: orderIDs });
	}

	async unApproveOrder(orderId) {
		return await ApiService.patchAsync(ApiService.routes(this.apiGroup())['un-approve'].replace('{id}', orderId));
	}

	async getListProduct(params) {
		let response = await ApiService.getAsync(this.#api["list-product"], params);

		return response;
	}

	async listWarehouse() {
		let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['list-warehouse']);

		return response;
	}

	async checkout(id, params) {
		let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['checkout'] + `/${id}/checkout`, params);

		return response;
	}

	async cancelOrder(id, params) {
		let response = await ApiService.patch(ApiService.routes(this.apiGroup())['cancel'].replace('{id}', id), params);

		return response;
	}

	async shippingOrder(params) {
		let response = await ApiService.patch(ApiService.routes(this.apiGroup())['shipping'], params);

		return response;
	}

	async shippingSuccess(id) {
		let response = await ApiService.patch(ApiService.routes(this.apiGroup())['shipping-success'].replace('{id}', id));

		return response;
	}

	async refund(id) {
		let response = await ApiService.patch(ApiService.routes(this.apiGroup())['refund'].replace('{id}', id));

		return response;
	}

}

export default Order;
