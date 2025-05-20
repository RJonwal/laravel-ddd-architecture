@extends('Layouts::auth')
@section('title', trans('global.forgot_password_title'))
@section('main-content')

<div class="row">
    <div class="col">
        <a href="#" title="logo" class="header-logo">
            <img src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset(config('constant.default.logo')) }}" alt="logo">
        </a>
    </div>
</div>
<div class="l_content">
    <div class="container px-0">
        <div class="row items-center">
            <div class="col-lg-7 d-none d-lg-block">
                <img src="{{ asset('admin-assets/images/reset-pass.webp') }}" alt="" class="img-fluid">
            </div>
            <div class="col-lg-5">
                <div class="log-register-block">
                    <h2 class="text-center">Reset Your Password</h2>
                    <p class="text-center">Reset your password to continue</p>
                    <form id="reset_password_form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" tabindex="1">
                                <div class="input-group-text toggle-password show-password" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="form-label">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Enter confirm password" tabindex="2">
                                <div class="input-group-text toggle-password show-password" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="btn-block">
                            <button class="btn btn-soft-primary w-100" type="submit">
                                @lang('global.submit')
                                @btnLoader
                            </button>
                        </div>
                    </form>
                    <p class="bottom-para">Already have an Account? <a href="{{ route('login') }}" class="text-decoration-underline">@lang('global.login')</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('custom_js')

<script>

// Reset Ajax
$(document).on('submit', '#reset_password_form', function(e){
    e.preventDefault();
    let formData = new FormData(this);

    $('.validation-error-block').remove();
    
    btnloader('show');
    $.ajax({
        type: 'post',
        url: '{{route("reset-new-password")}}',
        data: formData,
        dataType: "json",
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function(response, textStatus, jqXHR){
            window.location.href=response.redirect_url;
        },
        error: function(response, textStatus, jqXHR){
            if(response.responseJSON.error_type == 'something_error'){
                toasterAlert('error',response.responseJSON.error);
            } else {                    
                var errorLabelTitle = '';
                $.each(response.responseJSON.errors, function (key, item) {
                    errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</sapn>';
                    
                    $(errorLabelTitle).insertAfter("input[name='"+key+"']");
                });
            }
        },
        complete: function(response, textStatus, jqXHR){
            btnloader('hide');
        }
    });
});

</script>
@endsection