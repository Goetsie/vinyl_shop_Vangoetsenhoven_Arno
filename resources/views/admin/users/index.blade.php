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

                    {{--                    Dropdown list om te sorteren SWITCH CASE --}}
                    {{--                    <option value="%">All ....</option>--}}
                    {{--                    <option value="nameAZ" {{ (request()->sort == "nameAZ" ? 'selected' : '') }}>Name (A &#8594; Z)--}}
                    {{--                    </option>--}}
                    {{--                    <option value="nameZA" {{ (request()->sort == "nameZA" ? 'selected' : '') }}>Name (Z &#8594; A)--}}
                    {{--                    </option>--}}
                    {{--                    <option value="emailAZ" {{ (request()->sort == "emailAZ" ? 'selected' : '') }}>Email (A &#8594; Z)--}}
                    {{--                    </option>--}}
                    {{--                    <option value="emailZA" {{ (request()->sort == "emailZA" ? 'selected' : '') }}>Email (Z &#8594; A)--}}
                    {{--                    </option>--}}
                    {{--                    <option value="active" {{ (request()->sort == "active" ? 'selected' : '') }}>Not active</option>--}}
                    {{--                    <option value="admin" {{ (request()->sort == "admin" ? 'selected' : '') }}>Admin</option>--}}

                    {{--                    Dropdown list om te sorteren ARRAY --}}
                    @foreach($sortArray as $i => $order)
                        <option value="{{$i}}" {{request()->sort == $i ? 'selected' : ''}} >{{
                            $order['name'] }}
                        </option>
                    @endforeach
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
                        <form action="/admin/users/{{ $user->id }}" method="post" class="deleteFormUser">
                            @method('delete')
                            @csrf
                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit"
                                   class="btn btn-outline-success @if (auth()->user()->id == $user->id)disabled @endif"
                                   @if (auth()->user()->id != $user->id)data-toggle="tooltip"
                                   title="Edit {{ $user->name }}"
                                   @endif
                                   @if (auth()->user()->id == $user->id)onclick="return false;" @endif>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger"
                                        @if (auth()->user()->id != $user->id)
                                        data-toggle="tooltip"
                                        data-id="{{ $user->id }}"
                                        title="Delete {{ $user->name }}"
                                        @endif
                                        data-name="{{ $user->name }}"
                                        @if (auth()->user()->id == $user->id)disabled @endif>
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

            // ZONDER NOTY
            // $('.deleteFormUser button').click(function () {
            //     let name = $(this).data('name');
            //     let msg = `Delete the user ${name}?`;
            //     let hallo = `Delete the user again${name}?`;
            //     if (confirm(msg)) {
            //         console.log(this);
            //         if (confirm(hallo)) {
            //             $(this).closest('form').submit();
            //         }
            //     }
            // });

            $('.deleteFormUser button').click(function () {
                console.log('Delete knop 1 gedrukt');
                let name = $(this).data('name');
                let id = $(this).data('id');
                let form = $(this).closest('form'); // Safe the correct form name to use in the noty

                // Set some values for Noty
                let text = `<p>Delete the user <b>${name}</b>?</p>`;
                let type = 'warning';
                let btnText = 'Delete user';
                let btnClass = 'btn-success';

                // Show Noty
                let modal = new Noty({
                    timeout: false,
                    layout: 'center',
                    modal: true,
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {
                            // Delete the user and close the modal
                            console.log('delete knop 2 gedrukt');
                            $(form).submit();
                            modal.close();
                        }),
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });

        });
    </script>
@endsection
