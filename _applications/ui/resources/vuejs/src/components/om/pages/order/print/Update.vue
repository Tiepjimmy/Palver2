<template>
    <v-card elevation="0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex">
                        <div class="d-flex form-inline flex-grow-1">
                            <div class="form-group">
                                <v-select
                                    v-model="selectedForm"
                                    :items="PRINT_FORMS"
                                    dense
                                    item-text="title"
                                    item-value="id"
                                    outlined
                                    disabled
                                    hide-details
                                ></v-select>
                            </div>
                            <div class="d-flex flex-grow-1 justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-md px-5 font-weight-bold"
                                    @click="onClickSaveForm"
                                    :disabled="hasSelectedForm"
                                >
                                    Lưu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <ckeditor
                        :editor="editor"
                        v-model="form.content"
                        :config="editorConfig"
                        @ready="onEditorReady"
                    ></ckeditor>

                    <div class="form-group mt-3 d-flex align-items-center">
                        <v-checkbox
                            v-model="form.is_default"
                            label="Đặt làm mặc định"
                            color="primary"
                            value="1"
                            hide-details
                        ></v-checkbox>

                        <v-btn @click="onClickRollbackSystemForm" class="ma-2 ml-auto" color="primary" dark>
                            Khôi phục mẫu in về mặc định
                            <v-icon dark right> arrow_forward </v-icon>
                        </v-btn>
                    </div>
                </div>

                <div class="col-6">
                    <preview-print-form :template="form.content"></preview-print-form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <note></note>
                </div>
            </div>
        </div>
    </v-card>
</template>

<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Swal from 'sweetalert2';

import PreviewPrintForm from './Preview';
import Note from './Note';
import PrintedForm from '@/models/printed-forms/printed_form';
import Collection from '@/core/collection';

import { SET_BREADCRUMB } from '@/core/services/store/breadcrumbs.module';
import * as Request from '@/components/om/utils/Request';
import * as MessageConst from '@/components/om/utils/MessageConst';
import * as HttpCodes from "@/components/inventory/utils/HttpCodes";

