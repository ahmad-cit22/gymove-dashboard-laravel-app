@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories') }}">Categories</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('subCategories') }}">Sub-categories</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row">

                {{-- Sub-category List --}}
                <div class="card">
                    <div class="card-header">
                        <h2>Sub-category List</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <tr>
                                <th>SL</th>
                                <th>Sub-category Image</th>
                                <th>Sub-category Name</th>
                                <th>Category Name</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($subCategories as $key => $subCategory)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset('uploads/subCategory/' . $subCategory->subcategory_image) }}"
                                            alt="subcategory_image" width="60"></td>
                                    <td>{{ $subCategory->subcategory_name }}</td>
                                    <td>{{ $subCategory->rel_to_category->category_name }}</td>
                                    <td>{{ $subCategory->rel_to_user->name }}</td>
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
                                                <a class="dropdown-item" href="{{ route('subCategory.edit', $subCategory->id) }}">Edit</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('subCategory.delete', $subCategory->id) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                {{-- Sub-category List --}}


                {{-- Trashed Sub-category List --}}
                <div class="card">
                    <div class="card-header">
                        <h2>Trashed Sub-category List</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <tr>
                                <th>SL</th>
                                <th>Sub-category Image</th>
                                <th>Sub-category Name</th>
                                <th>Category Name</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($trashedSubCategories as $key => $trashedSubCategory)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset('uploads/subCategory/' . $trashedSubCategory->subcategory_image) }}"
                                            alt="subcategory_image" width="60"></td>
                                    <td>{{ $trashedSubCategory->subcategory_name }}</td>
                                    <td>{{ $trashedSubCategory->rel_to_category->category_name }}</td>
                                    <td>{{ $trashedSubCategory->rel_to_user->name }}</td>
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
                                                    href="{{ route('subCategory.restore', $trashedSubCategory->id) }}">Restore</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('subCategory.delete.force', $trashedSubCategory->id) }}">
                                                    Delete Permanently</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                {{-- Trashed Sub-category List --}}

            </div>
        </div>
        <div class="col-lg-4 border border-primary rounded">
            <div class="card">
                <div class="card-header">
                    <h3>Add Sub-category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('subCategory.store') }}" method="POST" enctype="multipart/form-data">
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

    @if (session('forceDelSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('forceDelSuccess') }}",
                'success'
            )
        </script>
    @endif
@endsection
