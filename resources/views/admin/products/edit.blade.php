@extends('layouts.admin')

@section('title', 'Edit Product')

@section('page-title', 'Edit Product')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Edit Product</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
      <li class="breadcrumb-item active">Edit Product</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-6">

      <div class="card">
      @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="card-body">
          <h5 class="card-title">Edit Product Form</h5>

          <!-- Edit Product Form Elements -->
          <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <label for="name" class="col-sm-2 col-form-label">Product Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}">
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" style="height: 100px" name="description" id="description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="price" class="col-sm-2 col-form-label">Price</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}">
                @error('price')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="stock" class="col-sm-2 col-form-label">Stock</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="stock" id="stock" value="{{ old('stock', $product->stock) }}">
                @error('stock')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="image" class="col-sm-2 col-form-label">Image</label>
              <div class="col-sm-10">
                <input class="form-control" type="file" id="image" name="image">
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                @endif
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="category_id" class="col-sm-2 col-form-label">Category</label>
              <div class="col-sm-10">
                <select name="category_id" id="category_id" class="form-select">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="is_active" class="col-sm-2 col-form-label">Is Active</label>
              <div class="col-sm-10">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                @error('is_active')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Update Product</button>
              </div>
            </div>

          </form><!-- End Edit Product Form Elements -->

        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

@endsection
