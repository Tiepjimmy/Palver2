<template>
  <v-card class="om-wp px-5">
    <v-tabs class="mt-5 border-bottom">
      <v-tab @click="loadListOrder()">Tất cả đơn hàng</v-tab>
      <v-tab @click="getListOrderWaitApprove()">Chờ duyệt</v-tab>
      <v-tab @click="getListPack()">Đóng gói</v-tab>
      <v-tab @click="getListDelivery()">Giao hàng</v-tab>
    </v-tabs>
    <v-row class="mt-2">
      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Mã đơn hàng</label>
          <v-text-field
            class="flex-basis"
            dense
            outlined
            hide-details
            v-model="params.code"
            placeholder="Nhập để tìm kiếm"
            @keyup.enter.native="search()"
          >
          </v-text-field>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Mã vận đơn</label>
          <v-text-field
            class="flex-basis"
            dense
            outlined
            hide-details
            v-model="params.lading_code"
            placeholder="Nhập để tìm kiếm"
            @keyup.enter.native="search()"
          >
          </v-text-field>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Trạng thái đơn hàng</label>
          <v-select
            no-data-text="không tìm thấy dữ liệu"
            class="flex-basis"
            v-model="params.order_status_id"
            :items="statuses"
            item-text="name"
            item-value="id"
            placeholder="Chọn trạng thái"
            dense
            outlined
            hide-details
            @change="search()"
          >
          </v-select>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Nhân viên tạo</label>
          <v-select
            no-data-text="không tìm thấy dữ liệu"
            class="flex-basis"
            v-model="params.user_id"
            :items="listUser"
            item-text="full_name"
            item-value="id"
            placeholder="Chọn nhân viên"
            dense
            outlined
            hide-details
            @change="search()"
          >
          </v-select>
        </div>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Ngày tạo</label>
          <v-menu
            ref="menuCreated"
            v-model="menuCreated"
            :close-on-content-click="false"
            :return-value.sync="params.created_at"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="params.created_at"
                class="flex-basis"
                placeholder="Từ ngày - đến ngày"
                readonly
                clearable
                dense
                outlined
                hide-details
                v-bind="attrs"
                v-on="on"
                @click:clear="clearTime('created_at')"
              ></v-text-field>
            </template>
            <v-date-picker v-model="params.created_at" no-title range scrollable locale="vi">
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="menuCreated = false">Hủy</v-btn>
              <v-btn text color="primary" @click="changeTime('menuCreated', 'created_at')">Chọn</v-btn>
            </v-date-picker>
          </v-menu>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Ngày duyệt</label>
          <v-menu
            ref="menuAprrove"
            v-model="menuAprrove"
            :close-on-content-click="false"
            :return-value.sync="params.approved_at"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="params.approved_at"
                class="flex-basis"
                placeholder="Từ ngày - đến ngày"
                readonly
                clearable
                dense
                outlined
                hide-details
                v-bind="attrs"
                v-on="on"
                @click:clear="clearTime('approved_at')"
              ></v-text-field>
            </template>
            <v-date-picker v-model="params.approved_at" no-title range scrollable locale="vi">
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="menuAprrove = false">Hủy</v-btn>
              <v-btn text color="primary" @click="changeTime('menuAprrove', 'approved_at')">Chọn</v-btn>
            </v-date-picker>
          </v-menu>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Ngày chuyển hàng</label>
          <v-menu
            ref="menuDelivered"
            v-model="menuDelivered"
            :close-on-content-click="false"
            :return-value.sync="params.delivered_at"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="params.delivered_at"
                class="flex-basis"
                placeholder="Từ ngày - đến ngày"
                readonly
                clearable
                dense
                outlined
                hide-details
                v-bind="attrs"
                v-on="on"
                @click:clear="clearTime('delivered_at')"
              ></v-text-field>
            </template>
            <v-date-picker v-model="params.delivered_at" no-title range scrollable locale="vi">
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="menuDelivered = false">Hủy</v-btn>
              <v-btn text color="primary" @click="changeTime('menuDelivered', 'delivered_at')">Chọn</v-btn>
            </v-date-picker>
          </v-menu>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Đơn thành công</label>
          <v-menu
            ref="menuConfirmed"
            v-model="menuConfirmed"
            :close-on-content-click="false"
            :return-value.sync="params.update_success_at"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="params.update_success_at"
                class="flex-basis"
                placeholder="Từ ngày - đến ngày"
                readonly
                clearable
                dense
                outlined
                hide-details
                v-bind="attrs"
                v-on="on"
                @click:clear="clearTime('update_success_at')"
              ></v-text-field>
            </template>
            <v-date-picker v-model="params.update_success_at" no-title range scrollable locale="vi">
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="menuConfirmed = false">Hủy</v-btn>
              <v-btn text color="primary" @click="changeTime('menuConfirmed', 'update_success_at')">Chọn</v-btn>
            </v-date-picker>
          </v-menu>
        </div>
      </v-col>

      <v-col cols="6" sm="4" md="3" lg="3" xl="2">
        <div class="d-flex flex-column h-100">
          <label class="flex-1 d-flex flex-column place-content-end">Ngày thu tiền</label>
          <v-menu
            ref="menuPaid"
            v-model="menuPaid"
            :close-on-content-click="false"
            :return-value.sync="params.paid_at"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="params.paid_at"
                class="flex-basis"
                placeholder="Từ ngày - đến ngày"
                readonly
                clearable
                dense
                outlined
                hide-details
                v-bind="attrs"
                v-on="on"
                @click:clear="clearTime('clearTime')"
              ></v-text-field>
            </template>
            <v-date-picker v-model="params.paid_at" no-title range scrollable locale="vi">
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="menuPaid = false">Hủy</v-btn>
              <v-btn text color="primary" @click="changeTime('menuPaid', 'paid_at')">Chọn</v-btn>
            </v-date-picker>
          </v-menu>
        </div>
      </v-col>
    </v-row>
    <div class="my-5 d-flex">
      <v-btn
        v-if="showButton == 'approve'"
        class=""
        dark
        small
        color="primary"
        @click="onClickBtnAprroveOrder"
      >
        Duyệt đơn
      </v-btn>
      <v-btn v-if="showButton == 'pack'" class="" dark small color="primary" @click="shippingOrder()">
        Chuyển hàng
      </v-btn>
      <v-btn v-if="showButton == 'shipping'" class="" dark small color="primary" @click="approveRevenue()">
        Xác nhận doanh thu thực tế
      </v-btn>
      <v-btn class="ml-auto" dark small color="success" @click="createOrder()"> Tạo đơn hàng </v-btn>
    </div>

    <v-data-table
      class="om-wp_border"
      :headers="computedHeaders"
      :items="dataList"
      hide-default-footer
      :items-per-page="params.limit"
      no-data-text="Không tồn tại dữ liệu"
      item-key="id"
    >
      <template v-slot:header.setting="{ header }">
        <v-btn icon @click="settingColumn()">
          <v-icon>fas fa-cog</v-icon>
        </v-btn>
      </template>

      <template v-slot:header.selected="{ item }">
        <v-checkbox
          class="checkbox-table"
          v-model="selectedAll"
          hide-details
          color="#0000008a"
          :indeterminate="indeterminate"
          @change="handleSelectAll($event)"
        >
        </v-checkbox>
      </template>

      <template v-slot:item.selected="{ item }">
        <v-checkbox
          class="checkbox-table"
          v-model="selectedOrder"
          :value="item.id"
          hide-details
          color="#0000008a"
          @change="handleSelectItem($event)"
        >
        </v-checkbox>
      </template>

      <template v-slot:item.setting="{ item, index }">
        <div class="d-flex align-items-center">
          <div class="mr-2">{{ params.offset + 1 + index }}</div>
          <v-menu
            v-model="item.detail"
            transition="scale-transition"
            :close-on-content-click="false"
            offset-x
            offset-y
            full-width
          >
            <template v-slot:activator="{ on, attrs }">
              <v-icon v-show="item.products" small class="cursor-pointer" color="darken-2" v-on="on">
                {{ item.detail ? "fas fa-angle-double-down" : "fas fa-angle-double-right" }}
              </v-icon>
            </template>
            <v-card color="#f0f8ff" class="overflow-x-auto">
              <order-detail
                :order="item"
                @printOrder="printOrder"
                @hideDetail="item.detail = false" />
            </v-card>
          </v-menu>
        </div>
      </template>

      <template v-slot:item.created_at="{ item }">
        <div>{{ formatTime(item.created_at) }}</div>
      </template>

      <template v-slot:item.order_status_id="{ item }">
        <v-chip
          :color="item.order_status.color"
          small
        >{{ item.order_status.name }}</v-chip>
      </template>

      <template v-slot:item.sub_status_id="{ item }">
        <v-icon v-show="item.sub_status_id == 2" small class="cursor-pointer" color="darken-2">
          fas fa-check-circle
        </v-icon>
      </template>

      <template v-slot:item.grand_total="{ item }">
        <div>{{ $helper.formatCurrency(item.grand_total, ',') }}</div>
      </template>
    </v-data-table>

    <div class="py-3 d-flex align-items-center">
      <b-form-select
        class="om-wp-list-number"
        v-model="params.limit"
        :options="options"
        size="sm"
        @change="search()"
      ></b-form-select>
      <div class="ml-3">
        Tổng số: <b>{{ total }}</b>
      </div>
      <v-pagination
        v-show="totalPage > 1"
        class="ml-auto"
        v-model="page"
        circle
        :length="totalPage"
        :total-visible="6"
        @input="paginate(page)"
      ></v-pagination>
    </div>

    <modal-print-order
      @print="print"
      :order="order"
    />

    <modal-confirm-shipping />

    <modal-order-cancel-reason @cancelOrder="search"/>

    <modal-confirm-shipping @update="search"/>
  </v-card>
