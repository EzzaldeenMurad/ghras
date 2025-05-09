@extends('layouts.master-with-header')

@section('title', 'الإستشارات')

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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">الإستشارات</h5>

                    </div>
                    {{-- @if (isset($consultations) && $consultations->count() > 0) --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>المستشار</th>
                                    <th>تاريخ</th>
                                    <th>الموضوع</th>
                                    <th>التفاصيل</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($consultations as $consultation)
                                    <tr>
                                        <td>
                                            <div class="consultant-profile">
                                                {{-- <img src="{{ $consultation->consultant->image ? asset($consultation->consultant->image) : asset('assets/images/avatar_user.jpg') }}"
                                                     alt="{{ $consultation->consultant->name }}" class="consultant-avatar"> --}}
                                                <span
                                                    class="consultant-name">{{ $consultation->consultation->consultant->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $consultation->created_at->format('d M Y') }}</td>
                                        <td class="consultation-subject">{{ $consultation->subject }}</td>
                                        <td class="consultation-details">{{ $consultation->description }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $consultation->getStatusColorAttribute() }} ">{{ $consultation->getStatusNameAttribute() }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <div class="d-flex gap-2 justify-content-end">
                                                    @if ($consultation->status == 'pending')
                                                        <input type="hidden" name="order_id" value="">

                                                        <a href="{{ route('seller.orders.cancelled', $consultation->id) }}"
                                                            class="btn p-0 btn-sm action-icon" title="الغاء"
                                                            value="cancelled"><i
                                                                class="fa-regular fa-circle-xmark text-danger"></i>
                                                        @elseif($consultation->status == 'accepted')
                                                            <a href="{{ route('payment.index', $consultation->id) }}"
                                                                class="btn p-0 btn-sm action-icon" title="pay"><i
                                                                    class="fa-brands fa-paypal"></i></a>
                                                        @elseif ($consultation->status == 'paid')
                                                            <form action="{{ route('chat') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="consultant_id"
                                                                    value="{{ $consultation->consultation->consultant->id }}">
                                                                <button type="submit" class="btn p-0 btn-sm action-icon"
                                                                    title="محادثة مع المستشار">
                                                                    <i class="fas fa-comments chat-icon"></i>

                                                                </button>
                                                            </form>
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا يوجد استشارات</td>
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
