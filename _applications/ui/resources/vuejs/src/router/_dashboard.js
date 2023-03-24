import {middleware} from 'vue-router-middleware'

export default [
	...middleware([], [
		{
			path: "/",
			name: "dashboard",
			component: () => import("@/components/main/pages/Dashboard.vue")
		},
		{
			path: "/dashboard",
			name: "dashboard2",
			component: () => import("@/components/main/pages/Dashboard.vue")
		}
	]),
]
