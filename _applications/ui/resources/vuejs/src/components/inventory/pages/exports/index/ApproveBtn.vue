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
        Duyệt phiếu <v-icon right> check </v-icon>
    </v-btn>
</template>

<script type="text/javascript">
import RequestMixin from "@/components/inventory/utils/mixins/RequestMixin";
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import GoodsIssue from "@/models/inventory/export/goods_issues";

export default {
    name: "ApproveBtn",
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
         * Determines if it exists Approveed.
         *
         * @return     {<type>}  True if exists Approveed, False otherwise.
         */
        canApproved() {
            return !this.selected.some(m => !m.isWaiting());
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
            if (this.canApproved) {
                return this.selected.length === 1 ? await this.approveOne() : await this.ApproveMany();
            }

            return this.showPopupError({
                html: 'Chỉ được duyệt các phiếu có trạng thái "<b>Chờ duyệt</b>". Vui lòng kiểm tra lại',
            });
        },

        /**
         * Duyệt một phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async approveOne() {
            if (!this.responseOk(await this.approve())) {
                return this.openPopupError();
            }

            this.openPopupSuccess({ title: "Duyệt thành công phiếu <b>" + this.selected[0].code + "</b>" });
        },

        /**
         * Duyệt nhiều phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async ApproveMany() {
            const result = await this.showPopupConfirm({
                title: `Bạn có chắc chắn muốn duyệt <b>${this.selected.length}</b> phiếu xuất kho ?`,
                text: "",
            });

            if (result.isDismissed) {
                return;
            }

            return this.responseOk(await this.approve())
                ? this.openPopupSuccess({
                      title: `Duyệt phiếu thành công <b>${this.selected.length}</b> phiếu xuất kho`,
                  })
                : this.openPopupError();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async approve() {
            const body = this.selected.map(function (model) {
                return { goods_issue_id: model.id, status: model.STATUSES_CONST().RESOLVED };
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
                title: "Duyệt phiếu không thành công",
                text: response.errors,
                onDestroy: () => this.emitError(),
            });
        },
    },
};
</script>
