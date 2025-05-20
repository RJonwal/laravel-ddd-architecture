<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

<script src="{{asset('admin-assets/vendor/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin-assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

{!! $dataTable->scripts() !!}

<script>

@can('milestone_create')
    $(document).on("click", ".btnAddMilestone", function() {
        pageLoader('show');
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: "{{route('milestones.create')}}",
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#AddMilestone').modal('show');

                    $('.select2').select2({
                        width: '100%',
                        dropdownParent: $('#AddMilestone'),
                        selectOnClose: false
                    });

                    $('#start_date').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        startDate: new Date(),
                    }).on('changeDate', function (selected) {            
                        $('#end_date').val('');
                        var minDate = new Date(selected.date.valueOf());
                        $('#end_date').datepicker('setStartDate', minDate);
                    });
                
                    $('#end_date').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        startDate: new Date(),
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
                pageLoader('hide');
            }
        });
    });

    $(document).on('submit','#AddMilestoneForm', function(e) {
        e.preventDefault();
        pageLoader('show', true);

        $('.validation-error-block').remove();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{route('milestones.store')}}",
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('#AddMilestone').modal('hide');
                    $('#milestone-table').DataTable().ajax.reload(null, false);
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
                    var errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = `<span class="validation-error-block">${item[0]}</span>`;

                        $("input[name='" + key + "']").after(errorLabelTitle);
                        $("textarea[name='" + key + "']").after(errorLabelTitle);

                         $("#"+key).siblings('.select2').after(errorLabelTitle);
                    });
                }
            },
            complete: function(xhr){
                pageLoader('hide', true);
            }
        });
    }); 
@endcan

@can('milestone_view')
    $(document).on("click", ".btnViewMilestone", function() {
        pageLoader('show');
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#ViewMilestone').modal('show');
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

@can('milestone_edit')
    $(document).on("click", ".btnEditMilestone", function() {
        pageLoader('show');
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#editMilestone').modal('show');

                    $('.select2').select2({
                        width: '100%',
                        dropdownParent: $('#editMilestone'),
                        selectOnClose: false
                    });
                      $('#start_date').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        startDate: new Date(),
                    }).on('changeDate', function (selected) {            
                        $('#end_date').val('');
                        var minDate = new Date(selected.date.valueOf());
                        $('#end_date').datepicker('setStartDate', minDate);
                    });
                
                    $('#end_date').datepicker({
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        startDate: new Date(),
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
                pageLoader('hide');
            }
        });
    });

    $(document).on('submit','#editMilestoneForm', function(e) {
        e.preventDefault();
       pageLoader('show', true);

        $('.validation-error-block').remove();
        var formData = $(this).serialize();

        var url = $(this).data('href');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('#editMilestone').modal('hide');
                    $('#milestone-table').DataTable().ajax.reload(null, false);
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
                    var errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</span>';

                        $("input[name='" + key + "']").after(errorLabelTitle);
                        $("textarea[name='" + key + "']").after(errorLabelTitle);

                        $("#"+key).siblings('.select2').after(errorLabelTitle);
                    });
                }
            },
            complete: function(xhr){
                pageLoader('hide', true);
            }
        });
    }); 
@endcan

@can('milestone_delete')
    $(document).on("click",".deleteMilestoneBtn", function() {
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
                pageLoader('show');
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    dataType: 'json',
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        if(response.success) {
                            $('#milestone-table').DataTable().ajax.reload(null, false);
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

</script>