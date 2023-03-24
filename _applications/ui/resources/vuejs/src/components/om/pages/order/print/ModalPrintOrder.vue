<template>
  <transition name="overlay" mode="out-in">
    <modal
      :id="modalName"
      :name="modalName"
      :adaptive="true"
      width="50%"
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
        <v-form ref="form">
          <v-row>
            <v-col cols="12" class="py-0">
              <h6>Chọn thông tin bạn muốn in</h6>
              <v-row class="my-3">
                <v-col
                  cols="4"
                  v-if="listSelectInformation.length > 0"
                  v-for="(selectInformation, index) in listSelectInformation"
                  :key="index"
                >
                  <v-checkbox
                    v-model="selectInformation.is_selected"
                    :label="selectInformation.name"
                  ></v-checkbox>
                </v-col>
              </v-row>
              <hr>
              <h6>Chọn mẫu in đơn hàng</h6>
              <v-row
                class="mt-3"
              >
                <v-col
                  v-for="printedForm in dataList"
                  :key="printedForm.id"
                  cols="4"
                  align="center"
                >
                  <v-btn
                    class="form-btn"
                    :color="printedForm.id == selected.id ? 'primary' : ''"
                    @click="select(printedForm)"
                  >
                    {{ printedForm.title }}
                  </v-btn>
                </v-col>
              </v-row>
            </v-col>
            <v-col cols="12">
              <v-checkbox
                v-if="selected"
                v-model="selected.is_default"
                :label="`Đặt làm mặc định cho chức năng in tùy chọn`"
              ></v-checkbox>
            </v-col>
          </v-row>
          <v-row v-show="false">
            <v-col cols="12">
              <preview-print-form v-if="selected" :template="selected.content"></preview-print-form>
            </v-col>
          </v-row>
        </v-form>
      </div>
      <footer class="modal-footer">
        <div class="d-flex ">
          <v-btn class="ml-auto mr-3" @click="closeModal()">Hủy bỏ</v-btn>
          <v-btn dark class="primary" @click="print()">In</v-btn>
        </div>
      </footer>
    </modal>
  </transition>
</template>

<script>
import PreviewPrintForm from "@/components/om/pages/order/print/Preview";
import PrintedForm from "@/models/printed-forms/printed_form";
import Collection from "@/core/collection";
import { PRINT_CONFIG, PRINTED_FORM_TYPE } from "@/config/print";


export default {
  name: "ModalPrintOrder",
  props: [
    'order'
  ],
  components: {
    PreviewPrintForm
  },
  data() {
    return {
      modalName: 'modal-print-order',
      title: 'In đơn hàng',
      printedForm: new PrintedForm({ type: 0, store_id: 1 }),
      dataList: new Collection(PrintedForm),
      selected: null,
      printConfig: PRINT_CONFIG,
      printedFormTypes: PRINTED_FORM_TYPE,
      listSelectInformation: []
    }
  },
  computed: {
  },
  methods: {
    beforeOpen() {
    },
    beforeClose() {
    },
    closeModal() {
      this.$modal.hide(this.modalName)
    },
    select(printedForm) {
      this.selected = _.cloneDeep(printedForm)
    },
    async print() {
      if (this.selected.is_default) {
        // TODO lưu tùy chọn in mặc định
      }
      let printWindow = window.open('', '', `height=${screen.height}, width=${screen.width}`);
      printWindow.document.write('<html><body>');
      let printData = document.getElementById('print-content').innerHTML;
      let orderPrintConfig = {};
      for (const [key, value] of Object.entries(this.printConfig)) {
        Object.assign(orderPrintConfig, value);
      }
      this.listSelectInformation.forEach(selectInformation => {
        if (selectInformation.is_selected) {
          if (orderPrintConfig[selectInformation.keyword]) {
            printData = printData.replace(selectInformation.keyword, this.order[orderPrintConfig[selectInformation.keyword].name_db] ?? selectInformation.name);
          }
        }
      });
      let printOption = null;
      this.printedFormTypes.forEach(printedFormType => {
        if (printedFormType.id == this.selected.type) {
          printOption = printedFormType;
        }
      });
      switch (printOption.id) {
        case 6:
        case 7:
        case 8:
          printData = "<div style='width: 50%; display: inline-block;'>" + printData + "</div>";
          break;
        case 9:
          printData = "<div style='width: 33.33%; display: inline-block;'>" + printData + "</div>";
          break;
        default:
          printData = "<div>" + printData + "</div>";
      }
      let allPrintData = '';
      for (let index = 1; index <= printOption.orders_per_sheet; index++) {
        allPrintData += printData;
      }
      printWindow.document.write(allPrintData);
      printWindow.document.write('</body></html>');
      printWindow.print();
      printWindow.document.close();
    },
    async listAsync() {
      try {
        this.loadingStart()
        await this.printedForm.fethSystemForms().then(response => {
          this.dataList = response.data.items
          this.dataList.forEach(printedForm => {
            if (printedForm.is_default) {
              this.selected = _.cloneDeep(printedForm)
              this.listSelectInformation = [];
              let printContent = this.selected.content
              let keywordPattern = /[_*2[A-Z]+[_*2]/g
              let keywordMatches = printContent.match(keywordPattern)
              let orderPrintConfig = this.printConfig.DH;
              if (keywordMatches.length) {
                keywordMatches.forEach(match => {
                  if (orderPrintConfig[match]) {
                    this.listSelectInformation.push({
                      keyword: match,
                      name: orderPrintConfig[match].name,
                      name_db: orderPrintConfig[match].name_db,
                      is_selected: true
                    });
                  }
                });
              }
            }
          });
        })
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      } finally {
        this.loadingClose()
      }
    },
  },
  async created() {
    await this.listAsync()
  }
}
</script>

<style scoped>
.form-btn span {
  text-transform: none;
}
</style>