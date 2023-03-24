<template>
    <v-card-text>
        <label>Mã đơn hàng (*)</label>
        <v-text-field v-model="invoice.sell.order_id" outlined dense @change="onOrderIDChanged" />

        <label>Người nhận</label>
        <v-text-field v-model="recipient" disabled outlined dense />

        <label>Thông tin liên hệ</label>
        <v-text-field v-model="contact" disabled outlined dense />

        <label>Địa chỉ</label>
        <v-text-field v-model="address" disabled outlined dense />
    </v-card-text>
</template>
<script type="text/javascript">
import Order from "@/models/inventory/external/order";
import GoodsIssue from "@/models/inventory/export/goods_issues";

export default {
    name: "ExportTypeSellBlock",
    props: {
        invoice: GoodsIssue,
    },
    data: () => ({
        OrderModel: new Order(),
        recipient: "",
        contact: "",
        address: "",
    }),
    computed: {},

    watch: {},

    methods: {
        /**
         * Called when order id changed.
         */
        onOrderIDChanged() {
            this.fetchOrderInfomation();
        },

        /**
         * Fetches an order infomation.
         *
         * @return     {Promise}  The order infomation.
         */
        async fetchOrderInfomation() {
            try {
                await this.OrderModel.loadById(this.order_id);

                this.fillOrderToModel(this.OrderModel);
                this.fillOrderToModelSell(this.OrderModel);
            } catch (e) {
                console.log(e);
                Swal.fire(ERROR_TITLE, ERROR_MESSAGE_FETCH, "error");
            }
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  order   The order
         */
        fillOrderToModel(order) {
            const products = order.products.map(p => ({
                product_id: p.id,
                name: p.product_name,
                code: p.product_code,
                unit: "Hộp",
                lot_id: 1,
                quantity: p.quantity,
                price: p.product_price || 0,
            }));

            this.$set(this.invoice, "store_id", order.store_id);
            this.$set(this.invoice, "warehouse_id", order.warehouse_id);
            this.$set(this.invoice, "products", products);
        },

        /**
         * { function_description }
         *
         * @param      {<type>}  order   The order
         */
        fillOrderToModelSell(order) {
            this.recipient = "Trần Văn A";
            this.contact = "tranvana@gmail.com/0922334212";
            this.address = "121 đường Kim Giang, Thanh XUân, Hà nội ";
        },
    },

    mounted() {},
};
</script>

<style></style>
