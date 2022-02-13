@extends('layouts.master_admin')
@section('content')

    <form method="POST" action="{{ route('update_delete_product') }}"  enctype="multipart/form-data" name="update_delete_form"
          style="border: 1px solid gray; width: 80%; float: right">
        @csrf
        <div style="padding: 2%;">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="title" value="<?=Arr::get($product,"title")?>">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="price" value="<?=Arr::get($product,"price")?>">
                </div>
                <div class="col-md-3">
                    <input type="file" class="form-control" name="image" placeholder="Image.."  value="<?=Arr::get($product,"imagePath")?>">
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="stock" id="stock" value="<?=Arr::get($product,"stock")?>">
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <textarea class="form-control" name="description" ><?=Arr::get($product,"description")?></textarea>
                </div>
                <div class="col-md-1"></div>
            </div>
            <br/>
            <input type="text" name="id" style="display: none" value="<?=Arr::get($product,"id")?>">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-2">
                    <input type="submit" name="action"  class="btn btn-info" value="update">
                </div>
                <div class="col-md-2">
                    <input type="submit" name="action"  class="btn btn-warning" value="delete" >
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </form>
@endsection
