<script type="text/javascript">
import Filter from "@/components/inventory/base_filter.js";
import GoodsReceipt from "@/models/inventory/import/goods_receipts";
import { default as TabContentMixin } from "./TabContentMixin";

export default {
  name: "TabReject",

  data: () => ({
    GoodsReceiptModel: new GoodsReceipt(),
  }),

  computed: {
    /**
     * { function_description }
     *
     * @return     {Object}  { description_of_the_return_value }
     */
    prepareFilter() {
      return new Filter({ ...this.filter, statuses: this.GoodsReceiptModel.STATUSES_CONST().REJECTED });
    },
  },

  mixins: [TabContentMixin],
};
</script>