</template>

<script>
import Swal from "sweetalert2";
import Filter from "@/core/filter";
import Collection from "@/core/collection";
import Order from "@/models/order/order";
import { mapGetters } from "vuex";
import moment from "moment";
import OrderDetail from "@/components/om/pages/order/list/Detail";
import { ORDER_STATUS_PACKING, ORDER_STATUS_SHIPING_SUCCESS, ORDER_STATUS_STORE } from "@/config/app";
import {SET_BREADCRUMB} from "@/core/services/store/breadcrumbs.module";
import ModalPrintOrder from "@/components/om/pages/order/print/ModalPrintOrder";
import ModalConfirmShipping from "@/components/om/pages/order/ModalConfirmShipping";
import ModalOrderCancelReason from "@/components/om/pages/order/ModalOrderCancelReason";

export default {
  name: "Order",
  components: {
    OrderDetail,
    ModalPrintOrder,
    ModalConfirmShipping,
    ModalOrderCancelReason
  },
  data() {
    return {
      selectedOrder: [],
      selectedAll: false,
      indeterminate: false,
      loading: false,
      params: new Filter(this.$route.query),
      firstFetched: false,
      order: new Order(),
      dataList: new Collection(Order),
      statuses: new Collection(Object, [{id: null, name: 'Tất cả'}]),
      listUser: new Collection(Object, [{id: null, full_name: 'Tất cả'}]),
      menuCreated: false,
      menuAprrove: false,
      menuDelivered: false,
      menuConfirmed: false,
      menuPaid: false,
      showButton: null,
      statusWaitingApprove: ORDER_STATUS_STORE,
      statusPack: ORDER_STATUS_PACKING,
      statusShip: ORDER_STATUS_SHIPING_SUCCESS,
      total: 0,
      page: 1,
      totalPage: 1,
      headers: [
        {
          text: "",
          value: "setting",
          align: "center",
          width: "50",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "",
          value: "selected",
          align: "center",
          width: "50",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "Mã đơn hàng",
          value: "code",
          align: "center",
          width: "100",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "Ngày tạo",
          value: "created_at",
          align: "center",
          width: "100",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "khách hàng",
          value: "customer_name",
          align: "center",
          width: "100",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "Số điện thoại",
          value: "customer_mobile",
          align: "center",
          width: "100",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "Trạng thái đơn hàng",
          value: "order_status_id",
          align: "center",
          width: "100",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "Trạng thái vận đơn",
          value: "shipping_status",
          align: "center",
          width: "100",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        {
          text: "Đã thanh toán",
          value: "sub_status_id",
          align: "center",
          width: "100",
          sortable: false,
          class: "om-wp_border-right",
          cellClass: "om-wp_border-right",
        },
        { text: "Tổng tiền", value: "grand_total", align: "center", width: "100", sortable: false },
      ],
      options: [10, 20, 30],
    };
  },
  methods: {
    /**
     * Called on click button aprrove order.
     */
    async onClickBtnAprroveOrder() {
      const result = await this.doApproveOrder();
      if (result) {
        this.getListOrderWaitApprove();
        // this.getListPack(this.statusPack);
      }
    },

    /**
     * Does an aprrove order.
     *
     * @return     {Promise}  { description_of_the_return_value }
     */
    async doApproveOrder() {
      try {
        if (this.isEmptySelectedOrder) {
          return this.messageError("Vui lòng chọn đơn hàng muốn duyệt !");
        }

        const result = await this.confirmApproveOrder();
        if (!result.isConfirmed) {
          return;
        }

        this.loadingStart()
        // this.showLoading({ title: "Đang duyệt đơn", html: "Việc duyệt đơn đang được tiến hành, xin chờ giây lát" });
        await this.approveOrder(this.selectedOrder);
        this.messageSuccess("Bạn đã duyệt đơn hàng thành công");
        await this.search()

        return true;
      } catch (e) {
        this.messageError("Duyệt đơn thất bại");
      }

      Swal.close();
    },

    /**
     * Xác nhận duyệt đơn
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    confirmApproveOrder() {
      const html = "Bạn chắc chắn muốn duyệt <b>" + this.numSelectedOrder + "</b> đơn hàng ?";

      return Swal.fire({
        icon: "question",
        title: "Xác nhận",
        html: html,
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đồng ý",
        cancelButtonText: "Không đồng ý",
      });
    },

    /**
     * Xác nhận duyệt đơn
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    showLoading(options) {
      Swal.fire({
        title: options.title,
        html: options.html,
        allowOutsideClick: false,
        showConfirmButton: false,
      });
      Swal.showLoading();
    },

    hideLoading() {
      Swal.hideLoading();
    },

    settingColumn() {},
    shippingOrder() {
      if (this.selectedOrder.length < 1) {
        return
      }

      this.$modal.show('modal-confirm-shipping', {ids: this.selectedOrder})
    },
    approveRevenue() {},
    handleSelectItem(event) {
      if (this.selectedOrder.length < 1) {
        this.selectedAll = false;
        this.indeterminate = false;
      }

      if (this.selectedOrder.length == this.dataList.length) {
        this.selectedAll = true;
        this.indeterminate = false;
      }

      if (this.selectedOrder.length < this.dataList.length && this.selectedOrder.length > 0) {
        this.selectedAll = false;
        this.indeterminate = true;
      }
    },
    handleSelectAll(event) {
      if (event) {
        this.selectedOrder = this.dataList.pluck("id");
      } else {
        this.selectedOrder = [];
      }
    },
    resetSelectedOrder() {
      this.selectedOrder = [];
      this.selectedAll = false;
      this.indeterminate = false;
    },
    resetParamTabOrder() {
      this.params.approved = null
      this.params.not_approved = null
      this.params.shipping = null
    },
    async getListDelivery() {
      this.resetSelectedOrder()
      this.resetParamTabOrder()
      this.params.shipping = 1
      this.showButton = 'shipping'
      await this.search()
    },
    async getListPack() {
      this.resetSelectedOrder()
      this.resetParamTabOrder()
      this.params.approved = 1
      this.showButton = 'pack'
      await this.search()
    },
    async getListOrderWaitApprove() {
      this.resetSelectedOrder()
      this.resetParamTabOrder()
      this.params.not_approved = 1
      this.showButton = 'approve'
      await this.search()
    },

    async loadListOrder(status = null) {
      this.resetParamTabOrder()
      this.resetSelectedOrder();

      if (status) {
        this.params.order_status_id = status;
        this.showButton = status;
      } else {
        this.params.order_status_id = null;
        this.showButton = null;
      }

      await this.search();
    },
    changeTime(entity, param) {
      this.$refs[entity].save(this.params[param]);
      this.search();
    },
    clearTime(param) {
      this.params[param] = null;
      this.search();
    },
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit;
      await this.listAsync();
      this.page = page;
    },

    async store() {
      this.resetSelectedOrder();
      await this.paginate((this.page = 1));
    },

    update(data) {
      const item = this.dataList.find(i => i.id == data.id);

      if (item != null) {
        item.bind(data);
      }
    },

    formatTime(time) {
      return time ? moment(time).format("DD/MM/YYYY") : "";
    },

    createOrder() {
      return this.$router.push({ name: "om.order.create" });
    },

    openModalEdit(item) {},

    async search() {
      this.resetSelectedOrder();
      this.page = 1;
      this.params.offset = 0;
      await this.listAsync();
    },

    async listAsync() {
      try {
        const params = this.params.reduces();
        this.loadingStart();

        this.dataList = await this.order.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true;
      } catch (e) {
        this.handleException(e);
      } finally {
        this.loadingClose();
      }
    },
    printOrder(data) {
      this.order = data
      this.$modal.show('modal-print-order', {})
    },
    print() {

    },
    async loadConfig() {
      this.orderConfig.then((result) => {
        this.listUser.push(...result.listUser)
        this.statuses.push(...result.statuses)
      })
    },

    /**
     * Thực thi việc duyệt đơn hàng
     *
     * @param      array   orderIDs  Danh sách ID đơn hàng
     * @return     Promise
     */
    async approveOrder(orderIDs) {
      try {
        return await this.order.approveOrder(orderIDs);
      } catch (e) {
        throw e;
      }

      this.loadingClose();
    },
  },
  computed: {
    ...mapGetters({
      orderConfig: 'omConfig/order'
    }),
    computedHeaders() {
      return this.headers.filter(i => (this.showButton ? i : i.value != "selected"));
    },

    /**
     * Determines if empty selected order.
     *
     * @return     {boolean}  True if empty selected order, False otherwise.
     */
    isEmptySelectedOrder() {
      return !this.numSelectedOrder;
    },

    /**
     * Số lượng đơn hàng đã chọn
     *
     * @return     int
     */
    numSelectedOrder() {
      return _.get(this, "selectedOrder.length", 0);
    },
  },
  async created() {
    await this.loadConfig();
    this.params.limit = 10;
    await this.listAsync();
  },
  mounted() {
    this.$store.dispatch(SET_BREADCRUMB, [{title: "Danh sách đơn hàng có sẵn"}]);
  },
};
</script>

<style scoped></style>
