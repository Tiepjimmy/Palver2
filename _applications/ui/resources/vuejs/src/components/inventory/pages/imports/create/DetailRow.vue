<template>
    <tr>
        <td>
            <v-icon @click="$emit('remove')"> mdi-delete </v-icon>
        </td>
        <td>{{ idx + 1 }}</td>
        <td>{{ detail.code }}</td>
        <td>{{ detail.name }}</td>
        <td>{{ detail.unit }}</td>
        <td>
            <v-select
                :items="allLots"
                v-model="detail.lot_id"
                item-text="code"
                item-value="id"
                :rules="[required]"
                placeholder="Chọn lô"
                dense
                outlined
                hide-details
            ></v-select>
        </td>
        <td>{{ lotExpired }}</td>
        <td>
            <v-text-field
                class="text-right-input"
                ref="quantity"
                v-model="detail.quantity"
                :rules="[required]"
                placeholder="Số lượng"
                required
                dense
                outlined
                hide-details
                type="number"
            >
            </v-text-field>
        </td>
        <td>{{ detail.price }}</td>
        <td>{{ totalAmount }}</td>
        <td>
            <v-textarea
                outlined
                name="input-7-4"
                placeholder="Vị trí lưu kho"
                v-model="detail.storage_location"
                :rules="[]"
                dense
                outlined
                hide-details
                rows="2"
            ></v-textarea>
        </td>
    </tr>
</template>
<script type="text/javascript">
import { required } from "@/components/inventory/validators/rules/required";

export default {
    name: "DetailRow",
    props: {
        idx: 0,
        detail: {},
        allLots: [],
    },

    data: () => ({
        required,
    }),

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        productID() {
            return this.detail.product_id;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalAmount() {
            return this.detail.price * this.detail.quantity;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        lotExpired() {
            return this.detail.lot_id && this.allLots.find(lot => lot.id == this.detail.lot_id).expired_date;
        },
    },

    methods: {},

    mounted() {},
};
</script>

<style lang="scss"></style>
