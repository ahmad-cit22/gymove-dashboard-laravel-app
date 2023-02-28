@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('orders.view') }}">Orders</a></li>
        </ol>
    </div>
    <div class="row">

        <div class="col-lg-12">
            <div class="row" style="width: 100% !important">
                {{-- Order List --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Order List (On process)</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped text-center" id="order_list">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Receiver Name</th>
                                        <th>Receiver Email</th>
                                        <th>Receiver Mobile</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th>Payment Method</th>
                                        <th>Order Status</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        @php
                                            $bill = App\Models\BillingDetails::where('order_id', $order->order_id)->first();
                                            
                                            if ($order->order_status == 6) {
                                                continue;
                                            } elseif ($order->order_status == 7) {
                                                continue;
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->order_id }}</td>
                                            <td>{{ $order->rel_to_customer->name }}
                                            </td>
                                            <td>{{ $bill->name }}
                                            </td>
                                            <td>{{ $bill->email }}
                                            </td>
                                            <td>{{ $bill->mobile_number }}
                                            </td>
                                            <td>{{ $bill->address }}
                                            </td>
                                            <td>{{ $order->total }}
                                            </td>
                                            <td>{{ $order->payment_method }}
                                            </td>
                                            <td>
                                                @php
                                                    if ($order->order_status == 1) {
                                                        echo '<span class="badge badge-info">Placed</span>';
                                                    } elseif ($order->order_status == 2) {
                                                        echo '<span class="badge badge-success">Confirmed</span>';
                                                    } elseif ($order->order_status == 3) {
                                                        echo '<span class="badge badge-warning">Processing</span>';
                                                    } elseif ($order->order_status == 4) {
                                                        echo '<span class="badge badge-dark">Shipped</span>';
                                                    } elseif ($order->order_status == 5) {
                                                        echo '<span class="badge badge-success">Ready to
                                                                                                                    Deliver</span>';
                                                    } elseif ($order->order_status == 6) {
                                                        echo '<span class="badge badge-dark">Delivered</span>';
                                                    } else {
                                                        echo '<span class="badge badge-danger">Canceled</span>';
                                                    }
                                                @endphp
                                            </td>
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

                                                        <form action="{{ route('orderStatus.update', $order->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button
                                                                class="dropdown-item deleteBtn  {{ $order->order_status == 1 ? 'text-info' : '' }}"
                                                                id="" value=1 name="status"
                                                                {{ $order->order_status == 1 ? 'disabled' : '' }}>Placed</button>
                                                            <button
                                                                class="dropdown-item deleteBtn {{ $order->order_status == 2 ? 'text-info' : '' }}"
                                                                id="" value=2 name="status"
                                                                {{ $order->order_status == 2 ? 'disabled' : '' }}>Confirmed</button>
                                                            <button
                                                                class="dropdown-item deleteBtn {{ $order->order_status == 3 ? 'text-info' : '' }}"
                                                                id="" value=3 name="status"
                                                                {{ $order->order_status == 3 ? 'disabled' : '' }}>Processing</button>
                                                            <button
                                                                class="dropdown-item deleteBtn {{ $order->order_status == 4 ? 'text-info' : '' }}"
                                                                id="" value=4 name="status"
                                                                {{ $order->order_status == 4 ? 'disabled' : '' }}>Shipped</button>
                                                            <button
                                                                class="dropdown-item deleteBtn {{ $order->order_status == 5 ? 'text-info' : '' }}"
                                                                id="" value=5 name="status"
                                                                {{ $order->order_status == 5 ? 'disabled' : '' }}>Ready to
                                                                Deliver</button>
                                                            <button
                                                                class="dropdown-item deleteBtn {{ $order->order_status == 6 ? 'text-info' : '' }}"
                                                                id="" value=6 name="status"
                                                                {{ $order->order_status == 6 ? 'disabled' : '' }}>Delivered</button>
                                                            <button
                                                                class="dropdown-item deleteBtn {{ $order->order_status == 7 ? 'text-danger' : '' }}"
                                                                id="" value=7 name="status"
                                                                {{ $order->order_status == 7 ? 'disabled' : '' }}>Canceled</button>
                                                        </form>
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
                {{-- Order List --}}
            </div>
            <div class="row" style="width: 100% !important">
                <div class="card">
                    <div class="card-header">
                        <h3>Order List (Completed)</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped text-center" id="completed_orders">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Receiver Name</th>
                                    <th>Receiver Email</th>
                                    <th>Receiver Mobile</th>
                                    <th>Address</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Order Status</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completed_orders as $key => $order)
                                    @php
                                        $bill = App\Models\BillingDetails::where('order_id', $order->order_id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->rel_to_customer->name }}
                                        </td>
                                        <td>{{ $bill->name }}
                                        </td>
                                        <td>{{ $bill->email }}
                                        </td>
                                        <td>{{ $bill->mobile_number }}
                                        </td>
                                        <td>{{ $bill->address }}
                                        </td>
                                        <td>{{ $order->total }}
                                        </td>
                                        <td>{{ $order->payment_method }}
                                        </td>
                                        <td><span class="badge badge-dark">Delivered</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-primary light sharp"
                                                    data-toggle="dropdown">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
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

                                                    <form action="{{ route('orderStatus.update', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button
                                                            class="dropdown-item deleteBtn  {{ $order->order_status == 1 ? 'text-info' : '' }}"
                                                            id="" value=1 name="status"
                                                            {{ $order->order_status == 1 ? 'disabled' : '' }}>Placed</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 2 ? 'text-info' : '' }}"
                                                            id="" value=2 name="status"
                                                            {{ $order->order_status == 2 ? 'disabled' : '' }}>Confirmed</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 3 ? 'text-info' : '' }}"
                                                            id="" value=3 name="status"
                                                            {{ $order->order_status == 3 ? 'disabled' : '' }}>Processing</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 4 ? 'text-info' : '' }}"
                                                            id="" value=4 name="status"
                                                            {{ $order->order_status == 4 ? 'disabled' : '' }}>Shipped</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 5 ? 'text-info' : '' }}"
                                                            id="" value=5 name="status"
                                                            {{ $order->order_status == 5 ? 'disabled' : '' }}>Ready to
                                                            Deliver</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 6 ? 'text-info' : '' }}"
                                                            id="" value=6 name="status"
                                                            {{ $order->order_status == 6 ? 'disabled' : '' }}>Delivered</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 7 ? 'text-danger' : '' }}"
                                                            id="" value=7 name="status"
                                                            {{ $order->order_status == 7 ? 'disabled' : '' }}>Canceled</button>
                                                    </form>
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

            <div class="row" style="width: 100% !important">
                <div class="card">
                    <div class="card-header">
                        <h3>Order List (Canceled)</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped text-center" id="canceled_orders">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Receiver Name</th>
                                    <th>Receiver Email</th>
                                    <th>Receiver Mobile</th>
                                    <th>Address</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Order Status</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($canceled_orders as $key => $order)
                                    @php
                                        $bill = App\Models\BillingDetails::where('order_id', $order->order_id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->order_id }}</td>
                                        <td>{{ $order->rel_to_customer->name }}
                                        </td>
                                        <td>{{ $bill->name }}
                                        </td>
                                        <td>{{ $bill->email }}
                                        </td>
                                        <td>{{ $bill->mobile_number }}
                                        </td>
                                        <td>{{ $bill->address }}
                                        </td>
                                        <td>{{ $order->total }}
                                        </td>
                                        <td>{{ $order->payment_method }}
                                        </td>
                                        <td><span class="badge badge-danger">Canceled</span></td>
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

                                                    <form action="{{ route('orderStatus.update', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button
                                                            class="dropdown-item deleteBtn  {{ $order->order_status == 1 ? 'text-info' : '' }}"
                                                            id="" value=1 name="status"
                                                            {{ $order->order_status == 1 ? 'disabled' : '' }}>Placed</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 2 ? 'text-info' : '' }}"
                                                            id="" value=2 name="status"
                                                            {{ $order->order_status == 2 ? 'disabled' : '' }}>Confirmed</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 3 ? 'text-info' : '' }}"
                                                            id="" value=3 name="status"
                                                            {{ $order->order_status == 3 ? 'disabled' : '' }}>Processing</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 4 ? 'text-info' : '' }}"
                                                            id="" value=4 name="status"
                                                            {{ $order->order_status == 4 ? 'disabled' : '' }}>Shipped</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 5 ? 'text-info' : '' }}"
                                                            id="" value=5 name="status"
                                                            {{ $order->order_status == 5 ? 'disabled' : '' }}>Ready to
                                                            Deliver</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 6 ? 'text-info' : '' }}"
                                                            id="" value=6 name="status"
                                                            {{ $order->order_status == 6 ? 'disabled' : '' }}>Delivered</button>
                                                        <button
                                                            class="dropdown-item deleteBtn {{ $order->order_status == 7 ? 'text-danger' : '' }}"
                                                            id="" value=7 name="status"
                                                            {{ $order->order_status == 7 ? 'disabled' : '' }}>Canceled</button>
                                                    </form>
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
        </div>
    </div>
@endsection

@section('footer_body')
    <script>
        $(document).ready(function() {
            $('#order_list').DataTable();
        });

        $(document).ready(function() {
            $('#completed_orders').DataTable();
        });

        $(document).ready(function() {
            $('#canceled_orders').DataTable();
        });
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
