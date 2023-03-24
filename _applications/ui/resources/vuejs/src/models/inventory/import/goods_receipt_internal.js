import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";

class GoodsReceiptInternal extends Model {
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
    this.borrow_id = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ["id", "goods_receipt_id", "borrow_id", "deleted_at"];
  }

  apiGroup() {
    return "inv-import-goods-receipt-details";
  }
}

export default GoodsReceiptInternal;
