
<script src="{{asset('admin-assets/vendor/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin-assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script>
$(document).ready(function(e){
    $('.select2').select2({
        width: '100%',
        dropdownParent: $('body'),
        selectOnClose: false
    });

    $('#report_date').datepicker({
        format: "{{ config('constant.js_date_format.date') }}",
        autoclose: true,
        startDate: new Date(),
    });
});

@can('daily_activity_log_create')
    $(document).on('submit','#AddDailyActivityLogForm', function(e) {
        e.preventDefault();

        pageLoader('show', true);

        $('.validation-error-block').remove();
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: "{{route('daily-activity-logs.store')}}",
            data: formData,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    toasterAlert('success',response.message);  
                    setTimeout(function() {                  
                        window.location.replace(response.redirectUrl);
                    }, 1500); 
                }
                else {
                    toasterAlert('error', response.error);
                }
            },
            error: function (response) {                
                let statusCode = response.status;
                if (statusCode === 400) {
                    toasterAlert('error',response.responseJSON.error);
                } else if (statusCode === 422) {
                    var errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = `<span class="validation-error-block">${item[0]}</span>`;
                        if (key.indexOf("daily_activity") != -1){
                            var array = key.split(".");
                            console.log(`textarea[name='${array[0]}[${array[1]}][${array[2]}]']`);
                            console.log(`select[name='${array[0]}[${array[1]}][${array[2]}]']`);
                            
                            $(errorLabelTitle).insertAfter(`input[name='${array[0]}[${array[1]}][${array[2]}]']`);
                            $(errorLabelTitle).insertAfter(`textarea[name='${array[0]}[${array[1]}][${array[2]}]']`);
                            $(`select[name='${array[0]}[${array[1]}][${array[2]}]']`).siblings('.select2').after(errorLabelTitle);
                        } else {
                            $(errorLabelTitle).insertAfter("input[name='"+key+"']");
                            $("select[name='"+key+"']").siblings('.select2').after(errorLabelTitle);
                        }
                    });
                }
            },
            complete: function(xhr){
                pageLoader('hide', true);
            }
        });
    }); 
@endcan

@can('daily_activity_log_edit')
    $(document).on('submit','#editDailyActivityLogForm', function(e) {
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
                    $('#editDailyActivityLog').modal('hide');
                    $('#daily_activity_log-table').DataTable().ajax.reload(null, false);
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

@can('daily_activity_log_view')
    $(document).on("click", ".btnViewDailyActivityLog", function() {
        pageLoader('show');
        var url = $(this).data('href');

        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    $('.popup_render_div').html(response.htmlView);
                    $('#ViewDailyActivityLog').modal('show');
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

$(document).on("change", "#project_id", function(e) {
    e.preventDefault();

    let projectId = $(this).val();

    $('#milestone_id').html('<option value="">Loading...</option>');
    if (projectId) {
        $.ajax({
            url: '{{ route("daily-activity-logs.get-milestones") }}',
            type: 'GET',
            data: { project_id: projectId },
            dataType: 'json',
            success: function (response) {
                if(response.success){
                    $('#milestone_id').html('<option value="">Select Milestone</option>');
                    $('#parent_task_id').html('<option value="">Select Task</option>');
                    $.each(response.milestones, function (key, milestone) {
                        $('#milestone_id').append('<option value="' + milestone.uuid + '">' + milestone.name + '</option>');
                    });
                    $('#milestone_id').append('<option value="0">Other</option>');
                }
            },
            error: function () {
                $('#milestone_id').html('<option value="">Error loading milestones</option>');
            }
        });
    } else {
        $('#milestone_id').html('<option value="">Select Milestone</option>');
    }
});

$(document).on("change", "#milestone_id", function(e){
    e.preventDefault();
    let milestoneId = $(this).val();
    
    if (milestoneId) {
        $.ajax({
            url: "{{ route('daily-activity-logs.get-task-html') }}",
            type: 'GET',
            data: { milestone_id: milestoneId },
            dataType: 'json',
            success: function (response) {
                if(response.success){
                    $('.task_activity_main').removeClass('d-none').html(response.htmlView);

                    $('.task_activity_main').find('.select2').select2({
                        width: '100%',
                        dropdownParent: $('body'),
                        selectOnClose: false
                    });
                }
            },
            error: function () {

            }
        });
    } else {
        $('.task_activity_main').addClass('d-none').html('');
    }
});

$(document).on("change", ".task_id", function(e) {
    e.preventDefault();
    let _this = $(this);
    let taskId = _this.val();

    let innerTaskContainer = _this.closest('.task_activity_inner');
    let subTaskDropdown = innerTaskContainer.find('.sub_task_id');

    subTaskDropdown.html('<option value="">Loading...</option>');
    if (taskId) {
        $.ajax({
            url: '{{ route("daily-activity-logs.get-subTasks") }}',
            type: 'GET',
            data: { task_id: taskId },
            dataType: 'json',
            success: function (response) {
                if(response.success){
                    subTaskDropdown.html('<option value="">Select Sub Task</option>');
                    $.each(response.subTasks, function (key, subTask) {
                        subTaskDropdown.append('<option value="' + subTask.uuid + '">' + subTask.name + '</option>');
                    });
                }
            },
            error: function () {
                $('#milestone_id').html('<option value="">Error loading Sub Task</option>');
            }
        });
    } else {
        $('#milestone_id').html('<option value="">Select Sub Task</option>');
    }
});

$(document).on('click', '.addTaskBtn', function(e){
    e.preventDefault();

    let _this = $(this);
    let milestoneId = $("#milestone_id").val();
    let taskCount = parseInt(_this.data('task_count'))+parseInt(1);
    
    if (milestoneId) {
        $.ajax({
            url: "{{ route('daily-activity-logs.get-task-html') }}",
            type: 'GET',
            data: { milestone_id: milestoneId, task_count : taskCount },
            dataType: 'json',
            success: function (response) {
                if(response.success){
                    $('.task_activity_main').append(response.htmlView);
                    _this.data('task_count', taskCount);
                    
                    $(`.task_activity_inner_${taskCount}`).find('.select2').select2({
                        width: '100%',
                        dropdownParent: $(`.task_activity_inner_${taskCount}`),
                        selectOnClose: false
                    });
                }
            },
            error: function () {

            }
        });
    } else {
        toasterAlert('warning', "@lang('messages.warning_messages.milestone_not_selected')");
    }
});

$(document).on("click",".removeTaskBtn", function() {
    let _this = $(this);
    Swal.fire({
        title: "{{ trans('global.areYouSure') }}",
        text: "Do you want to remove task ?",
        icon: "warning",
        showDenyButton: true,  
        //   showCancelButton: true,  
        confirmButtonText: "{{ trans('global.swl_confirm_button_text') }}",  
        denyButtonText: "{{ trans('global.swl_deny_button_text') }}",
    })
    .then(function(result) {
        if (result.isConfirmed) {
            _this.closest('.task_activity_inner').remove();
            
            // let task_count = $('.addTaskBtn').data('task_count');
            // $('.addTaskBtn').data('task_count', parseInt(task_count)-parseInt(1));

            /*pageLoader('show', true);
            $.ajax({
                type: 'DELETE',
                url: url,
                dataType: 'json',
                data: { _token: "{{ csrf_token() }}" },
                success: function (response) {
                    if(response.success) {
                        $('#daily_activity_log-table').DataTable().ajax.reload(null, false);
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
                    pageLoader('hide', true);
                }
            });*/
        }
    });
});
</script>