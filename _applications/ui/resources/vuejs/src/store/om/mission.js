import * as types from './mutation-types'
import Result from "@/models/mission/result";
import Task from "@/models/mission/task";

// state
const state = {
  missionResult: new Result(),
  missionTask: new Task(),
};

// getters
const getters = {
  missionResult: state => state.missionResult.getAllResult(),
  missionTask: state => state.missionTask.getAllTask(),
};

// mutations
const mutations = {
  updated: function (state, { module, data }) {
    state[module] = data
  },
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
