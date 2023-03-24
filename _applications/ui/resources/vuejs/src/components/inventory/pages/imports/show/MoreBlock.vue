<template>
    <!-- thong tin khacs -->
    <v-card outlined class="mt-3">
        <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin khác </v-card-title>
        <v-card-text>
            <div class="form-group m-0">
                <label>Ghi chú</label>
                <v-textarea
                    :value="detail.note"
                    disabled
                    dense
                    outlined
                    hide-details
                    class="blue-grey lighten-5"
                    rows="2"
                >
                </v-textarea>
            </div>
        </v-card-text>
    </v-card>
</template>
<script type="text/javascript">
export default {
    name: "MoreBlock",
    props: {
        detail: {},
    },
};
</script>

<style lang="scss"></style>
