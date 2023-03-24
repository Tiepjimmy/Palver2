<template>
    <!-- Bộ lọc nhà cung cấp -->
    <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        min-width="auto"
    >
        <template v-slot:activator="{ on, attrs }">
            <button :class="btnClass" v-bind="attrs" v-on="on">
                Nhà cung cấp <v-icon right> mdi-filter</v-icon>
            </button>
        </template>

        <v-list flat dense subheader>
            <v-list-item>
                <v-list-item-content>
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" v-model="search" />
                    </div>
                </v-list-item-content>
            </v-list-item>

            <v-list-item-group v-model="selected" multiple>
                <v-list-item v-for="(statusName, i) in providers" :key="i" :value="i" v-show="canItemShow(statusName)">
                    <template v-slot:default="{ active }">
                        <v-list-item-action>
                            <v-checkbox :input-value="active" color="primary"></v-checkbox>
                        </v-list-item-action>

                        <v-list-item-content>
                            <v-list-item-title>{{ statusName }}</v-list-item-title>
                        </v-list-item-content>
                    </template>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-menu>
</template>

<script type="text/javascript">
import { mapGetters, mapState, mapActions } from "vuex";
import { UPDATE_FILTER } from "@/store/inventory/export/goods-issue/index/action-const";

export default {
    name: "FilterProvidersBtn",
    props: {
        providers: {},
    },

    data() {
        return {
            search: "",

            menu: false,
            selected: [],
        };
    },

    methods: {
        ...mapActions("inventory/export/goods_issue/index", {
            UPDATE_FILTER,
        }),

        /**
         * Determines ability to item show.
         *
         * @param      {string}   statusName  The provider name
         * @return     {boolean}  True if able to item show, False otherwise.
         */
        canItemShow(statusName) {
            return !this.search || statusName.match(new RegExp(this.search, "gi"));
        },
    },

    watch: {
        /**
         * { function_description }
         *
         * @param      {<type>}  n       { parameter_description }
         * @param      {<type>}  o       { parameter_description }
         */
        selected(n, o) {
            this.UPDATE_FILTER({ key: "statuses", value: Object.assign([], this.selected) });
        },
    },

    computed: {
        /**
         * Class Binding
         *
         * @return     {Object}  { description_of_the_return_value }
         */
        btnClass() {
            return {
                btn: true,
                "btn-sm": true,
                "btn-primary": this.selected.length,
                "btn-light-primary": !this.selected.length,
                "font-weight-bold": true,
                "font-size-base": true,
                "text-uppercase": true,
                "ml-3": true,
            };
        },
    },
};
</script>
