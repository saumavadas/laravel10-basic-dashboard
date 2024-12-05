@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Customers List</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm">View</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No Stuff Users Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection