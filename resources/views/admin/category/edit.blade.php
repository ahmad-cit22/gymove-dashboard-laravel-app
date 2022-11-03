@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Categories</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
        </ol>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.edit') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="text" hidden value="{{ $category->id }}" name="category_id">
                            <div class="mb-4">
                                <label class="form-label">Edit Category Name</label>
                                <input type="text" class="form-control text-black" name="category_name"
                                    placeholder="Category Name" value="{{ $category->category_name }}" />
                                @error('category_name')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Update Category Image</label>
                                <input type="file" class="form-control text-black" name="category_image" />
                                @error('category_image')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
