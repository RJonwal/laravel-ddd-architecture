<!-- Vendor js -->
<script src="{{ asset('admin-assets/js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('admin-assets/js/app.min.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $( document ).ajaxError(function( event, response, settings ) {
        if(response.status == 401){
            window.location.href = "{{ route('login') }}";
        }
    });

    $(document).on('click', '.toggle-password', function () {        
        let passwordInput = $(this).prev('input');  
        console.log(passwordInput);      
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            $(this).removeClass('show-password');
        } else {
            passwordInput.attr('type', 'password');
            $(this).addClass('show-password');
        }
    });

    function btnloader(type='show') {
        if(type === 'show'){
            $("button[type='submit']").attr('disabled', true);
            $('.btn_loader').removeClass('d-none');
        } else {
            $("button[type='submit']").attr('disabled', false);
            $('.btn_loader').addClass('d-none');
        }
    }

    function pageLoader(type='show', isForm=false){
        if(type === 'show'){
            $('.loader-div').show();
            if(isForm){
                $("button[type='submit']").attr('disabled', true);
            }
        } else {
            $('.loader-div').hide();
            if(isForm){
                $("button[type='submit']").attr('disabled', false);
            }
        }
    }
</script>

@include('Layouts::partials.alert')