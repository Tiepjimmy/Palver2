<template>
    <!-- Bộ lọc nhà cung cấp -->
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
                <v-list-item
                    v-for="(providerName, i) in providers"
                    :key="i"
                    :value="i"
                    v-show="canItemShow(providerName)"
                >
                    <template v-slot:default="{ active }">
                        <v-list-item-action>
                            <v-checkbox :input-value="active" color="primary"></v-checkbox>
                        </v-list-item-action>

                        <v-list-item-content>
                            <v-list-item-title>{{ providerName }}</v-list-item-title>
                        </v-list-item-content>
                    </template>
                </v-list-item>
            </v-list-item-group>

            <v-list-item>
                <v-list-item-content>
                    <div class="d-flex justify-content-between">
                        <v-btn text color="primary" @click="onClickClearAll"> Clear All </v-btn>
                        <v-btn text color="primary" @click="onClickApply"> Apply </v-btn>
                    </div>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-menu>
</template>

<script type="text/javascript">
import { mapGetters, mapState, mapActions } from 'vuex';
import { UPDATE_FILTER } from '@/store/inventory/export/goods-issue/index/action-const';
export default {
    name: 'FilterProvidersBtn',
    props: {
        providers: {},
    },

    data() {
        return {
            search: '',

            menu: false,
            selected: [],
        };
    },

    methods: {
        ...mapActions('inventory/export/goods_issue/index', {
            UPDATE_FILTER,
        }),

        /**
         * Determines ability to item show.
         *
         * @param      {string}   providerName  The provider name
         * @return     {boolean}  True if able to item show, False otherwise.
         */
        canItemShow(providerName) {
            return !this.search || providerName.match(new RegExp(this.search, 'gi'));
        },

        /**
         * Called on click clear all.
         */
        onClickClearAll() {
            this.selected.splice(0, this.selected.length);
            this.onClickApply();
        },

        /**
         * Called on click apply.
         */
        onClickApply() {
            this.$refs.menu.save(this.selected);
            this.UPDATE_FILTER({ key: 'providers', value: Object.assign([], this.selected) });
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
                'btn-sm': true,
                'btn-primary': this.selected.length,
                'btn-light-primary': !this.selected.length,
                'font-weight-bold': true,
                'font-size-base': true,
                'text-uppercase': true,
                'ml-3': true,
            };
        },
    },
};
</script>
