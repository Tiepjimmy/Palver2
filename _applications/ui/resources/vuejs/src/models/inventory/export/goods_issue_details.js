import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";

class GoodsIssueDetails extends Model {
  id;

  /**
   * Constructs a new instance.
   *
   * @param      {<type>}  data    The data
   */
  constructor(data) {
    super();

    this.id = null;
    this.goods_issue_id = null;
    this.lot_id = null;
    this.product_id = null;
    this.quantity = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ["id", "goods_issue_id", "lot_id", "product_id", "quantity"];
  }

  apiGroup() {
    return "inv-import-goods-issue-details";
  }
}

export default GoodsIssueDetails;
