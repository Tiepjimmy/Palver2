// action types
export const UPDATE_MEDIA = "updateMedia";

// mutation types
export const SET_MEDIA = "setMedia";

const state = {
    access_key : 'Account',
    secret_key: '123456',
    url_token: "http://tuha-upload-media.palvietnam.local:81/api/v1/get-token",
    url_image: "http://tuha-upload-media.palvietnam.local:81/api/v1/image"
};

const getters = {
    accessMedia(state){
        return {
            access_key : state.access_key,
            secret_key: state.secret_key,
            url_token : state.url_token,
            url_image: state.url_image
        }
    }
};

const actions = {
    [UPDATE_MEDIA](context, payload){
        context.commit(SET_MEDIA, payload);
    }
};

const mutations = {
    [SET_MEDIA](state, token){
        state.token = token;
    },
};

export default {
    state,
    actions,
    mutations,
    getters
};
