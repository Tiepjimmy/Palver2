import ApiService from '@/core/api.service'
import Model from '@/core/model'
import Swal from "sweetalert2";

class Districts extends Model {
    /**
     * Order constructor
     * @param data
     */
    constructor(data) {
        super()
        this.id = null;
        this.province_id = null;
        this.district_name = null;
        this.district_cd = null;
        this.bind(data);
    }

    typeOfNumber() {
        return ['id']
    }

    apiGroup () {
        return 'districts'
    }
    async districts(param) {
        return ApiService.get(ApiService.routes(this.apiGroup())['index'],param).then(response => {
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

export default Districts
