<template>
  <v-card flat>
    <h3 class="mt-3">Diễn giải</h3>
    <p class="body-1">- NVC: Nhà vận chuyển.</p>
    <p class="body-1">- Tên: Để dễ nhận biết khi lựa chọn.</p>
    <p class="body-1">- Id tra cứu: Là ID tra cứu (Đối với bưu điện Hà Nội), là ClientID (Đối với giao hàng nhanh (GHN)). Giao hàng tiết kiệm (GHTK), là Username (Đối với BEST).</p>
    <p class="body-1">- Mã xác thực:</p>
    <p class="body-1">- Là Mã xác thực (Đối với bưu điện Hà Nội).</p>
    <p class="body-1">- Là customerid do J&T cung cấp (Đối với J&T).</p>
    <p class="body-1">- Là mật khẩu do BEST cung cấp (Đối với BEST).</p>
    <p class="body-1">- Là API key - Token (Đối với GHN).
      <span class="text-danger">Đường dẫn đăng nhập để lấy ClientID, API key bên GHN:</span>
      <a class="text-decoration-underline" href="#">https://sso.ghn.vn/ssoLogin?app=apiv3.</a>
    </p>
    <p class="body-1">- Là API Token Key do (Đối với GHTK).
      <span class="text-danger">Đường dẫn đăng nhập để lấy API Token Key bên GHTK:</span>
      <a class="text-decoration-underline" href="#">https://khachhang.giaohangtietkiem.vn/khach-hang/dang_nhap.</a>
      Sau khi đăng nhập, quý khách click vào Sửa thông tin cửa hàng, copy mã API Token Key.</p>
    <p class="body-1">- Để lấy mã xác thực bên Viettel Post, quý khách click vào
      <a class="text-decoration-underline" href="#">link sau</a>
      , nhập vào tài khoản Viettel Post, rồi click Lấy mã xác thực. Nếu quý khách chưa có tài khoản trên Viettel Post, vui lòng click vào
      <a class="text-decoration-underline" href="#">link sau</a>
      để đăng ký và lấy mã xác thực.</p>
    <p class="body-1">- Tiền tố mã vạch: Sử dụng để in mã vạch. VD: SP06.GHTK0112121 (có thể bỏ qua).</p>
    <p class="body-1">- Ẩn: Không sử dụng hãng vận chuyển này.</p>
    <v-alert
      prominent
      text
      type="info"
      color="warning"
      border="left"
    >
      <p class="body-1 font-weight-bold">TUHA mới tích hợp thêm đơn vị vận chuyển EMS. Để tích hợp đơn vị vận chuyển này, quý khách cần thực hiện như sau:</p>
      <p class="body-1 font-weight-bold">B1. Lấy mã xác thực:</p>
      <p class="body-1 font-weight-bold">- Quý khách đăng nhập tài khoản EMS theo đường dẫn sau
        <a class="text-decoration-underline font-weight-bold" href="#">https://bill.ems.com.vn/</a>
        . Tại menu Cấu hình, chọn Api Key, tạo 1 API KEY mới, copy mã API KEY.</p>
      <p class="body-1 font-weight-bold">B2. Cấu hình đường dẫn nhận những thay đổi trạng thái đơn hàng:</p>
      <p class="body-1 font-weight-bold">- Sau khi
        <a class="text-decoration-underline font-weight-bold" href="#">đăng nhập</a>
        trang EMS. Tại menu Cấu hình, chọn Webhook, tạo 1 Webhook mới. Tại vị trí ô Callback Url nhập link sau:
        <br>
        <a class="text-decoration-underline font-weight-bold" href="#">https://tuha.vn/work-auth/shipping.php?cmd=ems_callback&hash=85a7ada570bc8d6cd9fa01f2248f5574.</a>
      </p>
      <p class="body-1 font-weight-bold">Bước 3. Đồng bộ dữ liệu
        <a class="text-decoration-underline font-weight-bold" href="#">địa chỉ lấy hàng</a>
        bên TUHA và EMS:</p>
      <p class="body-1 font-weight-bold">- Sửa địa chỉ lấy hàng, click nút Tạo kho hàng trên EMS.</p>
    </v-alert>
    <v-row>
      <v-col md="12" class="py-0">
        <v-btn
          class="my-5 float-end"
          dark small
          color="primary"
          @click=""
        >
          Thêm mới
        </v-btn>
      </v-col>
    </v-row>
    <v-row class="" v-show="firstFetched">
      <v-col md="12">
        <v-card class="mb-1">
          <v-data-table
            class="om-wp_border-left om-wp_border-top om-wp_border-bottom om-wp_border-right"
            no-data-text="Không tồn tại dữ liệu"
            :headers="headers"
            :items="dataList"
            hide-default-footer
            :items-per-page="params.limit"
          >
            <template v-slot:item.index="{ item, index }">
              <span>{{ index + 1 }}</span>
            </template>
  
            <template v-slot:item.shipping_provider_id="{ item }">
