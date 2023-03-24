<template>
    <div>
        <div class="card">
            <!-- Search -->
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <b-form-input v-model="keyword" placeholder="Tìm kiếm theo tên, tổ chức" v-on:keyup.enter="searchNhomQuyen"></b-form-input>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary btn-active-primary fw-bolder w-100" @click="searchNhomQuyen">
                            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                <inline-svg src="media/svg/icons/General/Search.svg" />
                            </span>
                            Tìm kiếm
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card-body table-responsive" v-if="listRole.length && loading">
                <table class="table table-row-bordered">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800">
                            <th style="width: 60px;"></th>
                            <th class="text-center">Nhóm quyền</th>
                            <th class="text-center">Quyền</th>
                            <th class="text-center">Phân hệ</th>
                            <th class="text-center">Tổ chức</th>
                            <th class="text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in listRole" :key="role.id">
                            <td class="text-center">
                                <router-link class="btn btn-primary btn-icon btn-bg-light edit-test btn-active-color-white btn-sm me-1" :to="'/account/permissiongroup/update/' + role.id">
                                    <span class="svg-icon svg-icon-3">
                                        <v-img width="24" height="24" src="/media/svg/icons/General/Edit.svg"></v-img>
                                    </span>
                                </router-link>
                            </td>
                            <td class="pt-5">{{ role.group_name }}</td>
                            <td class="text-center pt-5">
                                <p v-for="quyen in role.permissions" :key="quyen.id">
                                    {{ quyen.permission_name }}
                                    <v-tooltip top :open-on-hover="false" :open-on-click="true" v-if="!!quyen.tooltip">
                                        <template v-slot:activator="{ on }">
                                            <span class="svg-icon svg-icon-3" @click="on.click" >
                                                <inline-svg src="media/svg/icons/Code/Question-circle.svg" />
                                            </span>
                                        </template>
                                        <span>{{ quyen.tooltip }}</span>
                                    </v-tooltip>
                                </p>
                            </td>
                            <td class="text-center pt-5">{{ role.subsystem.subsystem_name }}</td>
                            <td class="text-center pt-5">
                                <p v-for="toChuc in role.stores" :key="toChuc.id">{{ toChuc.store_name }}</p>
                            </td>
                            <td class="text-dark fw-bolder mb-1 fs-6 text-center pt-5" style="text-transform: capitalize;">
                                <b-badge pill :variant="role.active_status == 'active' ? 'success' : 'warning'">{{ role.active_status }}</b-badge>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="row justify-content-between align-items-center">
                    <div>
                        <label class="fs-6 fw-bold mr-3">Hiển thị</label>
                        <select class="form-control w-auto d-inline-block" v-model="itemPerPage" @change="searchNhomQuyen">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="overflow-auto">
                        <b-pagination-nav v-model="currentPage" :link-gen="linkGen" :number-of-pages="totalPage" use-router></b-pagination-nav>
                    </div>
                </div>
            </div>

            <!-- No result -->
            <p class="text-danger text-center mt-4" v-if="!listRole.length && loading">Không có kết quả tìm kiếm.</p>

            <!-- Loading -->
            <div style="display: flex;align-items: center;justify-content: center;" v-if="!loading">
                <div class="spinner-border mt-5 mb-5" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .v-tooltip {
        display: unset !important;
    }
    .v-tooltip__content {
        width: max-content;
    }
</style>
<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import axios from '@/core/plugins/axios';

export default {
    data() {
        return {
            keyword: '',
            currentPage: 1,
            totalPage: 1,
            itemPerPage: 10,
            listRole: {},
            loading: false
        };
    },
    watch: {
        currentPage: function () {
            this.searchNhomQuyen();
        }
    },
    beforeCreate() {
        axios.get("/proxy/account/v1/nhom-quyen?limit=10")
            .then(response => {
                this.listRole = response.data.data.items;
                this.totalPage = Math.ceil(response.data.data.total / this.itemPerPage);
                this.loading = true;
            })
            .catch(error => console.log(error))
    }, 
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            {title: "Quản lý nhóm quyền", route: "/account/permissiongroup"}
        ]);
        this.$store.dispatch(SET_ACTION, [
            {type: "link", param: "/account/permissiongroup/create", text: 'Thêm mới'}
        ]);
    },
    methods: {
        searchNhomQuyen() {
            this.loading = false;
            let search = '';
            if (this.keyword) {
                search = `&search=${this.keyword}`;
            }
            axios.get(`/proxy/account/v1/nhom-quyen?limit=${this.itemPerPage}&page=${this.currentPage}${search}`)
                .then(response => {
                    this.listRole = response.data.data.items;
                    this.totalPage = Math.ceil(response.data.data.total / this.itemPerPage);
                    this.loading = true;
                })

                .catch(error => console.log(error))
        },
        linkGen() {}
    }
}
</script>