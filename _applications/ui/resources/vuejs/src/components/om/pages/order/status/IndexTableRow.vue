<template>
  <tr>
    <td>
      <button class="px-1" @click.stop="onClickBtnEdit">
        <v-icon small>mdi-pencil</v-icon>
      </button>
      <button class="px-1" v-if="!isSystem" @click="onClickBtnRemove">
        <v-icon small>mdi-delete</v-icon>
      </button>
    </td>
    <td>{{ stt }}</td>
    <td>{{ levelName }}</td>
    <td>{{ status.name }}</td>
    <td>{{ typeName }}</td>
    <td>{{ status.action_name }}</td>
    <td>
      <v-icon small v-if="isNoRevenue">check_circle</v-icon>
    </td>
    <td>
      <v-icon small v-if="isActive">check_circle</v-icon>
    </td>
  </tr>
</template>
<script type="text/javascript">
export const EMITS = {
  CLICK_UPDATE: "click-update",
  CLICK_DELETE: "click-delete",
};

export default {
  name: "IndexTableRow",
  props: {
    idx: 0,
    status: {},
  },

  data: () => ({}),

  computed: {
    /**
     * Determines if no revenue.
     *
     * @return     {boolean}  True if no revenue, False otherwise.
     */
    isNoRevenue() {
      return this.status.is_no_revenue;
    },

    /**
     * Determines if active.
     *
     * @return     {boolean}  True if active, False otherwise.
     */
    isActive() {
      return this.status.is_active;
    },

    /**
     * Determines if system.
     *
     * @return     {boolean}  True if system, False otherwise.
     */
    isSystem() {
      return this.status.is_system;
    },

    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    stt() {
      return this.idx + 1;
    },

    /**
     * { function_description }
     *
     * @return     {string}  { description_of_the_return_value }
     */
    levelName() {
      return "Level " + (this.status.levelName() || '(không xác định)');
    },

    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    typeName() {
      return this.status.typeName();
    },
  },

  methods: {
    /**
     * Called on click button edit.
     */
    onClickBtnEdit() {
      this.$emit(EMITS.CLICK_UPDATE, this.status.id);
    },

    /**
     * Called on click button remove.
     */
    onClickBtnRemove() {
      this.$emit(EMITS.CLICK_DELETE, this.status.id);
    },
  },
};
</script>

<style lang="scss"></style>
