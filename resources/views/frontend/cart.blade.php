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
                            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center d-block mb-5">
                        <h2>Shopping Cart</h2>
                    </div>
                </div>
            </div>
            @php
                $sub_total = 0;
            @endphp
            <div class="row justify-content-between">
                @if ($cartItems->count() > 0)
                    <div class="col-12 col-lg-7 col-md-12">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
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
                                                    <a
                                                        href="{{ route('product.single', $cartItem->rel_to_product->slug) }}">
                                                        <h4 class="product_title fs-md ft-medium mb-1 lh-1">
                                                            {{ $cartItem->rel_to_product->product_name }}</h4>
                                                    </a>
                                                    <p class="mb-1 lh-1"><span class="text-dark">Size:
                                                            {{ $cartItem->rel_to_size->size_name }}</span></p>
                                                    <p class="mb-3 lh-1"><span class="text-dark">Color:
                                                            {{ $cartItem->rel_to_color->color_name }}</span></p>
                                                    <h4 class="fs-md ft-medium mb-3 lh-1">TK
                                                        {{ $cartItem->rel_to_product->after_discount }}</h4>
                                                    @php
                                                        $stock = App\Models\Inventory::where('product_id', $cartItem->product_id)
                                                            ->where('color_id', $cartItem->color_id)
                                                            ->where('size_id', $cartItem->size_id)
                                                            ->first()->quantity;
                                                    @endphp
                                                    <select class="mb-2 custom-select w-auto"
                                                        name="quantity[{{ $cartItem->id }}]">
                                                        @for ($i = 1; $i <= $stock; $i++)
                                                            <option {{ $cartItem->quantity == $i ? 'selected' : '' }}
                                                                value="{{ $i }}">
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="fls_last"><a href="{{ route('cart.remove', $cartItem->id) }}"
                                                        class="close_slide gray"><i class="ti-close"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    @php
                                        $sub_total += $cartItem->rel_to_product->after_discount * $cartItem->quantity;
                                    @endphp
                                @endforeach
                            </ul>
                            <div class="col-12 col-md-auto mfliud" style="display: flex; justify-content: end">
                                <button class="btn stretched-link borders">Update Cart</button>
                            </div>
                        </form>

                        <div class="mt-3 row align-items-end justify-content-between mb-10 mb-md-0">
                            <div class="col-12">
                                <!-- Coupon -->
                                <form class="mb-7 mb-md-0" action="{{ route('cart.view') }}" method="GET">
                                    <label class="fs-sm ft-medium text-dark">Coupon code:</label>
                                    <div class="row form-row display-flex justify-content-between">
                                        <div class="col">
                                            <input class="form-control" type="text" placeholder="Enter coupon code*"
                                                name="coupon_code">
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-dark" type="submit">Apply</button>
                                        </div>
                                    </div>
                                    @if ($message)
                                        <p class="mt-3 alert alert-warning">Sorry! {{ $message }}</p>
                                    @endif
                                </form>
                                <!-- Coupon -->

                            </div>

                        </div>
                    </div>
                @else
                    <p class="mx-auto text-danger">Your cart is currently empty!</p>
                @endif

                @php
                    $discount = 0;
                    if ($type === 1) {
                        if ($limit >= ($sub_total * $amount) / 100) {
                            $discount = ($sub_total * $amount) / 100;
                        } else {
                            $discount = $limit;
                        }
                    } else {
                        $discount = $amount;
                    }
                    $total = $sub_total - $discount;
                    
                    session([
                        'sub_total' => $sub_total,
                        'discount' => $discount,
                        'total' => $total,
                    ]);
                @endphp

                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card mb-4 gray mfliud">
                        <div class="card-body">
                            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">Tk
                                        {{ number_format($sub_total, 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Discount</span> <span class="ml-auto text-dark ft-medium">TK
                                        {{ number_format($discount, 2) }}</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Total</span> <span class="ml-auto text-dark ft-medium">TK
                                        {{ number_format(round($total), 2) }}</span>
                                </li>
                                <li class="list-group-item fs-sm text-center">
                                    Shipping cost calculated at Checkout *
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a class="btn btn-block btn-dark mb-3" href="{{ route('checkout.view') }}">Proceed to Checkout</a>

                    <a class="btn-link text-dark ft-medium" href="{{ url('/') }}">
                        <i class="ti-back-left mr-2"></i> Continue Shopping
                    </a>
                </div>

            </div>
        </div>
    </section>
    <!-- ======================= Product Detail End ======================== -->
@endsection

@section('footer_body')
    @if (session('updateSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('updateSuccess') }}",
                'success'
            )
        </script>
    @endif

    @if ($couponSuccess)
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
    @endif
@endsection
