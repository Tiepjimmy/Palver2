import { default as getters } from "./getters";
import { default as mutations } from "./mutations";
import { default as actions } from "./actions";

const state = {
  create: {
    title: "Hello",
  },
  index: {},
  show: {},
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
};
