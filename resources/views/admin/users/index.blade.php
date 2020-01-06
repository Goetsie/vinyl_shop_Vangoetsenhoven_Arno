@extends('layouts.template')

@section('title', 'Users (advanced)')

@section('main')

    <h1>Users (advanced)</h1>

    {{--    Nier meer nodig door gebruik van noty's--}}
    {{--    @include('shared.alert')--}}

    {{--    DE ARRAY VAN DE TWEEDE CONTROLLER WORDT GEBRUIKT, ANDERS USERS2 --> USERS--}}
    <form method="get" action="/admin/users2" id="searchFormUsers">
        <div class="row">
            <div class="col-sm-8 mb-8">
                <label for="nameSearch">Filter Name or Email</label>
                <input type="text" class="form-control" name="nameSearch" id="nameSearch"
                       value="{{ request()->nameSearch }}" placeholder="Filter Name Or Email">
            </div>
            <div class="col-sm-4 mb-4">
                <label for="sort">Sort by</label>
                <select class="form-control" name="sort" id="sort">

                    {{--                    Dropdown list om te sorteren via SWITCH CASE --}}
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

                    {{--                    Dropdown list om te sorteren via ARRAY --}}
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

            {{--            Tabel opvullen met gegevens van elke user --}}
            @foreach($users as $user)
                <tr id="{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    {{--                    Als de gebruiker actief is wordt een vinkje getoond bij de kolom active --}}
                    @if ( $user['active'] == 1)
                        <td><i class="fas fa-check"></i></td>
                    @else
                        <td></td>
                    @endif

                    {{--                    Als de gebruiker admin is wordt een vinkje getoond bij de kolom admin --}}
                    @if ( $user['admin'] == 1)
                        <td><i class="fas fa-check"></i></td>
                    @else
                        <td></td>
                    @endif


                    <td>
                        <div class="btn-group btn-group-sm">

                            {{--                            Edit link / button --}}
                            <a href="#!"
                               class="btn btn-outline-success btn-edit-user @if (auth()->user()->id == $user->id)disabled @endif"
                               {{--                               Tooltip niet laten zien bij eigen profiel--}}
                               @if (auth()->user()->id != $user->id)
                               data-toggle="tooltip"
                               title="Edit {{ $user->name }}"
                               @endif
                               data-name="{{$user->name}}"
                               data-id="{{$user->id}}"
                               data-email="{{$user->email}}"
                               data-active="{{$user->active}}"
                               data-admin="{{$user->admin}}"
                            >
                                <i class="fas fa-edit"></i>
                            </a>

                            {{--                            Delete link / button--}}
                            <a href="#!"
                               class="btn btn-outline-danger btn-delete  @if (auth()->user()->id == $user->id)disabled @endif"
                               @if (auth()->user()->id != $user->id)
                               data-toggle="tooltip"
                               title="Delete {{ $user->name }}"
                               @endif
                               data-name="{{ $user->name }}"
                               data-id="{{ $user->id }}"
                               data-email="{{ $user->email }}"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </a>

                        </div>
                    </td>
                </tr>

                {{--                @if (empty($user->id))--}}
                {{--                    <tr>--}}
                {{--                        <td>1</td>--}}
                {{--                        <td>1</td>--}}
                {{--                        <td>1</td>--}}
                {{--                        <td>1</td>--}}
                {{--                        <td>1</td>--}}
                {{--                        <td>1</td></tr>--}}
                {{--                    <div class="alert alert-danger alert-dismissible fade show">--}}
                {{--                        Can't find any artist or album with <b>'{{ request()->artist }}'</b> for this genre--}}
                {{--                        <button type="button" class="close" data-dismiss="alert">--}}
                {{--                            <span>&times;</span>--}}
                {{--                        </button>--}}
                {{--                    </div>--}}
                {{--                @endif--}}

            @endforeach
            </tbody>
        </table>
    </div>

    {{--     Foutmelding als er niets gevonden is?--}}


    {{--    Paginatie tonen--}}
    {{ $users->links() }}

    @include('admin.users.modalUsers')
@endsection

@section('script_after')

    <script>
        $(function () {

            // Submit form when leaving text field 'name or email'
            $('#nameSearch').blur(function () {
                $('#searchFormUsers').submit();
            });

            // Submit form when changing dropdown list
            $('#sort').change(function () {
                $('#searchFormUsers').submit();
            });

            // ZONDER NOTY - Google confirm
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

            // DELETE ORIGINAL
            // $('.deleteFormUser button').click(function () {
            //     console.log('Delete knop 1 gedrukt');
            //     let name = $(this).data('name');
            //     let id = $(this).data('id');
            //     let form = $(this).closest('form'); // Safe the correct form name to use in the noty
            //
            //     // Set some values for Noty
            //     let text = `<p>Delete the user <b>${name}</b>?</p>`;
            //     let type = 'warning';
            //     let btnText = 'Delete user';
            //     let btnClass = 'btn-success';
            //
            //     // Show Noty
            //     let modal = new Noty({
            //         timeout: false,
            //         layout: 'center',
            //         modal: true,
            //         type: type,
            //         text: text,
            //         buttons: [
            //             Noty.button(btnText, `btn ${btnClass}`, function () {
            //                 // Delete the user and close the modal
            //                 console.log('delete knop 2 gedrukt');
            //                 $(form).submit();
            //                 // deleteUser(id);
            //                 modal.close();
            //
            //             }),
            //             Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
            //                 modal.close();
            //             })
            //         ]
            //     }).show();
            // });

            // DELETE JQUERY BUTTON
            $(document).on("click", ".btn-delete", function () {

                // If the button is disabled do nothing
                if ($(this).hasClass('disabled')) {
                    console.log('You cannot delete yourself');
                } else {
                    let name = $(this).data('name');
                    let id = $(this).data('id');
                    let email = $(this).data('email');

                    console.log('Delete button for user', name, 'pressed');

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
                                console.log('Delete user' + name + ' is confirmed');
                                // Delete the user and close the modal
                                deleteUser(id, email);
                                modal.close();
                            }),
                            Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                                console.log('Delete user' + name + ' is canceled');
                                modal.close();
                            })
                        ]
                    }).show();
                }
            });

            // EDIT
            $('tbody').on('click', '.btn-edit-user', function () {

                if ($(this).hasClass('disabled')) {
                    console.log('You cannot edit yourself');
                } else {

                    // Get data attributes from td tag
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let email = $(this).data('email');
                    let active = $(this).data('active');
                    let admin = $(this).data('admin');

                    console.log('Edit knop geduwt voor user ', name, ', with id ', id, ', with email ', email);

                    // Update the modal
                    $('.modal-title').text(`Edit ${name}`);
                    $('form').attr('action', `/admin/users2/${id}`);
                    $('#name').val(name);
                    $('input[name="_method"]').val('put');
                    $('#email').val(email);
                    $('input[email="_method"]').val('put');

                    // console.log('Active?:', active);
                    if (active == 1) {
                        $('#active').prop("checked", true);
                    } else {
                        $('#active').prop("checked", false);
                    }
                    $('input[active="_method"]').val('put');

                    // console.log('Admin?:', admin);
                    if (admin == 1) {
                        $('#admin').prop("checked", true);
                    } else {
                        $('#admin').prop("checked", false);
                    }

                    // Show the modal
                    $('#modal-users').modal('show');
                }
            });

            // EDIT WORDT GESUBMIT
            $('#modal-users form').submit(function (e) {
                // Don't submit the form
                e.preventDefault();
                // Get the action property (the URL to submit)
                let action = $(this).attr('action');
                // Serialize the form and send it as a parameter with the post
                let pars = $(this).serialize();
                console.log(pars);
                // Post the data to the URL
                $.post(action, pars, 'json')
                    .done(function (data) {
                        console.log(data);
                        // Noty success message
                        new Noty({
                            type: data.type,
                            text: data.text
                        }).show();
                        // Hide the modal
                        $('#modal-users').modal('hide');

                        // Rebuild the table
                        // Rebuild the user in the tabel

                        // get the new data from the user from the controller
                        let id = data.id;
                        let name = data.name;
                        let oldName = data.oldName; // old name geeft problemen bij bv itf user 1 als oude naam
                        let email = data.email;
                        let oldEmail = data.oldEmail;
                        let admin = data.admin;
                        let active = data.active;

                        console.log('Update the updated user in the table with id', id, ', name:', name, ', email:', email, ', active:', active, ', admin:', admin);
                        console.log('new name:', name);
                        console.log('old name:', oldName);
                        console.log('new email:', email);
                        console.log('old email:', oldEmail);

                        // $("td:contains('" + name + "')").parent().css("background-color", "red");

                        // If see if user is active and admin to get the icons right
                        var iconActive = '';
                        if (active == 1) {
                            iconActive = '<i class="fas fa-check"></i>';
                        }
                        var iconAdmin = '';
                        if (admin == 1) {
                            iconAdmin = '<i class="fas fa-check"></i>';
                        }

                        // Change the table row from the user that is edited
                        $("td:contains('" + oldEmail + "')").parent().html('<td>' + id + '</td> <td>' + name + '</td> <td>' + email + ' </td> <td>' + iconActive + '</td> <td>' + iconAdmin + '</td> <td>' +
                            '                            <div class="btn-group btn-group-sm">' +
                            '                                <a href="#!"' +
                            '                                   class="btn btn-outline-success btn-edit-user @if (auth()->user()->id == $user->id)disabled @endif"' +
                            '                                   @if (auth()->user()->id != $user->id)data-toggle="tooltip"' +
                            '                                   data-name="' + name + '"' +
                            '                                   data-id="' + id + '"' +
                            '                                   data-email="' + email + '"' +
                            '                                   data-active="' + active + '"' +
                            '                                   data-admin="' + admin + '"' +
                            '                                   title="Edit ' + name + '"' +
                            '                                   @endif' +
                            '                                   @if (auth()->user()->id == $user->id)onclick="return false;" @endif>' +
                            '                                    <i class="fas fa-edit"></i>' +
                            '                                </a>' +
                            '                                <a href="#!"class="btn btn-outline-danger btn-delete"' +
                            '                                        data-toggle="tooltip" title="Delete ' + name + '"' +
                            '                                        data-name="' + name + '"' +
                            '                                        data-email="' + email + '"' +
                            '                                        data-id="' + id + '">' +
                            '                                    <i class="fas fa-trash-alt"></i>' +
                            '                               </a>' +
                            '                            </div>' +
                            '                            </td>');

                        $('[data-toggle="tooltip"]').tooltip({
                            // Tags gebruiken in tooltip
                            'html': true,
                        });

                        //  DIT HERLAAD HEEL DE PAGINA
                        // location.reload();

                    })
                    .fail(function (e) {

                        // Remove the is-invalid class (especially form is subbmitted again, and there still is an error)
                        $('#name').removeClass('is-invalid');
                        $('#email').removeClass('is-invalid');

                        console.log('error', e);
                        // e.responseJSON.errors contains an array of all the validation errors
                        console.log('error message:', e.responseJSON.errors);

                        // Loop over the e.responseJSON.errors array and create an ul list with all the error messages
                        let msg = '<ul>';
                        $.each(e.responseJSON.errors, function (key, value) {

                            // Create error message for noty
                            msg += `<li>${value}</li>`;

                            // Errors on form input fields of the modal window
                            // if (value.toString().includes('name')){
                            //     $('#name').addClass('is-invalid');
                            //     $('#invalid-feedback_name').html(value);
                            // }else{
                            //     $('#email').addClass('is-invalid');
                            //     $('#invalid-feedback_email').html(value);
                            // }

                            if (key == 'name') {
                                $('#name').addClass('is-invalid');
                                $('#invalid-feedback_name').html(value);
                            } else {
                                $('#email').addClass('is-invalid');
                                $('#invalid-feedback_email').html(value);
                            }

                        });
                        msg += '</ul>';
                        console.log('errors msg:', msg);
                        // Noty the errors
                        new Noty({
                            type: 'error',
                            text: msg
                        }).show();
                    });
            });

        });

        // Delete a user from the database and table (pagination not 100% correct)
        function deleteUser(id, email) {
            console.log('id', id);
            let pars = {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete'
            };
            $.post(`/admin/users2/${id}`, pars, 'json')
                .done(function (data) {
                    console.log('data', data);
                    // Show toast
                    new Noty({
                        type: data.type,
                        text: data.text
                    }).show();
                    // Rebuild the table
                    // loadTable();
                    if (data.type == 'success') {
                        $("td:contains('" + email + "')").parent().remove();
                    }
                })
                .fail(function (e) {
                    console.log('error', e);
                });
        }

    </script>

@endsection
