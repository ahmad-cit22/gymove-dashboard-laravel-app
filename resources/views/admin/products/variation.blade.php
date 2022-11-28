@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('product.variation') }}">Product Variation</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Add Color</h3>
                </div>
                <div class="card-body">
                    {{-- Add Colors form  --}}
                    <form action="{{ route('color.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Color Name</label>
                            <input type="text" class="form-control text-black" name="color_name" value="{{ old('color_name') }}" 
                                placeholder="Color Name" />
                            @error('color_name')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Color Code</label>
                            <input type="text" class="form-control text-black" name="color_code" value="{{ old('color_code') }}" 
                                placeholder="Color Code" />
                            @error('color_code')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Color</button>
                    </form>
                    {{-- Add Colors form  --}}

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Add Size</h3>
                </div>
                <div class="card-body">
                    {{-- Add Sizes form  --}}
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
                    {{-- Add Sizes form  --}}

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
