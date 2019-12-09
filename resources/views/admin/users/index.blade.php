@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    @include('shared.alert')

    <form method="get" action="/admin/users" id="searchFormUsers">
        <div class="row">
            <div class="col-sm-8 mb-8">
                <label for="nameSearch">Filter Name or Email</label>
                <input type="text" class="form-control" name="nameSearch" id="nameSearch"
                       value="{{ request()->nameSearch }}" placeholder="Filter Name Or Email">
            </div>
            <div class="col-sm-4 mb-4">
                <label for="sort">Sort by</label>
                <select class="form-control" name="sort" id="sort">
                    {{--                    <option value="%">All ....</option>--}}
                    <option value="nameAZ" {{ (request()->sort == "nameAZ" ? 'selected' : '') }}>Name (A &#8594; Z)</option>
                    <option value="nameZA" {{ (request()->sort == "nameZA" ? 'selected' : '') }}>Name (Z &#8594; A)</option>
                    <option value="emailAZ" {{ (request()->sort == "emailAZ" ? 'selected' : '') }}>Email (A &#8594; Z)</option>
                    <option value="emailZA" {{ (request()->sort == "emailZA" ? 'selected' : '') }}>Email (Z &#8594; A)</option>
                    <option value="active" {{ (request()->sort == "active" ? 'selected' : '') }}>Not active</option>
                    <option value="admin" {{ (request()->sort == "admin" ? 'selected' : '') }}>Admin</option>
                    {{--                    @foreach($genres as $genre)--}}
                    {{--                        --}}{{--                        <option value="{{ $genre->id }}">{{ ucfirst($genre->name) }} ({{ $genre->records_count }})</option>--}}
                    {{--                        <option value="{{ $genre->id }}" {{ (request()->genre_id == $genre->id ? 'selected' : '') }}>{{--}}
                    {{--                            $genre->name }}--}}
                    {{--                        </option>--}}
                    {{--                    @endforeach--}}
                </select>

            </div>
        </div>

    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    @if ( $user['active'] == 1)
                        <td><i class="fas fa-check"></i></td>
                    @else
                        <td></td>
                    @endif
                    @if ( $user['admin'] == 1)
                        <td><i class="fas fa-check"></i></td>
                    @else
                        <td></td>
                    @endif
                    <td>
                        <form action="/admin/users/{{ $user->id }}" method="post" class="deleteForm">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-outline-success"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger"
                                        data-toggle="tooltip"
                                        data-name="{{ $user->name }}"
                                        title="Delete {{ $user->name }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
@endsection
@section('script_after')
    <script>
        $(function () {

            // submit form when leaving text field 'name'
            $('#nameSearch').blur(function () {
                $('#searchFormUsers').submit();
            });
            // submit form when changing dropdown list 'genre_id'
            $('#sort').change(function () {
                $('#searchFormUsers').submit();
            });

            $('.deleteForm button').click(function () {
                let name = $(this).data('name');
                let msg = `Delete the user ${name}?`;
                if (confirm(msg)) {
                    $(this).closest('form').submit();
                }
            })
        });
    </script>
@endsection
