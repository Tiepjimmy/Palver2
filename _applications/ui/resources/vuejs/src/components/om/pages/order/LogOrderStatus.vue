<template>
  <div class="mt-5" >
    <div justify="center">
      <v-expansion-panels
        multiple
        accordion>
        <!-- Chờ chuyển hàng -->

        <v-expansion-panel
          v-if="order.approved_at"
          class="mb-3"
        >
          <v-expansion-panel-header class="px-3 om-wp_border-bottom">
            <div class="d-flex align-items-center">
              <v-icon
                class="mr-2"
                color="green"

              >mdi-check-circle</v-icon>
              <div class="font-weight-bold">Đơn hàng đã được duyệt</div>

              <v-btn
                v-if="order.approved_at && isDetailOrder() && this.order.order_statusid == this.statusApprove"
                small
                color="warning"
                class="ml-auto mr-3"
                @click.native.stop="rejectApproveOrder()"
              >
                Hủy duyệt
              </v-btn>
            </div>

            <template v-slot:actions>
              <v-icon>
                mdi-minus-box-outline
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-timeline
              align-top
              dense
            >
              <v-timeline-item
                class="pb-0"
                small
                color="#00a1ff"
              >
                <div class="d-flex align-items-center">
                  <span class="light-blue--text mr-5">{{ order.code }}</span>

                  <v-chip
                    color="green"
                    small
                  >
                    Kế toán mặc định
                  </v-chip>

                  <div class="ml-auto">
                    {{ formatTime(order.approved_at) }}
                  </div>
                </div>

                <div class="mt-3">
                  <div class="text-black-50">Người thực hiện</div>
                  <div>{{ order.user_approved.full_name }}</div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <!-- Đang Đóng gói -->
        <v-expansion-panel
          v-if="checkOrderPacking()"
          class="mb-3"
        >
          <v-expansion-panel-header class="px-3 om-wp_border-bottom">
            <div class="d-flex align-items-center">
              <v-icon
                class="mr-2"
                color="green"

              >mdi-check-circle</v-icon>
              <div class="font-weight-bold">Đơn hàng đang đóng gói</div>

              <v-menu
                offset-y
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    v-if="isDetailOrder() && order.order_status_id == (statusPacking || statusStringent)"
                    v-bind="attrs"
                    v-on="on"
                    small
                    color="warning"
                    class="ml-auto mr-3"
                    @click.native.stop
                  >
                    Thiếu hàng
                  </v-btn>
                </template>

                <v-list>
                  <v-list-item style="min-height: 25px" class="cursor-pointer">
                    <v-list-item-title @click="$emit('cancelOrder')">Hủy đơn</v-list-item-title>
                  </v-list-item>

                  <v-list-item style="min-height: 25px" class="cursor-pointer">
                    <v-list-item-title @click="$emit('editOrder')">Sửa đơn</v-list-item-title>
                  </v-list-item>

                  <v-list-item style="min-height: 25px" class="cursor-pointer">
                    <v-list-item-title @click="$emit('coppyOrder')">Sao chép đơn hàng</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>

            <template v-slot:actions>
              <v-icon>
                mdi-minus-box-outline
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-timeline
              align-top
              dense
            >
              <v-timeline-item
                class="pb-0"
                small
                color="#00a1ff"
              >
                <div class="d-flex align-items-center">
                  <span class="light-blue--text mr-5">{{ order.code }}</span>

                  <v-chip
                    color="green"
                    small
                  >
                    Chuyển hàng
                  </v-chip>

                  <div class="ml-auto">
                    18/02/2022 10:30
                  </div>
                </div>

                <div class="mt-3">
                  <div class="d-flex">
                    <div>
                      <div class="text-black-50">Phương thức vận chuyển</div>
                      <div>Kết nối đơn vị vận chuyển</div>
                    </div>

                    <div class="ml-auto">
                      <div class="text-black-50">Tổng tiền</div>
                      <div>2.660.000</div>
                    </div>
                  </div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-expansion-panel-content>
        </v-expansion-panel>

