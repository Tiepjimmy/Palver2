import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Swal from "sweetalert2";

class Stores extends Model {
  /**
   * Order constructor
   * @param data
   */
	constructor(data) {
		super()
        this.id = null;
        this.province_id = null;
        this.district_id = null;
        this.ward_id = null;
        this.parent_id = null;
        this.tree_path = null;
        this.tree_path = null;
        this.store_name = null;
        this.store_cd = null;
        this.hotline = null;
        this.address = null;
        this.active_status = null;
        this.stores = null;
        this.generalCompany = null;
      this.bind(data);
    }

    typeOfNumber() {
        return ['id']
    }

    apiGroup () {
        return 'stores'
    }
    async listdata(params = []) {
        return ApiService.get(ApiService.routes(this.apiGroup())['index'],params).then(response => {
            return response.data;
        });
    }
    async create() {
        return ApiService.get(ApiService.routes(this.apiGroup())['create']).then(response => {
            this.bind(response.data);
            return this;
        });
    }
    async store(param) {
        return ApiService.post(ApiService.routes(this.apiGroup())['store'],param).then(response => {
            return response;
        });
    }
    async show(id) {
        return ApiService.get(ApiService.routes(this.apiGroup())['show']+ `/${id}`).then(response => {
            if (response.status_code !== 200) {
                Swal.fire(
                    "Lỗi!",
                    "Có lỗi phát sinh vui lòng liên hệ admin!",
                    "error",
                ).then(function(result) {
                    if (result.value) {
                        return window.location.reload();
                    }
                    window.location.reload()
                });

                return false;
            }
            this.bind(response.data);
            return this;
        });
    }
    async updateStore(id,param) {
        return ApiService.patch(ApiService.routes(this.apiGroup())['update']+ `/${id}`,param).then(response => {
            return response;
        });
    }

}

export default Stores
