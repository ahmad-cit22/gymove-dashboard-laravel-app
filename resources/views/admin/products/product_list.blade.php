@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('product.list') }}">Products</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Product List</h3>
                </div>
                <div class="card-body">
                    {{-- product list table  --}}
                    <table id="product_list" class="table table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Sub-Category</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>After Discount</th>
                                <th>Brand</th>
                                <th>Preview</th>
                                <th>Thumbnails</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->rel_to_subcategory->subcategory_name }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>{{ $product->after_discount }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>
                                        <img src="{{ asset('uploads/productPreview/' . $product->preview) }}"
                                            alt="preview_img" width="70">
                                    </td>
                                    <td class="d-flex" style="align-items: center; height: 100px;">
                                        @foreach (App\Models\Thumbnail::where('product_id', $product->id)->get() as $thumb)
                                            <img class="ml-1"
                                                src="{{ asset('uploads/thumbnails/' . $thumb->thumbnail) }}"
                                                alt="thumbnail" width="40">
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary light sharp"
                                                data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
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
                                                    href="{{ route('product.inventory', $product->id) }}">Inventory</a>
                                                <a class="dropdown-item" href="">Edit</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('product.delete', $product->id) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- product list table  --}}

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Trashed Product List</h3>
                </div>
                <div class="card-body">

                    {{-- Trashed product list table  --}}
                    <table id="trashed_product_list" class="table table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Sub-Category</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>After Discount</th>
                                <th>Brand</th>
                                <th>Preview</th>
                                <th>Thumbnails</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trashed_products as $key => $product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $product->rel_to_subcategory->subcategory_name }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>{{ $product->after_discount }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>
                                        <img src="{{ asset('uploads/productPreview/' . $product->preview) }}"
                                            alt="preview_img" width="70">
                                    </td>
                                    <td class="d-flex">
                                        @foreach (App\Models\Thumbnail::where('product_id', $product->id)->get() as $thumb)
                                            <img class="ml-1"
                                                src="{{ asset('uploads/thumbnails/' . $thumb->thumbnail) }}"
                                                alt="thumbnail" width="40">
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary light sharp"
                                                data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
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
                                                    href="{{ route('product.restore', $product->id) }}">Restore</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('product.delete.force', $product->id) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Trashed product list table  --}}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_body')
    <script>
        $(document).ready(function() {
            $('#product_list').DataTable();
        });

        $(document).ready(function() {
            $('#trashed_product_list').DataTable();
        });
    </script>

    @if (session('delSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('delSuccess') }}",
                'success'
            )
        </script>
    @endif

    @if (session('fDelSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('fDelSuccess') }}",
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
@endsection
