import * as types from '@/store/om/mutation-types'
import Configs from "@/models/config/configs";

// state
const state = {
  omConfigs: new Configs()
}

// getters
const getters = {
  marketing: state => state.omConfigs.getConfigOm('marketing'),
  mission: state => state.omConfigs.getConfigOm('mission'),
  order: state => state.omConfigs.getConfigOm('order'),
}

// mutations
const mutations = {
  [types.LOAD_CONFIG_OM] (state, { module, config }) {
    state.omConfigs.set(module, config)
  },
  update: function (state, {module, item, data}) {
    state.omConfigs[module][item] = data
  }
}

// actions
const actions = {
  async load ({ commit }, module) {
    const config = await new Configs().loadConfigOm(module)
    commit(types.LOAD_CONFIG_OM, { module, config })
  },
  updateConfig: function ({commit}, module, item, data) {
    commit('update', {module, item, data})
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
