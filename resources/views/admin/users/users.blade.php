@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col m-auto">
                <h1 class="ml-2 mb-4" style="color: rgb(37, 1, 120)">User List</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td><button class="btn btn-danger">Delete</button></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
