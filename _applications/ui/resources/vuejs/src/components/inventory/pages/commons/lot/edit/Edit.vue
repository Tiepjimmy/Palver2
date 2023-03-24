<template>
    <v-card>
        <v-card-title class="text-h5 d-flex">
            <div class="flex-grow-1">Chỉnh sửa lô</div>
            <v-icon medium v-if="showCloseBtn" @click="onCloseClick">close</v-icon>
        </v-card-title>
        <v-card-text>
            <div class="container px-0">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Mã lô</label>
                        <v-text-field
                            placeholder="Mã lô ..."
                            v-model="LotModel.code"
                            :disabled="!lotExists"
                            dense
                            hide-details
                            outlined
                        >
                        </v-text-field>
                    </div>
                    <div class="col-6 d-flex align-items-end justify-content-end">
                        <expired-at-btn
                            :value="LotModel.expired_date"
                            @update:selected="onUpdateExpiredDate"
                        ></expired-at-btn>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Trạng thái</label>
                        <v-select
                            placeholder="Chọn trạng thái"
                            :items="statuses"
                            v-model="LotModel.status"
                            :disabled="!lotExists"
                            item-text="name"
                            item-value="value"
                            dense
                            outlined
                            hide-details
                        >
                        </v-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Ghi chú</label>
                        <v-textarea rows="2" v-model="LotModel.note" dense hide-details outlined :disabled="!lotExists">
                        </v-textarea>
                    </div>
                </div>
            </div>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="orange darken-1" text @click="onCancelBtnClick"> Hủy </v-btn>
            <v-btn color="blue darken-1" text @click="onUpdateBtnClick" :disabled="!canSave"> Lưu </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script type="text/javascript">
import { default as ExpiredAtBtn } from "./ExpiredAtBtn";
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import UpdateStatusMixin from "@/components/inventory/utils/mixins/UpdateStatusMixin";
import * as Request from "@/components/inventory/utils/Request";

import Collection from "@/core/collection";
import LotModel from "@/models/inventory/common/lot";

export default {
    mixins: [EmitsMixin, PopupMessagesMixin, UpdateStatusMixin],
    components: { ExpiredAtBtn },
    data: () => ({
        expiredBtnMenu: false,
        fetchLotStatus: null,

        LotModel: new LotModel(),
    }),

    props: {
        showCloseBtn: false,
        lotId: 0,
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        statuses() {
            return _.map(LotModel.statuses(), function (name, key) {
                return { value: key, name: name };
            });
        },

        /**
         * Determines if lot exists.
         *
         * @return     {<type>}  True if lot exists, False otherwise.
         */
        lotExists() {
            return this.LotModel.id === this.lotId;
        },

        /**
         * Determines if lot fetching.
         *
         * @return     {boolean}  True if lot fetching, False otherwise.
         */
        isLotFetching() {
            return this.fetchLotStatus === Request.FETCHING;
        },

        /**
         * Determines ability to save.
         *
         * @return     {boolean}  True if able to save, False otherwise.
         */
        canSave() {
            return this.updateStatus !== Request.UPDATING;
        },
    },

    watch: {
        lotId: {
            immediate: true,
            async handler(n, o) {
                try {
                    await this.loadLotData();
                } catch (e) {
                    this.messageError(e);
                }
            },
        },
    },

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
         * Called on cancel button click.
         *
         * @param      {<type>}  event   The event
         */
        onCancelBtnClick(event) {
            this.emitCancel();
        },

        /**
         * Called on update expired date.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateExpiredDate(val) {
            this.LotModel.expired_date = val;
        },

        /**
         * Called on update button click.
         *
         * @param      {<type>}   event   The event
         * @return     {Promise}  { description_of_the_return_value }
         */
        async onUpdateBtnClick(event) {
            try {
                await this.doUpdate();
            } catch (e) {
                this.setUpdateStatusError();
                this.messageError(e);
            }
        },

        /**
         * Does an update.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async doUpdate() {
            this.setUpdateStatusUpdating();
            this.emitUpdating();

            const response = await this.LotModel.updateAsync();

            this.showPopupUpdateSuccess({
                title: "Bạn cập nhật lô thành công",
                showConfirmButton: false,
                timer: 1500,
                onDestroy: () => {
                    this.setUpdateStatusSuccess();
                    this.emitUpdated();
                },
            });
        },

        /**
         * Loads a lot data.
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async loadLotData() {
            if (this.isLotFetching) {
                return;
            }

            try {
                await this.fetchLot();
            } catch (e) {
                console.log(e);
                this.fetchLotStatus = Request.ERROR;
                this.messageError(e);
            }
        },

        /**
         * Fetches a lot.
         *
         * @return     {Promise}  The lot.
         */
        async fetchLot() {
            this.fetchLotStatus = Request.FETCHING;
            await this.LotModel.loadById(this.lotId);
            this.LotModel.cacheOrigin();
            this.fetchLotStatus = Request.SUCCESS;
        },

        /**
         * Shows the popup updating.
         */
        showPopupUpdating() {
            Swal.fire({
                title: MessageConst.MESSAGE_UPDATING,
                onOpen: () => Swal.showLoading(),
            });
        },
    },

    mounted() {},
};
</script>
