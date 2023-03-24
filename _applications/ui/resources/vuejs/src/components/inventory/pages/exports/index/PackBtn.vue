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
        Đóng hàng <v-icon right> inventory </v-icon>
    </v-btn>
</template>

<script type="text/javascript">
import RequestMixin from "@/components/inventory/utils/mixins/RequestMixin";
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import GoodsIssue from "@/models/inventory/export/goods_issues";

export default {
    name: "PackBtn",
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
         * Determines if it exists packed.
         *
         * @return     {<type>}  True if exists packed, False otherwise.
         */
        canPacked() {
            return !this.selected.some(m => !m.isResolved());
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
            if (this.canPacked) {
                return this.selected.length === 1 ? await this.packOne() : await this.packMany();
            }

            return this.showPopupError({
                html: 'Chỉ được đóng hàng cho các phiếu có trạng thái "<b>Đã duyệt</b>". Vui lòng kiểm tra lại',
            });
        },

        /**
         * Duyệt một phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async packOne() {
            if (!this.responseOk(await this.pack())) {
                return this.openPopupError();
            }

            this.openPopupSuccess({ title: "Đóng hàng thành công SP của phiếu <b>" + this.selected[0].code + "</b>" });
        },

        /**
         * Duyệt nhiều phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async packMany() {
            const result = await this.showPopupConfirm({
                title: `Bạn có chắc chắn muốn đóng hàng cho <b>${this.selected.length}</b> phiếu xuất kho ?`,
                text: "",
            });

            if (result.isDismissed) {
                return;
            }

            return this.responseOk(await this.pack())
                ? this.openPopupSuccess({
                      title: `Đóng hàng thành công <b>${this.selected.length}</b> phiếu xuất kho`,
                  })
                : this.openPopupError();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async pack() {
            const body = this.selected.map(function (model) {
                return { goods_issue_id: model.id, status: model.STATUSES_CONST().PACKED };
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
                title: "Đóng hàng không thành công",
                text: response.errors,
                onDestroy: () => this.emitError(),
            });
        },
    },
};
</script>
