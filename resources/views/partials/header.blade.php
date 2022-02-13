<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img src="{{ URL::to('/') }}/images/logo.png" alt="logo" style="max-height: 50px; max-weight:50px">&nbsp;&nbsp;&nbsp;&nbsp;
    <a class="navbar-brand" href="{{ route('product.index') }}">MONTANIA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarSupportedContent">
        <ul class="nav navbar-nav">
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('product.index') }}">
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            @if(Auth::check())
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('shopcart.shoppingCart') }}">
                        <i class="fa fa-shopping-cart"></i> Shopping Cart <span class="sr-only">(current)</span>
                        <span class="badge">@isset($quantity)
                                {{  $quantity }}
                            @endisset</span>
                    </a>
                </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i>
                    Signup/Signin
                </a>
                <ul class="dropdown-menu">
                    @if(Auth::check())
                        <li role="separator" class="divider"></li>
                        <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                    @else
                        <li><a class="dropdown-item" href="{{ route('user.signup') }}">Signup
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('user.signin') }}">Signin
                            </a></li>

                    @endif


                </ul>
            </li>
        </ul>
    </div>
</nav>


