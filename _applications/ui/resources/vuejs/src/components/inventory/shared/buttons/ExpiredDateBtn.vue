<template>
    <!-- Bộ lọc ngày tạo -->
    <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        :return-value.sync="expired_date"
        transition="scale-transition"
        offset-y
        min-width="auto"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" :color="btnColor" depressed :disabled="disabled">
                <template v-if="isEmpty"> <slot>Ngày hết hạn</slot> </template>
                <template v-else-if="isArray">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-start">
                            <span v-if="isSelectedRange" class="flex-grow-1 text-end">Từ:</span
                            ><b>{{ fromFormatted }}</b>
                        </div>
                        <div class="d-flex justify-content-start">
                            <span v-if="isSelectedRange" class="flex-grow-1 text-end">Đến:</span
                            ><b>{{ toFormatted }}</b>
                        </div>
                    </div>
                </template>
                <template v-else> {{ expiredDateFromatted }} </template>
                <v-icon right> mdi-calendar-month-outline </v-icon>
            </v-btn>
        </template>
        <v-date-picker v-model="expired_date" :range="range" :multiple="multiple" no-title scrollable>
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="onClickBtnClearAll"> Xóa </v-btn>
            <v-btn color="primary" @click="onClickBtnApply"> Đồng ý </v-btn>
        </v-date-picker>
    </v-menu>
</template>

<script type="text/javascript">
import DateFormatter from '@/components/inventory/utils/DateFormatter';
const DEFAULT_STRING = '';
const DEFAULT_ARRAY = [];
export default {
    name: 'ExpiredDateBtn',

    props: {
        value: null,
        range: false,
        multiple: false,
        disabled: false,
    },

    data: () => ({
        menu: false,
        tmp: null,
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        expired_date: {
            set(value) {
                this.tmp = value;
                console.log(this.isSelectedRange);
                this.isSelectedRange &&
                    this.tmp.sort((a, b) => (new Date(a).getTime() > new Date(b).getTime() ? 1 : -1));
            },

            get() {
                return this.tmp || this.defaultValue;
            },
        },

        /**
         * Color Binding
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        btnColor() {
            return this.expired_date.length ? 'primary' : 'grey--text';
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        defaultValue() {
            return this.range || this.multiple ? DEFAULT_ARRAY : DEFAULT_STRING;
        },

        /**
         * Determines if empty.
         */
        isEmpty() {
            return !this.expired_date.length;
        },

        /**
         * Determines if array.
         */
        isArray() {
            return Array.isArray(this.expired_date);
        },

        /**
         * Determines if selected range.
         *
         * @return     {boolean}  True if selected range, False otherwise.
         */
        isSelectedRange() {
            return this.range && this.isArray && this.expired_date.length > 1;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        from() {
            return _.first(this.expired_date);
        },

        /**
         * Returns an item representation of the object.
         *
         * @return     {<type>}  representation of the object.
         */
        to() {
            return this.isSelectedRange ? _.last(this.expired_date) : '';
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        fromFormatted() {
            return this.formatDate(this.from);
        },

        /**
         * Returns a formatted representation of the object.
         *
         * @return     {<type>}  Formatted representation of the object.
         */
        toFormatted() {
            return this.formatDate(this.to);
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        expiredDateFromatted() {
            return DateFormatter['DD/MM/YYYY'](this.expired_date);
        },
    },

    watch: {
        value: {
            immediate: true,
            handler(n, o) {
                if (n) {
                    return (this.tmp = this.isArray ? [...n] : n);
                }

                return (this.tmp = this.defaultValue);
            },
        },
    },
    methods: {
        /**
         * { function_description }
         *
         * @param      {<type>}  date    The date
         * @return     {<type>}  { description_of_the_return_value }
         */
        formatDate(date) {
            if (!date) return null;

            const [year, month, day] = date.split('-');
            return `${day}/${month}/${year}`;
        },

        /**
         * Called on click clear all.
         */
        onClickBtnClearAll() {
            this.clearExpiredAt();
            this.onClickBtnApply();
        },

        /**
         * Làm rỗng thuộc tính expired_date từ model
         */
        clearExpiredAt() {
            if (this.isArray) {
                return this.tmp.splice(0, this.tmp.length);
            }

            this.tmp = '';
        },

        /**
         * Called on click apply.
         */
        onClickBtnApply() {
            this.$refs.menu.save(this.tmp);
            this.$emit('update:selected', this.tmp);
        },
    },
};
</script>
