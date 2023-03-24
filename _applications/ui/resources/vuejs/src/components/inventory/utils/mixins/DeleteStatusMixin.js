import * as Request from "@/components/inventory/utils/Request";
export default {
    data: () => ({
        DELETE_STATUS: Request.NONE,
    }),

    computed: {
        /**
         * Determines if delete error.
         *
         * @return     {boolean}  True if delete error, False otherwise.
         */
        isDeleteError() {
            return this.DELETE_STATUS === Request.ERROR;
        },

        /**
         * Determines if delete success.
         *
         * @return     {boolean}  True if delete success, False otherwise.
         */
        isDeleteSuccess() {
            return this.DELETE_STATUS === Request.SUCCESS;
        },

        /**
         * Determines if deleting.
         *
         * @return     {boolean}  True if deleting, False otherwise.
         */
        isDeleting() {
            return this.DELETE_STATUS === Request.DELETING;
        },
    },

    methods: {
        /**
         * Sets the delete status error.
         */
        setDeleteStatusError() {
            this.DELETE_STATUS = Request.ERROR;
        },

        /**
         * Sets the delete status success.
         */
        setDeleteStatusSuccess() {
            this.DELETE_STATUS = Request.SUCCESS;
        },

        /**
         * Sets the delete status deleting.
         */
        setDeleteStatusDeleting() {
            this.DELETE_STATUS = Request.DELETING;
        },
    },
};
