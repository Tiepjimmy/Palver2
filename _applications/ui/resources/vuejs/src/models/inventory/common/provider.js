import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";

class Provider extends Model {
  /**
   * Provider constructor
   * @param data
   */
  constructor(data) {
    super();

    this.id = null;
    this.province_id = null;
    this.district_id = null;
    this.ward_id = null;
    this.provider_cd = null;
    this.provider_name = null;
    this.email = null;
    this.phone = null;
    this.tax_cd = null;
    this.description = null;
    this.address = null;
    this.active_status = null;
    this.created_at = null;
    this.updated_at = null;
    this.deleted_at = null;

    this.bind(data);
  }

  typeOfNumber() {
    return ["id", "province_id", "district_id", "ward_id"];
  }

  apiGroup() {
    return "inv-common-providers";
  }
}

export default Provider;
