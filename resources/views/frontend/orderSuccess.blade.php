@extends('frontend.master')

@section('content')
    <!-- ======================= Top Breadcrubms ======================== -->
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Order</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Success</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->

    <!-- ======================= Product Detail ======================== -->
    <section class="middle">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                    <!-- Icon -->
                    <div
                        class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-success text-black mx-auto mb-4">
                        <i class="ti-face-smile fs-lg"></i></div>
                    <!-- Heading -->
                    <h2 class="mb-2 ft-bold">Your order has been placed successfully.</h2>
                    <!-- Text -->
                    <p class="ft-regular fs-md mb-5">PLease check your email for the billing details we have sent. We will inform you when your delivery is ready.</p>
                    <!-- Button -->
                    <a class="btn btn-dark" href="{{url('/')}}">Go To Home Page</a>
                </div>
            </div>

        </div>
    </section>
    <!-- ======================= Product Detail End ======================== -->
@endsection

@section('footer_body')
    @if (session('orderSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('orderSuccess') }}",
                'success'
            )
        </script>
    @endif

    {{--   @if ($message)
        <script>
            Swal.fire(
                'Sorry!',
                "{{ $message }}",
                'warning'
            )
        </script>
    @endif --}}
@endsection
