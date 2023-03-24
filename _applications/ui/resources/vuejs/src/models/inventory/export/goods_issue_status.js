import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";

class GoodsIssueStatus extends Model {
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
    this.status = null;
    this.user_id = null;
    this.created_date = null;
    this.created_at = null;
    this.deleted_at = null;
    this.note = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ["id", "goods_issue_id", "status", "user_id"];
  }

  apiGroup() {
    return "inv-import-goods-issue-details";
  }
}

export default GoodsIssueStatus;
