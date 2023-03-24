<template>
    <v-card class="om-wp">
        <v-card-title primary-title> Danh sách mẫu in </v-card-title>
        <v-card-text>
            <div class="d-flex mb-3">
                <v-text-field 
                    placeholder="Tìm mẫu in"
                    dense 
                    elevation="0"
                    hide-details="true"
                    outlined
                    clearable
                    @input="debouceKeyword">
                </v-text-field>
            </div>
            <div class="d-flex">
                <div class="flex-grow-1 d-flex justify-content-end">
                    <v-btn color="blue white--text" @click.stop="onClickBtnAddNew">
                        Thêm mới <v-icon right> mdi-plus </v-icon>
                    </v-btn>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="table table-bordered mb-0 mt-3">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Kiểu</th>
                            <th>Là form mặc định ?</th>
                            <th>Đang hoạt động ?</th>
                            <th>Tiện ích</th>
                        </tr>
                    </thead>
                    <tbody>
                        <IndexTableRow
                            v-for="(form, idx) in formCollection"
                            :key="idx"
                            :idx="idx"
                            :form="form"
                            @click-update="handleUpdateRow"
                        ></IndexTableRow>
                    </tbody>
                </table>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import Swal from 'sweetalert2';
import Collection from '@/core/collection';
import { FormFilter } from './filter';
import PrintedForm from '@/models/printed-forms/printed_form';
import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';

import { default as IndexTableRow } from './IndexTableRow';

import * as Request from '@/components/om/utils/Request';
import * as MessageConst from '@/components/om/utils/MessageConst';

export default {
    name: 'Index',

    components: {
        IndexTableRow,
    },

    data: () => ({
        filter: Object,
        PrintedFormModel: new PrintedForm(),
        formCollection: new Collection(PrintedForm),

        deleteModel: PrintedForm,
        deleteStatus: false,
    }),

    computed: {},

    watch: {
        filter: {
            deep: true,
            handler: function (n, o) {
                this.loadForms();
            },
        },
    },

    methods: {
        /**
         * { function_description }
         */
        debouceKeyword: _.debounce(function (evt) {
            return (this.filter.keyword = evt);
        }, 500),

        /**
         * { function_description }
         */
        async handleUpdateRow(idx) {
            this.$router.push({ name: 'om.order.print_forms.update', params: { id: this.formCollection[idx].id } });
        },

        /**
         * Called on click button add new.
         */
        onClickBtnAddNew() {
            this.$router.push({ name: 'om.order.print_forms.create' });
        },

        /**
         * Loads order statuses.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async loadForms() {
            try {
                this.loadingStart();

                this.formCollection = await this.PrintedFormModel.getListAsync(this.filter.reduces());
            } catch (e) {
                this.handleException(e);
            }
        },
    },

    created() {
        this.filter = new FormFilter({ store_id: 1, ...this.$route.query });
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: 'Quản lý mẫu in' }]);
    },
};
</script>
