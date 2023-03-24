<template>
  <tr>
    <td>{{ stt }}</td>
    <td>{{ form.title }}</td>
    <td>{{ form.type }}</td>
    <td>
      <v-icon small v-if="isDefault">check_circle</v-icon>
    </td>
    <td>
      <v-icon small v-if="isActive">check_circle</v-icon>
    </td>
    <td>
      <button class="px-1" @click.stop="onClickBtnEdit">
        <v-icon small>mdi-pencil</v-icon>
      </button>
      <!-- <button class="px-1" @click="onClickBtnRemove">
        <v-icon small>mdi-delete</v-icon>
      </button> -->
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
    form: {},
  },

  computed: {
    /**
     * Determines if default.
     *
     * @return     {boolean}  True if default, False otherwise.
     */
    isDefault() {
      return this.form.is_default;
    },

    /**
     * Determines if active.
     *
     * @return     {boolean}  True if active, False otherwise.
     */
    isActive() {
      return this.form.is_active;
    },

    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    stt() {
      return this.idx + 1;
    },
  },

  methods: {
    /**
     * Called on click button edit.
     */
    onClickBtnEdit() {
      this.$emit(EMITS.CLICK_UPDATE, this.idx);
    },

    /**
     * Called on click button remove.
     */
    onClickBtnRemove() {
      this.$emit(EMITS.CLICK_DELETE, this.idx);
    },
  },
};
</script>

<style lang="scss"></style>
