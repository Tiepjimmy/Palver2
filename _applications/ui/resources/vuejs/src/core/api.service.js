/** API **/

import axios from '@/core/plugins/axios';
import Utility from '@/helpers/utility';
import ResponseJson from './response';
import $ from 'jquery';

const API_ROUTES = require('@/config/api_routes.json');

const ApiService = {
  install: (Vue) => {
    Vue.prototype.$apiService = ApiService;
  },

  /**
   * @public
   * @param group
   * @returns {*}
   */
  routes(group) {
    return API_ROUTES[group];
  },

  /**
   * @public
   * @param url
   * @param params
   * @param config
   * @returns {Promise<ResponseJson | never>}
   */
  get(url, params, config = {}) {
    const queryString = params ? '?' + $.param(params) : ''
    return axios.get(Utility.apiUrl(url) + queryString, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param data
   * @param config
   * @returns {Promise<ResponseJson | never>}
   */
  post(url, data, config = {}) {
    return axios.post(Utility.apiUrl(url), data, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param data
   * @param config
   * @returns {Promise<ResponseJson | never>}
   */
  put(url, data, config = {}) {
    return axios.put(Utility.apiUrl(url), data, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param data
   * @param config
   * @returns {Promise<ResponseJson | never>}
   */
  patch(url, data, config = {}) {
    return axios.patch(Utility.apiUrl(url), data, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param params
   * @param config
   * @returns {Promise<ResponseJson | never>}
   */
  delete(url, params, config = {}) {
    let queryString = params ? '?' + $.param(params) : ''
    return axios.delete(Utility.apiUrl(url) + queryString, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param params
   * @param config
   * @returns {Promise<ResponseJson>}
   */
  async getAsync(url, params, config = {}) {
    let queryString = params ? '?' + $.param(params) : ''
    return await axios.get(Utility.apiUrl(url) + queryString, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param data
   * @param config
   * @returns {Promise<ResponseJson>}
   */
  async postAsync(url, data, config = {}) {
    return await axios.post(Utility.apiUrl(url), data, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param data
   * @param config
   * @returns {Promise<ResponseJson>}
   */
  async putAsync(url, data, config = {}) {
    return await axios.put(Utility.apiUrl(url), data, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param data
   * @param config
   * @returns {Promise<ResponseJson>}
   */
  async patchAsync(url, data, config = {}) {
    return await axios.patch(Utility.apiUrl(url), data, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param params
   * @param config
   * @returns {Promise<ResponseJson>}
   */
  async deleteAsync(url, params, config = {}) {
    let queryString = params ? ('?' + $.param(params)) : ''
    return await axios.delete(Utility.apiUrl(url) + queryString, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  },

  /**
   * @public
   * @param url
   * @param params
   * @param config
   * @returns {Promise<ResponseJson>}
   */
  async deleteMultiAsync(url, params, config = {}) {
    let queryString = params ? '?' + $.param(params) : ''
    return await axios.delete(Utility.apiUrl(url) + queryString, config)
      .then(response => response.data)
      .catch(error => {
        throw error
      });
  }
};

export default ApiService;
