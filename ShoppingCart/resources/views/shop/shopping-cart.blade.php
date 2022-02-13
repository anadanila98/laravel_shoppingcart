@extends('layouts.master')

@section('title')
    Montania
@endsection

@section('content')
      <br><br>
      @if(Session::has('error'))
          <div class="row">
              <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
                  <div id="charge-message" class="alert alert-danger">
                      {{ Session::get('error') }}
                  </div>

              </div>
          </div>
      @endif
    @if(count($products)>0)
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <ul class="list-group">
                    @foreach($products as $product)
                        <li class="list-group-item">
                            <strong>{{ $product['title'] }}</strong>
                            <span class="label label-success">{{ $product['description'] }}</span>

                            <div class="float-right">
                                <a href="{{ route('shopcart.reduceByOne', ['id' => $product['product_id'], 'cart_id'=>$product['cart_id']]) }}" type="button" class="btn btn-primary">-</a>
                                <a href="{{ route('shopcart.increaseByOne', ['id' => $product['product_id'], 'cart_id'=>$product['cart_id']]) }}" type="button" class="btn btn-primary">+</a>&nbsp;
                                <a href="{{ route('shopcart.removeItem', ['id' => $product['product_id'], 'cart_id'=>$product['cart_id']]) }}" type="button" class="btn btn-danger">Remove</a>
                            </div>

                            <span class="badge float-right">{{ $product['quantity'] }}</span>
                            <span class="badge float-right">{{ $product['price'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <strong>Total: {{ $totalPrice }}</strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <a href="{{ route('checkoutform', ['cart_id'=>$cart_id, 'totalPrice'=>$totalPrice]) }}" type="button" class="btn btn-success">Checkout</a>
                <a href="{{ route('shopcart.removeAll', ['cart_id'=>$cart_id]) }}" type="button" class="btn btn-danger">Remove all</a>
            </div>
        </div>

    @else

        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
               <h2>No items in Cart!</h2>
            </div>
        </div>

    @endif

@endsection
