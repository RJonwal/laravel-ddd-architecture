@extends('Layouts::auth')
@section('title', trans('global.login'))
@section('main-content')

<div class="l_content">
    <div class="container px-0">
        <div class="row items-center">
            <div class="col-xl-7 col-lg-6 d-none d-lg-block">
                <img src="{{ asset('admin-assets/images/login-img.svg') }}" alt="" class="img-fluid">
            </div>
            <div class="col-xl-5 col-lg-6">
                <div class="log-register-block">
                   <div class="text-center mb-4">
                    <a href="#" title="logo" class="header-logo">
                            <img src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset(config('constant.default.logo')) }}" alt="logo">
                        </a>
                   </div>
                    <h2 class="text-center">@lang('global.login')</h2>
                    <p class="text-center">Welcome to {{ getSetting('site_title') ? getSetting('site_title') : config('app.name') }}!</p>
                    <form method="POST" id="loginForm">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label for="emailaddress" class="form-label">@lang('global.login_email')</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Enter your email" tabindex="1"   autofocus>
                            
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">@lang('global.login_password')</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" tabindex="2">
                                <div class="input-group-text toggle-password show-password" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between flex-wrap">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">@lang('global.remember_me')</label>
                            </div>
                            {{-- <a href="{{ route('admin.forgot.password') }}" class="forgot-text">@lang('global.forgot_password')</a> --}}
                        </div>
                        <div class="text-start btn-block">
                            <button class="btn btn-soft-primary w-100" type="submit">
                                @lang('global.login')
                                @btnLoader
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('custom_js')

<script>

    // Password field hide/show functiolity
    /* $(document).on('click', '.toggle-password', function () {        
        var passwordInput = $(this).prev('input');  
        console.log(passwordInput);      
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            $(this).removeClass('show-password');
        } else {
            passwordInput.attr('type', 'password');
            $(this).addClass('show-password');
        }
    }); */

    // Login Ajax
    $(document).on('submit', '#loginForm', function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $("button[type='submit']").attr('disabled', true);
        btnloader('show');
        $.ajax({
            type: 'post',
            url: "{{route('login.submit')}}",
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
                $("button[type='submit']").attr('disabled', false);
            }
        });
    });
</script>
@endsection