@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col m-auto">
            <h1 class="ml-2 mb-4" style="color: rgb(37, 1, 120)">User List</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-center">Profile Picture</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>

                            <td class="text-center">
                                @if ($user->image == null)
                                    <img src="{{ Avatar::create($user->name)->toBase64() }}" width="55" height=55" />
                                @else
                                    <img src="{{ asset('uploads/user/' . $user->image) }}" width="55" height=55" />
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td><button value="{{ route('user.delete', $user->id) }}"
                                    class="btn btn-danger userDel">Delete</button></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footerBody')
    <script>
        $('.userDel').click(function() {
            let link = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            })
        })
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
@endsection
