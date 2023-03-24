<script type="text/javascript">
import BaseBtnUpdateStatus from "./BaseBtnUpdateStatus";

export default {
    name: "ImportBtn",
    components: { BaseBtnUpdateStatus },
    mixins: [BaseBtnUpdateStatus],

    data: () => ({
        ACTION_NAME: "nhập kho",
        STATUS: "IMPORTED",
        ICON: "move_to_inbox",
        STATUS_ACCEPT: "Đã duyệt",
    }),

    computed: {
        /**
         * Determines ability to import.
         *
         * @return     {boolean}  True if able to import, False otherwise.
         */
        canHandle() {
            return !this.selected.some(m => !m.isResolved());
        },
    },
};
</script>
