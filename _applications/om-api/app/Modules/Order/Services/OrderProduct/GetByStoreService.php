<?php

namespace App\Modules\Order\Services\OrderProduct;

use Illuminate\Support\Facades\Validator;
use AccountSdkDb\Modules\Product\Services\Impls\ProductServiceImplement;
use Inventory\Modules\Stock\Repositories\Contracts\StockInterface;
use App\Modules\Order\Exceptions\OrderException;

class GetByStoreService
{
    const DEFAULT_LIMIT_ROW = 10;
    protected $productServiceImplement;
    protected $stockInterface;

    public function __construct(ProductServiceImplement $productServiceImplement,
                                StockInterface $stockInterface)
    {
        $this->productServiceImplement = $productServiceImplement;
        $this->stockInterface = $stockInterface;
    }

    public function execute($payload)
    {
        // Validation...
        $validator = $this->validate($payload);

        $perPage = $payload['limit'] ?? self::DEFAULT_LIMIT_ROW;
        $storeId = $payload['store_id'];
        $warehouseId = 1;

        $dataItems = array();
        $retailProducts = $this->productServiceImplement->getRetailProductsByStoreId($storeId, array(), $perPage);
        if (!empty($retailProducts['items'])) {
            $productIds = array();
            foreach ($retailProducts['items'] as $product) {
                $productIds[] = $product->id;
            }
            $stockAll = $this->stockInterface->sumGroupByLot($storeId, $warehouseId, $productIds)->toArray();
            foreach ($retailProducts['items'] as $product) {           
                $pid = $product->id;
                $stocks = array_values(array_filter($stockAll, function ($v) use ($pid) {
                    return $v['product_id'] === $pid;
                }));
                if (!empty($stocks)) {
                    foreach ($stocks as $key => $stock) {
                        $stocks[$key]['lot_name'] = $stock['lot']['code'];
                        $stocks[$key]['lot_expired_date'] = $stock['lot']['expired_date'];
                        $stocks[$key]['quantity_available'] = (int) $stock['quantity_available'];
                        $stocks[$key]['quantity_really'] = (int) $stock['quantity_really'];
                        unset($stocks[$key]['lot']);
                    }
                }
                
                // lay thong tin sp
                $item = new \stdClass();
                $item->id = $product->id;
                $item->sku = $product->sku;
                $item->has_options = $product->has_options;
                $item->is_overwrite_prices = $product->is_overwrite_prices;
                $item->product_entity_avatar = $product->product_entity_avatar;

                $item->display_name = $product->product->product_display_name;
                $item->product_name = $product->product->product_name;
                $item->product_cd   = $product->product->product_cd;
                $item->description  = $product->product->description;
                $item->is_sales     = $product->product->is_sales;
                $item->unit         = $product->product->unit;

                // gia ban
                $price = new \stdClass();
                $price->prices = $product->retailEntityPrice->prices;
                $price->cost_prices = $product->retailEntityPrice->cost_prices;
                $price->wholesale_prices = $product->retailEntityPrice->wholesale_prices;
                $item->price = $price;
                
                // ton kho
                $item->stocks = $stocks;

                $dataItems[] = $item;
            }
        }
        
        return [
            'items' => $dataItems,
            'total' => $retailProducts['total'],
            'limit' => $perPage,
            'total_page' => $retailProducts['total_page'] ?? 1,
            'current_page' => $retailProducts['current_page'] ?? 1,
        ];
    }

    /**
     * @param array $payload
     * @return void
     * @throws OrderException
     */
    private function validate(array $payload)
    {
        $validator = Validator::make($payload, [
            
        ]);

        if ($validator->fails()) {
            throw new OrderException('ERR_002');
        }
    }
}
