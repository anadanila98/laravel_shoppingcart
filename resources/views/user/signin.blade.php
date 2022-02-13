@extends('layouts.master')

@section('content')
<br>
<div class="justify-content-center row">
    <div class="col-md-4 col-md-offset-4">
        <h1 class="text-center">Sign In</h1>

        @if(count($errors) > 0)
            <div class="alert alert-danger">
               <!--Variabila errors de la Laravel, voi afisa eroare in div daca am intampinat erori la validarea campurilor-->
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="justify-content-center" action="{{ route('user.signin') }}" method="post">
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="text" id="email" name="email" class="form-control" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" autocomplete="off">
            </div>

            <div class="text-center">
                <button class="btn btn-primary" type="submit">
                    Sign In
                </button>

                <!--aceasta metoda va insera datele din formular, are rolul unui hidden field cu session token-->
                {{ csrf_field() }}

            </div>
        </form>
        <br>
        <p class="text-center">Don't have an account? <a href="{{ route('user.signup') }}">Sign up!</a></p>
    </div>
</div>
@endsection
