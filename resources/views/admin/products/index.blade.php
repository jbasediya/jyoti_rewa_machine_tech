@extends('layouts.admin')

@section('title', 'Product List')

@section('page-title', 'Products')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Product List</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item active">Products</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
      @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
      @endif
        <div class="card-body">
          <h5 class="card-title">Products Table</h5>

           <!-- Import and Export Buttons -->
           <div class="mb-3">
            <!-- Export Button -->
            <a href="{{ route('products.export') }}" class="btn btn-success">Export CSV Products</a>

            <!-- Import Form -->
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="d-inline">
              @csrf
              <input type="file" name="csv_file"  class="form-control d-inline" style="width: auto;" required>
              <button type="submit" class="btn btn-primary">Import CSV Products</button>
            </form>
          </div>

          <!-- Default Table -->
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Image</th>
                <th scope="col">Product Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
              <tr>
                <th scope="row">{{ $product->id }}</th>
                <td>
                  @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                  @else
                    <img src="{{ asset('storage/products/default.png') }}" alt="Default Image" width="50">
                  @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                    <!-- Action buttons (Edit, Delete, etc.) -->
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- End Default Table Example -->
        </div>
      </div>
    </div>
  </div>
</section>

</main><!-- End #main -->

@endsection
