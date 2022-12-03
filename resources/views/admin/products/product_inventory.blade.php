@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.list') }}">Products</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('product.list') }}">Inventory</a></li>
        </ol>
    </div>
    <div class="row">

        <div class="col-lg-8">
            <div class="row" style="width: 100% !important">
                {{-- Inventory Table --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Inventory for -- <span class="text-primary"> {{ $product->product_name }}</span></h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Quantity</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventories as $key => $inventory)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $inventory->quantity }}</td>
                                            <td>{{ $inventory->rel_to_color->color_name }}</td>
                                            <td>{{ $inventory->rel_to_size->size_name }}</td>
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
                                                        <a class="dropdown-item"
                                                            href="">Edit</a>
                                                        <a class="dropdown-item"
                                                            href="">Delete</a>
                                                        {{-- <a class="dropdown-item"
                                                            href="{{ route('', $inventory->id) }}">Edit</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('', $inventory->id) }}">Delete</a> --}}
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
                {{-- Inventory Table --}}
            </div>
        </div>

        <div class="col-lg-4 border border-primary rounded">
            <div class="card">
                <div class="card-header">
                    <h3>Add Inventory</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.store', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Product Name</label>
                            <input type="text" readonly class="form-control text-black"
                                value="{{ $product->product_name }}" />
                        </div>

                        <div class="mb-3">
                            <select class="form-control" name="color">
                                <option value="">-- Select Color --</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                            @error('color')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <select class="form-control" name="size">
                                <option value="">-- Select Size --</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                            @error('size')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="number" class="form-control" name="quantity" />
                            @error('quantity')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Inventory</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_body')
    @if (session('addSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('addSuccess') }}",
                'success'
            )
        </script>
    @endif

    @if (session('InventoryAddSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('InventoryAddSuccess') }}",
                'success'
            )
        </script>
    @endif

    @if (session('delSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('delSuccess') }}",
                'success'
            )
        </script>
    @endif
    @if (session('restoreSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('restoreSuccess') }}",
                'success'
            )
        </script>
    @endif
    @if (session('forceDeleteSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('forceDeleteSuccess') }}",
                'success'
            )
        </script>
    @endif
@endsection
