import * as types from '@/store/mutation-types'
import Configs from "@/models/config/configs";

// state
const state = {
  configs: new Configs()
}

// getters
const getters = {
  system: state => state.configs.get('system'),
  user: state => state.configs.get('user'),
  order: state => state.configs.get('order'),
  setting: state => state.configs.get('setting'),
}

// mutations
const mutations = {
  [types.LOAD_CONFIG] (state, { module, config }) {
    state.configs.set(module, config)
  },
  mutateShowColumn: function (state, { module, config}) {
    state.configs[module].showColumns = config
  },
  updateStatuses: function (state, {module, config}) {
    state.configs[module].listStatus = config
  },
  updateGroupStatuses: function (state, {module, config}) {
    state.configs[module].listCustomerStatusGroup = config
  }
}

// actions
const actions = {
  async load ({ commit }, module) {
    const config = await new Configs().load(module)
    commit(types.LOAD_CONFIG, { module, config })
  },
  updateShowColumns: function ({commit}, {module, config}) {
    commit('mutateShowColumn',{module, config} )
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
