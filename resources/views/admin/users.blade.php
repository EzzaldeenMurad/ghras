@extends('layouts.master-with-header')

@section('title', 'لوحة التحكم| ادارة المستخدمين')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/style.css') }}">
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
                        <h5 class="card-title"> المستخدمين</h5>

                    </div>

                    @include('alerts.success')

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>أسم المستخدم</th>
                                    <th>تاريخ الانضمام</th>
                                    <th>المنطقة</th>
                                    <th>نوع الحساب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="{{ asset($user->image ? $user->image : 'assets/images/consultant.png') }}"
                                                    alt="{{ $user->name }}" class="img">
                                                <span>{{ $user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>{{ $user->region }}</td>
                                        <td>
                                            @if ($user->role == 'admin')
                                                مدير
                                            @elseif($user->role == 'seller')
                                                تاجر
                                            @elseif($user->role == 'buyer')
                                                زبون
                                            @elseif($user->role == 'consultant')
                                                مستشار
                                            @else
                                                {{ $user->role }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 ">
                                                {{-- <a href="{{ route('users.show', $user->id) }}" class="btn p-0 btn-sm action-icon" tabindex="-1">
                                                    <i class="fas fa-eye" title="عرض"></i>
                                                </a> --}}

                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn p-0 btn-sm action-icon">
                                                    <i class="fas fa-edit" title="تعديل"></i>
                                                </a>

                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn p-0 btn-sm action-icon"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                        <i class="fas fa-trash-alt text-danger" title="حذف"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا يوجد مستخدمين</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
