<template>
  <v-text-field
    type="text"
    :name="name"
    :value="currencyValue"
    :placeholder="placeholder"
    :disabled="disabled"
    outlined
    :rules="rules"
    :hide-details="hideDetails"
    :readonly="readonly"
    :background-color="background"
    dense
    @input="onInput"
  >
  </v-text-field>
</template>

<script>
export default {
  name: "VInputCurrency",
  props: {
    name: {
      type: String,
      default: null
    },
    value: {
      type: Number ,
      default: 0
    },
    placeholder: {
      type: String ,
      default: null
    },
    disabled: {
      type: Boolean ,
      default: false
    },
    readonly: {
      type: Boolean ,
      default: false
    },
    unReplace: {
      type: Boolean ,
      default: false
    },
    background: {
      type: String ,
      default: null
    },
    max: {
      type: Number ,
      default: null
    },
    rules: [

    ],
    hideDetails: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      currency: null
    }
  },
  methods: {
    onInput(value) {
      // if(this.ceil) {
      //   value = Math.ceil(value)
      // }
      if (this.unReplace) {
        value = `${value}`.replace(' ', '')
      } else {
        value = `${value}`.replace(/[^\d]+/g, '')
      }
      this.currency = value.length > 0 ? Number(value) : null

      this.handleMaxValue()

      this.$emit('input', this.currency)
    },

    handleMaxValue() {
      if (this.max == 0 || this.max) {
        if (this.currency > this.max) {
          this.currency = this.max
        }
      }
    }
  },
  computed: {
    currencyValue: function () {
      return this.$helper.formatCurrency(this.currency, ',')
    }
  },
  watch: {
    value: function () {
      this.onInput(this.value)
    }
  },
  created() {
    this.currency = this.value
  }
}
</script>
