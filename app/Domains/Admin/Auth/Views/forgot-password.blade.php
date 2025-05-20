@extends('Layouts::auth')
@section('title', __('global.forgot_password_title'))
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
                <img src="{{ asset('admin-assets/images/forgot-password.svg') }}" alt="" class="img-fluid">
            </div>
            <div class="col-lg-5">
                <div class="log-register-block">
                    <div class="text-center mb-4">
                    <a href="#" title="logo" class="header-logo">
                            <img src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset(config('constant.default.logo')) }}" alt="logo">
                        </a>
                   </div>
                    <h2 class="text-center">Forgot Password?</h2>
                    <p class="text-center">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                    <form id="forgot_password_form">
                        @csrf
                        <div class="form-group">
                            <label for="emailaddress" class="form-label">@lang('global.login_email')</label>
                            <input class="form-control" type="email" name="email"  placeholder="Enter your email" value="{{ old('email') }}" tabindex="1"   autofocus>
                            @error('email')
                            <span class="invalid-feedback d-block">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="btn-block">
                            <button class="btn btn-soft-primary w-100" type="submit">
                                @lang('global.reset_password')
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
$(document).on('submit', '#forgot_password_form', function(e){
    e.preventDefault();
    let formData = new FormData(this);

    $('.validation-error-block').remove();
    
    btnloader('show');
    $.ajax({
        type: 'post',
        url: '{{route("forgot.password.submit")}}',
        data: formData,
        dataType: "json",
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function(response, textStatus, jqXHR){
            toasterAlert('success',response.message);
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
