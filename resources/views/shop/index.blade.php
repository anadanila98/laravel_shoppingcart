@extends('layouts.master')

@section('title')
    Montania
@endsection


@section('carousel')

   @if(Session::has('success'))
       <div class="row">
          <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
             <div id="charge-message" class="alert alert-success">
                 {{ Session::get('success') }}
             </div>

          </div>
       </div>
    @endif

    @include('partials.carousel')
@endsection

@section('content')

   <br><br>
   @foreach($products->chunk(3) as $productChunk)
   <div class="row">
       @foreach($productChunk as $product)
           <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="{{ $product->imagePath }}" alt="...">
                    <div class="caption">
                        <h3>{{ $product->title }}</h3>
                        <p class="description">{{ $product->description }}</p>
                        <p class="stock">Available:{{ $product->stock }}</p>
                        <div class="clearfix">
                           <div class="pull-left price">
                           {{ $product->price }} EUR
                           </div>
                            <a href="{{ route('shopcart.addToCart', ['id' => $product->id]) }}" class="btn btn-success pull-right" role="button">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
       @endforeach
    </div>

    <br>
    <br>
   @endforeach
@endsection
