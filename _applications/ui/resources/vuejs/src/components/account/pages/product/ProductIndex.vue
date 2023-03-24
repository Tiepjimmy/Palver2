<template>
    <div>
        <IndexTongCty v-if="currentOwnerShop" @updateExportUrl="updateExportUrl" />
        <IndexChiNhanh v-else @updateExportUrl="updateExportUrl" />
        <Single v-bind:currentOwnerShop="currentOwnerShop" />
        <Combo v-bind:currentOwnerShop="currentOwnerShop" />
    </div>
</template>

<script>
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import {SET_ACTION} from "@/core/services/store/breadcrumbs.module";
import IndexTongCty from "@/components/account/pages/product/corporations/ProductIndex.vue";
import IndexChiNhanh from "@/components/account/pages/product/branch/ProductIndex.vue";
import Single from "@/components/account/pages/product/modal/Single.vue";
import Combo from "@/components/account/pages/product/modal/Combo.vue";

export default {
    props: {
        currentOwnerShop: Boolean
    },
    components: {
        IndexTongCty,
        IndexChiNhanh,
        Single,
        Combo
    },
    mounted() {
        this.$store.dispatch(SET_BREADCRUMB, [
            {title: "Quản lý chuẩn hóa sản phẩm", route: "/account/product"}
        ]);
        this.setAction('');
    },
    methods: {
        updateExportUrl: function(url) {
            this.setAction(url);
        },
        setAction:function (url) {
            this.$store.dispatch(SET_ACTION, [
                {type: "link", param: "/account/product/create", text: 'Thêm mới sp đơn'},
                {type: "link", param: "/account/product/create-combo", text: 'Thêm mới combo'},
                {type: "modal-dropdown", param: [
                    {param: "modal_import_product_single", text: 'Nhập file sản phẩm đơn'},
                    {param: "modal_import_product_combo", text: 'Nhập file sản phẩm combo'}
                ], text: 'Nhập file'},
                {type: "href", param: "/export-product" + url, text: 'Xuất file'}
            ]);
        }
    }
}
</script>