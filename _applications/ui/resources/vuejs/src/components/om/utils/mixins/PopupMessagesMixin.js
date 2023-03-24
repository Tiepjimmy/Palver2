import Swal from 'sweetalert2';
import * as MessageConst from '@/components/om/utils/MessageConst';

export default {
    methods: {
        /**
         * Shows the popup error.
         *
         * @param      {<type>}  [options={}]  The options
         */
        showPopupConfirm(options = {}) {
            const defaultOptions = {
                title: MessageConst.CONFIRM_TITLE,
                text: MessageConst.CONFIRM_MESSAGE,
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Hủy',
                confirmButtonText: 'Đồng ý',
                allowOutsideClick: false,
                customClass: {
                    title: 'd-inline',
                },
            };

            return Swal.fire(_.assignIn(defaultOptions, options));
        },

        /**
         * Shows the popup error.
         *
         * @param      {<type>}  [options={}]  The options
         */
        showPopupError(options = {}) {
            const defaultOptions = {
                title: MessageConst.ERROR_TITLE,
                text: MessageConst.ERROR_MESSAGE,
                icon: 'error',
            };

            return Swal.fire(_.assignIn(defaultOptions, options));
        },

        /**
         * Shows the popup create error.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupCreateError(options = {}) {
            return this.showPopupError({ text: MessageConst.ERROR_MESSAGE_SAVE, ...options });
        },

        /**
         * Shows the popup fetch error.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupFetchError(options = {}) {
            return this.showPopupError({ text: MessageConst.ERROR_MESSAGE_FETCH, ...options });
        },

        /**
         * Shows the popup update error.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupUpdateError(options = {}) {
            return this.showPopupError({ text: MessageConst.ERROR_MESSAGE_UPDATE, ...options });
        },

        /**
         * Shows the popup delete error.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupDeleteError(options = {}) {
            return this.showPopupError({ text: MessageConst.ERROR_MESSAGE_DELETE, ...options });
        },

        /**
         * Shows the popup error.
         *
         * @param      {<type>}  [options={}]  The options
         */
        showPopupSuccess(options = {}) {
            const defaultOptions = {
                title: MessageConst.SUCCESS_TITLE,
                text: MessageConst.SUCCESS_MESSAGE,
                icon: 'success',
            };

            return Swal.fire(_.assignIn(defaultOptions, options));
        },

        /**
         * Shows the popup create success.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupCreateSuccess(options = {}) {
            return this.showPopupSuccess({ text: MessageConst.SUCCESS_MESSAGE_SAVE, ...options });
        },

        /**
         * Shows the popup fetch success.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupFetchSuccess(options = {}) {
            return this.showPopupSuccess({ text: MessageConst.SUCCESS_MESSAGE_FETCH, ...options });
        },

        /**
         * Shows the popup update success.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupUpdateSuccess(options = {}) {
            return this.showPopupSuccess({ text: MessageConst.SUCCESS_MESSAGE_UPDATE, ...options });
        },

        /**
         * Shows the popup delete success.
         *
         * @param      {<type>}  [options={}]  The options
         * @return     {<type>}  { description_of_the_return_value }
         */
        showPopupDeleteSuccess(options = {}) {
            return this.showPopupSuccess({ text: MessageConst.SUCCESS_MESSAGE_DELETE, ...options });
        },
    },
};
