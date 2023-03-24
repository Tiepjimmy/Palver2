import Vue from 'vue'
import axios from 'axios'
import store from '@/store'
import Nprogress from "nprogress";
import { HTTP_BAD_REQUEST } from "@/core/HttpCodes";

Vue.prototype.$http = axios

let tokenRefreshed = false


//add Bearer to header authorization
axios.interceptors.request.use(async function (config) {
  try {
    const token = localStorage.getItem('token')
    if (token !== null) {

      if (store.getters['auth/token'] !== null && token !== store.getters['auth/token']) {
        if (! tokenRefreshed) {
          tokenRefreshed = true
          alert('Lỗi duyệt web. Vui lòng tải lại trang!');
          window.location.reload()
        }
      }

      config.headers.Authorization = `Bearer ${token}`
    }
  } catch (e) {
    console.log('axios.interceptors.request', e)
  }

  return config
}, function (err) {
  return Promise.reject(err)
})

//check auth
axios.interceptors.response.use(function (response) {
  // Close loading
  Nprogress.done()

  return response
}, function (error) {
  // Close loading
  Nprogress.done()

  // eslint-disable-next-line no-unused-vars
  const {config, response: {status}} = error
  let response =JSON.parse(error.request.responseText);

  switch (status) {
    case 401:
      if (response.hasOwnProperty('code')) {
        if (response.code === 2) {
          error.message = 'Hết phiên làm việc, vui lòng đăng nhập lại'
        } else {
          error.message = 'Lỗi xác thực thông tin truy cập'
        }
      } else{
        error.message = 'Lỗi xác thực thông tin truy cập'
      }

      store.commit('auth/LOGOUT')
      window.location.href = window.location.origin
      break
    case 402:
      store.commit('auth/LOGOUT')
      break
    case 403:
      error.message = 'Bạn không có quyền thực hiện thao tác này'
      break
    case 412:
      error.message = 'Lỗi xác thực tài khoản'
    case 429:
      error.message = 'Bạn thao tác quá nhanh. Vui lòng thử lại sau 1 phút'

    // Cho phép mã lỗi là 400 (mã lỗi validate dữ liệu fail) resolve để handle lỗi
    case HTTP_BAD_REQUEST:
      return Promise.resolve(response)
  }

  return Promise.reject(error)
})

export default axios
