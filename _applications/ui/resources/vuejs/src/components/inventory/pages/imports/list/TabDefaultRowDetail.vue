<template>
    <tr>
        <td colspan="12">
            <h6>Chi tiết phiếu nhập</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã SP</th>
                        <th>Tên SP</th>
                        <th>Đơn vị</th>
                        <th>Lô</th>
                        <th>Hạn sử dụng</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                        <th>Vị trí lưu kho</th>
                    </tr>
                </thead>
                <tbody>
                    <detail-product-row
                        as="tr"
                        v-for="(detail, idx) in invoice.details"
                        :idx="idx"
                        :key="idx"
                        :detail="detail"
                        @remove="deleteProduct(idx)"
                    ></detail-product-row>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="12" align="right">Tổng tiền: {{ totalAmount }}</td>
                    </tr>
                </tfoot>
            </table>
        </td>
    </tr>
</template>
<script type="text/javascript">
import { default as DetailProductRow } from './DetailProductRow';

export default {
    name: 'TabDefaultRowDetail',
    components: { DetailProductRow },
    props: {
        idx: 0,
        invoice: {},
    },

    computed: {
        /**
         * { function_description }
         *
         * @return     {<type>}  { description_of_the_return_value }
         */
        totalAmount() {
            return this.invoice.details.reduce(function (total, detail) {
                return (total += detail.price * detail.quantity);
            }, 0);
        },
    },
};
</script>

<style lang="scss"></style>
