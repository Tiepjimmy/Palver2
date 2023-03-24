<template>
    <!-- thong tin nha cung cap -->
    <v-card outlined>
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin nhà cung cấp </v-card-title>

        <v-card-text>
            <div class="provider-wrapper">
                <div class="text-h5">{{ provider.provider_name }}</div>
                <div class="">
                    Địa chỉ: <b>{{ provider.address }}</b>
                </div>
                <div class="">
                    SDT: <b>{{ provider.phone }}</b>
                </div>
                <div class="">
                    Email: <b>{{ provider.email }}</b>
                </div>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
export default {
    name: 'ProviderBlock',
    props: {
        detail: {},
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        provider() {
            return this.detail.provider || {};
        },
    },
};
</script>

<style lang="scss"></style>
