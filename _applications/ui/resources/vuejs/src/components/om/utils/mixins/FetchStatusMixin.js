import * as Request from '@/components/om/utils/Request';
export default {
    data: () => ({
        FETCH_STATUS: Request.NONE,
    }),

    computed: {
        /**
         * Determines if fetch error.
         *
         * @return     {boolean}  True if fetch error, False otherwise.
         */
        isFetchError() {
            return this.FETCH_STATUS === Request.ERROR;
        },

        /**
         * Determines if fetch success.
         *
         * @return     {boolean}  True if fetch success, False otherwise.
         */
        isFetchSuccess() {
            return this.FETCH_STATUS === Request.SUCCESS;
        },

        /**
         * Determines if fetching.
         *
         * @return     {boolean}  True if fetching, False otherwise.
         */
        isFetching() {
            return this.FETCH_STATUS === Request.FETCHING;
        },
    },

    methods: {
        /**
         * Sets the fetch status error.
         */
        setFetchStatusError() {
            this.FETCH_STATUS = Request.ERROR;
        },

        /**
         * Sets the fetch status success.
         */
        setFetchStatusSuccess() {
            this.FETCH_STATUS = Request.SUCCESS;
        },

        /**
         * Sets the fetch status fetching.
         */
        setFetchStatusFetching() {
            this.FETCH_STATUS = Request.FETCHING;
        },
    },
};
