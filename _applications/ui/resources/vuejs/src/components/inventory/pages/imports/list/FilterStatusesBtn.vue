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
      <v-btn :outlined="outlined" :color="color" v-bind="attrs" v-on="on" class="ml-2">
        Nhà cung cấp <v-icon right> mdi-filter</v-icon>
      </v-btn>
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
    /**
     * Determines ability to item show.
     *
     * @param      {string}   statusName  The provider name
     * @return     {boolean}  True if able to item show, False otherwise.
     */
    canItemShow(statusName) {
      return !this.search || statusName.match(new RegExp(this.search, 'gi'));
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
      this.$emit('update:providers', this.selected);
    },
  },

  computed: {
    /**
     * Color
     *
     * @return     string
     */
    color() {
      return !this.selected.length ? 'grey darken-2' : 'primary';
    },

    /**
     * Outlined
     *
     * @return     bool
     */
    outlined() {
      return !this.selected.length;
    },
  },
};
</script>
