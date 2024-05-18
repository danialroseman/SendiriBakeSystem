@extends('admin.layout')

@section('content')
            <h1 style="font-size: 35px; font-weight:bold;">Add New Product</h1>
            <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="product-container">
                    <div class="editproduct-image">
                        
                        <img id="previewImage" src="{{ asset('path_to_default_image.jpg') }}" alt="New Product Image"><br><br>
                        <input type="file" name="productImage" id="uploadImage" accept="image/*">
                    </div>
                    <div class="editproduct-details">
                        <input type="text" name="Category" placeholder="Category" class="category"><br><br>
                        <input type="text" name="productName" placeholder="Product Name" class="productname"><br><br>
                        <input type="text" name="productPrice" placeholder="Product Price" class="productprice"><br><br>
                        <textarea name="productDescription" placeholder="Product Description" class="productdesc" rows="4" cols="50"></textarea><br><br>
                        <input type="submit" name="addProduct" value="Add Product">
                    </div>
                </div>
            </form>     
       
@endsection
