import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";
import GoodsReceiptsDetail from "./goods_receipt_details";
import GoodsReceiptStatus from "./goods_receipt_status";
import GoodsReceiptInternal from "./goods_receipt_internal";
import Store from "@/models/inventory/external/store";
import Warehouse from "@/models/inventory/external/warehouse";
import Provider from "@/models/inventory/external/provider";

class GoodsReceipts extends Model {
  id;

  /**
   * Constructs a new instance.
   *
   * @param      {<type>}  data    The data
   */
  constructor(data) {
    super();

    this.id = null;
    this.provider_id = null;
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
    this.details = new Collection(GoodsReceiptsDetail);
    this.statuses = new Collection(GoodsReceiptStatus);
    this.internal = new GoodsReceiptInternal();
    this.store = new Store();
    this.warehouse = new Warehouse();
    this.provider = new Provider();
    this.bind(data);
  }

  /**
   * { function_description }
   *
   * @return     {Object}  { description_of_the_return_value }
   */
  STATUSES_CONST() {
    return { WAITING: 10, RESOLVED: 20, REJECTED: 30, IMPORTED: 40, CANCELED: 50 };
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
      [this.STATUSES_CONST().IMPORTED]: "Đã nhập kho",
      [this.STATUSES_CONST().CANCELED]: "Hủy phiếu",
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
    return { BUY: "buy", INTERNAL: "internal", DONATE: "donate", BALANCE: "balance" };
  }

  /**
   * { function_description }
   *
   * @param      {<type>}  [type=null]  The type
   * @return     {Object}  { description_of_the_return_value }
   */
  typeNames() {
    return {
      [this.types().BUY]: "Nhập mua",
      [this.types().INTERNAL]: "Nhập nội bộ",
      [this.types().DONATE]: "Nhập tặng",
      [this.types().BALANCE]: "Nhập cân bằng",
    };
  }

  /**
   * { function_description }
   *
   * @param      {<type>}  [status=null]  The status
   * @return     {<type>}  { description_of_the_return_value }
   */
  typeName(type = null) {
    return this.typeNames()[type || this.type];
  }

  typeOfNumber() {
    return ["id", "provider_id", "store_id", "warehouse_id", "status", "created_by", "updated_by"];
  }

  apiGroup() {
    return "inv-import-goods-receipts";
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
   * Determines if imported.
   *
   * @return     {boolean}  True if imported, False otherwise.
   */
  isImported() {
    return this.status === this.STATUSES_CONST().IMPORTED;
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
}

export default GoodsReceipts;
