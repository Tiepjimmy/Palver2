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
                            disabled
                            dense
                            hide-details
                            outlined
                        >
                        </v-text-field>
                    </div>
                    <div class="col-6 d-flex align-items-end justify-content-end">
                        <expired-at-btn
                            disabled
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
                            disabled
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
                        <v-textarea rows="2" v-model="LotModel.note" dense hide-details outlined disabled> </v-textarea>
                    </div>
                </div>
            </div>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="onUpdateBtnClick" :disabled="!canSave"> Sửa </v-btn>
        </v-card-actions>
    </v-card>
</template>
<script type="text/javascript">
import Swal from "sweetalert2";
import { default as ExpiredAtBtn } from "./ExpiredAtBtn";
import * as MessageConst from "@/components/inventory/utils/MessageConst";
import * as Request from "@/components/inventory/utils/Request";

import Collection from "@/core/collection";
import LotModel from "@/models/inventory/common/lot";

export default {
    components: { ExpiredAtBtn },
    data: () => ({}),

    props: {
        showCloseBtn: false,
        lot: LotModel,
    },

    computed: {},

    watch: {},

    methods: {},

    mounted() {},
};
</script>
