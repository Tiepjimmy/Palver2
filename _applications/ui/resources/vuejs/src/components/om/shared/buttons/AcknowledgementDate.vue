<template>
    <v-menu ref="menu" v-model="menu" :close-on-content-click="false" transition="scale-transition" offset-y>
        <template v-slot:activator="{ on, attrs }">
            <v-text-field
                v-model="dateFormatted"
                v-bind="$attrs"
                v-on="on"
                :rules="rulesComputed"
                :disabled="isReadonlyPanel"
            ></v-text-field>
        </template>
        <v-date-picker v-model="datePickerModel" no-title :readonly="isReadonlyPanel"></v-date-picker>
    </v-menu>
</template>

<script type="text/javascript">
import moment from 'moment';

const VALID_FORMAT = 'D/M/YYYY HH:mm:ss';
const DATE_PICKER_FORMAT = 'YYYY-MM-DD';
export default {
    name: 'AcknowledgementDate',

    props: {
        value: null,
        disabled: false,
    },

    data: () => ({
        menu: false,
        tmp: '',
        rules: [v => moment(v, VALID_FORMAT, true).isValid() || 'Ngày ghi nhận không hợp lệ'],
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {Array}  { description_of_the_return_value }
         */
        rulesComputed() {
            return [...this.rules, ...(this.$attrs['rules'] || [])];
        },

        /**
         * Determines if readonly panel.
         *
         * @return     {boolean}  True if readonly panel, False otherwise.
         */
        isReadonlyPanel() {
            return (
                !_.isEmpty(this.$attrs['readonly-panel']) ||
                (this.$attrs['readonly-panel'] && this.$attrs['readonly-panel'] !== false)
            );
        },

        /**
         * Determines if empty.
         */
        isEmpty() {
            return !this.tmp.length;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        tmpFormated() {
            return this.tmp.format(VALID_FORMAT);
        },

        datePickerModel: {
            set(value) {
                const newTime = this.tmpFormated.replace(
                    /\d{1,2}\/\d{1,2}\/\d{4}\s(.+)/,
                    moment(value).format('M/D/YYYY') + ' $1'
                );
                this.setTmp(moment(newTime));
            },

            get() {
                return this.tmp.format(DATE_PICKER_FORMAT);
            },
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        dateFormatted: {
            get() {
                return moment(this.tmp).format(VALID_FORMAT);
            },
            set(val) {
                const time = moment(val, VALID_FORMAT, true);
                if (time.isValid()) {
                    this.setTmp(time);
                }
            },
        },
    },

    watch: {
        value: {
            immediate: true,
            handler(n, o) {
                const m = moment(n, VALID_FORMAT, true);

                if (m.isValid()) {
                    return this.setTmp(m);
                }

                if (!this.tmp) {
                    return this.setTmp(moment());
                }
            },
        },
    },

    methods: {
        setTmp(val) {
            this.tmp = val;
            this.$emit('input', this.tmpFormated);
        },
    },
};
</script>
