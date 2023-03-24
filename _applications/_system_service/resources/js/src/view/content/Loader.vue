<template>
    <!-- begin::Page loader -->
    <div class="page-loader page-loader-logo">
        <img alt="Logo" :src="logo" width="100" />
        <div class="spinner" v-bind:class="spinnerClass || 'spinner-primary'"></div>
        <div class="container-fluid px-2 ">
            <div class="col-12 text-center text-light">{{message}}</div>
        </div>
    </div>
    <!-- end::Page Loader -->
</template>

<script>
export default {
  name: "Loader",
  props: {
    logo: String,
    spinnerClass: String,
    message: String
  }
};
</script>
