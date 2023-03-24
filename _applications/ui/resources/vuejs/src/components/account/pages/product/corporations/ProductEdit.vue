<template>
    <div>
        <SanPhamDon 
            v-if="sanPham.product_type == 'single'"
            v-bind:danhMuc="danhMuc"
            v-bind:donViKhoiLuong="donViKhoiLuong"
            v-bind:providers="providers"
            v-bind:sanPham="sanPham"
            v-bind:accessMedia="accessMedia"
            @refeshPage="refeshPage"
        />
        <SanPhamCombo 
            v-else-if="sanPham.product_type == 'combo'"
            v-bind:danhMuc="danhMuc"
            v-bind:donViKhoiLuong="donViKhoiLuong"
            v-bind:providers="providers"
            v-bind:sanPham="sanPham"
            v-bind:accessMedia="accessMedia"
            @refeshPage="refeshPage"
        />
    </div>
</template>

<script>
import SanPhamDon from "@/components/account/pages/product/corporations/edit/ProductSingle.vue";
import SanPhamCombo from "@/components/account/pages/product/corporations/edit/ProductCombo.vue";
import axios from "axios";

export default {
    data() {
        return {
            sanPham: {},
            danhMuc: [],
            donViKhoiLuong: [],
            providers: []
        }
    },
    props: {
        id: String,
        accessMedia: Object
    },
    components: {
        SanPhamDon,
        SanPhamCombo
    },
    mounted() {
        axios.get("/proxy/account/v1/san-pham/create")
            .then(response => {
                this.danhMuc = response.data.data.product_catalog;
                this.donViKhoiLuong = response.data.data.volume_unit;
                this.providers = response.data.data.providers;
                axios.get(`/proxy/account/v1/san-pham/${this.id}`)
                    .then(response => {
                        this.sanPham = response.data.data;
                    })
                    .catch(error => console.log(error))
            })
            .catch(error => console.log(error))
    },
    methods: {
        refeshPage() {
            this.$emit('refeshPage');
        }
    }
}
</script>