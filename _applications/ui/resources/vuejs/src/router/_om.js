import { middleware } from 'vue-router-middleware';

export default [
	...middleware(
		[],
		[
			{
				path: 'order',
				name: 'om.order.index',
				component: () => import('@/components/om/pages/order/list/Index'),
			},
			{
				path: 'order/edit/:id',
				name: 'om.order.edit',
				component: () => import('@/components/om/pages/order/edit/Edit'),
			},
			{
				path: 'order/create',
				name: 'om.order.create',
				component: () => import('@/components/om/pages/order/create/Create'),
			},
			{
				path: 'order/detail/:id',
				name: 'om.order.detail',
				component: () => import('@/components/om/pages/order/detail/OrderDetail'),
			},
			{
				path: 'order-cancel-reasons',
				name: 'om.order-cancel-reasons.index',
				component: () => import('@/components/om/pages/order-cancel-reason/Index'),
			},
			{
				path: 'marketing/channels',
				name: 'om.channels.index',
				component: () => import('@/components/om/pages/marketing/channel/Manager'),
			},
			{
				path: 'marketing/payment-accounts',
				name: 'om.payment_accounts.index',
				component: () => import('@/components/om/pages/marketing/payment_account/Index'),
			},
			{
				path: 'marketing/campaigns',
				name: 'om.campaigns.index',
				component: () => import('@/components/om/pages/marketing/campaign/Index'),
			},
			{
				path: 'marketing/leads',
				name: 'om.leads.index',
				component: () => import('@/components/om/pages/marketing/lead/Marketing'),
			},
			{
				path: 'marketing/sale-leads',
				name: 'om.leads.sale_lead',
				component: () => import('@/components/om/pages/marketing/lead/SaleLead'),
			},
			{
				path: 'marketing/sale',
				name: 'om.leads.sale',
				component: () => import('@/components/om/pages/marketing/lead/Sale'),
			},
			{
				path: 'mission',
				name: 'om.mission.index',
				component: () => import('@/components/om/pages/mission/Index'),
			},
			{
				path: 'order/statuses',
				name: 'om.order.statuses',
				component: () => import('@/components/om/pages/order/status/Index'),
			},
			{
				path: 'shipping-providers',
				name: 'om.shipping-providers.index',
				component: () => import('@/components/om/pages/shipping-provider/ManagerShippingProvider'),
			},
			{
				path: 'order/print-forms',
				name: 'om.order.print_forms',
				component: () => import('@/components/om/pages/order/print/Index'),
			},
			{
				path: 'order/print-forms/create',
				name: 'om.order.print_forms.create',
				component: () => import('@/components/om/pages/order/print/Create'),
			},
			{
				path: 'order/print-forms/:id/update',
				name: 'om.order.print_forms.update',
				component: () => import('@/components/om/pages/order/print/Update'),
			},
			/***************************************************************************************************************
			 * Loại chứng từ thu
			 ***************************************************************************************************************/
			{
				path: 'type-collect-vouchers',
				name: 'om.type_collect_vouchers',
				component: () => import('@/components/om/pages/type-collect-vouchers/Index'),
			},
			{
				path: 'type-collect-vouchers/create',
				name: 'om.type_collect_vouchers.create',
				component: () => import('@/components/om/pages/type-collect-vouchers/Create'),
			},
			{
				path: 'type-collect-vouchers/:id/edit',
				name: 'om.type_collect_vouchers.edit',
				component: () => import('@/components/om/pages/type-collect-vouchers/Edit'),
			},
			{
				path: 'type-collect-vouchers/:id',
				name: 'om.type_collect_vouchers.show',
				component: () => import('@/components/om/pages/type-collect-vouchers/Show'),
			},
			/***************************************************************************************************************
			 * Chứng từ thu
			 ***************************************************************************************************************/
			{
				path: 'receipt-vouchers',
				name: 'om.receipt_vouchers',
				component: () => import('@/components/om/pages/receipt-vouchers/index/Index'),
			},
			{
				path: 'receipt-vouchers/create',
				name: 'om.receipt_vouchers.create',
				component: () => import('@/components/om/pages/receipt-vouchers/create/Create'),
			},
			{
				path: 'receipt-vouchers/:id/edit',
				name: 'om.receipt_vouchers.edit',
				component: () => import('@/components/om/pages/receipt-vouchers/edit/Edit'),
			},
			{
				path: 'receipt-vouchers/:id',
				name: 'om.receipt_vouchers.show',
				component: () => import('@/components/om/pages/receipt-vouchers/show/Show'),
			},
			{
				path: 'marketing/type-payment-vouchers',
				name: 'om.type-payment-vouchers.index',
				component: () => import('@/components/om/pages/marketing/type-payment-voucher/Index'),
			},
			{
				path: 'marketing/payment-vouchers',
				name: 'om.payment-vouchers.index',
				component: () => import('@/components/om/pages/marketing/payment-voucher/Index'),
			},
			{
				path: 'marketing/payment-vouchers/create',
				name: 'om.payment-vouchers.create',
				component: () => import('@/components/om/pages/marketing/payment-voucher/Create'),
			},
			{
				path: 'marketing/payment-vouchers/:id/edit',
				name: 'om.payment-vouchers.edit',
				component: () => import('@/components/om/pages/marketing/payment-voucher/Edit'),
			},
			{
				path: 'marketing/payment-vouchers/:id',
				name: 'om.payment-vouchers.show',
				component: () => import('@/components/om/pages/marketing/payment-voucher/Show'),
			},
			{
				path: 'marketing/payment-vouchers/:id/create',
				name: 'om.payment-vouchers.clone',
				component: () => import('@/components/om/pages/marketing/payment-voucher/Clone'),
			},
		]
	),
];
