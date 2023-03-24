import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";

class GoodsReceiptDetails extends Model {
  id;

  /**
   * Constructs a new instance.
   *
   * @param      {<type>}  data    The data
   */
  constructor(data) {
    super();

    this.id = null;
    this.goods_receipt_id = null;
    this.lot_id = null;
    this.product_id = null;
    this.price = null;
    this.quantity = null;
    this.storage_location = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ["id", "goods_receipt_id", "lot_id", "product_id", "price", "quantity"];
  }

  apiGroup() {
    return "inv-import-goods-receipt-details";
  }
}

export default GoodsReceiptDetails;
