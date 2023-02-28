@extends('frontend.master')

@section('content')
    <!-- ======================= Top Breadcrubms ======================== -->
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->

    <!-- ======================= Dashboard Detail ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row align-items-start justify-content-between">

                <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                    <div class="d-block border rounded mfliud-bot">
                        <div class="dashboard_author px-2 py-5">
                            <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                                <img src="{{ asset('uploads/customer/' . Auth::guard('customerAuth')->user()->profile_picture) }}"
                                    class="img-fluid circle" width="100" alt="" />
                            </div>
                            <div class="dash_caption">
                                <h4 class="fs-md ft-medium mb-0 lh-1"> {{ Auth::guard('customerAuth')->user()->name }}</h4>
                                <span class="text-muted smalls mt-3">
                                    @php
                                        if (Auth::guard('customerAuth')->user()->city) {
                                            echo Auth::guard('customerAuth')->user()->rel_to_city->name . ', ' . Auth::guard('customerAuth')->user()->rel_to_country->name;
                                        } else {
                                            echo 'Please update your profile informations.';
                                        }
                                    @endphp
                                </span>
                            </div>
                        </div>

                        <div class="dashboard_author">
                            <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">
                                Dashboard Navigation</h4>
                            <ul class="dahs_navbar">
                                <li><a href="{{ route('customer.orders') }}"><i class="lni lni-shopping-basket mr-2"></i>My
                                        Orders</a></li>
                                <li><a href="{{ route('cart.view') }}"><i class="lni lni-heart mr-2"></i>My Cart</a></li>
                                <li><a href="{{ route('wish.view') }}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                                <li><a href="{{ route('customer.profile.view') }}" class="active"><i
                                            class="lni lni-user mr-2"></i>Profile Info</a></li>
                                <li><a href="{{ route('customer.logout') }}"><i class="lni lni-power-switch mr-2"></i>Log
                                        Out</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-8 col-xl-8">
                    <!-- row -->
                    <div class="row align-items-center">
                        <form class="row m-0" action="{{ route('customer.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Full Name *</label>
                                    <input type="text" class="form-control" placeholder="Dhananjay" name="name"
                                        value="{{ Auth::guard('customerAuth')->user()->name }}" />
                                    @error('name')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Email ID *</label>
                                    <input type="email" class="form-control" placeholder="dhananjay7@gmail.com"
                                        name="email" value="{{ Auth::guard('customerAuth')->user()->email }}" />
                                    @error('email')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Current Password *</label>
                                    <input type="password" class="form-control" placeholder="Current Password"
                                        name="old_password" />
                                    @error('old_password')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror

                                    @if (session('errPass'))
                                        <strong class="text-danger"
                                            style="display: block">{{ session('errPass') }}</strong>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">New Password *</label>
                                    <input type="password" class="form-control" placeholder="New Password"
                                        name="password" />
                                    @error('password')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Confirm Password *</label>
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                        name="password_confirmation" />
                                    @error('password_confirmation')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="text-dark">Country *</label>
                                    <select class="custom-select country_id select2" name="country">
                                        <option value="">-- Select Country --</option>
                                        @foreach ($countries as $country)
                                            <option
                                                {{ Auth::guard('customerAuth')->user()->country == $country->id ? 'selected' : '' }}
                                                value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="text-dark">City / Town *</label>
                                    <select class="custom-select city_id select2" name="city">
                                        <option value="">-- Select City --</option>
                                        @foreach ($cities as $city)
                                            <option
                                                {{ Auth::guard('customerAuth')->user()->city == $city->id ? 'selected' : '' }}
                                                value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Address</label>
                                    <input type="text" class="form-control" placeholder="Address" name="address"
                                        value="{{ Auth::guard('customerAuth')->user()->address }}" />
                                    @error('address')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Zip Code</label>
                                    <input type="number" class="form-control" placeholder="Zip Code" name="zip_code"
                                        value="{{ Auth::guard('customerAuth')->user()->zip_code }}" />
                                    @error('zip_code')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Phone Code *</label>
                                    <select class="custom-select" name="phone_code">
                                        <option value="">-- Select City --</option>
                                        @foreach ($countries as $country)
                                            <option
                                                {{ Auth::guard('customerAuth')->user()->country == $country->id ? 'selected' : '' }}
                                                value="{{ $country->phonecode }}">({{ $country->name }})
                                                {{ $country->phonecode }}</option>
                                        @endforeach
                                    </select>
                                    @error('phone_number')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Phone Number *</label>
                                    <input type="number" class="form-control" placeholder="Phone Number"
                                        name="phone_number"
                                        value="{{ Auth::guard('customerAuth')->user()->phone_number }}" />
                                    @error('phone_number')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Profile Image</label>
                                    <input type="file" class="form-control" name="profile_picture" />
                                    @error('profile_picture')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-dark">Save Changes</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <!-- row -->
                </div>

            </div>
        </div>
    </section>
    <!-- ======================= Dashboard Detail End ======================== -->
@endsection

@section('footer_body')
    <script>
        $('.select2').select2();

        $('.country_id').change(function() {
            var country_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getCity',
                data: {
                    'country_id': country_id
                },
                success: function(data) {
                    $('.city_id').html(data);
                }
            })
        })
    </script>

    @if (session('updateSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('updateSuccess') }}",
                'success'
            )
        </script>
    @endif
@endsection
