import * as Emits from '@/components/om/utils/Emits';
export default {
    computed: {
        EMITS() {
            return Emits;
        },
    },

    methods: {
        /**
         * { function_description }
         */
        emitCreating(params) {
            this.$emit(this.EMITS.CREATING, params);
        },

        /**
         * { function_description }
         */
        emitCreated(params) {
            this.$emit(this.EMITS.CREATED, params);
        },

        /**
         * { function_description }
         */
        emitCreateAndContinue(params) {
            this.$emit(this.EMITS.CREATE_AND_CONTINUE, params);
        },

        /**
         * { function_description }
         */
        emitReading(params) {
            this.$emit(this.EMITS.READING, params);
        },

        /**
         * { function_description }
         */
        emitReaded(params) {
            this.$emit(this.EMITS.READED, params);
        },

        /**
         * { function_description }
         */
        emitUpdating(params) {
            this.$emit(this.EMITS.UPDATING, params);
        },

        /**
         * { function_description }
         */
        emitUpdated(params) {
            this.$emit(this.EMITS.UPDATED, params);
        },

        /**
         * { function_description }
         */
        emitDeleting(params) {
            this.$emit(this.EMITS.DELETING, params);
        },

        /**
         * { function_description }
         */
        emitDeleted(params) {
            this.$emit(this.EMITS.DELETED, params);
        },

        /**
         * { function_description }
         */
        emitClose(params) {
            this.$emit(this.EMITS.CLOSE, params);
        },

        /**
         * { function_description }
         */
        emitCancel(params) {
            this.$emit(this.EMITS.CANCEL, params);
        },

        /**
         * { function_description }
         */
        emitError(params) {
            this.$emit(this.EMITS.ERROR, params);
        },

        /**
         * { function_description }
         */
        emitSuccess(params) {
            this.$emit(this.EMITS.SUCCESS, params);
        },

        /**
         * { function_description }
         */
        emitClickUpdate(params) {
            this.$emit(this.EMITS.CLICK_UPDATE, params);
        },

        /**
         * { function_description }
         */
        emitClickDelete(params) {
            this.$emit(this.EMITS.CLICK_DELETE, params);
        },

        /**
         * { function_description }
         */
        emitClickRow(params) {
            this.$emit(this.EMITS.CLICK_ROW, params);
        },
    },
};
