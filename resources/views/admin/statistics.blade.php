    @extends('layouts.master-with-header')

    @section('title', 'لوحة التحكم| احصائيات')

    @section('css')
        <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
        {{-- <style>
            .stat-card {
                transition: all 0.3s ease;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
                background-color: #fff;
                height: 100%;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            }

            .stat-title {
                color: #6c757d;
                font-size: 1.1rem;
                margin-bottom: 10px;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: bold;
                color: #d2691e;
            }

            .stat-card.primary .stat-number {
                color: #d2691e;
            }

            .stat-card.success .stat-number {
                color: #28a745;
            }

            .stat-card.info .stat-number {
                color: #17a2b8;
            }

            .stat-card.warning .stat-number {
                color: #ffc107;
            }

            .stat-card.danger .stat-number {
                color: #dc3545;
            }

            .stat-card.purple .stat-number {
                color: #6f42c1;
            }

            .recent-orders-card,
            .popular-products-card {
                margin-top: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
                background-color: #fff;
            }

            .card-title {
                color: #333;
                font-size: 1.3rem;
                margin-bottom: 20px;
                border-bottom: 1px solid #eee;
                padding-bottom: 10px;
            }

            .product-img {
                width: 40px;
                height: 40px;
                object-fit: cover;
                border-radius: 5px;
            }

            .revenue-highlight {
                font-size: 1.2rem;
                color: #28a745;
                font-weight: bold;
            }
        </style> --}}
    @endsection

    @section('content')
        <div class="row">
            <!-- Sidebar -->
            @include('layouts.admin-sidebar')
            <!-- Main Content -->
            <div class="col-lg-10 px-4">
                <h4 class="mb-4 mt-3">لوحة الإحصائيات</h4>

                <!-- First Row of Stats -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card primary">
                            <h3 class="stat-title">التجار</h3>
                            <div class="stat-number">{{ $sellersCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card success">
                            <h3 class="stat-title">الزبائن</h3>
                            <div class="stat-number">{{ $customersCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card info">
                            <h3 class="stat-title">المشرفين</h3>
                            <div class="stat-number">{{ $adminsCount ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <!-- Second Row of Stats -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card warning">
                            <h3 class="stat-title">المنتجات</h3>
                            <div class="stat-number">{{ $productsCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card danger">
                            <h3 class="stat-title">المبيعات</h3>
                            <div class="stat-number">{{ $salesCount ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card purple">
                            <h3 class="stat-title">المشتريات</h3>
                            <div class="stat-number">{{ $purchasesCount ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
