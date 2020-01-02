<div class="modal" id="modal-users">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">modal-users-title</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @method('')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
{{--                               class="form-control @error('name') is-invalid @enderror"--}}
                               class="form-control"
                               placeholder="Name"
                               minlength="2"
                               required
                               value="">
{{--                        @error('name')--}}
{{--                        <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                        @enderror--}}
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
{{--                               class="form-control @error('email') is-invalid @enderror"--}}
                               class="form-control"
                               placeholder="Email"
                               required
                               value="">
{{--                               value="{{ old('email', $user->email) }}">--}}
{{--                        @error('email')--}}
{{--                        <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                        @enderror--}}
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="active" id="active" value="active"
                            {{--                               @if (old('_token'))--}}
                            {{--                                    @if (old('active'))checked @endif--}}
                            {{--                               @else--}}
                            {{--                                    @if ($user['active']==1) checked @endif--}}
                            {{--                            @endif--}}
                            {{--                            @if (old('active', $user->active)==1)--}}
                            {{--                                checked--}}
                            {{--                            @endif--}}
                        >Active
                        <input type="checkbox" name="admin" id="admin" value="admin" class="ml-4"
                               {{--                               @if (old('_token'))--}}
                               {{--                               @if (old('admin'))checked @endif--}}
                               {{--                               @else--}}
                               @if ($user['admin']==1) checked @endif
                            {{--                            @endif--}}
                        >Admin
                    </div>
                    <button type="submit" class="btn btn-success">Save user</button>
                </form>
            </div>
        </div>
    </div>
</div>
