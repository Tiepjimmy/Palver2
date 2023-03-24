<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <filter-keyword-bar
                    v-model="filter.keyword"
                    placeholder="Nhập lô để tìm kiếm"
                    aria-label="Nhập lô để tìm kiếm"
                    hide-details
                    outlined
                    dense
                ></filter-keyword-bar>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Bộ lọc ngày tạo -->
                <filter-expired-date-btn
                    :value="filter.expired_date"
                    :multiple="true"
                    @update:selected="onUpdateExpiredDate"
                ></filter-expired-date-btn>

                <!-- Bộ lọc loại phiếu -->
                <filter-statuses-btn @update:selected="onUpdateStatuses"></filter-statuses-btn>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import Filter from '@/components/inventory/base_filter.js';
import { default as FilterKeywordBar } from './FilterKeywordBar';
import { default as FilterExpiredDateBtn } from './FilterExpiredDateBtn';
import { default as FilterStatusesBtn } from './FilterStatusesBtn';

export default {
    name: 'InventoryGoodsReceiptIndex',

    components: {
        FilterKeywordBar,
        FilterExpiredDateBtn,
        FilterStatusesBtn,
    },

    props: {
        loading: false,
        filter: new Filter(),
    },

    data: () => ({
        multiple: false,
        range: true,
    }),

    computed: {
        /**
         * Determines if multiple.
         *
         * @return     {boolean}  True if multiple, False otherwise.
         */
        isMultiple() {
            return !this.range && this.isMultiple;
        },
    },

    methods: {
        /**
         * Called on update expired at.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateExpiredDate(val) {
            this.resetPage();

            if (this.range) {
                this.$set(this.filter, 'expired_date', null);
                this.$set(this.filter, 'expired_date_from', _.first(val) || '');
                return this.$set(this.filter, 'expired_date_to', _.last(val) || '');
            }

            return this.$set(this.filter, 'expired_date', val);
        },

        /**
         * Called on update statuses.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateStatuses(val) {
            this.resetPage();
            this.$set(this.filter, 'statuses', val);
        },

        /**
         * Called on update statuses.
         *
         * @param      {<type>}  val     The value
         */
        onUpdateKeyword(val) {
            this.resetPage();
            this.$set(this.filter, 'keyword', val);
        },

        /**
         * { function_description }
         */
        resetPage() {
            this.filter.p = 1;
        },
    },
};
</script>
