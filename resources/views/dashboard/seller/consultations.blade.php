@extends('layouts.master-with-header')

@section('title', 'الإستشارات')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashbord.css') }}">
    {{-- <style>
        .consultant-profile {
            display: flex;
            align-items: center;
        }

        .consultant-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 10px;
        }

        .consultant-name {
            font-weight: 600;
        }

        .pending {
            color: #f39c12;
            font-weight: bold;
        }

        .paid {
            color: #27ae60;
            font-weight: bold;
        }

        .cancelled {
            color: #e74c3c;
            font-weight: bold;
        }

        .completed {
            color: #2980b9;
            font-weight: bold;
        }

        .action-icon {
            cursor: pointer;
            transition: transform 0.2s;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .action-icon:hover {
            transform: scale(1.1);
            background-color: rgba(0,0,0,0.05);
        }

        .chat-icon {
            color: #3498db;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #bdc3c7;
        }

        .consultation-subject {
            font-weight: 500;
            color: #2c3e50;
        }

        .consultation-details {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .add-consultation-btn {
            background-color: #27ae60;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }

        .add-consultation-btn:hover {
            background-color: #2ecc71;
            color: white;
        }
    </style> --}}
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
