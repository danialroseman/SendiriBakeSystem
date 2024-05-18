@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1 style="font-size: 35px; font-weight:bold;">Products List</h1>
    <a href="{{ route('add.product') }}"><button>Add New Product</button></a>
</div>
<div id="productImages">
    @foreach ($products as $product)
        <div class="productItem" onclick="redirectToEdit({{$product->Id}})">
            <img src="data:image/png;base64,{{ base64_encode($product->Pimage) }}" alt="{{ $product->Pname }}" onclick="redirectToEdit({{ $product->id }})">
            <p>{{ $product->Pname }}</p>
            <p>Price: {{ $product->price }}</p>
        </div>
    @endforeach
</div>

<script>
    function redirectToEdit(productId) {
        window.location.href = `/edit-product/${productId}`;
    }
</script>
@endsection
