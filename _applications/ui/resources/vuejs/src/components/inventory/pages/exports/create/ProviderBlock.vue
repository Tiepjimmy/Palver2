<template>
  <!-- thong tin nha cung cap -->
  <v-card outlined>
    <v-card-title primary-title class="text-h6 text-uppercase"> Thông tin nhà cung cấp </v-card-title>

    <v-card-text>
      <!-- search -->
      <div id="search-providers-wrapper">
        <v-text-field
          dense
          solo
          flat
          hide-details="auto"
          class="grey lighten-3"
          label="Tìm kiếm nhà cung cấp theo tên nhà cung cấp, mã nhà cung cấp, số điện thoại,..."
          v-model="keyword"
          @focus="hideSuggest = false"
        >
          <template v-slot:prepend-inner>
            <v-img width="24" height="24" src="/media/svg/icons/General/Search.svg"></v-img>
          </template>
        </v-text-field>
        <v-container class="suggest" v-if="showSuggest">
          <v-row v-for="(provider, idx) in providers" :key="idx" @click="onClickSuggestProviderItem(provider.id)">
            <v-col cols="12" class="d-flex flex-row">
              <v-avatar color="indigo">
                <v-icon dark> mdi-account-circle </v-icon>
              </v-avatar>
              <div class="d-flex flex-column ml-3">
                <div class="name text-h6">{{ provider.provider_name }}</div>
                <div class="phone">{{ provider.phone }}</div>
              </div>
            </v-col>
          </v-row>
        </v-container>
      </div>
      <div class="provider-wrapper" v-if="!!hasProvider">
        <div class="text-h5">{{ provider.provider_name }}</div>
        <div class="">
          Địa chỉ: <b>{{ provider.address }}</b>
        </div>
        <div class="">
          SDT: <b>{{ provider.phone }}</b>
        </div>
        <div class="">
          Email: <b>{{ provider.email }}</b>
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>
<script type="text/javascript">
import { GET_PROVIDER } from '@/store/inventory/getter-const';
export default {
  name: 'ProviderBlock',
  props: {
    storeId: 0,
  },

  data() {
    return {
      keyword: '',
      hideSuggest: true,
      provider: null,
    };
  },

  methods: {
    onClickSuggestProviderItem(providerID) {
      this.hideSuggest = true;
      this.provider = this.$store.getters[`inventory/${GET_PROVIDER}`](this.storeId)(providerID);
      this.$emit('provider', this.provider);
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
        this.keyword ? !!provider.provider_name.match(new RegExp(this.keyword, 'gi')) : true
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
