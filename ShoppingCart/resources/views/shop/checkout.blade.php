@extends('layouts.master')

@section('title')
    Montania
@endsection

@section('content')
   <br>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1 class="text-center">Checkout</h1>
            <h4 class="text-center">Your Total: ${{ $totalPrice }}</h4>
            <form action="{{ route('checkout') }}" method="post" id="checkout-form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control" required name="name">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" class="form-control" required name="address">
                            <input type="text" id="cart_id" name="cart_id" style="display: none" value="{{$cart_id}}">
                            <input type="text" id="total" name="total" style="display: none" value="{{$totalPrice}}">
                        </div>
                    </div>

                </div>

                {{ csrf_field() }}

                <div class="col text-center">
                    <button type="submit" class="btn btn-success">Buy now</button>
                </div>
            </form>
        </div>
    </div>
    <br><br>
@endsection
