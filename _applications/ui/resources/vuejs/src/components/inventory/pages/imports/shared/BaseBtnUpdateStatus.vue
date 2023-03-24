<template>
    <v-btn
        :disabled="disableBtn"
        class="font-weight-bold font-size-base text-uppercase"
        @click="onClick"
        v-bind="$attrs"
    >
        {{ _.upperFirst(ACTION_NAME) }} <v-icon right> {{ ICON }} </v-icon>
    </v-btn>
</template>

<script type="text/javascript">
import RequestMixin from "@/components/inventory/utils/mixins/RequestMixin";
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import GoodsReceipt from "@/models/inventory/import/goods_receipts";

export default {
    inheritAttrs: false,
    name: "BaseBtnUpdateStatus",
    mixins: [EmitsMixin, PopupMessagesMixin, RequestMixin],
    props: {
        disabled: null,
        selected: [],
        confirm: true,
        confirmWithNote: false,
    },

    data: () => ({
        model: new GoodsReceipt(),
        ACTION_NAME: "BaseBtnUpdateStatus",
        STATUS: "",
        ICON: "",
        STATUS_ACCEPT: "",
        color: "primary",

        reson: null,
    }),

    computed: {
        _: () => _,
        /**
         * Determines ability to import.
         *
         * @return     {boolean}  True if able to import, False otherwise.
         */
        canHandle() {
            return false;
        },

        /**
         * Disables the button.
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        disableBtn() {
            return this.disabled != null ? !!this.disabled : this.selected?.length === 0;
        },
    },

    methods: {
        /**
         * Called on click.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async onClick() {
            if (this.canHandle) {
                return this.selected.length === 1 ? await this.handleOne() : await this.handleMany();
            }

            return this.showPopupError({
                html: `Chỉ được ${this.ACTION_NAME} các phiếu có trạng thái "<b>${this.STATUS_ACCEPT}</b>". Vui lòng kiểm tra lại`,
            });
        },

        /**
         * Duyệt một phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async handleOne() {
            if (this.confirmWithNote) {
                const confirmWithNote = await this.isConfirmedWithNote();

                if (confirmWithNote.isDismissed) {
                    return;
                }

                this.reson = confirmWithNote.value;
            } else if (this.confirm) {
                const isConfirmed = await this.isConfirmed();
                if (!isConfirmed) {
                    return;
                }
            }

            if (!this.responseOk(await this.update())) {
                return this.openPopupError();
            }

            this.openPopupSuccess({
                title: _.upperFirst(`${this.ACTION_NAME} thành công phiếu <b>${this.selected[0].code}</b>`),
            });
        },

        /**
         * Determines if confirmed.
         *
         * @return     {Promise}  True if confirmed, False otherwise.
         */
        async isConfirmed() {
            const result = await this.showPopupConfirm({
                title: `Bạn có chắc chắn muốn ${this.ACTION_NAME} phiếu <b>${this.selected[0].code}</b> ?`,
                text: "",
            });

            return result.isConfirmed;
        },

        /**
         * Determines if confirmed with note.
         *
         * @return     {Promise}  True if confirmed with note, False otherwise.
         */
        async isConfirmedWithNote() {
            return await this.showPopupConfirm({
                title: `Bạn có chắc chắn muốn ${this.ACTION_NAME} phiếu <b>${this.selected[0].code}</b> ?`,
                text: "",
                input: "textarea",
                inputPlaceholder: "Lý do",
            });
        },

        /**
         * Duyệt nhiều phiếu
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async handleMany() {
            const title = `Bạn có chắc chắn muốn ${this.ACTION_NAME} cho <b>${this.selected.length}</b> phiếu ${this.ACTION_NAME} ?`;
            const result = await this.showPopupConfirm({ title: title, text: "" });

            if (result.isDismissed) {
                return;
            }

            return this.responseOk(await this.update())
                ? this.openPopupSuccess({
                      title: _.upperFirst(`${this.ACTION_NAME} thành công <b>${this.selected.length}</b> phiếu`),
                  })
                : this.openPopupError();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async update() {
            const body = this.selected.map(model => ({
                goods_receipt_id: model.id,
                status: model.STATUSES_CONST()[this.STATUS],
                note: this.reson,
            }));

            return await this.model.updateStatuses({ data: body });
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
                title: _.upperFirst(`${this.ACTION_NAME} không thành công`),
                text: response.errors,
                onDestroy: () => this.emitError(),
            });
        },
    },
};
</script>
