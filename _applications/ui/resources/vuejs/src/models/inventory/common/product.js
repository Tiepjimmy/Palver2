import ApiService from "@/core/api.service";
import Model from "@/core/model";
import Collection from "@/core/collection";

class Product extends Model {
  /**
   * Product constructor
   * @param data
   */
  constructor(data) {
    super();

    this.id = null;
    this.store_id = null;
    this.product_entity_id = null;
    this.is_overwrite_prices = null;
    this.has_options = null;
    this.created_at = null;
    this.updated_at = null;
    this.deleted_at = null;
    this.sku = null;
    this.product_entity_avatar = null;
    this.minimum_inventory = null;
    this.product_id = null;
    this.is_show = null;

    this.bind(data);
  }

  typeOfNumber() {
    return [
      "id",
      "store_id",
      "product_entity_id",
      "is_overwrite_prices",
      "has_options",
      "minimum_inventory",
      "product_id",
      "is_show",
    ];
  }

  /**
   * Fetches a retail products by provider id and store id.
   *
   * @param      {<type>}   storeID     The store id
   * @param      {<type>}   providerID  The provider id
   * @return     {Promise}  The retail products by provider id and store id.
   */
  async fetchRetailProductsByProviderIDAndStoreID(storeID, providerID) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())["retail-products"], {
      store_id: storeID,
      provider_id: providerID,
    });

    return response.data;
  }

  apiGroup() {
    return "inv-common-products";
  }
}

export default Product;
