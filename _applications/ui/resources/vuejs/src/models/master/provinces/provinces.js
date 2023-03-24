import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Swal from "sweetalert2";

class Provinces extends Model {
    /**
     * Order constructor
     * @param data
     */
    constructor(data) {
        super()
        this.id = null;
        this.province_name = null;
        this.province_cd = null;
        this.bind(data);
    }

    typeOfNumber() {
        return ['id']
    }

    apiGroup () {
        return 'provinces'
    }
    async listdata() {
        return ApiService.get(ApiService.routes(this.apiGroup())['index']).then(response => {
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

}

export default Provinces
