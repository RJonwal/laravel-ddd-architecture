<div class="card-body">
    <div class="form-group">
        <label for="name">@lang('cruds.user.fields.name') <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ isset($user) ? $user->name : '' }}" required>
    </div>

    <div class="form-group">
        <label for="email">@lang('cruds.user.fields.email')<span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="email" name="email" value="{{ isset($user) ? $user->email : '' }}" required autocomplete="username">
    </div>

    <div class="form-group">
        <label for="phone">@lang('cruds.user.fields.phone') <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="phone" name="phone" value="{{ isset($user) ? $user->phone : '' }}" required>
    </div>

    @if(!isset($user))
        <div class="form-group">
            <label for="password" class="form-label">@lang('global.login_password')</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" tabindex="2" required autocomplete="new-password">
                <div class="input-group-text toggle-password show-password" data-password="false">
                    <span class="password-eye"></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation" class="form-label">@lang('cruds.user.fields.password')</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter your password" tabindex="2" required autocomplete="new-password">
                <div class="input-group-text toggle-password show-password" data-password="false">
                    <span class="password-eye"></span>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-primary submitBtn">
        @lang('global.save')
        @btnLoader
    </button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('global.close')</button>
</div>