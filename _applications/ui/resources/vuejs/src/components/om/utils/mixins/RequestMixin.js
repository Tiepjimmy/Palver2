import * as Request from '@/components/om/utils/Request';
import * as HttpCodes from '@/components/om/utils/HttpCodes';
export default {
    computed: {},

    methods: {
        /**
         * { function_description }
         *
         * @param      {<type>}  response  The response
         * @return     {<type>}  { description_of_the_return_value }
         */
        responseOk(response) {
            return response && response.status_code === HttpCodes.HTTP_OK && response.success == true;
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  response  The response
         * @return     {<type>}  { description_of_the_return_value }
         */
        responseFail(response) {
            return !this.responseOK();
        },
    },
};
