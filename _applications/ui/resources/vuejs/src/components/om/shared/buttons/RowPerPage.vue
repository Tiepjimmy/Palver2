<template>
    <v-select
        :items="pages"
        v-model="filter.per_page"
        dense
        outlined
        hide-details
        :style="{ width: 'min-content', 'flex-grow': 'inherit' }"
    ></v-select>
</template>
<script type="text/javascript">
import Filter from '@/components/om/base_filter';
export default {
    name: 'RowPerPage',
    props: {
        filter: Filter,
    },

    data: () => ({
        pages: [10, 20, 50, 100],
    }),

    created() {
        this.filter.per_page = 10;
    },
};
</script>
