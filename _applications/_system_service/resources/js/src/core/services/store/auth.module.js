import ApiService from "@/core/services/api.service";
import {UPDATE_PERSONAL_INFO} from "./profile.module";
import {UPDATE_PERMISSION} from "./permission.module";

// action types
export const VERIFY_AUTH = "verifyAuth";
export const LOGOUT = "logout";

// mutation types
export const PURGE_AUTH = "logOut";
export const SET_AUTH = "setUser";
export const SET_ERROR = "setError";

const state = {
  errors: null,
  user: {},
  isAuthenticated: null
};

const getters = {
  currentUser() {
    return state.user;
  },
  isAuthenticated() {
    return state.isAuthenticated;
  }
};

const actions = {
    // [VERIFY_AUTH](context) {
    //     var $store = this;
    //     ApiService.setHeader();
    //     ApiService.get("/auth/user/info")
    //     .then(function(_ref){
    //         var responseData = _ref.data;
    //         context.commit(SET_AUTH, responseData.user);
    //         $store.dispatch(UPDATE_PERSONAL_INFO, responseData.user);
    //         $store.dispatch(UPDATE_PERMISSION, responseData.dsQuyen);
    //     }).catch(function(_ref){
    //         context.commit(SET_ERROR, _ref);
    //         context.commit(PURGE_AUTH);
    //     });
    // },
    [LOGOUT](context) {
        context.commit(PURGE_AUTH);
    },
};

const mutations = {
  [SET_ERROR](state, error) {
    state.errors = error;
  },
  [SET_AUTH](state, user) {
    state.isAuthenticated = true;
    state.user = user;
    state.errors = {};
  },
  [PURGE_AUTH](state) {
    state.isAuthenticated = false;
    state.user = {};
    state.errors = {};
  }
};

export default {
  state,
  actions,
  mutations,
  getters
};
