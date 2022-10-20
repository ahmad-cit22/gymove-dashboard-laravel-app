@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Categories</a></li>
        </ol>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8"></div>
            <div class="col-lg-4 border-left border-top border-primary rounded-left" style="height: 100vh">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category_name" />
                                @error('category_name')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Category Image</label>
                                <input type="file" class="form-control" name="category_image" />
                                @error('category_image')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
