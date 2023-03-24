import * as types from './mutation-types'
import Channel from "@/models/marketing/channel";
import SubChannel from "@/models/marketing/sub_channel";
import PaymentAccount from "@/models/marketing/payment_account";
import Campaign from "@/models/marketing/campaign";
import LeadStatus from "@/models/marketing/lead_status";

// state
const state = {
  channels: new Channel(),
  subChannels: new SubChannel(),
  paymentAccounts: new PaymentAccount(),
  userRoleMarketing: new Channel(),
  bundles: new Campaign(),
  leadStatus: new LeadStatus(),
};

// getters
const getters = {
  channels: state => state.channels.getAllChannel(),
  subChannels: state => state.subChannels.getAllSubChannel(),
  paymentAccounts: state => state.paymentAccounts.getAllPaymentAccount(),
  userRoleMarketing: state => state.userRoleMarketing.getListUser(),
  bundles: state => state.bundles.getListBundle(),
  leadStatus: state => state.leadStatus.getAllStatus(),
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
