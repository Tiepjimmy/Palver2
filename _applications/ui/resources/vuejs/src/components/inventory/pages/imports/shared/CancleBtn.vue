<script type="text/javascript">
import BaseBtnUpdateStatus from "./BaseBtnUpdateStatus";

export default {
    name: "CancleBtn",
    components: { BaseBtnUpdateStatus },
    mixins: [BaseBtnUpdateStatus],

    data: () => ({
        ACTION_NAME: "hủy",
        STATUS: "CANCELED",
        ICON: "close",
        STATUS_ACCEPT: "Hủy phiếu",
        color: "error",
    }),

    computed: {
        /**
         * Determines ability to import.
         *
         * @return     {boolean}  True if able to import, False otherwise.
         */
        canHandle() {
            return !this.selected.some(m => m.isCanceled());
        },
    },
};
</script>
