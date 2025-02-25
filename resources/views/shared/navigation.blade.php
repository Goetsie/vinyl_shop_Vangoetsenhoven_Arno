<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/">The Vinyl Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/shop">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact-us">Contact</a>
                </li>
            </ul>
            {{--  Admin navigation  --}}
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="/login"><i class="fas fa-sign-in-alt"></i>Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register"><i class="fas fa-signature"></i>Register</a>
                    </li>
                @endguest
                <li class="nav-item">
                    <a class="nav-link" href="/basket"><i class="fas fa-shopping-basket"></i>Basket</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#!" data-toggle="dropdown">
                            {{ auth()->user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="/user/profile"><i class="fas fa-user-cog"></i>Update Profile</a>
                            <a class="dropdown-item" href="/user/password"><i class="fas fa-key"></i>New Password</a>
                            <a class="dropdown-item" href="/user/history"><i class="fas fa-box-open"></i>Order history</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
                            @if(auth()->user()->admin)
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/admin/genres"><i class="fas fa-microphone-alt"></i>Genres</a>
                                <a class="dropdown-item" href="/admin/records"><i class="fas fa-compact-disc"></i>Records</a>
                                <a class="dropdown-item" href="/admin/users"><i class="fas fa-users-cog"></i>Users</a>
                                <a class="dropdown-item" href="/admin/users2"><i class="fas fa-users-cog"></i>Users (advanced)</a>
                                <a class="dropdown-item" href="/admin/orders"><i class="fas fa-box-open"></i>Orders</a>
                            @endif
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
