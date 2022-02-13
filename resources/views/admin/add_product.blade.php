@extends('layouts.master_admin')
@section('content')

    <form method="POST" action="{{ route('insert_product') }}"  enctype="multipart/form-data" name="FORM"
          style="border: 1px solid gray; width: 80%; float: right">
        @csrf
        <div style="padding: 2%;">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="title" placeholder="Title..">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="price" placeholder="Price..">
                </div>
                <div class="col-md-3">
                    <input type="file" class="form-control" name="image" placeholder="Image..">
                </div>
                <div class="col-md-3">
                    <input type="number" name="stock" id="stock" class="form-control" placeholder="Available items...">
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-10">
                    <textarea class="form-control" name="description" placeholder="Describe product..."></textarea>
                </div>
                <div class="col-md-1"></div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-info" >Save product<i class="fa fa-step-forward"></i></button>

                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </form>
@endsection
