<template>
    <v-card>
        <v-card-title class="text-h5 d-flex">
            <div class="flex-grow-1">Thêm loại chứng từ thu</div>
            <v-icon medium v-if="showCloseBtn" @click="onCloseClick">close</v-icon>
        </v-card-title>
        <v-card-text>
            <v-form ref="form">
                <div class="container px-0">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label class="form-label">Tên loại chứng từ thu (*)</label>
                            <v-text-field
                                v-model="TypeCollectVouchers.type_name"
                                placeholder="Tên loại chứng từ thu"
                                outlined
                                dense
                                :rules="[rules.name]"
                            ></v-text-field>

                            <label class="form-label">Mã loại chứng từ thu (*)</label>
                            <v-text-field
                                v-model="TypeCollectVouchers.type_code"
                                placeholder="Mã loại chứng từ thu"
                                outlined
                                dense
                                :rules="[rules.code]"
                            ></v-text-field>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label">Mô tả</label>
                            <v-textarea v-model="TypeCollectVouchers.note" placeholder="Mô tả" outlined dense>
                            </v-textarea>
                        </div>
                    </div>
                    <v-checkbox
                        v-model="TypeCollectVouchers.is_business_result"
                        label="Hạch toán kết quả kinh doanh"
                        hide-details
                    ></v-checkbox>
                </div>
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey darken-1" text @click="onCancelBtnClick"> Hủy </v-btn>
            <v-btn color="primary" depressed @click="onSaveBtnClick"> Lưu </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script type="text/javascript">
import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import TypeCollectVouchers from "@/models/type-collect-vouchers/type_collect_vouchers";
import * as Request from "@/components/om/utils/Request";
import * as MessageConst from "@/components/om/utils/MessageConst";
import EmitsMixin from "@/components/om/utils/mixins/EmitsMixin";
import CreateStatusMixin from "@/components/om/utils/mixins/CreateStatusMixin";

export default {
    name: "Create",

    mixins: [EmitsMixin, CreateStatusMixin],

    props: { showCloseBtn: false },

    data: () => ({
        TypeCollectVouchers: new TypeCollectVouchers(),
        createRequestStatus: null,

        rules: {
            type: v => !!v || "Phân loại là bắt buộc",
            level: v => !!v || "Level là bắt buộc",
            name: v => {
                if (!v) return "Tên loại chứng từ là bắt buộc";
                if (v.length > 200) return "Tên loại chứng từ tối đa 200 kí tự";

                return true;
            },

            code: v => {
                if (!v) return "Mã loại chứng từ là bắt buộc";
                if (v.length > 20) return "Mã loại chứng từ tối đa 20 kí tự";

                return true;
            },
        },
    }),

    computed: {},

    methods: {
        /**
         * Called on close click.
         *
         * @param      {<type>}  event   The event
         */
        onCloseClick(event) {
            this.emitClose();
        },

        /**
         * Called on cancel click.
         *
         * @param      {<type>}  event   The event
         */
        onCancelBtnClick(event) {
            this.$refs.form.reset();
            this.$refs.form.resetValidation();
            this.emitCancel();
        },

        /**
         * Called on save click.
         *
         * @param      {<type>}  event   The event
         */
        async onSaveBtnClick(event) {
            if (!this.$refs.form.validate()) {
                return;
            }

            this.emitCreating();

            try {
                await this.save();

                if (this.isCreateSuccess) {
                    this.emitCreated();
                    this.messageSuccess(MessageConst.SUCCESS_MESSAGE_SAVE);
                }
            } catch (e) {
                this.handleException(e);
                return this.emitError();
            }
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async save() {
            try {
                this.setCreateStatusCreating();
                await this.TypeCollectVouchers.storeAsync();
                this.setCreateStatusSuccess();
            } catch (e) {
                this.handleException(e);
                this.setCreateStatusError();
            }
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            { title: "Chứng từ thu" },
            { title: "Loại chứng từ thu" },
            { title: "Thêm mới" },
        ]);
    },
};
</script>
