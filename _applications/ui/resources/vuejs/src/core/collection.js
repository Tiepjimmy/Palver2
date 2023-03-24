/**
 * Collection class definition
 */

import stdClass from "./stdClass";
import Model from "./model";
const _ = require("lodash");

class Collection extends Array {
  #name = "Collection";
  limit = 0;
  total = 0;
  page = 1;
  current_page = 1;
  total_page = 1;
  per_page = 0;
  totalPage = 0;
  selected;
  matched;

  /**
   * Collection constructor
   * @param itemType
   * @param items
   */
  constructor(itemType, ...items) {
    super();
    this.__proto__ = Array.prototype;

    /**
     * Item type
     */
    this.itemType = itemType;

    this.__proto__.mapResponse = function (data) {
      for (const property in data) {
        if (property === "items" && data.items instanceof Array) {
          this.addRange(data.items);
          continue;
        }
        if (this.hasOwnProperty(property) && property !== "itemType") {
          this[property] = data[property];
        }
      }

      if (this.limit > 0) {
        this.totalPage = Math.ceil(this.total / this.limit) || 1;
      }
    };

    /**
     * Add item
     * @public
     * @param item
     * @returns {*}
     */
    this.__proto__.add = function (item) {
      if (!this.contains(item)) {
        if (!(item instanceof this.itemType)) {
          item = new this.itemType(item);
        }
        this.push(item);
      }
      return this;
    };

    /**
     * Add list of items
     * @public
     * @param items
     * @returns {*}
     */
    this.__proto__.addRange = function (items) {
      if (!(items instanceof Array)) {
        return this;
      }

      items.forEach(item => {
        this.add(item);
      });
      return this;
    };

    /**
     * Add item to beginning
     * @public
     * @param item
     * @returns {*}
     */
    this.__proto__.addTop = function (item) {
      if (!this.contains(item)) {
        if (!(item instanceof this.itemType)) {
          item = new this.itemType(item);
        }
        this.unshift(item);
      }
      return this;
    };

    /**
     * Add list of items to beginning
     * @public
     * @param items
     * @returns {*}
     */
    this.__proto__.addTopRange = function (items) {
      if (!(items instanceof Array)) {
        return this;
      }

      items.forEach(item => {
        this.addTop(item);
      });
      return this;
    };

    /**
     * Add list of items
     * @public
     * @returns {*}
     * @param recordsTotal
     */
    this.__proto__.setRecordsTotal = function (recordsTotal) {
      this.recordsTotal = Number(recordsTotal);
      return this;
    };

    /**
     * Find item by id
     * @public
     * @param id
     * @returns {*}
     */
    this.__proto__.findById = function (id) {
      return this.filter(i => i.id === id)[0];
    };

    /**
     * Find item by uid
     * @public
     * @param uid
     * @returns {*}
     */
    this.__proto__.findByUid = function (uid) {
      return this.filter(i => i.uid === uid)[0];
    };

    this.__proto__.contains = function (item) {
      return item instanceof this.itemType && this.includes(item);
    };

    /**
     * Pluck new array with values of specified property
     * @public
     * @returns {*}
     * @param property
     */
    this.__proto__.pluck = function (property) {
      let arr = [];
      this.forEach(i => {
        if (i.hasOwnProperty(property)) {
          if (!(i[property] instanceof Array)) {
            arr.push(i[property]);
          } else {
            arr.concat(i[property]);
          }
        }
      });
      return arr;
    };

    /**
     * Count items
     * @public
     * @returns {*}
     */
    this.__proto__.count = function () {
      return this.length;
    };

    /**
     * Check if has any of item
     * @public
     * @returns {*}
     */
    this.__proto__.any = function () {
      return this.length > 0;
    };

    /**
     * Remove item
     * @public
     * @param item
     * @returns {*}
     */
    this.__proto__.remove = function (item) {
      let index = -1;
      if (this.contains(item)) {
        for (const i in this) {
          if (this[i].id === item.id) {
            index = i;
            break;
          }
        }
      }
      if (index !== -1) {
        this.removeIndex(index);
      }
      return this;
    };

    /**
     * Remove item
     * @public
     * @param fn
     */
    this.__proto__.removeWhere = function (fn) {
      if (typeof fn === "function") {
        let items = this.filter(fn);
        for (let i in items) {
          this.remove(items[i]);
        }
      }
    };

    /**
     * Remove item by uid
     * @public
     * @param uid
     * @returns {*}
     */
    this.__proto__.removeUid = function (uid) {
      let item = this.findByUid(uid);
      if (typeof item !== "undefined") {
        this.remove(item);
      }
      return this;
    };

    /**
     * Remove item by id
     * @public
     * @param id
     * @returns {*}
     */
    this.__proto__.removeId = function (id) {
      this.removeUid(id);
      return this;
    };

    /**
     * Remove item by index
     * @public
     * @param index
     * @returns {*}
     */
    this.__proto__.removeIndex = function (index) {
      if (typeof this[index] !== "undefined") {
        this.splice(index, 1);
      }
      return this;
    };

    /**
     * Clear collection
     * @public
     * @returns {*}
     */
    this.__proto__.clear = function () {
      this.splice(0, this.length);
      return this;
    };

    /**
     * Get instance
     * @public
     * @returns {*}
     */
    this.__proto__.instance = function (items) {
      return new Collection(this.itemType, items);
    };

    /**
     * Clear collection
     * @public
     * @returns {*}
     */
    this.__proto__.clone = function () {
      let clone = this.instance();
      this.forEach(e => {
        if (e instanceof stdClass) {
          let eClone = e.clone();
          if (typeof e.collection !== "undefined" && e.collection instanceof Array) {
            if (e.collection.name === "Collection") {
              eClone.collection.addRange(e.collection.clone());
            } else {
              eClone.collection = _.cloneDeep(e.collection);
            }
          }
          clone.add(eClone);
        } else {
          clone.add(_.cloneDeep(e));
        }
      });
      return clone;
    };

    /**
     * Get selected items
     * @public
     * @returns {this}
     */
    this.__proto__.getSelected = function () {
      if (this.selected === null) {
        this.selected = this.instance();
      }
      return this.selected;
    };

    /**
     * Get matched items
     * @public
     * @returns {this}
     */
    this.__proto__.getMatched = function () {
      if (this.matched === null) {
        this.matched = this.instance();
      }
      return this.matched;
    };

    /**
     * @public
     * @returns {*}
     */
    this.__proto__.toArray = function () {
      return this.slice(0, this.length);
    };

    /**
     * @public
     * @returns {*}
     */
    this.__proto__.reduces = function (withNullable = false) {
      return this.toArray().map(e => {
        if (e instanceof Model) {
          return e.reduces(withNullable);
        }
        return e;
      });
    };

    /**
     * @public
     * @returns {null}
     */
    this.__proto__.first = function () {
      return this.length > 0 ? this[0] : null;
    };

    /**
     * @public
     * @returns {null}
     */
    this.__proto__.last = function () {
      return this.length > 0 ? this[this.length - 1] : null;
    };

    /**
     * Add items by default if provided
     */
    if (typeof items[0] !== "undefined") {
      this.addRange(items[0]);
    }
  }
}

export default Collection;
