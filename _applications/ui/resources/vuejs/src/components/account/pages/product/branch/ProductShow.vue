<template>
    <div>
        <div class="card">
            <div class="card-body row" v-if="!!data.product_name && !loading">
                <div class="col-md-12">
                    <h2>{{ data.product_name }}</h2>
                </div>
                <div class="col-md-12">
                    <div class="card p-3">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 160px;">Thông tin sản phẩm</th>
                                    <th>
                                        <b-badge v-if="data.is_sales == 'yes'" pill variant="success">Đang kinh doanh</b-badge>
                                        <b-badge v-else pill variant="danger">Ngừng kinh doanh</b-badge>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img style="width:150px" :src="data.product_avatar" alt=""></td>
                                    <td>
                                        <p>Tên sản phẩm: {{ data.product_name }}</p>
                                        <p>Tên hiển thị: {{ data.product_display_name }}</p>
                                        <p>Mã sản phẩm: {{ data.product_cd }}</p>
                                        <p>Mã SKU: {{ data.sku }}</p>
                                    </td>
                                    <td>
                                        <p>Nhà cung cấp: Giang</p>
                                        <p>Loại sản phẩm: {{ data.product_catalog.product_catalog_name }}</p>
                                        <p>Khối lượng: {{ data.quantity }}</p>
                                        <p>Đơn vị tính: {{ data.unit }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card p-3">
                        <table>
                            <thead>
                                <tr>
                                    <th>Giá sản phẩm</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Giá bán lẻ: {{ data.retail_product_entities[0].retail_entity_price.old_prices }}</p>
                                        <p>Giá bán buôn: {{ data.retail_product_entities[0].retail_entity_price.old_wholesale_prices }}</p>
                                    </td>
                                    <td>
                                        <p>Giá vốn: {{ data.retail_product_entities[0].retail_entity_price.old_cost_prices }}</p>
                                        <p></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3">
                        <table>
                            <thead>
                                <tr>
                                    <th>Thông tin thêm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p><input type="checkbox" v-model="data.is_sales" true-value="yes" false-value="no"> Cho phép bán</p>
                                        <p><input type="checkbox" v-model="data.is_enable_tax" true-value="yes" false-value="no"> Áp dụng thuế</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <router-link class="btn btn-primary float-right" :to="'/account/product/edit/' + id">
                        Chỉnh sửa
                    </router-link>
                </div>
            </div>

            <div class="card-body" style="text-align: center" v-else-if="!loading">
                <span style="color: red">Không có kết quả tìm kiếm</span>
            </div>

            <!-- Loading -->
            <div class="card-body" style="display: flex;align-items: center;justify-content: center;" v-else>
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    img {
        width: 100px;
    }
</style>

<script>
import axios from "axios";

export default {
    data() {
        return {
            data: {},
            loading: true
        }
    },
    props: {
        id: String
    },
    components: {
       
    },
    beforeCreate() {
        
    },
    mounted() {
        axios.get(`/proxy/account/v1/san-pham/${this.id}`)
            .then(response => {
                this.data = response.data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;
            })
    }
}
</script>