import * as types from './mutation-types'

const state = {
  loader: false
}

const getters = {
  loader: state => state.loader,
}

const mutations = {
  toggleLoading(state, loader ) {
    state.loader = loader
  }
}

const actions = {
  setLoading ({ commit }, loader ) {
    commit('toggleLoading', loader )
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
