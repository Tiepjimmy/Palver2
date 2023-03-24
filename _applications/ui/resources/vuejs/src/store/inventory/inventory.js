import * as types from "./mutation-types";
import { default as state } from "./state";
import { default as getters } from "./getters";
import { default as mutations } from "./mutations";
import { default as actions } from "./actions";

import { default as goods_receipt_create } from "./import/goods-receipt/create/module";
import { default as goods_issue_index } from "./export/goods-issue/index/module";
import { default as goods_issue_create } from "./export/goods-issue/create/module";
import { default as goods_issue_show } from "./export/goods-issue/show/module";

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
    modules: {
        import: {
            namespaced: true,
            modules: {
                // module phieu nhap
                goods_receipt: {
                    namespaced: true,
                    modules: { create: goods_receipt_create },
                },
            },
        },

        export: {
            namespaced: true,
            modules: {
                // module phieu xuat
                goods_issue: {
                    namespaced: true,
                    modules: {
                        index: goods_issue_index,
                        create: goods_issue_create,
                        show: goods_issue_show,
                    },
                },
            },
        },

        common: {
            namespaced: true,
            modules: {},
        },
    },
};
