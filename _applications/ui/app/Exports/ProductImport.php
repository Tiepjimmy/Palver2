<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\ProductSheedImport;

/**
 * ProductImport
 */
class ProductImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new ProductSheedImport()
        ];
    }
}