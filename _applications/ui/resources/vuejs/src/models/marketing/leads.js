import Model from '@/core/model'
import ApiService from "@/core/api.service";
import Channel from "@/models/marketing/channel";
import SubChannel from "@/models/marketing/sub_channel";
import Task from "@/models/mission/task";
import Script from "@/models/mission/script";

class Lead extends Model {
  /**
   * Lead constructor
   * @param data
   */
  constructor(data) {
    super()
    this.id = null
    this.name = null
    this.mobile = null
    this.customer_id = null
    this.email = null
    this.gender = null
    this.lead_status_id = null
    this.note = null
    this.is_duplicated = null
    this.channel_id = null
    this.channel = new Channel()
    this.sub_channel_id = null
    this.sub_channel = new SubChannel()
    this.product_catalog_id = null
    this.bundle = null
    this.user_marketing_id = null
    this.user_sale_id = null
    this.url = null
    this.type = null
    this.mission_id = null
    this.task = new Task()
    this.last_supported_at = null
    this.mission_script_id = null
    this.script = new Script()
    this.assigned_at = null
    this.assigned_user_id = null
    this.user_assigned = null
    this.created_by = null
    this.updated_by = null
    this.user_created = null
    this.assigned_group_id = null
    this.seller_id = null
    this.created_at = null
    this.code = null
    this.description = null
    this.log = false
    this.result_id = null


    this.bind(data)
  }

  typeOfNumber() {
    return ['id']
  }

  apiGroup() {
    return 'lead'
  }

  async settingMarketingUserAssign(params) {
    let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['setting-user-assign'], params);

    return response.data;
  }

  async settingMarketingSaleAssign(params) {
    let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['setting-sale-group-assign'], params);

    return response.data;
  }

  async assignGroupSale(params) {
    let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['sale-group-assign'], params);

    return response.data;
  }

  async assignUser(params) {
    let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['user-assign'], params);

    return response.data;
  }

  async rejectDataLead(id) {
    let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['reject-data']+ `/${id}`);

    return response.data;
  }

  async acceptAssign(id) {
    let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['accept-assign']+ `/${id}`);

    return response.data;
  }

  async cancelAssign(id) {
    let response = await ApiService.postAsync(ApiService.routes(this.apiGroup())['cancel-assign']+ `/${id}`);

    return response.data;
  }

  async getTotalLeadByStatus() {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['total-lead-by-status']);

    return response.data;
  }

  async updateBySale(data = null, id = null) {
    let response = await ApiService.patchAsync(
      ApiService.routes(this.apiGroup())['update-by-sale'] + '/' + (id || this.getId()),data ? data : this.reduces(false)
    );

    this.bind(response.data)
    return this;
  }
}


export default Lead
