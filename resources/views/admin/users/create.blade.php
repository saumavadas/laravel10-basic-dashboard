@extends('layouts.master')
@section('content')

    <div class="card border-0 shadow-sm">
        <div class="card-header">
            Create User
        </div>
        <form action="{{ route("admin.users.store")}}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-2">
                    <label for="title">Name*</label>
                    <input type="text" id="title" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', isset($user) ? $user->name : '') }}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="title">Email*</label>
                    <input type="email" id="email" name="email" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('email', isset($email) ? $user->email : '') }}" required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="title">Phone*</label>
                    <input type="phone" id="phone_number" name="phone_number" class="form-control @error('name') is-invalid @enderror"
                            required>
                    @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                

                <div class="mb-2">
                    <label for="title">Role*</label>
                    <select class="form-select @error('name') is-invalid @enderror" name="role" id="role" required>
                        <option selected>Select role</option>
                    @foreach ($roles as $id => $role)
                        <option value="{{$id}}">{{ $role }}</option>
                    @endforeach    
                    </select>

                    @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror


                </div>

                <div class="mb-2">
                    <label for="title">Password*</label>
                    <input type="password" id="paasword" name="password" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('password', isset($password) ? $user->$password : '') }}" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary me-2" type="submit">Save</button>
                <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">
                    Back to list
                </a>
            </div>
        </form>
    </div>
@endsection

