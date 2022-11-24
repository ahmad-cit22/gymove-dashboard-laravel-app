@extends('layouts.dashboard');

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('product.add') }}">Products</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Add Product</h3>
                </div>
                <div class="card-body">
                    {{-- product adding form  --}}
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Category</label>
                                    <select class="form-control text-black" name="product_category" id="product_category">
                                        <option value=""> -- Select Category -- </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_category')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Sub-category</label>
                                    <select class="form-control text-black" name="product_subcategory"
                                        id="product_subcategory">
                                        <option value=""> -- Select Sub-category -- </option>
                                    </select>
                                    @error('product_subcategory')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control text-black" name="product_name" />
                                    @error('product_name')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Product Price</label>
                                    <input type="number" class="form-control text-black" name="price" />
                                    @error('price')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Product Discount</label>
                                    <input type="number" class="form-control text-black" name="discount" />
                                    @error('discount')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Product Brand</label>
                                    <input type="text" class="form-control text-black" name="brand" />
                                    @error('brand')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label class="form-label">Short Description</label>
                                    <input type="text" class="form-control text-black" name="short_description" />
                                    @error('short_description')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-4">
                                    <label class="form-label">Long Description</label>
                                    <textarea class="form-control text-black" id="long_description" name="long_description"></textarea>
                                    @error('long_description')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Product Preview</label>
                                    <input type="file" class="form-control" name="preview" />
                                    @error('preview')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Product Thumbnails</label>
                                    <input type="file" class="form-control" name="thumbnails" />
                                    @error('thumbnails')
                                        <strong class="text-danger" style="display: block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-primary" style="width: 30%; margin-left: 330px">Add
                                Product</button>
                        </div>
                    </form>
                    {{-- product adding form  --}}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_body')
    {{-- @if (session('addSuccess'))
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
    @if (session('forceDeleteSuccess'))
        <script>
            Swal.fire(
                'Done!',
                "{{ session('forceDeleteSuccess') }}",
                'success'
            )
        </script>
    @endif --}}
    <script>
        $('#product_category').change(function() {
            let categoryId = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/getSubcategory',
                type: 'POST',
                data: {
                    'category_id': categoryId,
                },
                success: function(data) {
                    $('#product_subcategory').html(data);
                }
            })

        })
    </script>

    <script>
     var editor1 = new RichTextEditor("#long_description");   
     // $(document).ready(function() {
        //     $('#long_description').summernote();
        // });
    </script>
@endsection