<!--        Đơn hàng đã đóng gói-->
        <v-expansion-panel
          v-if="checkOrderPacked()"
          class="mb-3"
        >
          <v-expansion-panel-header class="px-3 om-wp_border-bottom">
            <div class="d-flex align-items-center">
              <v-icon
                class="mr-2"
                color="green"
              >mdi-check-circle
              </v-icon>
              <div class="font-weight-bold">Đơn hàng đã đóng gói </div>

              <div class="light-blue--text ml-auto mr-3">
                <span class="font-weight-bold mr-1">Đã xuất kho</span>
                15/10/2021
              </div>
            </div>

            <template v-slot:actions>
              <v-icon>
                mdi-minus-box-outline
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-timeline
              align-top
              dense
            >
              <v-timeline-item
                class="pb-0"
                small
                color="#00a1ff"
              >
                <div class="d-flex align-items-center">
                  <span class="light-blue--text mr-5">{{ order.code }}</span>

                  <v-chip
                    color="green"
                    small
                  >
                    Chuyển hàng
                  </v-chip>

                  <div class="ml-auto">
                    18/02/2022 10:30
                  </div>
                </div>

                <div class="mt-3">
                  <div class="text-black-50">Người thực hiện</div>
                  <div>Nguyễn Văn A</div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-expansion-panel-content>
        </v-expansion-panel>

