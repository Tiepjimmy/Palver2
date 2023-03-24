/**
 * Response Json
 */

import stdClass from './stdClass';
import {v1 as uuidv1} from 'uuid'

class ResponseJson extends stdClass {
  success = 0
  code = 0
  data
  exception
  message
  recordsTotal = 0
  page = 1
  totalPage = 0
  c

  constructor(data) {
    super();
    this.bind(data);
  }

  bind(data, clone = false) {
    if (data !== null) {
      try {
        for (let i in data) {
          const p = i.replace(/^\w/, c => c.toLowerCase());
          let _data = !clone ? data[i] : _.cloneDeep(data[i]);
          if (this[p] instanceof stdClass) {
            this[p].bind(_data, clone);
          } else if (this[p] instanceof Array) {
            if (this[p].name === 'Collection') {
              this[p].addRange(_data);
            } else {
              this[p] = _data || [];
            }
          } else {
            if (~this.typeOfNumber().indexOf(p)) {
              _data = data[i] !== null ? Number(_data) : 0;
            }
            this[p] = _data;
          }
        }
      } catch (e) {
        console.log(e)
      }
    }

    this.id = this.id || uuidv1();
    return this;
  }

  /**
   * Public
   * @returns {boolean}
   */
  isSuccess() {
    return this.success === 1;
  }
}

export default ResponseJson
