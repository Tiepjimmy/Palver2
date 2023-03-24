<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <filter-keyword-bar
          v-model:keyword="filter.keyword"
          placeholder="Nhập mã phiếu nhập để tìm kiếm"
          hide-details
          outlined
          dense
        ></filter-keyword-bar>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <!-- Bộ lọc ngày tạo -->
        <filter-created-at-btn :range="filterCreatedAtRange" @update:selected="onUpdateCreatedAt">
          Ngày tạo
        </filter-created-at-btn>

        <!-- Bộ lọc nhà cung cấp -->
        <filter-providers-btn :items="mock_providers" @update:selected="onUpdateProviders">
          Nhà cung cấp
        </filter-providers-btn>

        <!-- Bộ lọc cửa hàng -->
        <filter-stores-btn :items="stores" @update:selected="onUpdateStores" :searchable="true">
          Chi nhánh
        </filter-stores-btn>

        <!-- Bộ lọc kho -->
        <filter-warehouses-btn :items="mock_warehouses" @update:selected="onUpdateWarehouses" :searchable="true">
          Kho
        </filter-warehouses-btn>

        <!-- Bộ lọc loại phiếu -->
        <filter-types-btn :items="types" @update:selected="onUpdateTypes"> Loại phiếu </filter-types-btn>

        <!-- Bộ lọc người lập -->
        <filter-created-by-btn :items="mock_users" @update:selected="onUpdateCreatedBy">
          Người lập
        </filter-created-by-btn>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
import GoodsReceipt from "@/models/inventory/import/goods_receipts";

import Filter from "@/components/inventory/base_filter.js";
import { default as FilterKeywordBar } from "./FilterKeywordBar";
import { default as FilterCreatedAtBtn } from "./FilterCreatedAtBtn";
import { default as FilterProvidersBtn } from "./FilterProvidersBtn";
import { default as FilterStoresBtn } from "./FilterStoresBtn";
import { default as FilterWarehousesBtn } from "./FilterWarehousesBtn";
import { default as FilterTypesBtn } from "./FilterTypesBtn";
import { default as FilterCreatedByBtn } from "./FilterCreatedByBtn";

export default {
  name: "FilterBlock",
  components: {
    FilterKeywordBar,
    FilterCreatedAtBtn,
    FilterProvidersBtn,
    FilterStoresBtn,
    FilterWarehousesBtn,
    FilterTypesBtn,
    FilterCreatedByBtn,
  },
  props: {
    loading: false,
    filter: Filter,
  },

  data: () => ({
    GoodsReceiptModel: new GoodsReceipt(),
    filterCreatedAtRange: true,
    mock_warehouses: {
      1: "NCC 1",
      23: "Ncc so 2",
      33: "NCC ha noi",
      45: "NCC hcm",
      34: "Da nang",
      21: "Can tho",
    },
    mock_users: { 1: "Nam", 2: "Hiền", 3: "Thành", 4: "Tuấn" },
    mock_providers: { 1: "NCC 1", 23: "Ncc so 2", 33: "NCC ha noi", 45: "NCC hcm", 34: "Da nang", 21: "Can tho" },
  }),

  computed: {
    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    stores() {
      return _.get(this.$store.getters.currentPermission, "stores", []).reduce(function (res, store) {
        res[store.id] = store.store_name;
        return res;
      }, {});
    },

    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    types() {
      return this.GoodsReceiptModel.typeNames();
    },
  },

  methods: {
    /**
     * { function_description }
     *
     * @param      {<type>}  value   The value
     */
    onUpdateWarehouses(value) {
      this.$set(this.filter, "warehouses", value);
      this.resetPage();
    },

    /**
     * { function_description }
     *
     * @param      {<type>}  value   The value
     */
    onUpdateTypes(value) {
      this.$set(this.filter, "types", value);
      this.resetPage();
    },

    /**
     * { function_description }
     *
     * @param      {<type>}  value   The value
     */
    onUpdateCreatedBy(value) {
      this.$set(this.filter, "created_by", value);
      this.resetPage();
    },

    /**
     * { function_description }
     *
     * @param      {<type>}  value   The value
     */
    onUpdateStores(value) {
      this.$set(this.filter, "stores", value);
      this.resetPage();
    },

    /**
     * { function_description }
     *
     * @param      {<type>}  value   The value
     */
    onUpdateProviders(value) {
      this.$set(this.filter, "providers", value);
      this.resetPage();
    },

    /**
     * Called on update expired at.
     *
     * @param      {<type>}  val     The value
     */
    onUpdateCreatedAt(val) {
      this.resetPage();

      if (this.filterCreatedAtRange) {
        this.$set(this.filter, "created_at", null);
        this.$set(this.filter, "created_at_from", _.first(val) || "");
        return this.$set(this.filter, "created_at_to", _.last(val) || "");
      }

      return this.$set(this.filter, "created_at", val);
    },

    /**
     * Called on update statuses.
     *
     * @param      {<type>}  val     The value
     */
    onUpdateStatuses(val) {
      this.resetPage();
      this.$set(this.filter, "statuses", val);
    },

    /**
     * { function_description }
     */
    resetPage() {
      this.filter.p = 1;
    },
  },
};
</script>
