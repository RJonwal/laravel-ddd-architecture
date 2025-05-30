<script src="{{asset('admin-assets/vendor/dropify/dropify.min.js')}}"></script>
<script>
    $(document).on('submit', '#siteSettingform, #supportSettingform', function(e){
        e.preventDefault();
        $('.loader-div').show();
        $(".submitBtn").attr('disabled', true);

        $('.validation-error-block').remove();

        var formData = new FormData(this);

        $.ajax({
            type: 'post',
            url: "{{ route('admin.update.setting') }}",
            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                if(response.success) {
                    toasterAlert('success',response.message);
                    window.location.reload();
                }
            },
            error: function (response) {
                console.log(response);
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
            complete: function(res){
                $(".submitBtn").attr('disabled', false);
                $('.loader-div').hide();
            }
        });
    });

    $(document).on('click', '.setting-tab', function(e){
        e.preventDefault();

        var tab_id = $(this).attr('id');

        $('.setting-tab').removeClass('active');
        $(this).addClass('active');

        $('.tab-item').addClass('hide');
        $('.tab-item[data-id="'+tab_id+'"]').removeClass('hide');
    });

    $('.dropify').dropify();
    $('.dropify-errors-container').remove();
    $('.dropify-wrapper').find('.dropify-clear').hide();
</script>