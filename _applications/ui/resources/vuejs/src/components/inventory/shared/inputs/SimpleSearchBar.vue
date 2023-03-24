<template>
    <!-- Tìm kiếm -->
    <div class="flex-grow-1" v-bind="$attrs">
        <v-text-field
            :disabled="disabled"
            :value="keyword"
            @input="debouceKeyword"
            @keyup.enter="commitUpdateKeyword"
            v-bind="$attrs"
        >
            <template v-slot:prepend-inner>
                <v-fade-transition leave-absolute>
                    <v-progress-circular v-if="loading" size="24" color="info" indeterminate></v-progress-circular>
                    <v-icon v-else width="24" height="24">mdi-magnify</v-icon>
                </v-fade-transition>
            </template>
        </v-text-field>
    </div>
</template>

<script type="text/javascript">
export default {
    name: "SimpleSearchBar",
    inheritAttrs: false,
    props: {
        loading: false,
        keyword: "",
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        disabled() {
            return this.loading;
        },
    },

    methods: {
        /**
         * { function_description }
         */
        debouceKeyword: _.debounce(function (evt) {
            return this.commitUpdateKeyword(evt);
        }, 500),

        /**
         * Commits an update keyword.
         */
        commitUpdateKeyword(value) {
            this.$emit("input", value instanceof KeyboardEvent ? value.target.value : value);
        },
    },
};
</script>
