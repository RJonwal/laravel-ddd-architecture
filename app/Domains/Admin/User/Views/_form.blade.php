<div class="card-body">
    <div class="form-group">
        <label for="name">{{ trans('cruds.user.fields.name') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($user) ? $user->name : '' }}" required>
    </div>

    <div class="form-group">
        <label for="email">{{ trans('cruds.user.fields.email') }}<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="email" name="email" value="{{ isset($user) ? $user->email : '' }}" required>
    </div>

    <div class="form-group">
        <label for="phone">{{ trans('cruds.user.fields.phone') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ isset($user) ? $user->phone : '' }}" required>
    </div>

    @if(!isset($user))
        <div class="form-group">
            <label for="password" class="form-label">@lang('global.login_password')</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" tabindex="2" required>
                <div class="input-group-text toggle-password show-password" data-password="false">
                    <span class="password-eye"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation" class="form-label">@lang('cruds.user.fields.password')</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter your password" tabindex="2" required>
                <div class="input-group-text toggle-password show-password" data-password="false">
                    <span class="password-eye"></span>
                </div>
            </div>
        </div>
        {{-- <div class="form-group">
            <label for="password">{{ trans('cruds.user.fields.password') }}<span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">{{ trans('cruds.user.fields.confirm_password') }}<span class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div> --}}
    @endif
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">{{ trans('global.save') }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('global.close') }}</button>
</div>