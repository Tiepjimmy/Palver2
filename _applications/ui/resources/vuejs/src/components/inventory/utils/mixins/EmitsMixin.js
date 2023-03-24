import * as Emits from "@/components/inventory/utils/Emits";
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
        emitCreating() {
            this.$emit(this.EMITS.CREATING);
        },

        /**
         * { function_description }
         */
        emitCreated() {
            this.$emit(this.EMITS.CREATED);
        },

        /**
         * { function_description }
         */
        emitCreateAndContinue() {
            this.$emit(this.EMITS.CREATE_AND_CONTINUE);
        },

        /**
         * { function_description }
         */
        emitReading() {
            this.$emit(this.EMITS.READING);
        },

        /**
         * { function_description }
         */
        emitReaded() {
            this.$emit(this.EMITS.READED);
        },

        /**
         * { function_description }
         */
        emitUpdating() {
            this.$emit(this.EMITS.UPDATING);
        },

        /**
         * { function_description }
         */
        emitUpdated() {
            this.$emit(this.EMITS.UPDATED);
        },

        /**
         * { function_description }
         */
        emitDeleting() {
            this.$emit(this.EMITS.DELETING);
        },

        /**
         * { function_description }
         */
        emitDeleted() {
            this.$emit(this.EMITS.DELETED);
        },

        /**
         * { function_description }
         */
        emitClose() {
            this.$emit(this.EMITS.CLOSE);
        },

        /**
         * { function_description }
         */
        emitCancel() {
            this.$emit(this.EMITS.CANCEL);
        },

        /**
         * { function_description }
         */
        emitError() {
            this.$emit(this.EMITS.ERROR);
        },

        /**
         * { function_description }
         */
        emitSuccess() {
            this.$emit(this.EMITS.SUCCESS);
        },
    },
};
