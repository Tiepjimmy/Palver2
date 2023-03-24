/**
 * DataList class definition
 */

import Collection from './collection';

/**
 * DataList constructor
 */
class DataList {
  constructor(itemType) {
    this.itemType = itemType;
    this.list = new Collection(this.itemType);
    this.recordsTotal = 0;
    this.selected = null;
    this.matched = null;
  }

  bind(data) {
    if (data != null) {
      if (typeof data.list !== 'undefined') {
        this.list.addRange(data.list);
      }
      if (typeof data.recordsTotal !== 'undefined') {
        this.recordsTotal = Number(data.recordsTotal);
      }
    }
  }

  getSelected() {
    if (this.selected === null) {
      this.selected = new Collection(this.itemType);
    }
    return this.selected;
  }

  getMatched() {
    if (this.matched === null) {
      this.matched = new Collection(this.itemType);
    }
  }

  reset() {
    this.list = new Collection(this.itemType);
    this.selected = new Collection(this.itemType);
    this.recordsTotal = 0;
  }
}

export default DataList
