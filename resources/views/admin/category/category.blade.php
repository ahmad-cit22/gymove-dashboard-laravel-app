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
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h2>Category List</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <tr>
                                <th>SL</th>
                                <th>Category Image</th>
                                <th class="text-left">Category Name</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset('uploads/category/' . $category->category_image) }}"
                                            alt="" width="60"></td>
                                    <td class="text-left">{{ $category->category_name }}</td>
                                    <td>{{ $category->rel_to_user->name }}</td>
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
                                                <a class="dropdown-item" href="#">Edit</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('category.delete', $category->id) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <h2 style="margin-top: 100px">Trashed Category List</h2>
                        <table class="table table-striped text-center">
                            <tr>
                                <th>SL</th>
                                <th>Category Image</th>
                                <th class="text-left">Category Name</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($trashed_categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset('uploads/category/' . $category->category_image) }}"
                                            alt="" width="60"></td>
                                    <td class="text-left">{{ $category->category_name }}</td>
                                    <td>{{ $category->rel_to_user->name }}</td>
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
                                                    href="{{ route('category.restore', $category->id) }}">Restore</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('category.delete', $category->id) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 border border-primary rounded">
                <div class="card">
                    <div class="card-header">
                        <h3>Add Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control text-black" name="category_name" />
                                @error('category_name')
                                    <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Category Image</label>
                                <input type="file" class="form-control text-black" name="category_image" />
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
@endsection
