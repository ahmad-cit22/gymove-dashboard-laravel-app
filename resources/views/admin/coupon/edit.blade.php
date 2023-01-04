@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('coupon.view') }}">Coupons</a></li>
            <li class="breadcrumb-item active"><a href="#">Edit</a></li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Coupon</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('coupon.update', $coupon->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Coupon Code</label>
                                <input type="text" class="form-control text-black" value="{{ $coupon->coupon_code }}"
                                    name="coupon_code" />
                                @error('coupon_code')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select class="form-control text-black" name="type">
                                    <option value="">Select Discount Type</option>
                                    <option value="1" {{ $coupon->type === 1 ? 'selected' : '' }}> Percentage
                                    </option>
                                    <option value="2" {{ $coupon->type === 2 ? 'selected' : '' }}>Solid</option>
                                </select>
                                @error('type')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Discount Amount</label>
                                <input type="number" class="form-control text-black" value="{{ $coupon->amount }}"
                                    name="amount" />
                                @error('amount')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Discount Limit</label>
                                <input type="number" class="form-control text-black" value="{{ $coupon->limit }}"
                                    name="limit" />
                                @error('limit')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <input type="date" class="form-control text-black" name="validity"
                                    value="{{ $coupon->validity }}" />
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
    </div>
@endsection

@section('footer_body')
    
    @if (session('updateErr'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('updateErr') }}",
                'warning'
            )
        </script>
    @endif
@endsection
