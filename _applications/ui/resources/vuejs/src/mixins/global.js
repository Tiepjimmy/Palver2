import {mapGetters} from 'vuex'
import Nprogress from "nprogress";
import {APP_ENV} from "@/config/app";

const GlobalMixins = {
  beforeRouteEnter(to, from, next) {
    next()
  },

  beforeRouteLeave(to, from, next) {
    this.loadingStart()
    next()
  },

  computed: {
    ...mapGetters({
      //token: 'auth/token',
      user: 'auth/user',
    })
  },

  methods: {
    loadingStart() {
      Nprogress.start()
    },
    loadingClose() {
      Nprogress.done()
    },
    refreshPage(params = {}) {
      this.$router.replace({name: this.$route.name, query: params}).catch(err => {})
    },
    merge(object, value) {
      object.push(...value || [])
      return object
    },
    messageSuccess(message) {
      this.$bvToast.toast(message, {
        title: 'Thông báo',
        toaster: 'b-toaster-bottom-right',
        variant: 'success',
        solid: true
      })
    },
    messageError(message) {
      this.$bvToast.toast(message, {
        title: 'Thông báo',
        toaster: 'b-toaster-bottom-right',
        variant: 'danger',
        solid: true
      })
    },
    messageWarning(message) {
      this.$bvToast.toast(message, {
        title: 'Thông báo',
        toaster: 'b-toaster-bottom-right',
        variant: 'warning',
        solid: true
      })
    },
    handleException(e) {
      if (APP_ENV === 'local') {
        console.log(e)
      }

      if (typeof e === 'string') {
        this.messageError(e)
      } else {
        this.messageError(e.message || 'Có lỗi xảy ra, vui lòng thử lại')
      }
    },
  }
}

export default GlobalMixins
