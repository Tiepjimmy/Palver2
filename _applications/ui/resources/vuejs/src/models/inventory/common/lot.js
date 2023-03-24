import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";

class Lot extends Model {
  /**
   * Lot constructor
   * @param data
   */
  constructor(data) {
    super();

    this.id = null;
    this.code = null;
    this.status = null;
    this.note = null;
    this.expired_date = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ["id"];
  }

  apiGroup() {
    return "inv-common-lots";
  }

  /**
   * { function_description }
   *
   * @return     {Array}  { description_of_the_return_value }
   */
  static statuses() {
    return { active: "Hoạt động", inactive: "Không hoạt động" };
  }

  /**
   * { function_description }
   *
   * @return     {<type>}  { description_of_the_return_value }
   */
  statusName() {
    return this.constructor.statuses()[this.status];
  }

  /**
   * Fetches a list.
   *
   * @param      {<type>}    params    The parameters
   * @param      {Function}  callback  The callback
   * @return     {Promise}   The list.
   */
  async fetchList(params, callback) {
    return await ApiService.getAsync(this.URL("list"), params);
  }
}

export default Lot;