export default {
    name: 'Update',

    components: { Note, PreviewPrintForm },

    data: () => ({
        editor: ClassicEditor,
        editorData: '',
        editorConfig: {
            allowedContent: true,
        },

        shortcode: {},
        systemForms: new Collection(PrintedForm),

        selectedForm: 0,
        form: new PrintedForm(),
        updateStatus: Request.NONE,
    }),

    computed: {
        /**
         * Prints a forms.
         *
         * @class      PRINT_FORMS (name)
         * @return     {<type>}  { description_of_the_return_value }
         */
        PRINT_FORMS() {
            return [{ id: 0, title: 'Chọn mẫu in' }, ...this.systemForms];
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        currentForm() {
            return this.PRINT_FORMS.find(f => f.id  === this.form.type) || {};
        },

        /**
         * Determines if updating.
         */
        isUpdating() {
            return this.updateStatus === Request.UPDATING;
        },

        /**
         * Determines if updating.
         */
        isCreated() {
            return this.updateStatus === Request.SUCCESS;
        },

        /**
         * Determines if selected form.
         *
         * @return     {boolean}  True if selected form, False otherwise.
         */
        hasSelectedForm() {
            return !this.form.type;
        },
    },

    watch: {
        'form.type': function(n, o){
            this.selectedForm = n;
        }
    },

    methods: {
        ...mapActions({ SET_BREADCRUMB }),

        /**
         * Called on editor ready.
         */
        onEditorReady() {
            this.newFormContent();
        },

        /**
         * { function_description }
         */
        newFormContent() {
            this.form.content = this.currentForm.template;
            this.form.title = this.currentForm.name;
        },

        /**
         * Sets the updating status.
         */
        setUpdatingStatus() {
            this.updateStatus = Request.UPDATING;
        },

        /**
         * Sets the updated status.
         */
        setUpdatedStatus() {
            this.updateStatus = Request.SUCCESS;
        },

        /**
         * Sets the update error status.
         */
        setUpdateErrorStatus() {
            this.updateStatus = Request.ERROR;
        },

        /**
         * Sets the update cancel status.
         */
        setUpdateCancelStatus() {
            this.updateStatus = Request.CANCEL;
        },

        /**
         * Called on click save form.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async onClickSaveForm() {
            this.handleSaveForm();
        },

        /**
         * Called on click rollback system form.
         */
        async onClickRollbackSystemForm() {
            this.handleRollbackSystemForm();
        },

        /**
         * { function_description }
         */
        async handleRollbackSystemForm() {
            const result = await this.showConfirmRollbackSystemForm();

            if (result.isDismissed) {
                return Swal.close();
            }

            if (result.isConfirmed) {
                return this.newFormContent()
            }
        },

        /**
         * { function_description }
         */
        async handleSaveForm() {
            if (this.isUpdating) {
                return;
            }

            this.setUpdatingStatus();

            const response = await this.confirmSaveForm();

            this.showPopupSuccess();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async confirmSaveForm() {
            const result = await this.showConfirmSaveForm();

            if (result.isDismissed) {
                return this.setUpdateCancelStatus() && Swal.close();
            }

            if (result.isConfirmed) {
                return await this.update();
            }
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async confirmRollbackSystemForm() {
            const result = await this.showConfirmRollbackSystemForm();

            if (result.isDismissed) {
                this.updateStatus = Request.CANCEL;

                return Swal.close();
            }

            if (result.isConfirmed) {
                return this.rollbackSystemForm();
            }
        },

        /**
         * Shows the confirm rollback system form.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async showConfirmRollbackSystemForm() {
            const title =
                'Bạn có muốn chắc chắn muốn khôi phục mẫu in <b>' +
                this.form +
                '</b> về thiết lập mặc định của hệ thống ?';

            return Swal.fire({
                title: title,
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Hủy',
                confirmButtonText: 'Đồng ý',
                allowOutsideClick: false,
                customClass: {
                    title: 'd-inline',
                },
            });
        },

        /**
         * Shows the confirm save form.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async showConfirmSaveForm() {
            const title = 'Bạn có muốn chắc chắn muốn lưu mẫu in <b>' + this.form.title + '</b> ?';

            return Swal.fire({
                title: title,
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Hủy',
                confirmButtonText: 'Đồng ý',
                allowOutsideClick: false,
                customClass: {
                    title: 'd-inline',
                },
            });
        },

        /**
         * { function_description }
         */
        async rollbackSystemForm() {
            this.updateStatus = Request.SUCCESS;
        },

        /**
         * { function_description }
         */
        async update() {
            try{
                return _.tap(await this.form.updateAsync(), () => this.setUpdatedStatus())
            }catch(e){
                this.setUpdateErrorStatus()
                this.messageError(e)
            }
        },


        /**
         * Shows the popup error.
         */
        showPopupError() {
            Swal.fire(MessageConst.ERROR_TITLE, MessageConst.ERROR_MESSAGE_UPDATE, "error");
        },

        /**
         * Shows the popup success.
         */
        showPopupSuccess() {
            Swal.fire({
                title: MessageConst.SUCCESS_TITLE,
                text: MessageConst.SUCCESS_MESSAGE_UPDATE,
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
                onDestroy: () => this.onPopupSuccessDestroy(),
            });
        },

        /**
         * Called on popup success destroy.
         */
        onPopupSuccessDestroy() {
            this.$router.push({ name: "om.order.print_forms" });
        },

        /**
         * Fetches a form.
         *
         * @param      {<type>}  formID  The form id
         * @return     {<type>}  The form.
         */
        fetchForm(formID){
            return this.form.loadById(formID)
        },

        /**
         * Loads a short code.
         */
        async loadShortCode() {
            try {
                const res = await this.form.fetchShortCode();
                this.shortcode = res.data
            } catch (e) {
                this.messageError('Tải danh sách short code thất bại !');
                console.log(e);
            }
        },

        /**
         * Loads system forms.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async loadSystemForms() {
            try {
                const res = await this.form.fethSystemForms();
                this.systemForms.addRange(res.data.items)
            } catch (e) {
                this.messageError('Tải danh sách form hệ thống thất bại !');
                console.log(e);
            }
        },
    },

    /**
     * { function_description }
     */
    created() {
        this['SET_BREADCRUMB']([{ title: 'Quản lý mẫu in' }, { title: 'Tạo mẫu in' }]);
        this.fetchForm(this.$route.params.id)
        this.loadShortCode()
        this.loadSystemForms()
    },
};
</script>
