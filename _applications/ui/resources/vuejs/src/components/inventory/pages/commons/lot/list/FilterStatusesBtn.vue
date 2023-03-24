<template>
    <!-- Bộ lọc loại phiếu -->
    <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        :return-value.sync="model"
        transition="scale-transition"
        offset-y
        min-width="auto"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn v-bind="attrs" v-on="on" :color="btnColor" depressed>
                Trạng thái <v-icon right> mdi-filter</v-icon>
            </v-btn>
        </template>

        <v-list flat dense subheader>
            <v-list-item-group v-model="tmp" multiple>
                <v-list-item v-for="(typeName, i) in statuses" :key="i" :value="i">
                    <template v-slot:default="{ active }">
                        <v-list-item-action>
                            <v-checkbox :input-value="active" color="primary"></v-checkbox>
                        </v-list-item-action>

                        <v-list-item-content>
                            <v-list-item-title>{{ typeName }}</v-list-item-title>
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
export default {
    name: "FilterStatusBtn",

    props: {
        value: null,
    },

    data: () => ({
        statuses: { active: "Hoạt động", inactive: "Không hoạt động" },
        menu: false,
        tmp: [],
    }),

    computed: {
        model: {
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
            return this.model.length ? "primary" : "grey--text";
        },
    },

    methods: {
        /**
         * Called on click clear all.
         */
        onClickBtnClearAll() {
            this.clearStatuses();
            this.onClickBtnApply();
        },

        /**
         * { function_description }
         */
        clearStatuses() {
            this.model.splice(0, this.model.length);
        },

        /**
         * Called on click apply.
         */
        onClickBtnApply() {
            this.$refs.menu.save(this.model);
            this.$emit("update:selected", this.model);
        },
    },

    created() {
        return (this.tmp = Array.isArray(this.value) ? [...this.value] : []);
    },
};
</script>
