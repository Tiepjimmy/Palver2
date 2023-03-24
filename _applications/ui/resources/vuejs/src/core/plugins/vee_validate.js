import Vue from 'vue'
import Validator from 'vee-validate'

const phoneNumber = {
  getMessage(field, args) {
    return `Số điện ${field} thoại không hợp lệ`;
  },
  validate (value, args) {
    var vnf_regex = /((0)+([0-9]{9,12})\b)/g;
    if(value !==''){
      if (vnf_regex.test(value) == false)
      {
        return false
      }else{
        return true
      }
    }
    return  false

  }
};


Validator.Validator.extend('phoneNumber', phoneNumber);

Vue.use(Validator);