<template>
    <tr>
        <td>
            <v-menu :offset-x="true">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn dark icon v-bind="attrs" v-on="on">
                        <img src="/media/svg/icons/General/Other1.svg" />
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item @click="onClickEdit">
                        <v-list-item-icon>
                            <v-icon>mdi-pencil</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Sửa</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="onClickDelete">
                        <v-list-item-icon>
                            <v-icon>mdi-delete</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Xóa</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </td>
        <td>
            <a href="#" @click.prevent="onClickEdit">{{ lot.code }}</a>
        </td>
        <td>{{ expiredDateFormatted }}</td>
        <td>{{ statusName }}</td>
        <td>{{ lot.note }}</td>
    </tr>
</template>
<script type="text/javascript">
import DateFormatter from "@/components/inventory/utils/DateFormatter";
export default {
    name: "LotListRow",
    props: {
        lot: {},
    },

    data: () => ({
        items: [
            { icon: "mdi-pencil", text: "Sửa" },
            { icon: "mdi-delete", text: "Xóa" },
        ],
    }),
    computed: {
        /**
         * { function_description }
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        statusName() {
            return this.lot.statusName();
        },

        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        expiredDateFormatted() {
            return DateFormatter["DD/MM/YYYY"](this.lot.expired_date);
        },
    },

    methods: {
        /**
         * Called on click edit.
         */
        onClickEdit() {
            this.$emit("edit:lot", this.lot.id);
        },

        /**
         * Called on click edit.
         */
        onClickDelete() {
            this.$emit("delete:lot", this.lot.id);
        },
    },
};
</script>

<style lang="scss"></style>
