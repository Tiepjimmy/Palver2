import store from '@/store'
import permission_store from '@/core/services/store';
import {UPDATE_PERSONAL_INFO} from "../../core/services/store/profile.module";
import {FETCH_PERMISSION} from "../../core/services/store/permission.module";

export default async (args, to, from, next) => {
  if (to.path === from.path) {
    let user = store.getters['auth/user']
    if (user) {
      store.dispatch(UPDATE_PERSONAL_INFO, user);
      await next()
    }

    if (to.path !== '/') {
      return
    }
  }

  let user = store.getters['auth/user']
  if (!user) {
    try {
      await store.dispatch('auth/fetchUser')
    } catch (e) {
      console.log('#auth-error', e)
    }
  }
  user = store.getters['auth/user'];
  store.dispatch(UPDATE_PERSONAL_INFO, user);

  let permission = permission_store.getters['currentPermission'];
  if(permission == undefined || permission == null){
    store.dispatch(FETCH_PERMISSION);
  }
  return await next()
}
