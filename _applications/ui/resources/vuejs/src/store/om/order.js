import Provinces from "@/models/master/provinces/provinces";

// state
const state = {
  province: new Provinces(),
};

// getters
const getters = {
  provinces: state => state.province.listdata()
};

// mutations
const mutations = {
  updated: function (state, { module, data }) {
    state[module] = data
  }
};

// actions
const actions = {

};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
