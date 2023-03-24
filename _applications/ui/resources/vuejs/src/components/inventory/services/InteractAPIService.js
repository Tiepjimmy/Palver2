import { default as ApiService } from "@/core/api.service";

/**
 * This class describes an interact api service.
 *
 * @class      InteractAPIService (name)
 */
export class InteractAPIService {
    /**
     * Shows the lot.
     *
     * @param      {<type>}  lotID   The lot id
     * @return     {<type>}  { description_of_the_return_value }
     */
    static showLot(lotID) {
        return ApiService.get("/proxy/inventory/v1/lot/" + lotID);
    }

    /**
     * Stores a lot.
     *
     * @param      {<type>}  lot     The lot
     * @return     {<type>}  { description_of_the_return_value }
     */
    static storeLot(lot) {
        return ApiService.post("/proxy/inventory/v1/lot", lot);
    }

    /**
     * { function_description }
     *
     * @param      {<type>}  lot     The lot
     * @return     {<type>}  { description_of_the_return_value }
     */
    static updateLot(lotID, lot) {
        return ApiService.patch("/proxy/inventory/v1/lot/" + lotID, lot);
    }

    /**
     * Fetches a providers by store id.
     *
     * @param      int        storeID  The store id
     * @return     {Promise}  The providers by store id.
     */
    static fetchProvidersByStoreIDs(storeIDs) {
        return ApiService.get("/proxy/inventory/v1/store/providers", { store_id: storeIDs });
    }

    /**
     * Fetches lots.
     *
     * @param      {<type>}   params  The parameters
     * @return     {Promise}  The lots.
     */
    static fetchLots(params) {
        return ApiService.get("/proxy/inventory/v1/lot", params);
    }

    /**
     * Fetches a lot list.
     *
     * @param      {<type>}  params  The parameters
     * @return     {<type>}  The lot list.
     */
    static fetchLotList(params) {
        return ApiService.get("/proxy/inventory/v1/lot/", params);
    }

    /**
     * Fetches products.
     *
     * @param      {<type>}   params  The parameters
     * @return     {Promise}  The products.
     */
    static fetchProducts(params) {
        return ApiService.get("/proxy/inventory/v1/store/retail-products", params);
    }

    /**
     * Fetches a goods receipt list.
     *
     * @param      {<type>}   params  The parameters
     * @return     {Promise}  The goods receipt list.
     */
    static fetchGoodsReceiptList(params) {
        return ApiService.get("/proxy/inventory/v1/goods-receipt/list", params);
    }

    /**
     * Fetches a goods receipt.
     *
     * @param      {string}  goodsReceiptID  The goods receipt id
     * @return     {<type>}  The goods receipt.
     */
    static fetchGoodsReceipt(goodsReceiptID) {
        return ApiService.get("/proxy/inventory/v1/goods-receipt/" + goodsReceiptID);
    }

    /**
     * { function_description }
     *
     * @param      {<type>}  goodsReceiptIDs  The goods receipt i ds
     * @param      {<type>}  status           The status
     * @return     {<type>}  { description_of_the_return_value }
     */
    static updateManyGoodsReceiptStatus(goodsReceiptIDs, status) {
        return ApiService.post("/proxy/inventory/v1/goods-receipt/statuses", {
            goods_receipt_ids: goodsReceiptIDs,
            status: status,
        });
    }

    /**
     * Stores a goods receipt.
     *
     * @param      {<type>}  goodsreceipt  The goodsreceipt
     * @return     {<type>}  { description_of_the_return_value }
     */
    static storeGoodsReceipt(goodsreceipt) {
        return ApiService.post("/proxy/inventory/v1/goods-receipt", goodsreceipt);
    }

    /**
     * Fetches store branches.
     *
     * @param      {<type>}   params  The parameters
     * @return     {Promise}  The store branches.
     */
    static fetchStoreBranches(params) {
        return ApiService.get("/proxy/inventory/v1/store/branches", params);
    }

    /**
     * Fetches a goods issue list.
     *
     * @param      {<type>}  params  The parameters
     * @return     {<type>}  The goods issue list.
     */
    static fetchGoodsIssueList(params) {
        return ApiService.get("/proxy/inventory/v1/goods-issue/list", params);
    }

    /**
     * Stores a goods issue.
     *
     * @param      {<type>}  goodsreceipt  The goodsreceipt
     * @return     {<type>}  { description_of_the_return_value }
     */
    static fetchOrderByID(orderID) {
        return ApiService.get("/proxy/inventory/v1/order/" + orderID);
    }

    /**
     * Stores a goods issue.
     *
     * @param      {<type>}  goodsreceipt  The goodsreceipt
     * @return     {<type>}  { description_of_the_return_value }
     */
    static storeGoodsIssue(goods_issue) {
        console.log(goods_issue);
        return ApiService.post("/proxy/inventory/v1/goods-issue/", goods_issue);
    }

    /**
     * Fetches a goods issue.
     *
     * @param      {string}  goodsIssueID  The goods issue id
     * @return     {<type>}  The goods issue.
     */
    static fetchGoodsIssue(goodsIssueID) {
        return ApiService.get("/proxy/inventory/v1/goods-issue/" + goodsIssueID);
    }

    /**
     * { function_description }
     *
     * @param      {<type>}  goodsIssueIDs  The goods issue i ds
     * @param      {<type>}  status         The status
     * @return     {<type>}  { description_of_the_return_value }
     */
    static updateManyGoodsIssueStatus(params) {
        return ApiService.patch("/proxy/inventory/v1/goods-issue/statuses", params);
    }
}
