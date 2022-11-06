@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories') }}">Categories</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subCategories') }}">Sub-categories</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
        </ol>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-7 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Sub-category</h3>
                    </div>
                    <div class="card-body">
                        {{-- <form action="{{ route('category.edit') }}" method="POST" enctype="multipart/form-data">
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
                            <input type="file" class="form-control text-black" name="category_image"
                                id="category_image" />
                            <img id="display_image" src="{{ asset('uploads/category/' . $category->category_image) }}"
                                alt="category_image" width="80" />
                            @error('category_image')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        </form> --}}
                            <form action="{{ route('subCategory.update', $subCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <select name="category_name" id="" class="form-control">
                                <option value=""> --Select Category-- </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"> {{ $category->category_name }} </option>
                                @endforeach
                            </select>
                            @error('category_name')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Sub-category Name</label>
                            <input type="text" class="form-control text-black" name="subcategory_name"
                                placeholder="Sub-category Name" />
                            @error('subcategory_name')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Sub-category Image</label>
                            <input type="file" class="form-control text-black" name="subcategory_image" />
                            @error('subcategory_image')
                                <strong class="text-danger" style="display: block">{{ $message }}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Sub-category</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_body')
    {{-- <script>
        category_image.onchange = evt => {
            const [file] = category_image.files
            if (file) {
                display_image.src = URL.createObjectURL(file)
            }
        }
    </script>

    @if (session('updateSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('updateSuccess') }}",
                'success'
            )
        </script>
    @endif --}}
@endsection
