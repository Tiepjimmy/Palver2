/**
 * stdClass
 * @param data
 */

import Utility from '@/helpers/utility';
import {v1 as uuidv1} from 'uuid';

const _ = require('lodash');

class stdClass {
  id

  /**
   * stdClass constructor
   */
  constructor() {
    this.id = uuidv1();
  }

  bind(data, clone = false) {
    if (data != null) {
      try {
        for (let i in data) {
          // const p = i.replace(/^\w/, c => c.toLowerCase());
          const p = i
          if (!this.hasOwnProperty(p)) {
            continue
          }

          let _data = !clone ? data[i] : _.cloneDeep(data[i])
          if (this[p] instanceof stdClass) {
            this[p].bind(_data, clone)
            continue
          }

          if (this[p] instanceof Array) {
            if (this[p].name === 'Collection') {
              this[p].addRange(_data);
            } else {
              this[p] = _data || [];
            }
            continue
          }

          if (~this.typeOfNumber().indexOf(p)) {
            _data = data[i] !== null ? Number(_data) : 0;
          } else if (~this.typeOfTimestamp().indexOf(p)) {
            _data = data[i] !== null ? _data * 1e3 : null;
          }

          this[p] = _data;
        }
      } catch (e) {
        console.log(e)
      }
    }

    this.id = this.id || uuidv1();
    return this;
  }

  typeOfNumber() {
    return [];
  }

  typeOfTimestamp() {
    return [];
  }

  valueStringOrDefault(number) {
    if (number === null) {
      return '';
    }
    return Utility.priceToString(number);
  }

  set(key, value) {
    if (this.hasOwnProperty(key)) {
      this[key] = value;
    }
  }

  getId() {
    return (this.id || 0);
  }

  newInstance(data) {
    const instance = new this.constructor();
    if (data !== null) {
      instance.bind(data)
    }
    return instance;
  }

  clone() {
    return Object.assign(this.newInstance(), this)
  }

  cloneWith(data) {
    const clone = this.clone();
    clone.bind(data);
    return clone;
  }

  cloneWithNewId() {
    return this.cloneWith({id: uuidv1()});
  }

  reset() {
    return this.bind(this.newInstance());
  }

  reduces(withNullable = true) {
    const ret = {};
    for (let i in this) {
      const propValue = this[i];
      if (!withNullable && (propValue === null || typeof propValue === 'undefined')) {
        continue
      }
      ret[i] = propValue;
    }
    return ret;
  }
}

export default stdClass;
