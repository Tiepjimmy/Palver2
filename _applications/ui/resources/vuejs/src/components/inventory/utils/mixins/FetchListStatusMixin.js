import * as Request from "@/components/inventory/utils/Request";
export default {
    data: () => ({
        FETCH_LIST_STATUS: Request.NONE,
    }),

    computed: {
        /**
         * Determines if fetch error.
         *
         * @return     {boolean}  True if fetch error, False otherwise.
         */
        isFetchListError() {
            return this.FETCH_LIST_STATUS === Request.ERROR;
        },

        /**
         * Determines if fetch success.
         *
         * @return     {boolean}  True if fetch success, False otherwise.
         */
        isFetchListSuccess() {
            return this.FETCH_LIST_STATUS === Request.SUCCESS;
        },

        /**
         * Determines if fetching.
         *
         * @return     {boolean}  True if fetching, False otherwise.
         */
        isListFetching() {
            return this.FETCH_LIST_STATUS === Request.FETCHING;
        },
    },

    methods: {
        /**
         * Sets the fetch status error.
         */
        setFetchListStatusError() {
            this.FETCH_LIST_STATUS = Request.ERROR;
        },

        /**
         * Sets the fetch status success.
         */
        setFetchListStatusSuccess() {
            this.FETCH_LIST_STATUS = Request.SUCCESS;
        },

        /**
         * Sets the fetch status fetching.
         */
        setFetchListStatusFetching() {
            this.FETCH_LIST_STATUS = Request.FETCHING;
        },
    },
};
