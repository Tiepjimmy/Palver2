import menu_config from "@/core/config/menu.config";

// action types
export const UPDATE_PERMISSION = "updatePermission";

// mutation types
export const SET_PERMISSION = "setPermission";

const state = {
    permission : null,
    ownerShop: false
};

const getters = {
    currentPermission(state){
        return state.permission;
    },
    currentAvaiableMenu(state){
        if(state.permission == null){
            return [];
        }
        if(state.permission.owner.length > 0){
            return menu_config['menu'];
        }
        var menu = [];
        for(let block of menu_config['menu']){
            var aivaibleBlocks = {
                "name" : block.name,
                "child" : []
            };
            for (let childItem  in block.child){
                if(state.permission['ds-quyen'].indexOf(childItem.quyen_cd) >= 0){
                    aivaibleBlocks.child.push(childItem);
                }
            }
            menu.push(aivaibleBlocks);
        }
        return menu;
    },
    currentOwnerShop(state){
        if(state.permission == null){
            return false;
        }
        if(state.permission.owner.length > 0){
            return true;
        }
        
        return false;
    }
};

const actions = {
    [UPDATE_PERMISSION](context, payload){
        context.commit(SET_PERMISSION, payload);
    }
};

const mutations = {
    [SET_PERMISSION](state, permission){
        state.permission = permission;
    },
};

export default {
    state,
    actions,
    mutations,
    getters
};
