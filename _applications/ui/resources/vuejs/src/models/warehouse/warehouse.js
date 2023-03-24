import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Swal from "sweetalert2";
import Provinces from "@/models/master/provinces/provinces";
import Districts from "@/models/master/districts/districts";
import Wards from "@/models/master/wards/wards";

class Warehouse extends Model {
    /**
     * Order constructor
     * @param data
     */
    constructor(data) {
        super()
        this.id = null;
        this.warehouse_type_id = null;
        this.province_id = null;
        this.province = new Provinces()
        this.district_id = null;
        this.district = new Districts()
        this.ward_id = null;
        this.ward = new Wards()
        this.warehouse_name = null;
        this.warehouse_cd = null;
        this.note = null;
        this.address = null;
        this.hotline = null;
        this.active_status = null;
        this.warehouse_type = null;
        this.warehouse_stores = null;
        this.bind(data);
    }

    typeOfNumber() {
        return ['id']
    }

    apiGroup () {
        return 'warehouse'
    }
    async listdata(params = []) {
        return ApiService.get(ApiService.routes(this.apiGroup())['index'],params).then(response => {
            return response.data;
        });
    }
    async create() {
        return ApiService.get(ApiService.routes(this.apiGroup())['create']).then(response => {
            return response.data;
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
    async updateWarehouse(id,param) {
        return ApiService.patch(ApiService.routes(this.apiGroup())['update']+ `/${id}`,param).then(response => {
            return response;
        });
    }

}

export default Warehouse
