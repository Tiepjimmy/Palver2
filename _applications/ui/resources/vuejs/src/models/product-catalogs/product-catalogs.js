import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Swal from "sweetalert2";

class ProductCatalogs extends Model {
    /**
     * Order constructor
     * @param data
     */
    constructor(data) {
        super()
        this.id = null;
        this.parent_id = null;
        this.product_catalog_cd = null;
        this.product_catalog_name = null;
        this.note = null;
        this.product_cd_prefix = null;
        this.active_status = null;
        this.stores = null;
        this.productCatalogs = null;
        this.bind(data);
    }

    typeOfNumber() {
        return ['id']
    }

    apiGroup () {
        return 'product-catalogs'
    }
    async listdata(params = []) {
        return ApiService.get(ApiService.routes(this.apiGroup())['index'],params).then(response => {
            return response.data;
        });
    }
    async create() {
        return ApiService.get(ApiService.routes(this.apiGroup())['create']).then(response => {
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
            return response.data;
        });
    }
    async updateCatalog(id,param) {
        return ApiService.patch(ApiService.routes(this.apiGroup())['update']+ `/${id}`,param).then(response => {
            return response;
        });
    }

}

export default ProductCatalogs
