<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class CustomerController extends Controller
{
   public function index()
   {
      
      $products = Product::with('category')->get();
      
      return view('frontend.index', compact('products'));
   }

   public function product_list()
   {
      
     // $products = Product::with('category')->get();
      
      return view('frontend.product_list');
   }

   public function single_product()
   {
      
     // $products = Product::with('category')->get();
      
      return view('frontend.single_product');
   }


}
