<template>
    <tr>
        <td>
            <img
                :style="toggleDetailStyle"
                src="/media/svg/icons/Navigation/Angle-double-right.svg"
                @click="toggleDetail"
            />
        </td>
        <th>
            <v-checkbox
                :value="selectedRow"
                @change="onSelectedChange"
                color="primary"
                class="m-0 p-0"
                hide-details
            ></v-checkbox>
        </th>
        <td>{{ idx + 1 }}</td>
        <td>{{ invoice.code }}</td>
        <td>{{ storeName }}</td>
        <td>{{ warehouseName }}</td>
        <td>{{ statusName }}</td>
        <td>
            {{ totalAmount }}
        </td>
        <td>{{ invoice.created_by }}</td>
        <td>{{ createdAtFormatted }}</td>
        <td>{{ invoice.note }}</td>
    </tr>
</template>
<script type="text/javascript">
import DateFormatter from "@/components/inventory/utils/DateFormatter";
export default {
    name: "TabDefaultRow",
    props: {
        idx: 0,
        invoice: {},
        selectedRow: false,
    },

    data() {
        return {
            openDetail: false,
        };
    },

    methods: {
        /**
         * { function_description }
         */
        toggleDetail() {
            this.openDetail = !this.openDetail;

            this.$emit("toggle-detail", { id: this.invoice.id, open: this.openDetail });
        },

        /**
         * Called on click row checkbox.
         *
         * @param      {<type>}  event   The event
         */
        onSelectedChange(value) {
            this.$emit("update:select-row", { invoice: this.invoice, checked: value });
        },
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        createdAtFormatted() {
            return DateFormatter["DD/MM/YYYY"](this.invoice.expired_date);
        },

        /**
         * Determines if selected row.
         *
         * @return     {boolean}  True if selected row, False otherwise.
         */
        isSelectedRow() {
            return this.selectedRow;
        },
        /**
         * { function_description }
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        toggleDetailStyle() {
            return {
                cursor: "pointer",
                transition: "all 0.25s ease-in-out",
                transform: this.openDetail ? "rotate(90deg)" : "initial",
            };
        },

        /**
         * Stores a name.
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        storeName() {
            return this.invoice.store?.store_name;
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        warehouseName() {
            return this.invoice.warehouse?.warehouse_name;
        },

        /**
         * { function_description }
         *
         * @return     {Array}  { description_of_the_return_value }
         */
        statusName() {
            return this.invoice.statusName();
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalAmount() {
            return this.invoice.details.reduce(function (res, detail) {
                return (res += detail.price * detail.quantity);
            }, 0);
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        lotExpired() {
            return this.invoice.lot.expired_date;
        },
    },
};
</script>

<style lang="scss"></style>