<!--              <span>{{ item.shippingProvider.name }}</span>-->
              <span>Giao hàng tiết kiệm</span>
            </template>
  
            <template v-slot:item.verify_id="{ item }">
<!--              <span>{{ item.verify.name }}</span>-->
              <span>FC24005-NguyenQuy</span>
            </template>
  
            <template v-slot:item.is_default="{ item }">
              <v-icon
                v-show="item.is_default"
                small
                color="darken-2"
              >
                mdi-check-circle
              </v-icon>
            </template>
  
            <template v-slot:item.is_active="{ item }">
              <v-icon
                v-show="item.is_active"
                small
                color="darken-2"
              >
                mdi-check-circle
              </v-icon>
            </template>
            
            <template v-slot:item.action="{ item }">
              <v-icon
                class="cursor-pointer"
                small
                color="darken-2"
                @click=""
              >
                fas fa-edit
              </v-icon>

              <v-icon
                class="cursor-pointer"
                color="darken-2"
                @click=""
              >
                mdi-delete
              </v-icon>
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
            <div class="ml-3">Tổng số: <b>{{ total }}</b></div>
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
        </v-card>
      </v-col>
    </v-row>
    <br>
    <v-alert
      prominent
      text
      type="info"
      color="warning"
      border="left"
    >
      <p class="body-1 font-weight-bold">Chú ý:</p>
      <p class="body-1 font-weight-bold">1. Với Bưu Điện Hà Nội bạn bắt buộc phải nhập thông tin tài khoản vận chuyển do BĐHN cung cấp.</p>
      <p class="body-1 font-weight-bold">2. Với GHN và GHTK:</p>
      <p class="body-1 font-weight-bold">- Nếu bạn chưa có tài khoản thì hệ thống sẽ sử dụng tài khoản mặc Định của Tuha.</p>
      <p class="body-1 font-weight-bold">- Nếu bạn đã có tài khoản do GHN hoặc GHTK cung cấp thì vui lòng nhấn vào Thêm mới để khai báo tài khoản của bạn đã được đơn vị vận chuyển cung cấp.</p>
      <p class="body-1 font-weight-bold">3. Với BEST, hệ thống sẽ sử dụng tài khoản mặc định của Tuha.</p>
    </v-alert>
  </v-card>
</template>

<script>
import Collection from "@/core/collection";
import Filter from "@/core/filter";
import ShippingProvider from "@/models/shipping-provider/shipping-provider";

export default {
  name: "ShippingPartner",
  props: ['isChange'],
  components: {
  },
  data() {
    return {
      params: new Filter(this.$route.query),
      firstFetched: false,
      shippingProvider: new ShippingProvider(),
      dataList: new Collection(ShippingProvider),
      total: 0,
      page: 1,
      totalPage: 1,
      headers: [
        {text: 'STT', value: 'index', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Hãng vận chuyển', value: 'shipping_provider_id', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên tài khoản', value: 'account_name', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tên shop', value: 'shop_name', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'ID tra cứu (NVC cung cấp)', value: 'verify_id', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Mã xác thực (NVC cung cấp)', value: 'verify_secret', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tiền tố mã vạch', value: 'prefix', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Đặt làm mặc định', value: 'is_default', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Hiệu lực', value: 'is_active', align: 'center', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
        {text: 'Tiện ích', value: 'action',  align: 'center', width: '100', sortable: false, class: 'om-wp_border-left', cellClass: 'om-wp_border-left'},
      ],
      options: [10, 20, 30]
    }
  },
  methods: {
    async paginate(page) {
      this.params.offset = (page - 1) * this.params.limit
      await this.listAsync()
      this.page = page
    },
    
    async search() {
      this.page = 1
      this.params.offset = 0
      this.selected = []
      await this.listAsync()
    },

    async listAsync() {
      try {
        const params = this.params.reduces()
        this.loadingStart()
        this.dataList = await this.shippingProvider.getListAsync(params)
        this.total = this.dataList.total
        this.totalPage = this.dataList.totalPage
        this.firstFetched = true
      } catch (e) {
        this.handleException(e)
      }
    },
  },
  computed: {
  },
  async created() {
    this.params.limit = this.$route.query.limit || 10
    await this.listAsync()
  },
  mounted() {
  },
}
</script>

<style lang="scss">

</style>