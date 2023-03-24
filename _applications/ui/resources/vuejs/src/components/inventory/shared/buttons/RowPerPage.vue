<template>
    <v-select
        :items="pages"
        v-model="filter.limit"
        dense
        outlined
        hide-details
        :style="{ width: 'min-content' }"
    ></v-select>
</template>
<script type="text/javascript">
import Filter from "@/components/inventory/base_filter.js";
export default {
    name: "RowPerPage",
    props: {
        filter: Filter,
    },

    data: () => ({
        pages: [10, 20, 50, 100],
    }),

    created() {
        this.filter.limit = 10;
    },
};
</script>

<style lang="scss"></style>
