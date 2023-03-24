<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithLimit;

/**
 * ProductSheedImport
 */
class ProductSheedImport implements WithHeadingRow, WithLimit
{
    public function headingRow(): int
    {
        return 1;
    }

    public function limit(): int
    {
        return 7001;
    }
}