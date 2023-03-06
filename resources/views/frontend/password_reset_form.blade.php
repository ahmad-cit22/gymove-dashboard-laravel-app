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
                            <li class="breadcrumb-item active"><a href="#">Passwor Reset</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->

    <!-- ======================= Reset Form ======================== -->
    <section class="middle">
        <div class="container">
            <div class="card col-md-8 mx-auto">
                <div class="card-header text-center">
                    <h3>
                        Reset your password
                    </h3>
                    <h5>Enter your registered email to get link to reset your password.</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.password.reset.handle', $resetToken) }}" method="POST"
                        class="border p-3 rounded">
                        @csrf
                        <div class="form-group col-md-12">
                            <label>New Password *</label>
                            <input type="password" class="form-control" placeholder="Password*" name="password"
                                value="{{ old('password') }}">
                            @error('password')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror

                        </div>

                        <div class="form-group col-md-12">
                            <label>Confirm Password *</label>
                            <input type="password" class="form-control" placeholder="Confirm Password*"
                                name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset
                                Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ======================= Login End ======================== -->
@endsection

@section('footer_body')
    {{-- @if (session('success'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('success') }}",
                'success'
            )
        </script>
    @endif

    --}}
@endsection
