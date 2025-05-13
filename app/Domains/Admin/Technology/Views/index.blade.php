@extends('Layouts::app')
@section('title', __('cruds.technology.title'))

@section('custom_css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">

<link href="{{ asset('admin-assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')

    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="page-title-box">
                <h4 class="page-title">@lang('cruds.technology.title')</h4>
            </div>
            <div class="my-3">
                <a href="javascript:void(0);"  class="btn btn-primary btnAddTechnology">Create</a>
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

<script src="{{asset('admin-assets/vendor/select2/js/select2.min.js')}}"></script>

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

@can('technology_create')
    $(document).on("click", ".btnAddTechnology", function() {
        $('.loader-div').show();
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: "{{route('technologies.create')}}",
            dataType: 'json',
            success: function (response) {
                $('.loader-div').hide();
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#AddTechnology').modal('show');

                    $('.select2').select2({
                        width: '100%',
                        dropdownParent: $('#AddTechnology'),
                        selectOnClose: false
                    });
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

    $(document).on('submit','#AddTechnologyForm', function(e) {
        e.preventDefault();
        $('.loader-div').show();

        $('.validation-error-block').remove();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{route('technologies.store')}}",
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if(response.success) {
                    $('#AddTechnology').modal('hide');
                    $('#technology-table').DataTable().ajax.reload(null, false);
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
                        errorLabelTitle = `<span class="validation-error-block">${item[0]}</span>`;

                        $("input[name='" + key + "']").after(errorLabelTitle);
                        $("textarea[name='" + key + "']").after(errorLabelTitle);

                        if (key === 'technology_type') {
                            $("#technology_type").next('.select2-container').after(errorLabelTitle);
                        } else {
                            $("select[name='" + key + "']").after(errorLabelTitle);
                        }
                    });
                }
            },
            complete: function(xhr){
                $('.loader-div').hide();
            }
        });
    }); 
@endcan

@can('technology_view')
    $(document).on("click", ".btnViewTechnology", function() {
        $('.loader-div').show();
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#ViewTechnology').modal('show');
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

@can('technology_edit')
    $(document).on("click", ".btnEditTechnology", function() {
        $('.loader-div').show();
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#editTechnology').modal('show');

                    $('.select2').select2({
                        width: '100%',
                        dropdownParent: $('#editTechnology'),
                        selectOnClose: false
                    });
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

    $(document).on('submit','#editTechnologyForm', function(e) {
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
                    $('#editTechnology').modal('hide');
                    $('#technology-table').DataTable().ajax.reload(null, false);
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

                        if (key === 'technology_type') {
                            $("#technology_type").next('.select2-container').after(errorLabelTitle);
                        } else {
                            $("select[name='" + key + "']").after(errorLabelTitle);
                        }
                    });
                }
            },
            complete: function(xhr){
                $('.loader-div').hide();
            }
        });
    }); 
@endcan

@can('technology_delete')
$(document).on("click",".deleteTechnologyBtn", function() {
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
                            $('#technology-table').DataTable().ajax.reload(null, false);
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

</script>

@endsection