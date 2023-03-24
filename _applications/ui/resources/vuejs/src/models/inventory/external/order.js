import Model from "@/core/model";
import Collection from "@/core/collection";
import OrderOM from "@/models/order/order";

class Order extends OrderOM {
	apiGroup() {
		return "inv-order";
	}
}

export default Order;
