/**
 * Helpers
 */

import $ from 'jquery';
import { APP_ENV, API_VERSION } from '@/config/app'

const Utility = {
  install: (Vue) => {
    Vue.prototype.$helper = Utility;
  },

  /**
   * Get internal url
   * @public
   * @param {string} path
   * @param params
   */
  url(path = '', params) {
    let url = window.location.origin ;
    // let url = 'http://shop1.tuhav2.local/proxy/account/v1';
    path = path || ''

    url += '/' + path.replace(/^[/\\]+|[/\\]+$/g, '')
    if (typeof params === 'object') {
      url += '?' + $.param(params)
    }
    return url
  },

  /**
   * Get API url
   * @public
   * @param path
   * @param params
   * @returns {string}
   */
  apiUrl(path = '', params) {
    // let url = this.url(`/account/v1/${API_VERSION}`)
    // let url = window.location.origin+'/proxy';
    let url = window.location.origin ;
    path = path || ''
    url += '/' + path.replace(/^[/\\]+|[/\\]+$/g, '')
    if (typeof params === 'object') {
      url += '?' + $.param(params)
    }
    return url
  },

  /**
   * Redirect to internal url
   * @public
   * @param {string} path
   */
  redirect(path = '') {
    let url = window.location.origin
    path = path || ''
    window.location.href = url + '/' + path.replace(/^[/\\]+|[/\\]+$/g, '')
  },

  pushState({$route, params} = {}) {
    if (typeof params === 'object') {
      if (Object.keys(params).length > 0) {
        const url = window.location.origin + $route.path + '?' + $.param(params)
        history.pushState({}, document.title, url)
      }
    }
  },

  /**
   * Format number to string
   * @public
   * @param number
   * @param splitter
   * @returns {string}
   */
  formatCurrency(number, splitter = '.') {
    if (number === null || number === '') {
      return '';
    }

    let temp_number_string = String(Number(number));
    let temp_number_array = [];
    temp_number_string = temp_number_string.replace(/\./g, '');
    temp_number_string = temp_number_string.split('');
    temp_number_string.reverse();
    temp_number_string.forEach(function (item, key) {
      temp_number_array.push(item);
      if ((key + 1) % 3 === 0 && temp_number_string[key + 1]) {
        temp_number_array.push(splitter);
      }
    });
    temp_number_array.reverse();
    return String(temp_number_array.join(''));
  },

  /**
   * @public
   * @param string
   * @returns {number}
   */
  stringToPrice(string) {
    let price = string.replace(/[^\d]+/ig, '');
    return Number(price);
  },

  formatMoney(number, currency = 'VND') {
    number = number == null ? 0 : number
    const currencyMap = {
      'VND': '₫'
    }

    let money = this.formatCurrency(number)
    switch (currency) {
      case 'VND':
        money += ` ${currencyMap[currency]}`
    }
    return money
  },

  /**
   * Price to string
   * @public
   * @param number
   * @returns {string}
   */
  priceToString(number) {
    if (number === null || number === '') {
      return '';
    }

    let temp_number_string = String(Number(number));
    let temp_number_array = [];
    temp_number_string = temp_number_string.replace(/\./g, '');
    temp_number_string = temp_number_string.split('');
    temp_number_string.reverse();
    temp_number_string.forEach(function (item, key) {
      temp_number_array.push(item);
      if ((key + 1) % 3 === 0 && temp_number_string[key + 1]) {
        temp_number_array.push('.');
      }
    });
    temp_number_array.reverse();
    return String(temp_number_array.join(''));
  },

  /**
   * Convert to number
   * @public
   * @param number
   * @returns {number}
   */
  number(number) {
    return Number(number);
  },

  /**
   * Show toasted message - success
   * @public
   * @param message
   * @param options
   */
  messageSuccess(message, options = {}) {
    window.app.$snotify.success(message)
    // window.app.$vs.notify({
    //   title:'Thông báo',
    //   text: message,
    //   color:'success',
    //   iconPack: 'feather',
    //   icon:'icon-check',
    //   position: options.position || 'bottom-right',
    // })
  },

  /**
   * Show toasted message - success
   * @public
   * @param message
   * @param actionCallback
   */
  messageSuccessWButton(message, actionCallback) {
    // window.app.$vs.notify({
    //   title:'Thông báo',
    //   text: message,
    //   color:'success',
    //   iconPack: 'feather',
    //   icon:'icon-message-square',
    //   position:'top-right',
    //   click: actionCallback,
    //   time: 8 * 1e3
    // })
  },

  /**
   * Show toasted message - error
   * @public
   * @param message
   * @param options
   */
  messageError(message, options = {}) {
    window.app.$snotify.error(message)
    // window.app.$vs.notify({
    //   title:'Thông báo',
    //   text: message,
    //   color:'danger',
    //   iconPack: 'feather',
    //   icon:'icon-alert-triangle',
    //   position: options.position || 'bottom-right',
    // })
  },

  /**
   * Show toasted message - error
   * @public
   * @param message
   * @param options
   */
  messageWarning(message, options = {}) {
    window.app.$snotify.warning(message)
    // window.app.$vs.notify({
    //   title:'Thông báo',
    //   text: message,
    //   color:'warning',
    //   iconPack: 'feather',
    //   icon:'icon-alert-triangle',
    //   position: options.position || 'bottom-right',
    // })
  },

  /**
   * Set timeout function, wait for every change event
   * @public
   * @param fn
   * @param time
   */
  timeoutWaitChange: function (fn, time) {
    if (this.timeoutSet) {
      clearTimeout(this.timeoutSet);
    }
    this.timeoutSet = setTimeout(fn, time !== null ? time : 5e2);
  },

  /**
   * @public
   * @param event
   */
  moveFocusElement(event) {
    let element = event.target;
    let keyCode = event.keyCode || event.which;

    switch (keyCode) {
      case 38:
        if (element.previousSibling && element.previousSibling.nodeName === element.nodeName) {
          $(element.previousSibling).focus();
        }
        break;
      case 40:
        if (element.nextSibling && element.nextSibling.nodeName === element.nodeName) {
          element.nextSibling.focus();
        }
        break;
      case 13:
        element.click();
        break;
    }
  },

  /**
   * Check if string is empty
   * @public
   * @param str
   * @returns {boolean}
   */
  isEmpty(str) {
    return str === null || str.trim().length === 0;
  },

  /**
   * Start loading spinner
   * @public
   */
  startLoading() {
    $('#page-loading').fadeIn(100);
  },

  /**
   * Stop loading spinner
   * @public
   */
  stopLoading() {
    $('#page-loading').fadeOut(100);
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

  /**
   * @public
   * @param file
   * @returns {Promise<any>}
   */
  getFileBase64(file) {
    return fetch(file).then(r => r.blob()).then(blob => {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
      })
    })
  },

  /**
   * @public
   * @param fileName
   * @returns {T}
   */
  getFileExtension(fileName) {
    return fileName.split('.').pop();
  },

  /**
   * @public
   * @param phone
   * @returns {boolean}
   */
  isValidPhone(phone) {
    if (phone === null) return false;
    phone = phone.trim();
    let regex = /^\(?([0-9]{3})\)?[-.●]?([0-9]{3})[-.●]?([0-9]{4,5})$/;
    return regex.test(phone);
  },

  /**
   * @public
   * @param email
   * @returns {boolean}
   */
  isValidEmail(email) {
    if (email === null) return false;
    email = email.trim();
    let regex = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)$/;
    return regex.test(email);
  },

  // Restricts input for the given textbox to the given inputFilter function.
  setInputFilter(textBox, inputFilter) {
    let handler = function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    };

    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textBox.removeEventListener(event, handler)
      textBox.addEventListener(event, handler)
    });
  },

  devtoolWarning() {
    const warningTitleCSS = 'color:red; font-size:60px; font-weight: bold; -webkit-text-stroke: 1px black;';
    const warningDescCSS = 'font-size: 18px;';

    console.log('%cDừng lại!', warningTitleCSS);
    console.log('%cĐây là một tính năng của trình duyệt dành cho các nhà phát triển. Nếu ai đó bảo bạn sao chép-dán nội dung nào đó vào đây để bật một tính năng của TUHA V2 hoặc "hack" tài khoản của người khác, thì đó là hành vi lừa đảo và sẽ khiến họ có thể truy cập vào tài khoản TUHA V2 của bạn.', warningDescCSS);
  },

  getBaseColor() {
    return '#7867F3'
  },

  isPrimitive(test) {
    return test !== Object(test);
  },

  isDesktopScreen() {
    return window.app.$vuetify.breakpoint.lg || window.app.$vuetify.breakpoint.xl
  },

  isTabletScreen() {
    return window.app.$vuetify.breakpoint.md
  },

  isMobileScreen() {
    if (this.isDesktopScreen() && this.isTabletScreen()) {
      return false;
    }
    return window.app.$vuetify.breakpoint.mobile;
  },

  getHeaderStyle(t) {
    const defaultColors = function () {
      let bg = '#089bab';
      let bd = '#089bab';
      switch (t) {
        default:
        case 3:
          bg = '#089bab';
          bd = '#089bab';
          break;
        case 2:
          bg = '#2873C5';
          bd = '#2873C5';
          break;
      }
      return {bgColor: bg, bdColor: bd};
    }
    const color = defaultColors(t);
    let bgColor = color.bgColor;
    let bdColor = color.bdColor;

    let sConfig = JSON.parse(localStorage.getItem('shop_info')) || false;
    if (sConfig.type !== t) {
      localStorage.removeItem('shop_info');
      localStorage.removeItem('token');
    }

    if (sConfig && sConfig.type > 1 && this.isRealValue(sConfig.config)) {
      bgColor = sConfig.config.header_color || bgColor;
      bdColor = sConfig.config.header_color || bdColor;
    }
    return {
      'background-color': bgColor + ' !important',
      'border-color': bdColor + ' !important'
    };
  },
  isRealValue(obj) {
    return obj && obj !== 'null' && obj !== 'undefined';
  }
};

export default Utility;