<!--        Đơn hàng đang được giao-->
        <v-expansion-panel
          v-if="checkStatusOutStock()"
          class="mb-3"
        >
          <v-expansion-panel-header class="px-3 om-wp_border-bottom">
            <div class="d-flex align-items-center">
              <v-icon
                class="mr-2"
                color="green"
              >mdi-check-circle</v-icon>
              <div class="font-weight-bold">Đơn hàng đang được giao</div>
            </div>

            <template v-slot:actions>
              <v-icon>
                mdi-minus-box-outline
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-timeline
              align-top
              dense
            >
              <v-timeline-item
                class="pb-0"
                small
                color="#00a1ff"
              >
                <div class="d-flex align-items-center">
                  <span class="light-blue--text mr-5">{{ order.code }}</span>

                  <v-chip
                    color="green"
                    small
                  >
                    Thu gom thành công
                  </v-chip>

                  <div class="ml-auto">
                    18/02/2022 10:30
                  </div>
                </div>

                <div class="mt-3">
                  <div class="d-flex">
                    <div>
                      <div class="text-black-50">Phương thức vận chuyển</div>
                      <div>Kết nối đơn vị vận chuyển</div>
                    </div>

                    <div class="ml-auto">
                      <div class="text-black-50">Tổng tiền</div>
                      <div>2.660.000</div>
                    </div>
                  </div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-expansion-panel-content>
        </v-expansion-panel>

        <!-- Đơn giao thành công -->

        <v-expansion-panel
          v-if="checkStatusSuccess()"
          class="mb-3"
        >
          <v-expansion-panel-header class="px-3 om-wp_border-bottom">
            <div class="d-flex align-items-center">
              <v-icon
                class="mr-2"
                color="green"
              >mdi-check-circle
              </v-icon>
              <div class="font-weight-bold">Đơn hàng đã được giao </div>

              <v-btn
                v-if="isDetailOrder()"
                small
                color="warning"
                class="ml-auto mr-3"
                @click.native.stop
              >
                Hủy hoàn thành
              </v-btn>
            </div>

            <template v-slot:actions>
              <v-icon>
                mdi-minus-box-outline
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-timeline
              align-top
              dense
            >
              <v-timeline-item
                class="pb-0"
                small
                color="#00a1ff"
              >
                <div class="d-flex align-items-center">
                  <span class="light-blue--text mr-5">{{ order.code }}</span>

                  <v-chip
                    color="green"
                    small
                  >
                    Đơn hành giao thành công
                  </v-chip>

                  <div class="ml-auto">
                    18/02/2022 10:30
                  </div>
                </div>

                <div class="mt-3">
                  <div class="text-black-50">Người thực hiện</div>
                  <div>Nguyễn Văn A</div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-expansion-panel-content>
        </v-expansion-panel>

  <!-- Đơn chuyển hoàn -->

        <v-expansion-panel
          v-if="checkStatusRefund()"
          class="mb-3"
        >
          <v-expansion-panel-header class="px-3 om-wp_border-bottom">
            <div class="d-flex align-items-center">
              <v-icon
                class="mr-2"
                color="green"
              >mdi-check-circle
              </v-icon>
              <div class="font-weight-bold">Đơn hàng đã được giao </div>

              <v-btn
                v-if="isDetailOrder()"
                small
                color="warning"
                class="ml-auto mr-3"
                @click.native.stop
              >
                Hủy hoàn thành
              </v-btn>
            </div>

            <template v-slot:actions>
              <v-icon>
                mdi-minus-box-outline
              </v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-timeline
              align-top
              dense
            >
              <v-timeline-item
                class="pb-0"
                small
                color="#00a1ff"
              >
                <div class="d-flex align-items-center">
                  <span class="light-blue--text mr-5">{{ order.code }}</span>

                  <v-chip
                    color="green"
                    small
                  >
                    Chuyển hoàn
                  </v-chip>

                  <div class="ml-auto">
                    18/02/2022 10:30
                  </div>
                </div>

                <div class="mt-3">
                  <div class="d-flex">
                    <div>
                      <div class="text-black-50">Phương thức vận chuyển</div>
                      <div>Kết nối đơn vị vận chuyển</div>
                    </div>

                    <div class="ml-auto">
                      <div class="text-black-50">Tổng tiền</div>
                      <div>2.660.000</div>
                    </div>
                  </div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-expansion-panel-content>
        </v-expansion-panel>

      </v-expansion-panels>
    </div>

    <v-card v-if="isDetailOrder() && ! order.approved_at">
      <div class="px-3 d-flex align-items-center py-2">
        <div class="d-flex align-items-center">
          <v-icon class="mr-2">far fa-thumbs-up</v-icon>
          <span class="font-size-h6 text-uppercase">Duyệt đơn hàng</span>
        </div>

        <v-btn
          class="ml-auto"
          color="primary"
          small
          @click="$emit('approveOrder')"
        >
          Duyệt đơn
        </v-btn>
      </div>
    </v-card>

    <v-card v-if="isDetailOrder() && order.order_status_id == statusApprove">
      <div class="px-3 d-flex align-items-center py-2">
        <div class="d-flex align-items-center">
          <v-icon class="mr-2">mdi-gift-outline</v-icon>
          <span class="font-size-h6 text-uppercase">Đóng gói và giao hàng</span>
        </div>

        <v-btn
          class="ml-auto"
          color="primary"
          small
          @click="$emit('shippingOrder')"
        >
          Chuyển hàng
        </v-btn>
      </div>
    </v-card>

    <v-card v-if="isDetailOrder() && order.order_status_id == statusOutStock">
      <div class="px-3 d-flex align-items-center py-2">
        <div class="d-flex align-items-center">
          <v-icon class="mr-2">far fa-thumbs-up</v-icon>
          <span class="font-size-h6 text-uppercase">Kết quả giao hàng</span>
        </div>

        <v-menu
          offset-y
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              v-bind="attrs"
              v-on="on"
              small
              class="ml-auto"
              color="primary"
            >
              Hoàn thành
            </v-btn>
          </template>

          <v-list>
            <v-list-item style="min-height: 25px" class="cursor-pointer">
              <v-list-item-title @click="shippingSuccess()">Giao hàng thành công</v-list-item-title>
            </v-list-item>

            <v-list-item style="min-height: 25px" class="cursor-pointer">
              <v-list-item-title @click="refund()">Chuyển hoàn</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-card>

    <v-card v-if="isDetailOrder() && order.order_status_id == statusSuccess">
      <div class="px-3 d-flex align-items-center py-2">
        <div class="d-flex align-items-center">
          <v-icon class="mr-2">fas fa-reply</v-icon>
          <span class="font-size-h6 text-uppercase">Hoàn trả hàng đã giao</span>
        </div>

        <v-menu
          offset-y
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              v-bind="attrs"
              v-on="on"
              small
              class="ml-auto"
            >
              Đổi trả hàng
            </v-btn>
          </template>

          <v-list>
            <v-list-item style="min-height: 25px" class="cursor-pointer">
              <v-list-item-title>Trả hàng toàn bộ</v-list-item-title>
            </v-list-item>

            <v-list-item style="min-height: 25px" class="cursor-pointer">
              <v-list-item-title>Trả hàng 1 phần</v-list-item-title>
            </v-list-item>

            <v-list-item style="min-height: 25px" class="cursor-pointer">
              <v-list-item-title>Đổi hàng</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-card>
  </div>
