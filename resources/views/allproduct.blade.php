@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                <table border=1>
                  <tr>
                  <th>Product Name</th>
                  <th>Product Price</th>
                  <th>Color</th>
                  <th>Size</th>
                  <th>Image</th>
                  <th>Action</th>
                  </tr>

                  @foreach($products as $product)
                  <tr>
                  <td>{{@$product->name}}</td>
                  <td>${{@$product->price}}</td>
                  <td>@forelse($product->color as $color) {{  $color->color->name}} @if (!$loop->last),@endif @empty {{"N/A"}} @endforelse</td>
                  <td>@forelse($product->size as $size) {{  $size->size->name}} @if (!$loop->last),@endif @empty {{"N/A"}} @endforelse</td>
                  <td>@foreach($product->image as $image) <img src="{{asset('Uploads/'.$image->pic)}}" style="width: 62px;">  @endforeach</td>
                  <th><a href="{{route('edit_product',@$product->id)}}">Edit</a></th>
                  </tr>
                  @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
