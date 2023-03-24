<template>
    <v-card>
        <v-card-title class="text-h5 d-flex">
            <div class="flex-grow-1">Thêm mới lô</div>
            <v-icon medium v-if="showCloseBtn" @click="onCloseClick">close</v-icon>
        </v-card-title>
        <v-card-text>
            <div class="container px-0">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Mã lô (*)</label>
                        <v-text-field placeholder="Mã lô ..." v-model="LotModel.code" dense hide-details outlined>
                        </v-text-field>
                    </div>
                    <div class="col-6 d-flex align-items-end justify-content-end">
                        <expired-at-btn :value="LotModel.expired_date" @update:selected="onUpdateExpiredAt">
                            Ngày hết hạn (*)
                        </expired-at-btn>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Trạng thái (*)</label>
                        <v-select
                            placeholder="Chọn trạng thái"
                            :items="statuses"
                            v-model="LotModel.status"
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
                        <v-textarea rows="2" v-model="LotModel.note" dense hide-details outlined></v-textarea>
                    </div>
                </div>
            </div>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="grey darken-1" text elevation="0" depressed small @click="onResetClick"> Reset </v-btn>
            <v-btn color="orange darken-1 white--text" elevation="0" depressed small @click="onCancelClick">
                Hủy
            </v-btn>
            <v-btn color="blue darken-1 white--text" elevation="0" depressed small @click="onSaveClick"> Lưu </v-btn>
            <v-btn color="blue darken-1 white--text" elevation="0" depressed small @click="onSaveAndContinueClick">
                Lưu và tiếp tục
            </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script type="text/javascript">
import Swal from "sweetalert2";
import { default as ExpiredAtBtn } from "./ExpiredAtBtn";
import EmitsMixin from "@/components/inventory/utils/mixins/EmitsMixin";
import PopupMessagesMixin from "@/components/inventory/utils/mixins/PopupMessagesMixin";
import CreateStatusMixin from "@/components/inventory/utils/mixins/CreateStatusMixin";
import * as Request from "@/components/inventory/utils/Request";
import * as HttpCodes from "@/components/inventory/utils/HttpCodes";

import Collection from "@/core/collection";
import LotModel from "@/models/inventory/common/lot";

export default {
    mixins: [EmitsMixin, PopupMessagesMixin, CreateStatusMixin],
    components: { ExpiredAtBtn },
    data: () => ({
        statuses: [
            { value: "active", name: "Hoạt động" },
            { value: "inactive", name: "Không hoạt động" },
        ],

        LotModel: LotModel,
        storeID: 1,
        expiredBtnMenu: false,
    }),

    props: {
        showCloseBtn: false,
    },

    computed: {},

    watch: {
        /**
         * Saves a status.
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         * @return     {<type>}  { description_of_the_return_value }
         */
        SAVE_STATUS(n, o) {
            if (this.isCreateError) {
                return this.emitError();
            }
        },
    },

    methods: {
        /**
         * Initializes the lot model.
         */
        initLotModel() {
            this.LotModel = new LotModel();
        },

        /**
         * Called on update expired at.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateExpiredAt(val) {
            this.LotModel.expired_date = val;
        },
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
        onCancelClick(event) {
            this.emitCancel();
        },

        /**
         * Called on reset click.
         */
        onResetClick() {
            this.initLotModel();
        },

        /**
         * Called on save click.
         *
         * @param      {<type>}  event   The event
         */
        async onSaveClick(event) {
            try {
                await this.handleSave();

                this.showPopupCreateSuccess({
                    text: "Bạn thêm mới lô thành công",
                    showConfirmButton: false,
                    timer: 1500,
                    onDestroy: () => {
                        this.setCreateStatusSuccess();
                        this.onPopupSuccessDestroy();
                        this.emitCreated();
                    },
                });
            } catch (e) {
                this.setCreateStatusError();
                this.emitError();
                this.messageError(e);
            }
        },

        /**
         * Called on save and continue click.
         *
         * @param      {<type>}  event   The event
         */
        async onSaveAndContinueClick(event) {
            try {
                const response = await this.handleSave();
                if(response.status_code === HttpCodes.HTTP_BAD_REQUEST){
                    return this.validateError(response.errors)
                }

                this.showPopupCreateSuccess({
                    text: "Bạn thêm mới lô thành công",
                    showConfirmButton: false,
                    timer: 1500,
                    onDestroy: () => {
                        this.setCreateStatusSuccess();
                        this.onPopupSuccessDestroy();
                        this.emitCreateAndContinue();
                    },
                });
            } catch (e) {
                this.setCreateStatusError();
                this.emitError();
                this.messageError(e);
            }
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async handleSave() {
            if (this.isCreating) {
                return;
            }

            this.emitCreating();

            return await this.save();
        },

        /**
         * { function_description }
         *
         * @return     {Promise}  { description_of_the_return_value }
         */
        async save() {
            this.setCreateStatusCreating();

            return await this.LotModel.storeAsync();
        },

        /**
         * Called on popup success destroy.
         */
        onPopupSuccessDestroy() {
            this.initLotModel();
        },
    },

    mounted() {
        this.initLotModel();
    },
};
</script>
