/**
 * Model class definition
 */

import stdClass from './stdClass';
import Collection from './collection';
import ApiService from './api.service';
import Utility from '@/helpers/utility';

/**
 * Model constructor
 */
class Model extends stdClass {
  #originData
  #changedData
  created_at
  updated_at

  /**
   * Model constructor
   * @param data
   */
  constructor(data) {
    super()
    this.bind(data)
  }

  apiGroup() {
    return '';
  }

  /**
   * Lấy url của path name đã được khai báo trong api_routes
   *
   * @class      Model (name)
   * @param      {string}   path    The path
   * @return     {string} 
   */
  URL(path = ''){
    return _.get(ApiService.routes(this.apiGroup()), path)
  }

  cacheOrigin() {
    this.#originData = this.clone();
  }

  /**
   * @public
   */
  reduces(withNullable = true) {
    const ret = {};
    let regex = new RegExp(/[^\d]+/);
    for (let i in this) {
      let propValue = this[i];

      if (propValue == null) {
        if (withNullable) {
          ret[i] = propValue;
        }
      } else {
        if (propValue instanceof Object) {
          if (typeof propValue.reduces === 'function') {
            propValue.length === 0 || (ret[i] = propValue.reduces(withNullable))
          } else {
            ret[i] = propValue
          }
        } else if (typeof propValue === 'string' || typeof propValue === 'number') {
          ret[i] = propValue;
          if (i === 'id' && regex.test(ret[i])) {
            delete ret[i];
          }
        } else if (typeof propValue === 'boolean') {
          ret[i] = Number(propValue)
        }
      }
    }

    const typeOfNumber = this.typeOfNumber()
    if (typeOfNumber.length > 0) {
      typeOfNumber.forEach(i => {
        if (ret[i] != null) {
          ret[i] = Number(ret[i])
        }
      })
    }

    const typeOfTimestamp = this.typeOfTimestamp()
    if (typeOfTimestamp.length > 0) {
      typeOfTimestamp.forEach(i => {
        if (ret[i] != null) {
          ret[i] = ret[i] / 1e3
        }
      })
    }

    return ret;
  }

  /**
   * @public
   */
  reducesEntity(withNullable = true) {
    const ret = {};
    let regex = new RegExp(/[^\d]+/);
    for (let i in this) {
      let propValue = this[i];

      if (propValue == null) {
        if (withNullable) {
          ret[i] = propValue;
        }
      } else {
        if (!Utility.isPrimitive(propValue)) {
          continue
        }

        if (typeof propValue === 'string' || typeof propValue === 'number') {
          ret[i] = propValue;
          if (i === 'id' && regex.test(ret[i])) {
            delete ret[i];
          }
        } else if (typeof propValue === 'boolean') {
          ret[i] = Number(propValue)
        }
      }
    }

    const typeOfNumber = this.typeOfNumber()
    if (typeOfNumber.length > 0) {
      typeOfNumber.forEach(i => {
        if (ret[i] != null) {
          ret[i] = Number(ret[i])
        }
      })
    }

    const typeOfTimestamp = this.typeOfTimestamp()
    if (typeOfTimestamp.length > 0) {
      typeOfTimestamp.forEach(i => {
        if (ret[i] != null) {
          ret[i] = ret[i] / 1e3
        }
      })
    }

    return ret;
  }

  /**
   * @public
   */
  getChanges() {
    if(!this.#originData){
      return false
    }
    
    const dataChanged = {};
    for (let i in this) {
      let propValue = this[i];

      if (typeof propValue === 'string' || typeof propValue === 'number') {
        if (propValue !== this.#originData[i]) {
          dataChanged[i] = propValue;
        }
      }
    }
    return dataChanged;
  }

  /**
   * @public
   * @param params
   * @returns {*}
   */
  load(params) {
    this.reset();
    return ApiService.get(ApiService.routes(this.apiGroup())['detail'], params).then(response => {
      this.bind(response.data);
      return this;
    });
  }

