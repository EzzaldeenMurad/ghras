@php
    $role = Auth::user()->role;

    $menuItems = [];

    // Define menu items based on user role
    if ($role === 'seller') {
        $menuItems = [
            ['title' => 'الملف الشخصي', 'route' => 'profile'],
            ['title' => 'المنتجات', 'route' => 'seller.products.index'],
            ['title' => 'الطلبات', 'route' => 'seller.orders'],
            ['title' => 'الاستشارات', 'route' => 'seller.consultations'],
        ];
        $sidebarTitle = 'ملف حساب المزارع';
    } elseif ($role === 'buyer') {
        $menuItems = [
            ['title' => 'الملف الشخصي', 'route' => 'profile'],
            ['title' => 'المشتريات', 'route' => 'buyer.mysells'],
        ];
        $sidebarTitle = 'ملف حساب الزبون';
    } elseif ($role === 'consultant') {
        $menuItems = [
            ['title' => 'الملف الشخصي', 'route' => 'profile'],
            ['title' => 'طلبات الإستشارة', 'route' => 'conslut.order-conslut'],
        ];
        $sidebarTitle = 'ملف حساب المستشار';
    } else {
        $menuItems = [['title' => 'الملف الشخصي', 'route' => 'profile']];
        $sidebarTitle = 'ملف حساب المدير';
    }

@endphp

<div class="col-lg-3 mb-4">
    <div class="sidebar">
        <p class="sidebar-title">{{ $sidebarTitle }}</p>
        <ul class="sidebar-nav">
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
