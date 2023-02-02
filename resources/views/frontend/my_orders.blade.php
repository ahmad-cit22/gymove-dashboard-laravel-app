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
                            <li class="breadcrumb-item active" aria-current="page">My Orders</li>
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
                                <span class="text-muted smalls">{{ $city_name }},
                                    {{ $country_name }}</span>
                            </div>
                        </div>

                        <div class="dashboard_author">
                            <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">
                                Dashboard Navigation</h4>
                            <ul class="dahs_navbar">
                                <li><a href="{{ route('customer.orders') }}" class="active"><i
                                            class="lni lni-shopping-basket mr-2"></i>My Orders</a></li>
                                <li><a href="{{ route('cart.view') }}"><i class="lni lni-heart mr-2"></i>My Cart</a></li>
                                <li><a href="{{ route('wish.view') }}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                                <li><a href="{{ route('customer.profile.view') }}"><i class="lni lni-user mr-2"></i>Profile
                                        Info</a></li>
                                <li><a href="{{ route('customer.logout') }}"><i class="lni lni-power-switch mr-2"></i>Log
                                        Out</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                    @foreach ($orders as $order)
                        <!-- Single Order List -->
                        <div class="ord_list_wrap border mb-4">
                            <div class="row" style="align-items: center; justify-content: space-between">
                                <div class="col-lg-10">
                                    <div
                                        class="ord_list_head gray d-flex align-items-center justify-content-between px-3 py-3">
                                        <div class="olh_flex">
                                            <p class="m-0 p-0"><span class="text-muted">Order ID</span></p>
                                            <h6 class="mb-0 ft-medium">{{ $order->order_id }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-12 ml-auto">
                                    <p class="mb-1 p-0"><span class="text-muted">Order Status</span></p>
                                    <div class="delv_status"><span
                                            class="ft-medium small text-info bg-light-info rounded px-3 py-1">Confirmed</span>
                                    </div>
                                </div>
                            </div>
                            @php
                                $orderProducts = App\Models\OrderProduct::where('order_id', $order->order_id)->get();
                            @endphp
                            <div class="ord_list_body text-left">

                                @foreach ($orderProducts as $product)
                                    <!-- First Product -->
                                    <div class="row align-items-center justify-content-start m-0 py-4 br-bottom">
                                        <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                            <div class="cart_single d-flex align-items-start mfliud-bot">
                                                <div class="cart_selected_single_thumb">
                                                    <a href="#"><img
                                                            src="{{ asset('uploads/productPreview/' . $product->rel_to_product->preview) }}"
                                                            width="75" class="img-fluid rounded" alt=""></a>
                                                </div>
                                                <div class="cart_single_caption pl-3">
                                                    <p class="mb-0"><span class="text-muted small">
                                                            {{ $product->rel_to_product->rel_to_subcategory->subcategory_name }}</span>
                                                    </p>
                                                    <h4 class="product_title fs-sm ft-medium mb-1 lh-1">
                                                        {{ $product->rel_to_product->product_name }}
                                                    </h4>
                                                    <p class="mb-2"><span class="text-dark medium">Size:
                                                            {{ $product->rel_to_size->size_name }}</span>, <span
                                                            class="text-dark medium">Color:
                                                            {{ $product->rel_to_color->color_name }}</span></p>
                                                    <h4 class="fs-sm ft-bold mb-0 lh-1">BDT
                                                        {{ number_format(round($product->price), 2) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                            <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3">
                                <div
                                    class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                                    <div class="olf_flex_inner">
                                        <p class="m-0 p-0"><span class="text-muted medium text-left">Order Date:
                                                {{ $order->created_at->format('d-M-Y') }}</span></p>
                                    </div>
                                    <div class="olf_inner_right">
                                        <h5 class="mb-0 fs-sm ft-bold">Total: BDT
                                            {{ number_format(round($order->total), 2) }}</h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- End Order List -->
                    @endforeach
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
