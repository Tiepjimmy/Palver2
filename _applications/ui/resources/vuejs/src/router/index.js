import Vue from 'vue'
import Router from 'vue-router'
import paths from './paths'
import VueRouterMiddleware from 'vue-router-middleware'
import Nprogress from "nprogress";

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: paths
})

// Load middleware modules dynamically.
const routeMiddleware = resolveMiddleware(
    require.context('@/router/middleware', false, /.*\.js$/)
)

Vue.use(VueRouterMiddleware, {
  router,
  middlewares: routeMiddleware
})

// router navigation guards
router.beforeEach((to, from, next) => {
  Nprogress.start();
  next();
})

router.afterEach(() => {
  Nprogress.done();

  setTimeout(() => {
    const contentWrapper = document.querySelector("html");
    if (contentWrapper !== null) {
      contentWrapper.scrollTop = 0;
    }
  }, 200);
})

export default router

/**
 * @param  {Object} requireContext
 * @return {Object}
 */
function resolveMiddleware (requireContext) {
  return requireContext.keys()
      .map(file =>
          [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
      )
      .reduce((guards, [name, guard]) => (
          { ...guards, [name]: guard.default }
      ), {})
}
