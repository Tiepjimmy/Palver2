import { middleware } from 'vue-router-middleware';

const invPath = path => 'inventory' + path;

const invImportPath = path => invPath('/import' + path);
const invExportPath = path => invPath('/export' + path);
const invCommonPath = path => invPath('/common' + path);

export default [
	...middleware(
		[],
		[
			/***********************************************************************************************************
			 * Xuất kho route
			 **********************************************************************************************************/
			{
				path: invExportPath('/'),
				name: 'inv.export',
				component: () => import('@/components/inventory/pages/exports/index/Index'),
			},
			{
				path: invExportPath('/'),
				name: 'inv.export.goods-issue.index',
				component: () => import('@/components/inventory/pages/exports/index/Index'),
			},
			{
				path: invExportPath('/create'),
				name: 'inv.export.goods-issue.create',
				component: () => import('@/components/inventory/pages/exports/create/Create'),
			},
			{
				path: invExportPath('/:id'),
				name: 'inv.export.goods-issue.show',
				component: () => import('@/components/inventory/pages/exports/show/Show'),
			},

			/***********************************************************************************************************
			 * Nhập kho route
			 **********************************************************************************************************/
			{
				path: invImportPath('/'),
				name: 'inv.import',
				component: () => import('@/components/inventory/pages/imports/list/List'),
			},
			{
				path: invImportPath('/'),
				name: 'inv.import.goods-receipt.index',
				component: () => import('@/components/inventory/pages/imports/list/List'),
			},
			{
				path: invImportPath('/create'),
				name: 'inv.import.goods-receipt.create',
				component: () => import('@/components/inventory/pages/imports/create/Create'),
			},
			{
				path: invImportPath('/:id'),
				name: 'inv.import.goods-receipt.show',
				component: () => import('@/components/inventory/pages/imports/show/Show'),
			},

			{
				path: invImportPath('/:id/import'),
				name: 'inv.import.goods-receipt.import',
				component: () => import('@/components/inventory/pages/imports/show/Import'),
			},
			{
				path: invImportPath('/:id/edit'),
				name: 'inv.import.goods-receipt.edit',
				component: () => import('@/components/inventory/pages/imports/Edit'),
			},

			/***********************************************************************************************************
			 * Quản lý chung route
			 **********************************************************************************************************/
			{
				path: invCommonPath('/'),
				name: 'inv.common',
				component: () => import('@/components/inventory/pages/commons/lot/list/List'),
			},
			{
				path: invCommonPath('/lot'),
				name: 'inv.common.lot',
				component: () => import('@/components/inventory/pages/commons/lot/list/List'),
			},

			/***********************************************************************************************************
			 * Quản lý tồn kho route
			 **********************************************************************************************************/
			{
				path: invCommonPath('/'),
				name: 'inv.stock',
				component: () => import('@/components/inventory/pages/commons/lot/list/List'),
			},
		]
	),
];
