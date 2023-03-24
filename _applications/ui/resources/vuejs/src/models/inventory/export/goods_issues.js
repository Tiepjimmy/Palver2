import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";
import GoodsIssueDetails from "./goods_issue_details";
import GoodsIssueSells from "./goods_issue_sells";
import GoodsIssueStatus from "./goods_issue_status";
import GoodsIssueInternal from "./goods_issue_internal";
import Store from "@/models/stores/stores";
import Warehouse from "@/models/warehouse/warehouse";

class GoodsIssues extends Model {
  id;

  /**
   * Constructs a new instance.
   *
   * @param      {<type>}  data    The data
   */
  constructor(data) {
    super();

    this.id = null;
    this.store_id = null;
    this.warehouse_id = null;
    this.code = null;
    this.type = null;
    this.status = null;
    this.note = null;
    this.created_by = null;
    this.updated_by = null;
    this.created_at = null;
    this.updated_at = null;
    this.deleted_at = null;
    this.details = new Collection(GoodsIssueDetails);
    this.sell = new GoodsIssueSells();
    this.statuses = new Collection(GoodsIssueStatus);
    this.internal = new GoodsIssueInternal();
    this.store = new Store();
    this.warehouse = new Warehouse();
    this.bind(data);
  }

  typeOfNumber() {
    return ["id", "store_id", "warehouse_id", "status", "created_by", "updated_by"];
  }

  /**
   * { function_description }
   *
   * @return     {Object}  { description_of_the_return_value }
   */
  STATUSES_CONST() {
    return { WAITING: 10, RESOLVED: 20, REJECTED: 30, EXPORTED: 40, PACKED: 50, CANCELED: 60 };
  }

  /**
   * { function_description }
   *
   * @return     {Object}  { description_of_the_return_value }
   */
  statusNames() {
    return {
      [this.STATUSES_CONST().WAITING]: "Chờ duyệt",
      [this.STATUSES_CONST().RESOLVED]: "Đã duyệt",
      [this.STATUSES_CONST().REJECTED]: "Từ chối",
      [this.STATUSES_CONST().EXPORTED]: "Xuất kho",
      [this.STATUSES_CONST().PACKED]: "Đóng hàng",
      [this.STATUSES_CONST().CANCELED]: "Hủy",
    };
  }

  /**
   * { function_description }
   *
   * @param      {<type>}  [status=null]  The status
   * @return     {<type>}  { description_of_the_return_value }
   */
  statusName(status = null) {
    return this.statusNames()[status || this.status];
  }

  /**
   * { function_description }
   *
   * @return     {Object}  { description_of_the_return_value }
   */
  types() {
    return { SELL: "sell", INTERNAL: "internal", CANCEL: "cancel", BALANCE: "balance" };
  }

  /**
   * { function_description }
   *
   * @param      {<type>}  [type=null]  The type
   * @return     {Object}  { description_of_the_return_value }
   */
  typeNames() {
    return {
      [this.types().SELL]: "Xuất bán",
      [this.types().INTERNAL]: "Xuất nội bộ",
      [this.types().CANCEL]: "Xuất hủy",
      [this.types().BALANCE]: "Xuất cân bằng",
    };
  }

  /**
   * { function_description }
   *
   * @param      {<type>}  [type=null]  The type
   * @return     {<type>}  { description_of_the_return_value }
   */
  typeName(type = null) {
    return this.typeNames()[type || this.type];
  }

  /**
   * Determines if waiting.
   *
   * @return     {boolean}  True if waiting, False otherwise.
   */
  isWaiting() {
    return this.status === this.STATUSES_CONST().WAITING;
  }

  /**
   * Determines if resolved.
   *
   * @return     {boolean}  True if resolved, False otherwise.
   */
  isResolved() {
    return this.status === this.STATUSES_CONST().RESOLVED;
  }

  /**
   * Determines if rejected.
   *
   * @return     {boolean}  True if rejected, False otherwise.
   */
  isRejected() {
    return this.status === this.STATUSES_CONST().REJECTED;
  }

  /**
   * Determines if exported.
   *
   * @return     {boolean}  True if exported, False otherwise.
   */
  isExported() {
    return this.status === this.STATUSES_CONST().EXPORTED;
  }

  /**
   * Determines if packed.
   *
   * @return     {boolean}  True if packed, False otherwise.
   */
  isPacked() {
    return this.status === this.STATUSES_CONST().PACKED;
  }

  /**
   * Determines if canceled.
   *
   * @return     {boolean}  True if canceled, False otherwise.
   */
  isCanceled() {
    return this.status === this.STATUSES_CONST().CANCELED;
  }

  /**
   * Cập nhật trạng thái cho các mã phiếu
   *
   * @param      {<type>}  params  The parameters
   * @return     {<type>}  { description_of_the_return_value }
   */
  updateStatuses(params) {
    return ApiService.patch(this.URL("statuses"), params);
  }

  /**
   * { function_description }
   *
   * @return     {string}  { description_of_the_return_value }
   */
  apiGroup() {
    return "inv-import-goods-issues";
  }
}

export default GoodsIssues;
