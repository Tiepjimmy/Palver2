<template>
    <!-- thong tin khac -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin khác </v-card-title>

        <v-card-text>
            <div class="form-group">
                <label>Ghi chú</label>
                <textarea v-model="note" class="form-control form-control-sm"></textarea>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import * as actions from '@/store/inventory/export/goods-issue/create/action-const';

export default {
    name: 'NoteBlock',
    data: () => ({}),

    computed: {
        ...mapState('inventory/export/goods_issue/create', {
            model: state => state.model,
        }),

        note: {
            set(value) {
                this.UPDATE_MODEL({ key: 'note', value: value });
            },

            get() {
                return this.model.note;
            },
        },
    },

    watch: {},

    methods: {
        ...mapActions('inventory/export/goods_issue/create', {
            UPDATE_MODEL: actions.UPDATE_MODEL,
        }),
    },

    mounted() {},
};
</script>

<style></style>
