<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container mt-0 pt-0">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="غراس" class="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-sm-start" id="navbarNav">
                <ul class="navbar-nav gap-2 text-center">
                    @php
                        $menuItems = [
                            ['title' => 'الرئيسية', 'route' => 'home'],
                            ['title' => 'المنتجات', 'route' => 'products.index'],
                            ['title' => 'المستشارين', 'route' => 'consultants'],
                            ['title' => 'المقالات', 'route' => 'articles'],
                            ['title' => 'تواصل معنا', 'route' => 'contact'],
                        ];
                    @endphp
                    @foreach ($menuItems as $item)
                        <li class="nav-item">

                            <a class="nav-link {{ request()->routeIs($item['route'] . '*') ? 'active' : '' }}"
                                href="{{ route($item['route']) }}">
                                {{ $item['title'] }}
                            </a>

                        </li>
                    @endforeach
                </ul>
            </div>
            @if (!Auth::check())
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle"
                        id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ms-2">تسجيل دخول</span>
                        <i class="fa fa-arrow-alt-circle-left"></i>
                    </a>
                    <ul class="dropdown-menu text-end" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item" href="{{ route('login') }}">دخول ك ماسترويب</a></li>
                        <li><a class="dropdown-item " href="{{ route('login') }}">دخول ك بابع</a></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}">دخول ك زبون</a></li>
                        <li><a class="dropdown-item" href="{{ route('login') }}">دخول ك مستشار</a></li>
                    </ul>
                </div>
            @else
                @if (auth()->user()->role === 'buyer')
                    <div class="cart position-relative ms-3">
                        <a href="{{ route('cart') }}"
                            class="d-flex align-items-center text-decoration-none text-dark me-2">
                            <i class="fa fa-shopping-cart fa-lg position-relative "></i>
                            <span
                                class="cart-count position-absolute top-0.5 start-100 translate-middle badge rounded-pill ">
                                0
                            </span>
                        </a>
                    </div>
                @endif
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle"
                        id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="ms-2">{{ Auth::user()->name }}</span>
                        <div class="user-img">
                            <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('assets/images/avatar_user.jpg') }}"
                                alt="User" class="rounded-circle w-100 h-100">
                        </div>
                    </a>
                    <ul class="dropdown-menu text-end" aria-labelledby="loginDropdown">
                        <li> <a class="dropdown-item"
                                href="{{ Auth::user()->role === 'admin' ? route(Auth::user()->role . '.dashboard') : route('profile') }}">
                                لوحة التحكم
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                            </form>
                        </li>
                    </ul>

                </div>
            @endif

        </div>
    </nav>
</header>
