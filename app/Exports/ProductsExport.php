<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings

{
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Description',
            'Price',
            'Category',
            'Stock',
            'Image',
            'Status',
        ];
    }
}
