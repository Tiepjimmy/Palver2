<template>
    <div>
        <EditTongCty 
            v-if="currentOwnerShop"
            v-bind:id="this.$route.params.id"
            v-bind:accessMedia="accessMedia"
            @refeshPage="refeshPage"
        />
        <EditChiNhanh
            v-else
            v-bind:id="this.$route.params.id"
            v-bind:accessMedia="accessMedia"
            @refeshPage="refeshPage"
        />
    </div>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import EditTongCty from "@/components/account/pages/product/corporations/ProductEdit.vue";
import EditChiNhanh from "@/components/account/pages/product/branch/ProductEdit.vue";

export default {
    props: {
        currentOwnerShop: Boolean,
        accessMedia: Object
    },
    components: {
        EditTongCty,
        EditChiNhanh
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            {title: "Quản lý chuẩn hóa sản phẩm", route: "/account/product"},
            {title: "Cập nhật sản phẩm", route: `/account/product/edit/${this.$route.params.id}`}
        ]);
        this.$store.dispatch(SET_ACTION, []);
    },
    methods: {
        refeshPage() {
            this.$router.push({ name: "product" });
        }
    }
}
</script>
