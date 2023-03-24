import * as types from '@/store/mutation-types'
import User from '@/models/user/user'
import ApiService from '@/core/api.service'

// state
const state = {
  user: null,
  token: localStorage.getItem('token'),
  hasAccessPermission: false,
  isAuthenticated: true
}

// getters
const getters = {
  user: state => state.user,
  // token: () => localStorage.getItem('token'),
  isAuthenticated: state => state.isAuthenticated,
  hasAccessPermission: state => state.hasAccessPermission
}

// mutations
const mutations = {
  [types.SAVE_TOKEN] (state, { token }) {
    state.token = token
    localStorage.setItem('token', token)
  },

  [types.FETCH_USER_SUCCESS] (state, { user }) {
    state.user = user

    localStorage.removeItem('loginState')
  },

  [types.FETCH_USER_FAILURE] (state, { message }) {

  },

  [types.LOGOUT] (state) {
    state.token = null
    state.routeLogin = null

    localStorage.removeItem('token')
  },

  [types.UPDATE_USER] (state, { user }) {
    state.user = user
  },

  [types.HAS_ACCESS_PERMISSION] (state, hasPermission) {
    state.hasAccessPermission = hasPermission
  },
}

// actions
const actions = {
  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser ({ commit }) {
    try {
      const user = await new User().profile()
      commit(types.FETCH_USER_SUCCESS, { user: user })
    } catch (e) {
      console.log(e)
      commit(types.FETCH_USER_FAILURE, e)
    }
  },

  updateUser ({ commit }, payload) {
    commit(types.UPDATE_USER, payload)
  },

  async logout ({ commit }, { callback }) {
    let result = await ApiService.post('auth/logout')
    if (!result.isSuccess()) {
      throw result.message
    }

    if (typeof callback === 'function') {
      callback.call(null)
    }

    commit(types.LOGOUT)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
