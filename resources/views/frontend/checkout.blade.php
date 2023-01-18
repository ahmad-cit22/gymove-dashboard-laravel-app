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
                            <li class="breadcrumb-item"><a href="#">Support</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->


    <!-- ======================= Checkout Start ======================== -->
    <section class="middle">
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center d-block mb-5">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-md-12">
                    <form action="{{ route('customer.update') }}" method="POST">
                        <h5 class="mb-4 ft-medium">Billing Details</h5>
                        <div class="row mb-2">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Full Name *</label>
                                    <input type="text" class="form-control" placeholder="Full Name"
                                        value="{{ Auth::guard('customerAuth')->user()->name }}" name="name" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Email *</label>
                                    <input type="email" class="form-control" placeholder="Email"
                                        value="{{ Auth::guard('customerAuth')->user()->email }}" name="email" />
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Company</label>
                                    <input type="text" class="form-control" placeholder="Company Name (optional)" name="company" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Mobile Number *</label>
                                    <input type="text" class="form-control" placeholder="Mobile Number" name="number" />
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Address *</label>
                                    <input type="text" class="form-control" placeholder="Address" name="address" />
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Country *</label>
                                    <select class="custom-select" name="country">
                                        <option value="">-- Select Country --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">City / Town *</label>
                                     <select class="custom-select" name="city">
                                        <option value="">-- Select City --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">ZIP / Postcode *</label>
                                    <input type="text" class="form-control" placeholder="Zip / Postcode" name="zip" />
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Additional Information / Note</label>
                                    <textarea class="form-control ht-50" name="note"></textarea>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>

                <!-- Sidebar -->
                @php
                    $sub_total = 0;
                @endphp
                <div class="col-12 col-lg-4 col-md-12">
                    <div class="d-block mb-3">
                        <h5 class="mb-4">Order Items ({{ $cartItems->count() }})</h5>
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                            @foreach ($cartItems as $cartItem)
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <!-- Image -->
                                            <a href="{{ route('product.single', $cartItem->rel_to_product->slug) }}"><img
                                                    src="{{ asset('uploads/productPreview/' . $cartItem->rel_to_product->preview) }}"
                                                    alt="productPreview" class="img-fluid"></a>
                                        </div>
                                        <div class="col d-flex align-items-center justify-content-between">
                                            <div class="cart_single_caption pl-2">
                                                <a href="{{ route('product.single', $cartItem->rel_to_product->slug) }}">
                                                    <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                                        {{ $cartItem->rel_to_product->product_name }}</h4>
                                                </a>
                                                <p class="mb-1 lh-1"><span class="text-dark">Size:
                                                        {{ $cartItem->rel_to_size->size_name }}</span></p>
                                                <p class="mb-3 lh-1"><span class="text-dark">Color:
                                                        {{ $cartItem->rel_to_color->color_name }}</span></p>
                                                <h4 class="fs-md ft-medium mb-3 lh-1">TK
                                                    {{ $cartItem->rel_to_product->after_discount }} x
                                                    {{ $cartItem->quantity }}</h4>

                                            </div>
                                        </div>
                                    </div>
                                </li>

                                @php
                                    $sub_total += $cartItem->rel_to_product->after_discount * $cartItem->quantity;
                                @endphp
                            @endforeach
                        </ul>
                    </div>

                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Delivery Location</h6>
                            <ul class="no-ul-list">
                                <li>
                                    <input id="c1" class="radio-custom deliveryLocation" value="70"
                                        name="charge" type="radio">
                                    <label for="c1" class="radio-custom-label">Inside City</label>
                                </li>
                                <li>
                                    <input id="c2" class="radio-custom deliveryLocation" value="100"
                                        name="charge" type="radio">
                                    <label for="c2" class="radio-custom-label">Outside City</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Select Payment Method</h6>
                            <ul class="no-ul-list">
                                <li>
                                    <input id="c3" class="radio-custom" name="payment_method" type="radio" value="1">
                                    <label for="c3" class="radio-custom-label">Cash on Delivery</label>
                                </li>
                                <li>
                                    <input id="c4" class="radio-custom" name="payment_method" type="radio" value="2">
                                    <label for="c4" class="radio-custom-label">Pay With SSLCommerz</label>
                                </li>
                                <li>
                                    <input id="c5" class="radio-custom" name="payment_method" type="radio" value="3">
                                    <label for="c5" class="radio-custom-label">Pay With Stripe</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @php
                        $total = $sub_total - session('discount');
                    @endphp

                    <div class="card mb-4 gray">
                        <div class="card-body">
                            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">Tk
                                        {{ number_format(round($sub_total), 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Charge</span> <span class="ml-auto text-dark ft-medium" id="charge">TK
                                        0</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Discount</span> <span class="ml-auto text-dark ft-medium">TK
                                        {{ number_format(round(session('discount')), 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Total</span> <span class="ml-auto text-dark ft-medium" id="grandTotal">TK
                                        {{ number_format(round($total), 2) }}</span>
                                </li>
                            </ul>
                        </div>
                        {{-- <div>
                            <input value="{{session('sub_total')}}" id="sub_total"/>
                            <input value="{{session('discount')}}" id="discount"/>
                            <input value="{{session('total')}}" id="total"/>
                        </div> --}}
                    </div>


                    <a class="btn btn-block btn-dark mb-3" href="checkout.html">Place Your Order</a>
                </div>

            </div>

        </div>
    </section>
    <!-- ======================= Checkout End ======================== -->
@endsection

@section('footer_body')
    <script>
        $('.deliveryLocation').click(function() {
            let charge = $(this).val();
            $('#charge').html('TK ' + charge + '.00');

            const formatter = new Intl.NumberFormat('en-IN');

            let grandTotal = formatter.format({{ round($total) }} + parseInt(charge));
            $('#grandTotal').html('TK ' + grandTotal + '.00');

        })
    </script>
    {{-- @if ($couponSuccess)
        <script>
            Swal.fire(
                'Done!',
                "{{ $couponSuccess }}<br>You got <strong class='text-success'>TK {{ number_format($discount) }}</strong> discount.",
                'success'
            )
        </script>
    @endif

    @if ($message)
        <script>
            Swal.fire(
                'Sorry!',
                "{{ $message }}",
                'warning'
            )
        </script>
    @endif --}}
@endsection
