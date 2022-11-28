@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('product.variation') }}">Product Variation</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-8">
            {{-- color list table --}}
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3>Color List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Color Name</th>
                                <th>Color</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($colors as $sl => $color)
                                <tr>
                                    <td>{{ $sl + 1 }}</td>
                                    <td>{{ $color->color_name }}</td>
                                    <td>
                                        <span
                                            style="color: {{ $color->color_code }}; background: {{ $color->color_code }}">Preview</span>
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
                                                <a class="dropdown-item" href="">Edit</a>
                                                <a class="dropdown-item" href="">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            {{-- color list table --}}

            {{-- size list table --}}
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3>Size List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Size Name</th>
                                <th>Action</th>
                            </tr>
                            {{-- @foreach ($sizes as $sl => $size)
                            <tr>
                                <td>{{ $sl + 1 }}</td>
                                <td>{{ $size->size_name }}</td>
                                <td>
                                    <a href="" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach --}}
                        </table>
                    </div>
                </div>
            </div>
            {{-- size list table --}}
        </div>

        <div class="col-lg-4">
            {{-- add color form --}}
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Color</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('color.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Color Name</label>
                                <input type="text" class="form-control text-black" name="color_name"
                                    value="{{ old('color_name') }}" placeholder="Color Name" />
                                @error('color_name')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Color Code</label>
                                <input type="text" class="form-control text-black" name="color_code"
                                    value="{{ old('color_code') }}" placeholder="Color Code" />
                                @error('color_code')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Color</button>
                        </form>

                    </div>
                </div>
            </div>
            {{-- add color form --}}

            {{-- add size form --}}
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Size</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('size.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Size Name</label>
                                <input type="text" class="form-control text-black" name="size_name"
                                    placeholder="Size Name" />
                                @error('size_name')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Size</button>
                        </form>

                    </div>
                </div>
            </div>
            {{-- Add Sizes form  --}}
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

    @if (session('addSuccessSize'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('addSuccessSize') }}",
                'success'
            )
        </script>
    @endif
    {{--   @if (session('delSuccess'))
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
    @endif --}}
@endsection
