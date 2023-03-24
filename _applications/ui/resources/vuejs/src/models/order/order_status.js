import Model from "@/core/model";
import ApiService from "@/core/api.service";
import Collection from "@/core/collection";

/**
 * OrderStatus constructor
 */
class OrderStatus extends Model {
  constructor(data) {
    super();

    this.id = null;
    this.store_id = null;
    this.name = null;
    this.code = null;
    this.color = null;
    this.description = null;
    this.level = null;
    this.type = null;
    this.action_name = null;
    this.is_no_revenue = null;
    this.is_system = null;
    this.is_active = null;
    this.created_by = null;
    this.updated_by = null;
    this.created_at = null;
    this.updated_at = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ["id", "store_id", "created_by", "updated_by", "is_no_revenue", "is_system", "is_active", "level", "type"];
  }

  apiGroup() {
    return "order-status";
  }

  /**
   * { function_description }
   *
   * @return     {Object}  { description_of_the_return_value }
   */
  types() {
    return {
      1: {
        name: "Đơn hàng có sẵn",
        levels: { 3: 3, 4: 4, 5: 5, 6: 6, 7: 7 },
      },
      2: {
        name: "Đơn hàng đặt trước",
        levels: { 1: 1, 2: 2 },
      },
      3: {
        name: "Đơn hàng hoàn",
        levels: { 1: 1, 2: 2 },
      },
    };
  }

  /**
   * { function_description }
   *
   * @return     {<type>}  { description_of_the_return_value }
   */
  typeName() {
    return this.types()[this.type]?.name;
  }

  /**
   * { function_description }
   *
   * @return     {<type>}  { description_of_the_return_value }
   */
  levelName() {
    return this.types()[this.type]?.levels[this.level];
  }

  async getSubStatusOrder(id) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['sub-status'].replace('{id}', id));

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }
}

export default OrderStatus;
