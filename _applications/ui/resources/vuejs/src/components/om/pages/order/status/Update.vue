<template>
  <v-card>
    <v-card-title class="text-h5 d-flex">
      <div class="flex-grow-1">Cập nhật trạng thái</div>
      <img v-if="showCloseBtn" src="/media/svg/icons/Navigation/Close.svg" @click="onCloseClick" />
    </v-card-title>
    <v-card-text>
      <div class="container px-0">
        <!-- Phan loai -->
        <div class="row">
          <div class="col-12">
            <label class="form-label">Phân loại</label>
            <div v-if="!canChangeAttribute" class="form-control form-control-sm form-control-solid">
              {{ typeName }}
            </div>
            <select v-else class="form-control form-control-sm form-control-solid" v-model="statusModel.type">
              <option value="0">Chọn phân loại trạng thái</option>
              <option v-for="(type, id) of types" :value="id">
                {{ type }}
              </option>
            </select>
          </div>
        </div>

        <!-- Chuc nang -->
        <div class="row" v-if="isSystem">
          <div class="col-12">
            <label class="form-label">Chức năng</label>
            <div class="form-control form-control-sm form-control-solid">{{ statusModel.action_name }}</div>
          </div>
        </div>

        <!-- Level -->
        <div class="row">
          <div class="col-12">
            <label class="form-label">Level(*)</label>
            <div v-if="!canChangeAttribute" class="form-control form-control-sm form-control-solid">
              {{ levelName }}
            </div>
            <select v-else class="form-control form-control-sm" v-model="statusModel.level">
              <option value="0">Chọn level trạng thái</option>
              <option v-for="level of levels" :value="level">Level {{ level }}</option>
            </select>
          </div>
        </div>

        <!-- Ten -->
        <div class="row">
          <div class="col-12">
            <label class="form-label">Tên trạng thái</label>
            <input class="form-control form-control-sm" v-model="statusModel.name" />
          </div>
        </div>

        <!-- Tinh doanh thu -->
        <div class="row">
          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" v-model="statusModel.is_no_revenue" />
              <label class="form-check-label"> Tính doanh thu </label>
            </div>
          </div>
        </div>

        <!-- Hieu luc -->
        <div class="row" v-if="!isSystem">
          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" v-model="statusModel.is_active" />
              <label class="form-check-label"> Hiệu lực</label>
            </div>
          </div>
        </div>
      </div>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="grey darken-1" text @click="onCancelBtnClick"> Hủy </v-btn>
      <v-btn color="btn-primary" text @click="onSaveBtnClick"> Lưu </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script type="text/javascript">
import OrderStatus from "@/models/order/order_status";
import * as Request from "@/components/om/utils/Request";
import * as MessageConst from "@/components/om/utils/MessageConst";

export const EMITS = {
  UPDATED: "updated",
  CLOSE: "close",
  CANCEL: "cancel",
  UPDATING: "updating",
  UPDATE_ERROR: "update-error",
};

const SUCCESS = 1;
const ERROR = 0;

export default {
  name: "OrderStatusUpdate",

  data: () => ({
    updateStatus: null,
  }),

  props: {
    statusModel: OrderStatus,
    showCloseBtn: false,
  },

  computed: {
    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    type() {
      return this.statusModel.types()[this.statusModel.type];
    },

    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    typeName() {
      return this.type?.name;
    },

    /**
     * { function_description }
     *
     * @param      {string}  [prefix='Level ']  The prefix
     * @return     {<type>}  { description_of_the_return_value }
     */
    levelName() {
      return "Level " + (this.type?.levels[this.statusModel.level] || "");
    },

    /**
     * Determines if system.
     *
     * @return     {boolean}  True if system, False otherwise.
     */
    isSystem() {
      return this.statusModel.is_system;
    },

    /**
     * Determines ability to change attribute.
     *
     * @return     {boolean}  True if able to change attribute, False otherwise.
     */
    canChangeAttribute() {
      return !this.isSystem;
    },

    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    types() {
      const types = this.statusModel.types();
      return Object.keys(types).reduce((res, id) => {
        res[id] = types[id].name;

        return res;
      }, {});
    },

    /**
     * { function_description }
     */
    levels() {
      return _.get(this.statusModel.types(), `${this.statusModel.type}.levels`, []);
    },

    /**
     * Determines if updating.
     *
     * @return     {boolean}  True if updating, False otherwise.
     */
    isUpdating() {
      return this.updateStatus === Request.UPDATING;
    },

    /**
     * Determines if successed.
     *
     * @return     {boolean}  True if successed, False otherwise.
     */
    isSuccessed() {
      return this.updateStatus === Request.SUCCESS;
    },
  },

  watch: {
    "statusModel.type": function (n, o) {
      this.statusModel.level = 0;
    },

    /**
     * { function_description }
     *
     * @param      {<type>}  n       { parameter_description }
     * @param      {<type>}  o       { parameter_description }
     * @return     {<type>}  { description_of_the_return_value }
     */
    updateStatus(n, o) {
      if (n === Request.ERROR) {
        return this.$emit(EMITS.UPDATE_ERROR);
      }
    },
  },

  methods: {
    /**
     * Called on close click.
     *
     * @param      {<type>}  event   The event
     */
    onCloseClick(event) {
      this.$emit(EMITS.CLOSE);
    },

    /**
     * Called on cancel click.
     *
     * @param      {<type>}  event   The event
     */
    onCancelBtnClick(event) {
      this.$emit(EMITS.CANCEL);
    },

    /**
     * Called on save click.
     *
     * @param      {<type>}  event   The event
     */
    async onSaveBtnClick(event) {
      try {
        this.$emit(EMITS.UPDATING);

        await this.update();

        if (this.isSuccessed) {
          this.$emit(EMITS.UPDATED);
        }
      } catch (e) {
        this.updateStatus = Request.ERROR;
        this.handleException(e);
      }
    },

    /**
     * { function_description }
     *
     * @return     {Promise}  { description_of_the_return_value }
     */
    async update() {
      if (this.isUpdating) {
        return;
      }

      this.updateStatus = Request.UPDATING;
      await this.statusModel.updateAsync();
      this.updateStatus = Request.SUCCESS;
    },
  },

  UPDATED() {},
};
</script>
