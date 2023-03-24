<template>
    <tr>
        <td>{{ stt }}</td>
        <td>{{ model.type_code }}</td>
        <td>{{ model.type_name }}</td>
        <td>
            <v-icon small v-if="isAccounting">check_circle</v-icon>
        </td>
        <td>
            <v-icon small v-if="isActive">check_circle</v-icon>
        </td>
        <td>
            {{ model.note }}
        </td>
        <td>
            {{ createdAtFormatted }}
        </td>
        <td>
            {{ updatedAtFormatted }}
        </td>
        <td>
            <button class="px-1" @click.stop="onClickBtnEdit">
                <v-icon small>mdi-pencil</v-icon>
            </button>
            <button class="px-1" @click="onClickBtnRemove">
                <v-icon small>mdi-delete</v-icon>
            </button>
        </td>
    </tr>
</template>
<script type="text/javascript">
import moment from 'moment';
import * as EMITS from '@/components/om/utils/Emits';
import TypeCollectVouchers from '@/models/type-collect-vouchers/type_collect_vouchers';

export default {
    name: 'IndexTableRow',
    props: {
        idx: 0,
        model: TypeCollectVouchers,
    },

    computed: {
        /**
         * Determines if default.
         *
         * @return     {boolean}  True if default, False otherwise.
         */
        isAccounting() {
            return this.model.is_business_result;
        },

        /**
         * Determines if active.
         *
         * @return     {boolean}  True if active, False otherwise.
         */
        isActive() {
            return this.model.is_active;
        },

        /**
         * { function_description }
         *
         * @return
         */
        stt() {
            return this.idx + 1;
        },

        /**
         * { function_description }
         *
         * @return
         */
        createdAtFormatted() {
            return moment(this.model.created_at).format('DD/MM/YYYY hh:mm:ss');
        },

        /**
         * { function_description }
         *
         * @return
         */
        updatedAtFormatted() {
            return this.model.updated_at ? moment(this.model.updated_at).format('DD/MM/YYYY hh:mm:ss') : '';
        },
    },

    methods: {
        /**
         * Called on click button edit.
         */
        onClickBtnEdit() {
            this.$emit(EMITS.CLICK_UPDATE, this.idx);
        },

        /**
         * Called on click button remove.
         */
        onClickBtnRemove() {
            this.$emit(EMITS.CLICK_DELETE, this.idx);
        },
    },
};
</script>

<style lang="scss"></style>
