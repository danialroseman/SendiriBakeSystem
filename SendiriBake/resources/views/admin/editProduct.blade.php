@extends('admin.layout')

@section('content')
<div class="edit-product-container">
    <h1>Edit Product</h1>
    <form class="edit-product-form" method="POST" action="{{ route('update.product', $product->Id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Display original product image if it exists -->
        <div>
            @if ($product->Pimage)
                <img id="originalImage" src="data:image/png;base64,{{ base64_encode($product->Pimage) }}" alt="Product Image" style= "width: 250px; height: 250px">
            @else
                <p>No original image available</p>
            @endif
        </div>

        <!-- Input field for uploading a new product image -->
        <div>
            <label for="productImage">New Product Image</label>
            <input type="file" id="productImage" name="productImage" accept="image/*" onchange="previewImage(event)">
            <!-- Image preview container -->
            <img id="imagePreview" src="#" alt="Product Image Preview" style="display: none; max-width: 200px;">
        </div>


        <!-- Other form fields for product details -->
        <div>
            <label for="productName">Product Name</label>
            <input type="text" id="productName" name="productName" value="{{ $product->Pname }}">
        </div>

        <div>
            <label for="productPrice">Product Price</label>
            <input type="text" id="productPrice" name="productPrice" value="{{ $product->price }}">
        </div>

        <div>
            <label for="productDescription">Product Description</label>
            <textarea id="productDescription" name="productDescription">{{ $product->Pdesc }}</textarea>
        </div>

        <div>
            <button type="submit">Update Product</button>
        </div>
    </form>

    <form class="delete-form" method="POST" action="{{ route('delete.product', $product->Id) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Product</button>
    </form>
</div>

<script>
    // Function to preview the selected image
    function previewImage(event) {
        // Display the new image preview and hide the original image
        document.getElementById('originalImage').style.display = 'none';
        document.getElementById('imagePreview').style.display = 'inline';

        // Set the preview image source
        document.getElementById('imagePreview').src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endsection
