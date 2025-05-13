@extends('Layouts::app')
@section('title', __('cruds.user.title'))

@section('custom_css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">

@endsection

@section('main-content')

    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="page-title-box">
                <h4 class="page-title">@lang('cruds.user.title')</h4>
            </div>
            <div class="my-3">
                <a href="javascript:void(0);"  class="btn btn-primary btnAddUser">Create</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                       
                        {{$dataTable->table(['class' => 'table mb-0', 'style' => 'width:100%;'])}}
                           
                    </div> 
                </div>
            </div> 
        </div> 
    </div>
   


@endsection

@section('custom_js')
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

{!! $dataTable->scripts() !!}

<script>

$(document).ready(function(e){
    $(document).on('datatableLoaded', function () {
        var buttonCount = $('.dt-paging-button').not('.previous, .next').length;
        alert("sdgsdg : "+buttonCount);
        if(buttonCount <= 1){
            $('.paging_simple_numbers').addClass('d-none');
        }
    })
})

@can('user_create')
    $(document).on("click", ".btnAddUser", function() {
        $('.loader-div').show();
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: "{{route('users.create')}}",
            dataType: 'json',
            success: function (response) {
                $('.loader-div').hide();
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#AddUser').modal('show');
                }
                else {
                    toasterAlert('error',response.error);
                }
            },
            error: function(res){
                $('.loader-div').hide();
                toasterAlert('error',res.responseJSON.error);
            },
            complete: function(xhr){
                $('.loader-div').hide();
            }
        });
    });

    $(document).on('submit','#AddUserForm', function(e) {
        e.preventDefault();
        $('.loader-div').show();

        $('.validation-error-block').remove();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{route('users.store')}}",
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
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
                console.log(response);
                if(response.responseJSON.error_type == 'something_error'){
                    toasterAlert('error',response.responseJSON.error);
                } else {
                    var errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</span>';

                        $("input[name='" + key + "']").after(errorLabelTitle);
                        $("textarea[name='" + key + "']").after(errorLabelTitle);
                    });
                }
            },
            complete: function(xhr){
                $('.loader-div').hide();
            }
        });
    }); 
@endcan

@can('user_view')
    $(document).on("click", ".btnViewUser", function() {
        $('.loader-div').show();
        var url = $(this).data('href');

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
                $('.loader-div').hide();
            }
        });
    });
@endcan

@can('user_edit')
    $(document).on("click", ".btnEditUser", function() {
        $('.loader-div').show();
        var url = $(this).data('href');

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
                $('.loader-div').hide();
            }
        });
    });

    $(document).on('submit','#editUserForm', function(e) {
        e.preventDefault();
        $('.loader-div').show();

        $('.validation-error-block').remove();
        var formData = $(this).serialize();

        var url = $(this).data('href');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
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
                console.log(response);
                if(response.responseJSON.error_type == 'something_error'){
                    toasterAlert('error',response.responseJSON.error);
                } else {
                    var errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</span>';

                        $("input[name='" + key + "']").after(errorLabelTitle);
                        $("textarea[name='" + key + "']").after(errorLabelTitle);
                    });
                }
            },
            complete: function(xhr){
                $('.loader-div').hide();
            }
        });
    }); 
@endcan

@can('user_delete')
$(document).on("click",".deleteUserBtn", function() {
        var url = $(this).data('href');
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
                $('.loader-div').show();
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
                        $('.loader-div').hide();
                    }
                });
            }
        });
    });
@endcan

$(document).on('click','.user_status_cb', function(){
    var $this = $(this);
    var userId = $this.data('user_id');
    var flag = true;
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
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
                }
            });
        }
        else {
            $this.prop('checked', flag);
        }
    });
});

</script>

@endsection