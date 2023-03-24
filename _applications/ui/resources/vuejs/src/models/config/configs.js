import Model from '@/core/model'
import ApiService from "@/core/api.service";
import {v1 as uuidv1} from "uuid";
const camelCase = require('camelcase');
import store from '@/store'

class Configs extends Model {
  system
  user
  customer
  order
  setting

  /**
   * Configs constructor
   * @param data
   */
  constructor(data) {
    super()

    this.marketing = null
    this.mission = null
    this.order = null

    this.bind(data)
  }

  async get(module) {
    if (this[camelCase(module)] !== null) {
      return this[camelCase(module)]
    }
    return await this.load(module)
  }

  async getConfigOm(module) {
    if (this[camelCase(module)] !== null) {
      return this[camelCase(module)]
    }
    return await this.loadConfigOm(module)
  }

  set(module, config) {
    if (this[camelCase(module)] === null) {
      this[camelCase(module)] = config
    } else {
      this[camelCase(module)].bind(config)
    }
  }

  apiGroup() {
    return 'configs'
  }

  async load(module) {
    try {
      return ApiService.get(`config/${module}`).then(response => {
        store.commit('configs/LOAD_CONFIG', {module, config: new Config(response.data)})
        return this[camelCase(module)];
      })
    } catch (e) {}

    return new Config();
  }

  async loadConfigOm(module) {
    try {
      return ApiService.get(`proxy/om/v1/config/${module}`).then(response => {
        store.commit('omConfig/LOAD_CONFIG_OM', {module, config: new Config(response.data)})
        return this[camelCase(module)];
      })
    } catch (e) {}

    return new Config();
  }
}

class Config {
  constructor(data) {
    this.bind(data)
  }

  bind(data) {
    if (data !== null) {
      try {
        for (let i in data) {
          this[i] = data[i]
        }
      } catch (e) {
        console.log(e)
      }
    }

    this.id = this.id || uuidv1()
    return this
  }
}

export default Configs
