<template>
  <v-card>
    <v-card-title class="text-h5 d-flex">
      <div class="flex-grow-1">Thêm mới trạng thái</div>
      <img v-if="showCloseBtn" src="/media/svg/icons/Navigation/Close.svg" @click="onCloseClick" />
    </v-card-title>
    <v-card-text>
      <div class="container px-0">
        <v-form ref="form">
          <label class="form-label">Phân loại (*)</label>
          <v-select
            v-model="status.type"
            :items="types"
            placeholder="Chọn phân loại trạng thái"
            outlined
            dense
            item-text="name"
            item-value="id"
            :rules="[rules.type]"
          ></v-select>

          <label class="form-label">Level(*)</label>
          <v-select
            v-model="status.level"
            :items="levels"
            placeholder="Chọn level trạng thái"
            outlined
            dense
            item-text="name"
            item-value="id"
            :rules="[rules.level]"
          ></v-select>

          <label class="form-label">Tên trạng thái (*)</label>
          <v-text-field
            v-model="status.name"
            placeholder="Tên trạng thái"
            outlined
            dense
            :rules="[rules.name]"
          >
          </v-text-field>

          <v-checkbox v-model="status.is_no_revenue" label="Tính doanh thu "></v-checkbox>
        </v-form>
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
  CREATED: "created",
  CLOSE: "close",
  CANCEL: "cancel",
  CREATING: "creating",
  CREATE_ERROR: "create-error",
};

export default {
  name: "OrderStatusCreate",

  data: () => ({
    status: new OrderStatus(),
    createStatus: null,

    rules: {
      type: v => !!v || "Phân loại là bắt buộc",
      level: v => !!v || "Level là bắt buộc",
      name: v => {
        if (!v) return "Tên trạng thái là bắt buộc";
        if (v.length > 50) return "Tên trạng thái tối đa 50 kí tự";

        return true
      },
    },
  }),

  props: {
    showCloseBtn: false,
  },

  computed: {
    /**
     * { function_description }
     *
     * @return     {<type>}  { description_of_the_return_value }
     */
    types() {
      const types = this.status.types();

      return Object.keys(types).reduce(function (res, id) {
        return _.tap(res, res => res.push({ id: id, name: types[id].name }));
      }, []);
    },

    /**
     * { function_description }
     */
    levels() {
      const raw = _.get(this.status.types(), `${this.status.type}.levels`, []);

      return _.map(raw, (e, i) => ({ id: i, name: "Level " + e }));
    },

    /**
     * Determines if creating.
     *
     * @return     {boolean}  True if creating, False otherwise.
     */
    isCreating() {
      return this.createStatus === Request.CREATING;
    },

    /**
     * Determines if successed.
     *
     * @return     {boolean}  True if successed, False otherwise.
     */
    isSuccessed() {
      return this.createStatus === Request.SUCCESS;
    },
  },

  watch: {
    "status.type": function (n, o) {
      this.status.level = 0;
    },

    /**
     * Creates a status.
     *
     * @param      {<type>}  n       { parameter_description }
     * @param      {<type>}  o       { parameter_description }
     * @return     {<type>}  { description_of_the_return_value }
     */
    createStatus(n, o) {
      if (n === Request.ERROR) {
        return this.$emit(EMITS.CREATE_ERROR);
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
      this.$refs.form.reset()
      this.$refs.form.resetValidation()
      this.$emit(EMITS.CANCEL);
    },

    /**
     * Called on save click.
     *
     * @param      {<type>}  event   The event
     */
    async onSaveBtnClick(event) {
      if(!this.$refs.form.validate()){
        return;
      }

      this.$emit(EMITS.CREATING);

      try {
        await this.save();

        if (this.isSuccessed) {
          this.$emit(EMITS.CREATED);
          this.messageSuccess(MessageConst.SUCCESS_MESSAGE_SAVE);
        }
      } catch (e) {
        this.handleException(e);
      }
    },

    /**
     * { function_description }
     *
     * @return     {Promise}  { description_of_the_return_value }
     */
    async save() {
      if (this.isCreating) {
        return;
      }

      this.createStatus = Request.CREATING;
      await this.status.storeAsync();
      this.createStatus = Request.SUCCESS;
    },
  },

  created() {
    this.status.level = 0;
    this.status.type = 0;
  },
};
</script>
