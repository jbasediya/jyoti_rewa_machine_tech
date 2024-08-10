<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row[0],
            'description' => $row[1],
            'price' => $row[2],
            'category_id' => $row[3],
            'image' => $row[4],
            'stock' => $row[5],
            'is_active' => $row[6],
        ]);
    }
}
