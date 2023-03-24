import store from '@/store'

export default async (args, to, from, next) => {
  if (to.path === from.path) {
    await next()
    if (to.path !== '/') {
      return
    }
  }

  const hasPermission = store.getters['auth/hasAccessPermission']

  if (!hasPermission) {
    return await next()
  }

  const matched = to.matched.find(record => record.meta.module)

  if (matched) {
    const config = store.getters[`configs/${matched.meta.module}`]
  }

  await next()
}
