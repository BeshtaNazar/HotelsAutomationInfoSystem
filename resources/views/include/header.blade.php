<header class="header">
    <div class="header-wrapper">
        <a href="/" class="navbar-logo">Hotels automation</a>
        <nav class="header-navbar">
            <ul class="navbar-menu" id="navbar-menu">
                <li><a href="{{ route('hotel.list') }}">List your hotel</a></li>
                @if (Auth::check())
                    <li class="profile-icon"><a class="_icon-profile" href="/account/profile"></a></li>
                    <li class="profile-title"><a href="/account/profile">Profile</a></li>
                @else
                    <li><a href="/login">Log in</a></li>
                @endif
                <li class="cart-title"><a href="{{ route('cart') }}">Shopping cart</a></li>
                <li class="cart-icon"><a href="{{ route('cart') }}" class="cart-link _icon-cart"><span
                            class="cart-indicator hidden"></span></a></li>
            </ul>
        </nav>
        <div class="burger-menu">
            <span></span>
        </div>
    </div>
</header>
