import axios from "axios";
// action types
export const UPDATE_MEDIA = "updateMedia";
export const UPDATE_OWNER = "updateOwner";

// mutation types
export const SET_MEDIA = "setMedia";
export const SET_OWNER = "setOwner";

const state = {
    access_key : 'Account',
    secret_key: '123456',
    url_token: "http://account-s3.intranet/api/v1/get-token",
    url_image: "http://account-s3.intranet/api/v1/image",
    ownerShop: false
};

const getters = {
    accessMedia(state){
        return {
            access_key : state.access_key,
            secret_key: state.secret_key,
            url_token : state.url_token,
            url_image: state.url_image
        }
    },
    currentOwnerShop(state){
        return state.ownerShop;
    }
};

const actions = {
    [UPDATE_OWNER](context) {
        axios.get("/proxy/account/v1/owner-shop")
        .then(function(_ref){
            var responseData = _ref.data;
            context.commit(SET_OWNER, responseData.data);
        }).catch(function(_ref){
            
        });
    },
    [UPDATE_MEDIA](context, payload){
        context.commit(SET_MEDIA, payload);
    }
};

const mutations = {
    [SET_MEDIA](state, token){
        state.token = token;
    },
    [SET_OWNER](state, ownerShop){
        state.ownerShop = ownerShop;
    }
};

export default {
    state,
    actions,
    mutations,
    getters
};