  /**
   * @public
   * @param id
   * @returns {*}
   */
  loadById(id) {
    this.reset();
    return ApiService.get(ApiService.routes(this.apiGroup())['detail'] + `/${id}`).then(response => {
      this.bind(response.data);
      return this;
    });
  }

  /**
   * @public
   * @returns {*}
   */
  store(data = null) {
    return ApiService.post(
      ApiService.routes(this.apiGroup())['store'],
      Object.assign({store_id: 1}, data ? data : this.reduces(false))
    ).then(response => {
      return response;
    }).then(response => {
      this.bind(response.data)
    });
  }

  /**
   * @public
   * @param data
   * @returns {*}
   */
  update(data = null) {
    return ApiService.put(
      ApiService.routes(this.apiGroup())['update'],
      Object.assign({store_id: 1}, data ? data : this.reduces(false))
    ).then(response => {
      return response;
    }).then(response => {
      this.bind(response.data)
    });
  }

  /**
   * @public
   * @returns {*}
   */
  delete() {
    return ApiService.delete(ApiService.routes(this.apiGroup())['delete'], {id: this.getId()}).then(response => {
      return response;
    });
  }

  /**
   * @public
   * @param params
   * @returns {Promise<Model>}
   */
  async loadAsync(params) {
    this.reset();
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['detail'], params);
    this.bind(response.data);
    return this;
  }

  /**
   * @public
   * @param id
   * @returns {Promise<Model>}
   */
  async loadByIdAsync(id) {
    this.reset();
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['detail'] + `/${id}`);
    this.bind(response.data);
    return this;
  }

  /**
   * @public
   * @param params
   * @param callback
   * @returns {Promise<*>}
   */
  async getListAsync(params, callback) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['list'], params);

    if (typeof callback === 'function') {
      callback.call(null, response.data);
    }

    const collection = new Collection(this.constructor);
    collection.mapResponse(response.data);

    return collection;
  }

  /**
   * @public
   * @param data
   * @returns {Promise<Model>}
   */
  async storeAsync(data = null) {
    let response = await ApiService.postAsync(
      ApiService.routes(this.apiGroup())['store'],
      Object.assign({store_id: 1}, data ? data : this.reduces(false))
    );

    this.bind(response.data);
    return this;
  }

  /**
   * @public
   * @param id
   * @param data
   * @returns {Promise<Model>}
   */
  async updateAsync(data = null, id = null) {
    let response = await ApiService.patchAsync(
      ApiService.routes(this.apiGroup())['update'] + '/' + (id || this.getId()),
      Object.assign({store_id: 1}, data ? data : this.reduces(false))
    );

    this.bind(response.data)
    return this;
  }

  /**
   * @public
   * @returns {Promise<Model>}
   */
  async deleteAsync(id = null) {
    let response = await ApiService.deleteAsync(ApiService.routes(this.apiGroup())['delete'] + '/' + (id || this.getId()));

    this.bind(response.data);
    return this;
  }

  /**
   * @param ids
   * @public
   * @returns {Promise<Model>}
   */
  async deleteMultiAsync(params = null) {
    let response = await ApiService.deleteMultiAsync(ApiService.routes(this.apiGroup())['delete-multi'], params);

    this.bind(response.data);
    return this;
  }

  /**
   * @public
   * @returns {boolean}
   */
  exists() {
    return Number(this.getId()) > 0;
  }

  /**
   * @public
   * @returns {*|string}
   */
  lastModifiedTime() {
    return Utility.toDateString(this.modifiedTime || this.createdTime);
  }

  /**
   * @public
   * @param params
   * @param callback
   * @returns {Promise<Collection>}
   */
  async loadCollectionAsyncAll(params, callback) {
    let response = await ApiService.getAsync(ApiService.routes(this.apiGroup())['all'], params);

    this.collection.clear();
    this.collection.mapResponse(response);

    if (typeof callback === 'function') {
      callback.call(null, response.data);
    }

    return this.collection;
  }
}

export default Model
