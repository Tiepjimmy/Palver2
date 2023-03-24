<script type="text/javascript">
import Filter from "@/components/inventory/base_filter.js";
import GoodsIssue from "@/models/inventory/export/goods_issues";
import TabContentMixin from "./TabContentMixin";

export default {
  name: "TabReject",
  data: () => ({
    GoodsIssueModel: new GoodsIssue(),
  }),
  computed: {
    /**
     * { function_description }
     *
     * @return     {Object}  { description_of_the_return_value }
     */
    prepareFilter() {
      return new Filter({ ...this.filter, statuses: this.GoodsIssueModel.STATUSES_CONST().EXPORTED });
    },
  },

  mixins: [TabContentMixin],
};
</script>
