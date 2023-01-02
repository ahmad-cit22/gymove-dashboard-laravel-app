@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('product.list') }}">Coupons</a></li>
        </ol>
    </div>
    <div class="row">

        <div class="col-lg-9">
            <div class="row" style="width: 100% !important">
                {{-- Coupon List --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped text-center" id="coupon_list">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Coupon Code</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Discount Limit</th>
                                        <th>Validity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $coupon)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $coupon->coupon_code }}</td>
                                            <td>{{ $coupon->type == 1 ? 'Percentage' : 'Solid' }}</td>
                                            <td>{{ $coupon->amount }}</td>
                                            <td>{{ $coupon->limit ? $coupon->limit : 'N/A' }}</td>
                                            <td>{{ $coupon->validity }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-primary light sharp"
                                                        data-toggle="dropdown">
                                                        <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                            version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <circle fill="#000000" cx="5" cy="12"
                                                                    r="2" />
                                                                <circle fill="#000000" cx="12" cy="12"
                                                                    r="2" />
                                                                <circle fill="#000000" cx="19" cy="12"
                                                                    r="2" />
                                                            </g>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="">Edit</a>
                                                        <a class="dropdown-item" href="">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Coupon List --}}
            </div>
        </div>

        <div class="col-lg-3 border border-primary rounded">
            <div class="card">
                <div class="card-header">
                    <h3>Add New Coupon</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('coupon.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Coupon Code</label>
                            <input type="text" class="form-control text-black" value="{{ old('coupon_code') }}"
                                name="coupon_code" />
                            @error('coupon_code')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <select class="form-control text-black" name="type">
                                <option value="">Select Discount Type</option>
                                <option value="1">Percentage</option>
                                <option value="2">Solid</option>
                            </select>
                            @error('type')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Discount Amount</label>
                            <input type="number" class="form-control text-black" value="{{ old('amount') }}"
                                name="amount" />
                            @error('amount')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Discount Limit</label>
                            <input type="number" class="form-control text-black" value="{{ old('limit') }}"
                                name="limit" />
                            @error('limit')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="date" class="form-control text-black" name="validity"
                                value="{{ old('validity') }}" />
                            @error('validity')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add
                            Coupon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_body')
    <script>
        $(document).ready(function() {
            $('#coupon_list').DataTable();
        });
    </script>

    @if (session('addSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('addSuccess') }}",
                'success'
            )
        </script>
    @endif
@endsection
