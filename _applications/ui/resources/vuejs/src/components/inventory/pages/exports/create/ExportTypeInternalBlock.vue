<template>
    <v-card-text>
        <div class="form-group">
            <label>Mã đơn hàng</label>
            <input v-model="order_id" type="text" class="form-control form-control-sm" @change="onOrderIDChanged" />
        </div>

        <div class="form-group">
            <label>Người nhận</label>
            <input v-model="recipient" type="text" disabled class="form-control form-control-sm" />
        </div>

        <div class="form-group">
            <label>Thông tin liên hệ</label>
            <input v-model="contact" type="text" disabled class="form-control form-control-sm" />
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <input v-model="address" type="text" disabled class="form-control form-control-sm" />
        </div>
    </v-card-text>
</template>
<script type="text/javascript">
import Order from "@/models/inventory/external/order";

export default {
    name: "ExportTypeInternalBlock",
    data: () => ({
        recipient: "",
        contact: "",
        address: "",
    }),

    computed: {
        order_id: {
            set(value) {
                this.UPDATE_MODEL_SELL({ order_id: value });
            },

            get() {
                return this.model_sell.order_id;
            },
        },
    },

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
                const response = await InteractAPIService.fetchOrderByID(this.order_id);

                this.fillOrderToModel(response.data);
                this.fillOrderToModelSell(response.data);
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
            this.UPDATE_MODEL({ store_id: order.store_id, warehouse_id: order.warehouse_id, products: products });
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
