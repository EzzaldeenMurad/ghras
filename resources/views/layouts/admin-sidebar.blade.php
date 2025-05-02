{{-- <div class="col-lg-2 mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <!-- <h5 class="card-title text-center mb-4">لوحة التحكم</h5> -->
            <div class="sidebar">
                <ul class="nav flex-lg-column gap-2 justify-content-center  px-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.statistics') }}">
                            لوحة التحكم
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products') }}">
                            المنتجات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('admin.orders') }}">
                            الطلبات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.articles') }}">
                            المقالات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">
                            المستخدمين
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}

@php
    $menuItems = [
        ['title' => 'لوحة التحكم', 'route' => 'admin.dashboard'],
        ['title' => 'المنتجات', 'route' => 'admin.products.index'],
        ['title' => 'الفئات', 'route' => 'categories.index'],
        ['title' => 'الطلبات', 'route' => 'admin.orders'],
        ['title' => 'المقالات', 'route' => 'admin.articles'],
        ['title' => 'المستخدمين', 'route' => 'users.index'],
    ];
@endphp

<div class="col-lg-2 mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="sidebar">
                <ul class="nav flex-lg-column gap-2 justify-content-center px-0">
                    @foreach ($menuItems as $item)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                                href="{{ route($item['route']) }}">
                                {{ $item['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
