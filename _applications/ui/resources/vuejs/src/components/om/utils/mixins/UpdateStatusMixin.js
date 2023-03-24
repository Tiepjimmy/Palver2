import * as Request from '@/components/om/utils/Request';
export default {
    data: () => ({
        UPDATE_STATUS: Request.NONE,
    }),

    computed: {
        /**
         * Determines if update error.
         *
         * @return     {boolean}  True if update error, False otherwise.
         */
        isUpdateError() {
            return this.UPDATE_STATUS === Request.ERROR;
        },

        /**
         * Determines if update success.
         *
         * @return     {boolean}  True if update success, False otherwise.
         */
        isUpdateSuccess() {
            return this.UPDATE_STATUS === Request.SUCCESS;
        },

        /**
         * Determines if updating.
         *
         * @return     {boolean}  True if updating, False otherwise.
         */
        isUpdating() {
            return this.UPDATE_STATUS === Request.UPDATING;
        },
    },

    methods: {
        /**
         * Sets the create status error.
         */
        setUpdateStatusError() {
            this.UPDATE_STATUS = Request.ERROR;
        },

        /**
         * Sets the create status success.
         */
        setUpdateStatusSuccess() {
            this.UPDATE_STATUS = Request.SUCCESS;
        },

        /**
         * Sets the create status updating.
         */
        setUpdateStatusUpdating() {
            this.UPDATE_STATUS = Request.UPDATING;
        },
    },
};
