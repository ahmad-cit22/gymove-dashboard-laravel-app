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
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Login</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->

    <!-- ======================= Login Detail ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row align-items-start justify-content-between">

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="mb-3">
                        <h3>Login</h3>
                        <p>If you are new here, please <span style="font-weight: bold">register</span> first.</p>
                    </div>
                    <form action="{{ route('customer.login') }}" method="POST" class="border p-3 rounded">
                        @csrf
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" class="form-control" placeholder="Email*" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" class="form-control" placeholder="Password*" name="password"
                                value="{{ old('password') }}">
                            @error('password')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="eltio_k2">
                                    <a href="#">Lost Your Password?</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                        </div>
                    </form>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
                    <div class="mb-3">
                        <h3>Register</h3>
                    </div>
                    <form action="{{ route('customer.signup') }}" method="POST" class="border p-3 rounded">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Full Name *</label>
                                <input type="text" class="form-control" placeholder="Full Name" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" class="form-control" placeholder="Email*" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Password *</label>
                                <input type="password" class="form-control" placeholder="Password*" name="password"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror

                            </div>

                            <div class="form-group col-md-6">
                                <label>Confirm Password *</label>
                                <input type="password" class="form-control" placeholder="Confirm Password*"
                                    name="password_confirmation" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create
                                An Account</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- ======================= Login End ======================== -->
@endsection

@section('footer_body')
    @if (session('regSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('regSuccess') }}",
                'success'
            )
        </script>
    @endif

    @if (session('customer_reg'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('customer_reg') }}",
                'warning'
            )
        </script>
    @endif

    @if (session('loginFailed'))
        <script>
            Swal.fire(
                'Sorry!',
                "{{ session('loginFailed') }}",
                'warning'
            )
        </script>
    @endif
@endsection
