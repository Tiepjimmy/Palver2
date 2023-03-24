<template>
    <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        :return-value.sync="selected"
        transition="scale-transition"
        offset-y
        min-width="auto"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" :color="btnColor" depressed>
                <slot>Lọc</slot> <v-icon right> mdi-filter</v-icon>
            </v-btn>
        </template>

        <v-list flat dense subheader>
            <v-list-item v-if="searchable">
                <v-list-item-content>
                    <v-text-field v-model="search" placeholder="Tìm kiếm" dense hide-details outlined></v-text-field>
                </v-list-item-content>
            </v-list-item>

            <v-list-item-group v-model="selected" multiple>
                <v-list-item v-for="(itemName, i) in items" :key="i" :value="i" v-show="canItemShow(itemName)">
                    <template v-slot:default="{ active }">
                        <v-list-item-action>
                            <v-checkbox :input-value="active" color="primary"></v-checkbox>
                        </v-list-item-action>

                        <v-list-item-content>
                            <v-list-item-title>{{ itemName }}</v-list-item-title>
                        </v-list-item-content>
                    </template>
                </v-list-item>
            </v-list-item-group>

            <v-list-item>
                <v-list-item-content>
                    <div class="d-flex justify-content-between">
                        <v-btn text color="primary" depressed small @click="onClickBtnClearAll">Xóa</v-btn>
                        <v-btn color="primary" depressed small @click="onClickBtnApply">Đồng ý</v-btn>
                    </div>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script type="text/javascript">
import { mapGetters, mapState, mapActions } from "vuex";
import { UPDATE_FILTER } from "@/store/inventory/export/goods-issue/index/action-const";

export default {
    name: "FilterStoresBtn",
    props: {
        searchable: false,
        items: {},
    },

    data: () => ({
        search: "",

        menu: false,
        tmp: [],
    }),

    computed: {
        selected: {
            set(val) {
                this.tmp = val;
            },

            get(val) {
                return this.tmp || [];
            },
        },

        /**
         * Color Binding
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        btnColor() {
            return this.selected.length ? "primary" : "grey--text";
        },
    },

    methods: {
        ...mapActions("inventory/export/goods_issue/index", {
            UPDATE_FILTER,
        }),

        /**
         * Determines ability to item show.
         *
         * @param      {string}   itemName  The provider name
         * @return     {boolean}  True if able to item show, False otherwise.
         */
        canItemShow(itemName) {
            return !this.search || itemName.match(new RegExp(this.search, "gi"));
        },

        /**
         * Called on click clear all.
         */
        onClickBtnClearAll() {
            this.selected.splice(0, this.selected.length);
            this.onClickBtnApply();
        },

        /**
         * Called on click apply.
         */
        onClickBtnApply() {
            this.$refs.menu.save(this.selected);
            this.$emit("update:selected", this.selected);
        },
    },

    created() {
        return (this.tmp = Array.isArray(this.value) ? [...this.value] : []);
    },
};
</script>
