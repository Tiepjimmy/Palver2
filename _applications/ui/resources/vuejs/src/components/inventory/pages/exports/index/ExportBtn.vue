<template>
    <v-btn
        :disabled="disableBtn"
        color="primary"
        class="font-weight-bold font-size-base text-uppercase"
        v-show="show"
        outlined
        depressed
        @click="onClick"
    >
        Xuất kho <v-icon right> mdi-export-variant </v-icon>
    </v-btn>
</template>

<script type="text/javascript">
import RequestMixin from "@/components/inventory/utils/mixins/RequestMixin";
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import GoodsIssue from "@/models/inventory/export/goods_issues";

export default {
    name: "ExportBtn",
    mixins: [EmitsMixin, PopupMessagesMixin, RequestMixin],
    props: {
        disabled: null,
        show: false,
        selected: Array,
    },

    data: () => ({
        GoodsIssueModel: new GoodsIssue(),
    }),

    computed: {
        /**
         * Determines ability to exported.
         *
         * @return     {boolean}  True if able to exported, False otherwise.
         */
        canExported() {
            return !this.selected.some(m => !m.isPacked());
        },

        /**
         * Disables the button.
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        disableBtn() {
            return this.disabled != null ? !!this.disabled : !this.selected.length;
        },
    },

    methods: {
        /**
         * Called on click.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async onClick() {
            if (this.canExported) {
                return this.selected.length === 1 ? await this.exportOne() : await this.exportMany();
            }

            return this.showPopupError({
                html: 'Chỉ được xuất kho cho các phiếu có trạng thái "<b>Đã đóng gói</b>". Vui lòng kiểm tra lại',
            });
        },

        /**
         * Duyệt một phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async exportOne() {
            if (!this.responseOk(await this.export())) {
                return this.openPopupError();
            }

            this.openPopupSuccess({ title: "Xuất kho thành công SP của phiếu <b>" + this.selected[0].code + "</b>" });
        },

        /**
         * Duyệt nhiều phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async exportMany() {
            const result = await this.showPopupConfirm({
                title: `Bạn có chắc chắn muốn xuất kho cho <b>${this.selected.length}</b> phiếu xuất kho ?`,
                text: "",
            });

            if (result.isDismissed) {
                return;
            }

            return this.responseOk(await this.export())
                ? this.openPopupSuccess({
                      title: `Xuất kho thành công <b>${this.selected.length}</b> phiếu xuất kho`,
                  })
                : this.openPopupError();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async export() {
            const body = this.selected.map(function (model) {
                return { goods_issue_id: model.id, status: model.STATUSES_CONST().EXPORTED };
            });

            return await this.GoodsIssueModel.updateStatuses({ data: body });
        },

        /**
         * Opens a popup success many.
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        openPopupSuccess(options) {
            return this.showPopupSuccess({
                ...options,
                text: "",
                customClass: { title: "d-inline" },
                onDestroy: () => this.emitSuccess(),
            });
        },

        /**
         * Opens a popup error.
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        openPopupError() {
            return this.showPopupError({
                title: "xuất kho không thành công",
                text: response.errors,
                onDestroy: () => this.emitError(),
            });
        },
    },
};
</script>
