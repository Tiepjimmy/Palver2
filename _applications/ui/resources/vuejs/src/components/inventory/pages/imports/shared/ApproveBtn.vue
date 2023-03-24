<script type="text/javascript">
import BaseBtnUpdateStatus from "./BaseBtnUpdateStatus";

export default {
    name: "ApproveBtn",
    components: { BaseBtnUpdateStatus },
    mixins: [BaseBtnUpdateStatus],

    data: () => ({
        ACTION_NAME: "duyệt phiếu",
        STATUS: "RESOLVED",
        ICON: "check",
        STATUS_ACCEPT: "Chờ duyệt, Từ chối",
    }),

    computed: {
        /**
         * Determines if it exists Approveed.
         *
         * @return     {<type>}  True if exists Approveed, False otherwise.
         */
        canHandle() {
            return !this.selected.some(m => !m.isWaiting() && !m.isRejected());
        },
    },
};
</script>
