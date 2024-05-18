@extends('admin.layout')

@section('content')
<div>
    <h1>Edit Product</h1>
    <form method="POST" action="{{ route('update.product', $product->Id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
    <form method="POST" action="{{ route('delete.product', $product->Id) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Delete Product</button>
    </form>
</div>
@endsection
 