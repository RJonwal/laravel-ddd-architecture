<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

{!! $dataTable->scripts() !!}

<script>

@can('user_create')
    $(document).on("click", ".btnAddUser", function() {
        pageLoader();
        let url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: "{{ route('users.create') }}",
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#AddUser').modal('show');
                }
                else {
                    toasterAlert('error',response.error);
                }
            },
            error: function(res){
                toasterAlert('error',res.responseJSON.error);
            },
            complete: function(xhr){
                pageLoader('hide');
            }
        });
    });

    $(document).on('submit','#AddUserForm', function(e) {
        e.preventDefault();

        pageLoader('show', true);

        $('.validation-error-block').remove();
        let formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{route('users.store')}}",
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('#AddUser').modal('hide');
                    $('#user-table').DataTable().ajax.reload(null, false);
                    toasterAlert('success',response.message);
                }
                else {
                    toasterAlert('error', response.error);
                }
            },
            error: function (response) {
                if(response.responseJSON.error_type == 'something_error'){
                    toasterAlert('error',response.responseJSON.error);
                } else {
                    let errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = `<span class="validation-error-block">${item[0]}</span>`;

                        $(`input[name='${key}']`).after(errorLabelTitle);
                        $(`textarea[name='${key}']`).after(errorLabelTitle);
                    });
                }
            },
            complete: function(xhr){
                pageLoader('hide', true);
            }
        });
    }); 
@endcan

@can('user_view')
    $(document).on("click", ".btnViewUser", function() {
        let url = $(this).data('href');
        pageLoader();

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#ViewUser').modal('show');
                }
                else {
                    toasterAlert('error',response.error);
                }
            },
            error: function(res){
                toasterAlert('error',res.responseJSON.error);
            },
            complete: function(xhr){
                pageLoader('hide');
            }
        });
    });
@endcan

@can('user_edit')
    $(document).on("click", ".btnEditUser", function() {
        pageLoader('show');
        let url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#editUser').modal('show');
                }
                else {
                    toasterAlert('error',response.error);
                }
            },
            error: function(res){
                toasterAlert('error',res.responseJSON.error);
            },
            complete: function(xhr){
                pageLoader('hide');
            }
        });
    });

    $(document).on('submit','#editUserForm', function(e) {
        e.preventDefault();
        pageLoader('show', true);

        $('.validation-error-block').remove();
        let formData = $(this).serialize();

        let url = $(this).data('href');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('#editUser').modal('hide');
                    $('#user-table').DataTable().ajax.reload(null, false);
                    toasterAlert('success',response.message);
                }
                else {
                    toasterAlert('error', response.error);
                }
            },
            error: function (response) {
                if(response.responseJSON.error_type == 'something_error'){
                    toasterAlert('error',response.responseJSON.error);
                } else {
                    let errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = `<span class="validation-error-block">${item[0]}</span>`;

                        $(`input[name='${key}']`).after(errorLabelTitle);
                        $(`textarea[name='${key}']`).after(errorLabelTitle);
                    });
                }
            },
            complete: function(xhr){
                pageLoader('hide', true);
            }
        });
    }); 
@endcan

@can('user_delete')
$(document).on("click",".deleteUserBtn", function() {
        let url = $(this).data('href');
        Swal.fire({
            title: "{{ trans('global.areYouSure') }}",
            text: "{{ trans('global.onceClickedRecordDeleted') }}",
            icon: "warning",
            showDenyButton: true,  
            //   showCancelButton: true,  
            confirmButtonText: "{{ trans('global.swl_confirm_button_text') }}",  
            denyButtonText: "{{ trans('global.swl_deny_button_text') }}",
        })
        .then(function(result) {
            if (result.isConfirmed) {  
                pageLoader('show');
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    dataType: 'json',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        if(response.success) {
                            $('#user-table').DataTable().ajax.reload(null, false);
                            toasterAlert('success',response.message);
                        }
                        else {
                            toasterAlert('error',response.error);
                        }
                    },
                    error: function(res){
                        toasterAlert('error',res.responseJSON.error);
                    },
                    complete: function(xhr){
                        pageLoader('hide');
                    }
                });
            }
        });
    });
@endcan

$(document).on('click','.user_status_cb', function(){
    let $this = $(this);
    let userId = $this.data('user_id');
    let flag = true;
    let csrf_token = $('meta[name="csrf-token"]').attr('content');
    if($this.prop('checked')){
        flag = false;
    }
    Swal.fire({
            title: "{{ trans('global.areYouSure') }}",
            text: "{{ trans('global.want_to_change_status') }}",
            icon: "warning",
            showDenyButton: true, 
            confirmButtonText: "{{ trans('global.swl_confirm_button_text') }}",  
            denyButtonText: "{{ trans('global.swl_deny_button_text') }}",
    })
    .then(function(result) {
        if (result.isConfirmed) { 
            pageLoader('show'); 
            $.ajax({
                type: 'POST',
                url: "{{ route('user.status') }}",
                dataType: 'json',
                data: { _token: csrf_token, id: userId },
                success: function (response) {
                    if(response.status == 'true') {
                        toasterAlert('success',response.message);
                        $('#user-table').DataTable().ajax.reload(null, false);
                    }
                },
                error:function (response){
                    $this.prop('checked', flag);
                    toasterAlert('error',response.error);
                },
                complete: function(xhr){
                    pageLoader('hide');
                }
            });
        }
        else {
            $this.prop('checked', flag);
        }
    });
});

</script>