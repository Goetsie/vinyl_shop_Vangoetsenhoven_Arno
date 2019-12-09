@extends('layouts.template')

@section('title', 'Edit user')

@section('main')
    <h1>Edit user: {{ $user->name }}</h1>
    <form action="/admin/users/{{ $user->id }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Name"
                   minlength="2"
                   required
                   value="{{ old('name', $user->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email"
{{--                   minlength="3"--}}
                   required
                   value="{{ old('email', $user->email) }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <input type="checkbox" name="active" value="active" @if ($user['active']==1) checked @endif >Active
            <input type="checkbox" name="admin" value="admin" class="ml-4" @if ($user['admin']==1) checked @endif>Admin
        </div>

        <button type="submit" class="btn btn-success">Save user</button>
    </form>
@endsection