</template>

<script>
import Order from "@/models/order/order";
import moment from "moment"
import Swal from "sweetalert2";
import {
  ORDER_STATUS_APPROVE, ORDER_STATUS_OUT_STOCK,
  ORDER_STATUS_PACKING, ORDER_STATUS_REFUND,
  ORDER_STATUS_SHIPING_SUCCESS,
  ORDER_STATUS_STORE, ORDER_STATUS_STRINGENT
} from "@/config/app";

export default {
  name: "LogOrderStatus",
  props: {
    order: {
      type: Object,
      default: new Order()
    }
  },
  data() {
    return {
      panel: [],
      statusWaiting: ORDER_STATUS_STORE,
      statusPacking: ORDER_STATUS_PACKING,
      statusSuccess: ORDER_STATUS_SHIPING_SUCCESS,
      statusApprove: ORDER_STATUS_APPROVE,
      statusRefund: ORDER_STATUS_REFUND,
      statusStringent: ORDER_STATUS_STRINGENT,
      statusOutStock: ORDER_STATUS_OUT_STOCK
    }
  },
  methods: {
    formatTime(value) {
      if (!value) {
        return
      }

      return moment(value).format('DD-MM-YYYY HH:mm')
    },
    isDetailOrder() {
      if (this.$route.name == 'om.order.detail') {
        return true
      }

      return false
    },
    rejectApproveOrder() {
      Swal.fire({
        text: `Bạn có chắc chắn muốn hủy duyệt đơn hàng ${this.order.code}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then(async (result) => {
        if (result.isConfirmed) {
          await this.unApprove();
        }
      })
    },
    checkStatusOutStock() {
      if (this.order.order_status_id == this.statusOutStock ||
        this.order.order_status_id == this.statusSuccess) {
        return true
      }

      return false
    },
    checkOrderPacked() {
      if (this.order.order_status_id == this.statusOutStock ||
        this.order.order_status_id == this.statusSuccess ||
        this.order.order_status_id == this.statusRefund
      ) {
        return true
      }

      return false
    },
    checkOrderPacking() {
      if (this.order.order_status_id == this.statusPacking ||
        this.order.order_status_id == this.statusStringent
      ) {
        return true
      }

      return false
    },
    checkStatusSuccess() {
      if (this.order.order_status_id == this.statusSuccess) {
        return true
      }

      return false
    },

    checkStatusRefund() {
      if (this.order.order_status_id == this.statusRefund) {
        return true
      }

      return false
    },
    shippingSuccess() {
      Swal.fire({
        text: `Đơn hàng ${this.order.code} đã được giao thành công ?`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then(async (result) => {
        if (result.isConfirmed) {
          this.$emit('shippingSuccess')
        }
      })
    },
    refund() {
      Swal.fire({
        text: `Đơn hàng ${this.order.code} đã được chuyển hoàn ?`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
      }).then(async (result) => {
        if (result.isConfirmed) {
          this.$emit('refund')
        }
      })
    },
    async unApprove() {
      try {
        this.loadingStart()
        let orderId = this.order.id;
        await this.order.unApproveOrder(orderId);
        this.$emit('rejectApproveOrder')
        this.messageSuccess(`Bạn đã duyệt đơn hàng thành công!`)
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    }
  },
  created() {
  }
}
</script>

<style scoped>

</style>