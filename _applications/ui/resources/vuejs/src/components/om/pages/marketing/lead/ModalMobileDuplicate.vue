<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="80%"
      :minWidth="375"
      height="auto"
      :scrollable="true"
      :clickToClose="false"
      @before-open="beforeOpen"
      @before-close="beforeClose"
    >
      <header class="modal-header flex">
        <h4 class="m-auto">{{ title }}</h4>
        <v-btn
          icon
          @click="closeModal()"
        >
          <v-icon
          >
            mdi-close
          </v-icon>
        </v-btn>
      </header>
      <div class="modal-body">
        <div class="d-flex">
          <p style="width: 150px">Số lần trùng:</p>
          <p class="red--text font-weight-bold">{{ duplicated }} lần</p>
        </div>
        <div class="d-flex">
          <p  style="width: 150px">Số điện thoại trùng:</p>
          <p class="red--text font-weight-bold">{{ lead.mobile }}</p>
        </div>
        <v-data-table
          class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
          :headers="headers"
          :items="dataList"
          no-data-text="Không tồn tại dữ liệu"
          :items-per-page="100"
          hide-default-footer
          item-key="name"
        >

          <template v-slot:item.action="{ item }">
            <v-icon
              class="cursor-pointer"
              small
              color="darken-2"
              @click="openModalEdit(item)"
            >
              fas fa-edit
            </v-icon>
          </template>

          <template v-slot:item.channel="{ item }">
            <div>{{ item.channel ? item.channel.name : '' }}</div>
          </template>

          <template v-slot:item.lead_status_id="{ item }">
            <v-chip
              :color="getColorStatus(item.lead_status_id)"
              outlined
              small
              class="ma-2"
            >
              {{ getNameStatus(item.lead_status_id) }}
            </v-chip>
          </template>

          <template v-slot:item.sub_channel="{ item }">
            <div>{{ item.sub_channel ? item.sub_channel.name : '' }}</div>
          </template>

          <template v-slot:item.user_assigned="{ item }">
            <div>{{ item.user_assigned ? item.user_assigned.name : '' }}</div>
          </template>
        </v-data-table>
      </div>
    </modal>
  </transition>
</template>

<script>
import Collection from "@/core/collection";
import Lead from "@/models/marketing/leads";

export default {
  name: "ModalMobileDuplicate",
  data() {
    return {
      duplicated: 5,
      modalName: 'modal-mobile-duplicate',
      title: 'Danh sách số trùng',
      lead: new Lead(),
      dataList: new Collection(Lead),
      headers: [
        {text: '', value: 'action',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Ngày tạo', value: 'created_at', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Tên khách hàng', value: 'name',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Mô tả', value: 'note', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Kênh', value: 'channel', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Sub kênh', value: 'sub_channel',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Loại sản phẩm', value: 'bundle', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'Trạng thái', value: 'lead_status_id', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'},
        {text: 'NV chăm sóc', value: 'user_assigned', align: 'center', width: '100', sortable: false, class: 'om-wp_border-right', cellClass: 'om-wp_border-right'}
      ],
      statuses: [
        {name: 'Chờ chăm sóc', id: 1, color: 'red'},
        {name: 'Số hủy', id: 2, color: 'blue'},
        {name: 'Đang chăm sóc', id: 3, color: 'orange'},
        {name: 'Đã tạo đơn', id: 4, color: 'green'},
      ],
    }
  },
  methods: {
    getNameStatus(id) {
      let status = this.statuses.find(i => i.id == id )

      return status.name
    },

    getColorStatus(id) {
      let status = this.statuses.find( i => i.id == id )

      return status.color
    },
    openModalEdit(item) {

    },
    beforeOpen(event) {
      this.lead = _.cloneDeep(event.params.lead)
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
  }
}
</script>

<style scoped>

</style>