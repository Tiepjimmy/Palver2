<template>
    <div>
        <CreateTongCty 
            v-if="currentOwnerShop" 
            @refeshPage="refeshPage" 
            v-bind:accessMedia="accessMedia"
        />
        <CreateChiNhanh
            v-else
            @refeshPage="refeshPage" 
            v-bind:accessMedia="accessMedia"
        />
    </div>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import CreateTongCty from "@/components/account/pages/product/corporations/ProductCreateCombo.vue";
import CreateChiNhanh from "@/components/account/pages/product/branch/ProductCreateCombo.vue";

export default {
    props: {
        currentOwnerShop: Boolean,
        accessMedia: Object
    },
    components: {
        CreateTongCty,
        CreateChiNhanh
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            {title: "Quản lý chuẩn hóa sản phẩm", route: "/account/product"},
            {title: "Thêm mới chuẩn hóa sản phẩm", route: "/account/product/create-combo"}
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