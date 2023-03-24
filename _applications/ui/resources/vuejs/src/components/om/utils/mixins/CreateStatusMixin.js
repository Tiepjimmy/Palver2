import * as Request from '@/components/om/utils/Request';
export default {
    data: () => ({
        CREATE_STATUS: Request.NONE,
    }),

    computed: {
        /**
         * Determines if create error.
         *
         * @return     {boolean}  True if create error, False otherwise.
         */
        isCreateError() {
            return this.CREATE_STATUS === Request.ERROR;
        },

        /**
         * Determines if create success.
         *
         * @return     {boolean}  True if create success, False otherwise.
         */
        isCreateSuccess() {
            return this.CREATE_STATUS === Request.SUCCESS;
        },

        /**
         * Determines if creating.
         *
         * @return     {boolean}  True if creating, False otherwise.
         */
        isCreating() {
            return this.CREATE_STATUS === Request.CREATING;
        },
    },

    methods: {
        /**
         * Sets the create status error.
         */
        setCreateStatusError() {
            this.CREATE_STATUS = Request.ERROR;
        },

        /**
         * Sets the create status success.
         */
        setCreateStatusSuccess() {
            this.CREATE_STATUS = Request.SUCCESS;
        },

        /**
         * Sets the create status saving.
         */
        setCreateStatusCreating() {
            this.CREATE_STATUS = Request.CREATING;
        },
    },
};
