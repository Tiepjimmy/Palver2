// actionAdd types
export const APPEND_BREADCRUM = "appendBreadcrumb";

// mutation types
export const SET_BREADCRUMB = "setBreadcrumb";
export const ADD_BREADCRUMB = "addBreadcrumb";
export const SET_ACTION = "setAction";
export const SET_SUBMIT = "setSubmit";

export default {
  state: {
    breadcrumbs: [],
      actionAdd: [],
        actionSubmit: false
  },
  getters: {
    /**
     * Get list of breadcrumbs for current page
     * @param state
     * @returns {*}
     */
    breadcrumbs(state) {
      return state.breadcrumbs;
    },
      actionAdd(state) {
          return state.actionAdd;
      },
        actionSubmit(state) {
          return state.actionSubmit;
        },

    /**
     * Get the page title
     * @param state
     * @returns {*}
     */
    pageTitle(state) {
      let last = state.breadcrumbs[state.breadcrumbs.length - 1];
      if (last && last.title) {
        return last.title;
      }
    }
  },
  actions: {
    /**
     * Set the breadcrumbs list
     * @param state
     * @param payload
     */
    [SET_BREADCRUMB](state, payload) {
      state.commit(SET_BREADCRUMB, payload);
    },
      [SET_ACTION](state, payload) {
          state.commit(SET_ACTION, payload);
      },
        [SET_SUBMIT](state, payload) {
          state.commit(SET_SUBMIT, payload);
        },

    /**
     * Add breadcrumb
     * @param state
     * @param payload
     */
    [ADD_BREADCRUMB](state, payload) {
      if (typeof payload === "object") {
        payload.forEach(item => state.commit(APPEND_BREADCRUM, item));
      } else {
        state.commit(APPEND_BREADCRUM, payload);
      }
    }
  },
  mutations: {
    [APPEND_BREADCRUM](state, payload) {
      state.breadcrumbs = [...state.breadcrumbs, payload];
    },
    [SET_BREADCRUMB](state, payload) {
      state.breadcrumbs = payload;
    },
      [SET_ACTION](state, payload) {
          state.actionAdd = payload;
      },
        [SET_SUBMIT](state, payload) {
          state.actionSubmit = payload;
        }
  }
};
