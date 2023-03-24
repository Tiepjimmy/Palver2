<template>
    <div class="card-header">
        <v-stepper alt-labels :elevation="0" class="flex-grow-1">
            <v-stepper-header>
                <v-stepper-step step="1"> Tạo phiếu </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="2"> Duyệt phiếu </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="3"> Đóng hàng </v-stepper-step>
                <v-divider></v-divider>

                <v-stepper-step step="4"> Xuất kho </v-stepper-step>
                <v-divider></v-divider>
            </v-stepper-header>
        </v-stepper>
    </div>
</template>
<script type="text/javascript">
import { default as StepCancel } from './StepCancel';

export default {
    name: 'StepCreate',
};
</script>

<style></style>
