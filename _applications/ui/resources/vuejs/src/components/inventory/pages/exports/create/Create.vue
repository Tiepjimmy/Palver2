<template>
    <div class="card card-custom">
        <step-create></step-create>
        <div class="card-body">
            <div class="container p-0">
                <div class="row">
                    <div class="col-3 pt-0 pl-0">
                        <invoice-block :invoice="GoodsIssueModel"></invoice-block>

                        <addition-block :invoice="GoodsIssueModel" class="mt-3"></addition-block>
                    </div>
                    <div class="col-9 p-0">
                        <products-block :invoice="GoodsIssueModel"></products-block>
                        <note-block :invoice="GoodsIssueModel" class="mt-3"></note-block>

                        <div class="mt-3 d-flex justify-content-end">
                            <v-btn color="warning" @click="onClickCancelBtn" dense depressed :disabled="isCreating">
                                Hủy
                            </v-btn>
                            <v-btn
                                class="ml-1"
                                color="primary"
                                @click="onClickSaveBtn"
                                dense
                                depressed
                                :disabled="isCreating"
                            >
                                Tạo phiếu
                            </v-btn>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import CreateStatusMixin from "@/components/inventory/utils/mixins/CreateStatusMixin";

import { SET_BREADCRUMB } from "@/core/services/store/breadcrumbs.module";
import { default as ProductsBlock } from "./ProductsBlock";
import { default as InvoiceBlock } from "./InvoiceBlock";
import { default as AdditionBlock } from "./AdditionBlock";
import { default as NoteBlock } from "./NoteBlock";
import { default as StepCreate } from "../components/StepCreate";

import GoodsIssue from "@/models/inventory/export/goods_issues";

export default {
    name: "Create",
    mixins: [EmitsMixin, PopupMessagesMixin, CreateStatusMixin],
    components: {
        ProductsBlock,
        InvoiceBlock,
        AdditionBlock,
        NoteBlock,
        StepCreate,
    },

    data: () => ({
        GoodsIssueModel: GoodsIssue,
    }),

    computed: {},

    watch: {},

    methods: {
        /**
         * Called on click cancel button.
         */
        onClickCancelBtn() {
            this.gotoIndexPage();
        },

        /**
         * Called on click save button.
         */
        async onClickSaveBtn() {
            await this.create();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async create() {
            try {
                await this.GoodsIssueModel.storeAsync();

                return this.showPopupCreateSuccess({
                    html: `Thêm phiếu xuất kho <b>${this.GoodsIssueModel.code}</b> thành công!`,
                    showConfirmButton: false,
                    timer: 1500,
                    onDestroy: () => {
                        this.initModel();
                        this.gotoIndexPage();
                    },
                });
            } catch (e) {
                console.log(e);
                return this.messageError(e);
            }
        },

        /**
         * Initializes the model.
         */
        initModel() {
            this.GoodsIssueModel = new GoodsIssue();
        },

        /**
         * { function_description }
         */
        gotoIndexPage() {
            this.$router.push({ name: "inv.export.goods-issue.index" });
        },
    },

    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [{ title: "Phiếu nhập kho" }, { title: "Tạo phiếu" }]);
    },

    created() {
        this.initModel();
    },
};
</script>

<style></style>
