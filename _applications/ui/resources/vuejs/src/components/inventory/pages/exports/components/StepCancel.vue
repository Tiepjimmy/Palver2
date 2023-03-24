<template>
    <v-stepper-step :step="step" :rules="[() => false]" complete> Hủy phiếu </v-stepper-step>
</template>
<script type="text/javascript">
export default {
    name: 'StepCancel',

    props: {
        step: Number,
    },
};
</script>

<style></style>
