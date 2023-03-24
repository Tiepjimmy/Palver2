<?php
namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

/**
 * ProductExport
 */
class ProductExport implements FromView, WithTitle
{
    private $_product;
        
    /**
     * __construct
     *
     * @param  mixed $product
     * @return void
     */
    public function __construct($product)
    {
        $this->_product = $product;
    }
    
    /**
     * view
     *
     * @return View
     */
    public function view(): View
    {
        return view('exel.exports', [
            'product' => $this->_product,
        ]);
    }
    
    /**
     * title
     *
     * @return string
     */
    public function title(): string
    {
        return 'Danh sách sản phẩm';
    }
}