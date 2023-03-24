<template>
    <div>
        <div class="card">
            <!-- Search -->
            <div class="card-header">
                <div class="row">
                    <div class="col-2">
                        <treeselect 
                            v-if="page.loading"
                            :options="optionTypeProduct"
                            :default-expand-level="2"
                            placeholder="Chọn loại sản phẩm"
                            v-model="search.type"
                        />
                    </div>
                    <div class="col-8">
                        <b-form-input v-model="search.keyword" placeholder="Tìm kiếm theo tên, mã sản phẩm" v-on:keyup.enter="searchSanPham"></b-form-input>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary btn-active-primary fw-bolder w-100" @click="searchSanPham">
                            Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card-body table-responsive" v-if="listSanPham.length && page.loading">
                <table class="table table-row-bordered">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800">
                            <th class="text-center"><input type="checkbox" v-model="check.all" @change="selectAll($event)"></th>
                            <th class="text-center"></th>
                            <th class="text-center">Ảnh sản phẩm</th>
                            <th class="text-center">Mã sản phẩm</th>
                            <th class="text-center">Tên sản phẩm</th>
                            <th class="text-center">Danh mục sản phẩm</th>
                            <th class="text-center">Loại sản phẩm</th>
                            <th class="text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in listSanPham" :key="item.id">
                            <td class="text-center"><input type="checkbox" v-model="check.props" :value="item.id"></td>
                            <td class="text-center">
                                <router-link class="btn btn-primary btn-icon btn-bg-light edit-test btn-active-color-white btn-sm me-1" :to="'/account/product/show/' + item.id">
                                    <span class="svg-icon svg-icon-3">
                                        <v-img width="24" height="24" src="/media/svg/icons/General/Edit.svg"></v-img>
                                    </span>
                                </router-link>
                                <button class="btn btn-danger btn-icon btn-bg-light edit-test btn-active-color-white btn-sm me-1" @click="deleteItem(item.id)">
                                    <span class="svg-icon svg-icon-3">
                                        <v-img width="24" height="24" src="/media/svg/icons/General/Trash.svg"></v-img>
                                    </span>
                                </button>
                            </td>
                            <td class="text-center"><img style="width:150px" :src="item.product_avatar" alt=""></td>
                            <td class="text-center">{{ item.product_cd }}</td>
                            <td class="text-center">{{ item.product_name }}</td>
                            <td class="text-center">{{ item.product_catalog.product_catalog_name ? item.product_catalog.product_catalog_name : '' }}</td>
                            <td class="text-center">{{ item.product_type == "single" ? "Sản phẩm đơn" : "Sản phẩm combo" }}</td>
                            <td class="text-center">{{ item.is_sales == "yes" ? "Đang kinh doanh" : "Ngừng kinh doanh" }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="row justify-content-between align-items-center mt-2">
                    <div>
                        <label class="fs-6 fw-bold mr-3">Hiển thị</label>
                        <select class="form-control w-auto d-inline-block" v-model="page.itemPerPage" @change="searchSanPham">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="overflow-auto">
                        <b-pagination-nav v-model="currentPage" :link-gen="linkGen" :number-of-pages="page.totalPage" use-router></b-pagination-nav>
                    </div>
                </div>
            </div>

            <!-- No result -->
            <p class="text-danger text-center mt-4" v-if="!listSanPham.length && page.loading">Không có kết quả tìm kiếm.</p>

            <!-- Loading -->
            <div style="display: flex;align-items: center;justify-content: center;" v-if="!page.loading">
                <div class="spinner-border mt-5 mb-5" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    input[type=checkbox] {
        transform: scale(1.5);
    }
</style>

<script>
import axios from "axios";
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
import Swal from "sweetalert2";

export default {
    data() {
        return {
            check: {
                all: false,
                props: []
            },
            search: {
                type: '',
                keyword: ''
            },
            currentPage: 1,
            page: {
                totalPage: 1,
                itemPerPage: 10,
                loading: false,
            },
            listSanPham: []
        }
    },
    beforeCreate() {
        axios.get("/proxy/account/v1/san-pham?limit=10")
            .then(response => {
                this.listSanPham = response.data.data.items;
                // this.listSanPham.forEach((sanpham, key) => {
                //     let extenstion = sanpham.product_avatar.split('.').pop();
                //     this.listSanPham[key].product_avatar = this.listSanPham[key].product_avatar.replace('.' + extenstion, '_S.' + extenstion)
                // });
                this.page.totalPage = Math.ceil(response.data.data.total / this.page.itemPerPage);
                this.page.loading = true;
                this.$emit('updateExportUrl', '?limit=10');
            })
            .catch(error => console.log(error))
    },
    watch: {
        currentPage: function () {
            this.searchSanPham();
        }
    },
    computed: {
        optionTypeProduct: function () {
            return [
                {
                    id: "",
                    label: "Tất cả"
                },
                {
                    id: "single",
                    label: "Sản phẩm đơn"
                },
                {
                    id: "combo",
                    label: "Sản phẩm combo"
                }
            ];
        }
    },
    methods: {
        linkGen() {},
        selectAll: function(e) {
            let _that = this;
            this.listSanPham.map(function(sanPham) { 
                if (e.target.checked) {
                    if (!_that.check.props.includes(sanPham.id)) {
                        _that.check.props.push(sanPham.id);
                    }
                } else {
                    let position = _that.check.props.indexOf(sanPham.id);
                    if (position != -1) {
                        _that.check.props.splice(position, 1);
                    }
                }
            });
        },
        searchSanPham() {
            this.page.loading = false;
            let search = '';
            let type = '';
            if (this.search.keyword) {
                search = `&search=${this.search.keyword}`;
            }
            if (!!this.search.type) {
                type = `&product_type=${this.search.type}`;
            }
            this.$emit('updateExportUrl', `?limit=${this.page.itemPerPage}&page=${this.currentPage}${search}${type}`);
            axios.get(`/proxy/account/v1/san-pham?limit=${this.page.itemPerPage}&page=${this.currentPage}${search}${type}`)
                .then(response => {
                    this.listSanPham = response.data.data.items;
                    // this.listSanPham.forEach((sanpham, key) => {
                    //     let extenstion = sanpham.product_avatar.split('.').pop();
                    //     this.listSanPham[key].product_avatar = this.listSanPham[key].product_avatar.replace('.' + extenstion, '_S.' + extenstion)
                    // });
                    this.page.totalPage = Math.ceil(response.data.data.total / this.page.itemPerPage);
                    this.page.loading = true;
                })

                .catch(error => console.log(error))
        },
        deleteItem(id) {
            if (! id) {
                return
            }

            Swal.fire({
                text: "Bạn có chắc chắn muốn hủy ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                this.confirmDelete(id)
                }
            })
        },
        async confirmDelete(id) {
            try {
                this.loadingStart()

                await axios.delete(`/proxy/account/v1/san-pham/${id}`)
                .then(response => {
                    this.listSanPham = response.data.data.items;
                    this.page.totalPage = Math.ceil(response.data.data.total / this.page.itemPerPage);
                    this.page.loading = true;
                })

                .catch(error => console.log(error))
                this.messageSuccess('Bạn đã hủy chứng từ chi thành công')
                this.searchSanPham()
            } catch (e) {
                this.handleException(e)
            } finally {
                this.loadingClose()
            }
        }
    }
}
</script>