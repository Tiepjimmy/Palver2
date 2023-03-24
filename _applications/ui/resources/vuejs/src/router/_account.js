import {middleware} from 'vue-router-middleware'

export default [
	...middleware([], [
		{
			path: "account/changelog",
			name: "account.changelog",
			component: () => import("@/components/account/pages/changelog/ChangeLog.vue")
		},
		{
			path: "account/permissiongroup",
			name: "account.permissiongroup",
			component: () => import("@/components/account/pages/permissiongroup/PermissionGroupIndex.vue")
		},
		{
			path: "account/permissiongroup/create",
			name: "account.permissiongroup.create",
			component: () => import("@/components/account/pages/permissiongroup/PermissionGroupCreate.vue")
		},
		{
			path: "account/permissiongroup/update/:id",
			name: "account.permissiongroup.edit",
			component: () => import("@/components/account/pages/permissiongroup/PermissionGroupEdit.vue")
		},
		{
            path: "/account/product",
            name: "account.product",
            component: () => import("@/components/account/pages/product/ProductIndex.vue")
		},
		{
            path: "/account/product/create",
            name: "product.create",
            component: () => import("@/components/account/pages/product/ProductCreate.vue")
		},
		{
            path: "/account/product/create-combo",
            name: "product.create-combo",
            component: () => import("@/components/account/pages/product/ProductCreateCombo.vue")
		},
		{
            path: "/account/product/show/:id",
            name: "product.show",
            component: () => import("@/components/account/pages/product/ProductShow.vue")
		},
		{
            path: "/account/product/edit/:id",
            name: "product.edit",
            component: () => import("@/components/account/pages/product/ProductEdit.vue")
		},
		{
			path: "account/stores",
			name: "account.stores",
			component: () => import("@/components/account/pages/stores/Index.vue")
		},
		{
			path: "account/product-catalog",
			name: "account.product-catalog",
			component: () => import("@/components/account/pages/product-catalogs/Index.vue")
		},
		{
			path: "account/warehouse",
			name: "account.warehouse",
			component: () => import("@/components/account/pages/warehouse/Index.vue")
		},
		{
			path: "account/user",
			name: "account.user",
			component: () => import("@/components/account/pages/user/UserIndex.vue")
		},
		{
			path: "account/user/create",
			name: "account.user_create",
			component: () => import("@/components/account/pages/user/UserCreate.vue")
		},
		{
			path: "account/user/:id/update",
			name: "account.user_update",
			component: () => import("@/components/account/pages/user/UserEdit.vue")
		},
		{
			path: "account/attribute-group",
			name: "account.attribute-group",
			component: () => import("@/components/account/pages/attribute-group/AttributeGroupIndex.vue")
		},
		{
			path: "account/attribute-group/create",
			name: "account.attribute-group.create",
			component: () => import("@/components/account/pages/attribute-group/AttributeGroupCreate.vue")
		},
		{
			path: "account/attribute-group/:id/update",
			name: "account.attribute-group.update",
			component: () => import("@/components/account/pages/attribute-group/AttributeGroupEdit.vue")
		},
		{
			path: "account/provider",
			name: "account.provider",
			component: () => import("@/components/account/pages/provider/ProviderIndex.vue")
		},
		{
			path: "account/job-title",
			name: "account.job-title",
			component: () => import("@/components/account/pages/job-title/JobTitleIndex.vue")
		},
	]),
]
