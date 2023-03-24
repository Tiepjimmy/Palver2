<template>
    <div>
        <ShowTongCty 
            v-if="currentOwnerShop"
            v-bind:id="this.$route.params.id"
        />
        <ShowChiNhanh 
            v-else
            v-bind:id="this.$route.params.id"
        />
    </div>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import ShowTongCty from "@/components/account/pages/product/corporations/ProductShow.vue";
import ShowChiNhanh from "@/components/account/pages/product/branch/ProductShow.vue";

export default {
    props: {
        currentOwnerShop: Boolean
    },
    components: {
        ShowTongCty,
        ShowChiNhanh
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            {title: "Quản lý chuẩn hóa sản phẩm", route: "/account/product"},
            {title: "Chi tiết sản phẩm", route: `/account/product/show/${this.$route.params.id}`}
        ]);
        this.$store.dispatch(SET_ACTION, []);
    }
}
</script>