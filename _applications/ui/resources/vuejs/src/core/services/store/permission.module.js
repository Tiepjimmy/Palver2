import menu_config from "@/core/config/menu.config";
import api_route_config from "@/config/api_routes.json"
import ApiService from '@/core/api.service'

// action types
export const UPDATE_PERMISSION = "updatePermission";
export const FETCH_PERMISSION = "fetchPermission";

// mutation types
export const SET_PERMISSION = "setPermission";

const state = {
    permission: null
};

const getters = {
    currentPermission(state) {
        return state.permission;
    },
    currentAvailableMenu(state) {
        let menu = [];
        for (let block of menu_config["menu"]) {
            let aivailableBlocks = {
                name: block.name,
                child: [],
            };

            // for (let childItem  in block.child){
            //     console.log(childItem, 'childItem')
            //     // if(state.permission['ds-quyen'].indexOf(childItem.quyen_cd) >= 0){
            //         aivailableBlocks.child.push(...childItem);
            //     // }
            // }

            if (! (block.child instanceof Array)) {
                continue
            }

            block.child instanceof Array && block.child.forEach(function(childItem){
                if(state.permission == null){
                    return;
                }
                state.permission.roles.forEach(function(role){
                    if(!childItem['quyen_cd']){
                        return;
                    }
                    if(childItem['quyen_cd'].includes(role['permission_cd'])){
                        aivailableBlocks.child.push(childItem)
                    }
                });
            });

            menu.push(aivailableBlocks);
        }
        return menu;
    },
};

const actions = {
    [UPDATE_PERMISSION](context, payload) {
        context.commit(SET_PERMISSION, payload);
    },
    [FETCH_PERMISSION](context, payload){
        ApiService.get(api_route_config['user']['roles']).then(response => {
            context.commit(SET_PERMISSION, response.data);
        });
    }
};

const mutations = {
    [SET_PERMISSION](state, permission) {
        state.permission = permission;
    },
};

export default {
    state,
    actions,
    mutations,
    getters,
};

