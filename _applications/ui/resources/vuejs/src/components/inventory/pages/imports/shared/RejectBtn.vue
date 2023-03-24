<script type="text/javascript">
import BaseBtnUpdateStatus from "./BaseBtnUpdateStatus";

export default {
    name: "RejectBtn",
    components: { BaseBtnUpdateStatus },
    mixins: [BaseBtnUpdateStatus],

    data: () => ({
        ACTION_NAME: "từ chối",
        STATUS: "REJECTED",
        ICON: "file-cancel-outline",
        STATUS_ACCEPT: "Chờ duyệt",
        color: "warning",
    }),

    computed: {
        /**
         * Determines if it exists Approveed.
         *
         * @return     {<type>}  True if exists Approveed, False otherwise.
         */
        canHandle() {
            return !this.selected.some(m => !m.isWaiting());
        },
    },
};
</script>
