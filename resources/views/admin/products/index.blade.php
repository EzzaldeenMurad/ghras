@extends('layouts.master-with-header')

@section('title', 'لوحة التحكم| ادارة المنتجات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
    <style>
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('layouts.admin-sidebar')
        <!-- Main Content -->
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">إدارة المنتجات</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>صاحب المنتج</th>
                                    <th>سعر المنتج</th>
                                    <th>الفئة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($product->images()->first())
                                                    <img src="{{ $product->images()? asset($product->images()->first()->image_url): asset('assets/images/img1.png') }}"
                                                        alt="{{ $product->name }}" class="product-img">
                                                @else
                                                    <div
                                                        class="product-img bg-light d-flex align-items-center justify-content-center">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <span>{{ $product->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $product->user->name ?? 'غير معروف' }}</td>
                                        <td>{{ $product->price }} ريال</td>
                                        <td>{{ $product->category->name ?? 'بدون فئة' }}</td>
                                        <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('admin.products.show', $product) }}"
                                                    class="btn p-0 btn-sm action-icon">
                                                    <i class="fas fa-eye" title="عرض"></i>
                                                </a>

                                                <form action="{{ route('admin.products.destroy', $product) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn p-0 btn-sm action-icon"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                                        <i class="fas fa-trash-alt text-danger" title="حذف"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            <i class="fas fa-box-open fa-3x mb-3"></i>
                                            <p>لا توجد منتجات متاحة حالياً</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
