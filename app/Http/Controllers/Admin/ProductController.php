<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\ProductsExport;
// use App\Imports\ProductsImport;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         $this->middleware('auth');
     }
 
  
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $product = new Product($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $product->fill($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
    public function export()
    {
        $products = Product::all();
    
        // Define the CSV file headers
        $csvHeader = ['ID', 'Name', 'Description', 'Price', 'Category ID', 'Stock', 'Is Active', 'Image'];
    
        // Create a file pointer
        $file = fopen('php://output', 'w');
    
        // Send the headers
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="products.csv"');
    
        // Output the column headings
        fputcsv($file, $csvHeader);
    
        // Output each product row
        foreach ($products as $product) {
            fputcsv($file, [
                $product->id,
                $product->name,
                $product->description,
                $product->price,
                $product->category_id,
                $product->stock,
                $product->is_active,
                $product->image
            ]);
        }
    
        fclose($file);
        exit();
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);
    
        // Open and read the CSV file
        if (($handle = fopen($request->file('csv_file')->getRealPath(), 'r')) !== false) {
            // Get the first row, which contains the column headers
            $header = fgetcsv($handle, 1000, ',');
    
            // Loop through the file rows
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // Combine headers with row data
                $data = array_combine($header, $row);
    
                // Create or update the product record
                Product::updateOrCreate(
                    ['name' => $data['name']],
                    [
                        'description' => $data['description'],
                        'price' => $data['price'],
                        'category_id' => $data['category_id'],
                        'stock' => $data['stock'],
                        'is_active' => $data['is_active'],
                        'image' => $data['image']
                    ]
                );
            }
    
            fclose($handle);
        }
    
        return redirect()->back()->with('success', 'Products imported successfully.');
    }
}
