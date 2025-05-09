@extends('layouts.master-with-header')

@section('title', ' سجل المشتريات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar -->
        @include('dashboard.partials.sidebar')
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="card bg-transparent border-0" style="width: 97%;">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <h5 class="card-title text-center">طلبات الإستشارة</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>الموضوع</th>
                                    <th>التفاصيل</th>
                                    <th>تاريخ</th>
                                    <th>أسم المستخدم</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                    <th>الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>
                                            {{ $order->subject }}
                                        </td>
                                        <td>{{ $order->description }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>{{ $order->seller->name }}</td>

                                        <td><span class="pending"> {{ $order->consultation->price }} </span></td>
                                        <td>
                                            <span
                                                class="text-{{ $order->getStatusColorAttribute() }}">{{ $order->getStatusNameAttribute() }}</span>
                                        </td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <form action="{{ route('dashboard.consultants.orders.update') }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <button class="btn p-0 btn-sm action-icon" title="قبول"
                                                            name="status" value="accepted"><i
                                                                class="fa-regular  fa-circle-check text-success"></i></button>
                                                        <button type="submit" class="btn p-0 btn-sm action-icon"
                                                            title="الغاء" name="status" value="cancelled"><i
                                                                class="fa-regular fa-circle-xmark text-danger"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            @elseif ($order->status == 'paid')
                                                <form action="{{ route('chat') }}" method="post">
                                                    @csrf
                                                    {{-- <input type="hidden" name="consultant_id"
                                                        value="{{ $order->seller->id }}"> --}}
                                                    <button type="submit" class="btn p-0 btn-sm action-icon"
                                                        title="محادثة مع المستشار">
                                                        <i class="fas fa-comments chat-icon"></i>

                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا يوجد طلبات</td>
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
