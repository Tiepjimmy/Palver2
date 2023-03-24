<template>
  <!-- thong tin nha cung cap -->
  <v-card outlined>
    <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin nhà cung cấp </v-card-title>

    <v-card-text>
      <v-autocomplete
        v-model="ProviderModel"
        :items="providers"
        item-text="provider_name"
        return-object
        auto-select-first
        placeholder="Tìm kiếm nhà cung cấp theo tên nhà cung cấp, mã nhà cung cấp, số điện thoại,..."
        outlined
        hide-details
        dense
        :disabled="hasSelectedStore"
      >
        <template v-slot:item="data">
          <v-list-item-avatar>
            <v-sheet color="grey darken-2" height="46" outlined width="46"></v-sheet>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title v-html="data.item.provider_name"></v-list-item-title>
            <v-list-item-subtitle v-html="data.item.phone"></v-list-item-subtitle>
          </v-list-item-content>
        </template>
      </v-autocomplete>

      <div class="provider-wrapper" v-if="!!hasProvider">
        <div class="text-h5">{{ ProviderModel.provider_name }}</div>
        <div class="">
          Địa chỉ: <b>{{ ProviderModel.address }}</b>
        </div>
        <div class="">
          SDT: <b>{{ ProviderModel.phone }}</b>
        </div>
        <div class="">
          Email: <b>{{ ProviderModel.email }}</b>
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>
<script type="text/javascript">
import { GET_PROVIDER } from "@/store/inventory/getter-const";
export default {
  name: "ProviderBlock",
  props: {
    storeId: 0,
  },

  data() {
    return {
      keyword: "",
      hideSuggest: true,
      provider: null,
    };
  },

  methods: {
    onClickSuggestProviderItem(providerID) {
      this.hideSuggest = true;
      this.provider = this.$store.getters[`inventory/${GET_PROVIDER}`](this.storeId)(providerID);
      this.$emit("provider", this.provider);
    },
  },

  computed: {
    /**
     * Shows the suggest.
     *
     * @return     {boolean}
     */
    showSuggest() {
      return !this.hideSuggest && this.providers.length;
    },

    /**
     * Determines if provider.
     *
     * @return     {boolean}  True if provider, False otherwise.
     */
    hasProvider() {
      return !!this.provider;
    },

    /**
     * { function_description }
     *
     * @return     array
     */
    providers() {
      const providers = this.$store.state.inventory.providers[this.storeId] || [];

      return providers.filter(provider =>
        this.keyword ? !!provider.provider_name.match(new RegExp(this.keyword, "gi")) : true
      );
    },

    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    goodsReceiptStore() {
      return this.$store.state.inventory.goodsreceipt;
    },
  },
  mounted() {},
};
</script>

<style lang="scss">
#search-providers-wrapper {
  position: relative;
  .suggest {
    position: absolute;
    top: 40px;
    z-index: 1;
    background: #fff;
  }
}
</style>
