@extends('Layouts::app')
@section('title', __('cruds.task.title'))

@section('custom_css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">

<link href="{{ asset('admin-assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('main-content')

    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div class="page-title-box">
                <h4 class="page-title">@lang('cruds.task.title')</h4>
            </div>
            <div class="my-3">
                <a href="javascript:void(0);"  class="btn btn-primary btnAddTask">Create</a>
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

    @can('task_create')
        $(document).on("click", ".btnAddTask", function() {
            $('.loader-div').show();
            var url = $(this).data('href');

            $.ajax({
                type: 'get',
                url: "{{route('tasks.create')}}",
                dataType: 'json',
                success: function (response) {
                    $('.loader-div').hide();
                    if(response.success) {
                        $('.popup_render_div').html(response.htmlView);

                        // Populate the assigned_to select with users dynamically
                        let assignedToSelect = $('#assigned_to');
                        assignedToSelect.empty();  // Clear existing options
                        assignedToSelect.append('<option value="">Select Assigned User</option>'); // Default option
                        $.each(response.users, function(index, user) {
                            assignedToSelect.append('<option value="' + user.uuid + '">' + user.name + '</option>');
                        });

                        let projectSelect = $('#project_id');
                        projectSelect.empty();  // Clear existing options
                        projectSelect.append('<option value="">Select Project</option>'); // Default option
                        $.each(response.projects, function(index, project) {
                            projectSelect.append('<option value="' + project.uuid + '">' + project.name + '</option>');
                        });

                        
                        $('.select2').select2({
                            width: '100%',
                            dropdownParent: $('#AddTask'),
                            selectOnClose: false
                        });
                        
                        $('#AddTask').modal('show');

                        $('#project_id').on('change', function () {
                            let projectId = $(this).val();
                            $('#milestone_id').html('<option value="">Loading...</option>');

                            if (projectId) {
                                $.ajax({
                                    url: '{{ route("tasks.milestones.byProject") }}',
                                    type: 'GET',
                                    data: { project_id: projectId },
                                    success: function (data) {
                                        $('#milestone_id').html('<option value="">Select Milestone</option>');
                                        $.each(data, function (key, milestone) {
                                            $('#milestone_id').append('<option value="' + milestone.uuid + '">' + milestone.name + '</option>');
                                        });
                                    },
                                    error: function () {
                                        $('#milestone_id').html('<option value="">Error loading milestones</option>');
                                    }
                                });
                            } else {
                                $('#milestone_id').html('<option value="">Select Milestone</option>');
                            }
                        });

                        $('#milestone_id').on('change', function () {
                            let milestoneId = $(this).val();
                            $('#parent_task_id').html('<option value="">Loading...</option>');
                            if (milestoneId) {
                                $.ajax({
                                    url: "{{ route('tasks.byMilestones') }}",
                                    type: 'GET',
                                    data: { milestone_id: milestoneId },
                                    success: function (data) {
                                        $('#parent_task_id').html('<option value="">Select Task</option>');
                                        if (data.length > 0) {
                                            $.each(data, function (key, task) {
                                                $('#parent_task_id').append('<option value="' + task.uuid + '">' + task.name + '</option>');
                                            });
                                        }
                                    },
                                    error: function () {
                                        $('#parent_task_id').html('<option value="">Error loading milestones</option>');
                                    }
                                });
                            } else {
                                $('#parent_task_id').html('<option value="">Select Task</option>');
                            }
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

        $(document).on('submit','#AddTaskForm', function(e) {
            e.preventDefault();
            $('.loader-div').show();

            $('.validation-error-block').remove();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('tasks.store')}}",
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if(response.success) {
                        $('#AddTask').modal('hide');
                        $('#task-table').DataTable().ajax.reload(null, false);
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

                            if (key === 'task_type') {
                                $("#task_type").next('.select2-container').after(errorLabelTitle);
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

    @can('task_view')
        $(document).on("click", ".btnViewTask", function() {
            $('.loader-div').show();
            var url = $(this).data('href');

            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function (response) {
                    if(response.success) {
                        $('.popup_render_div').html(response.htmlView);
                        $('#ViewTask').modal('show');
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

    @can('task_edit')
        $(document).on("click", ".btnEditTask", function() {
            $('.loader-div').show();
            var url = $(this).data('href');

            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function (response) {
                    if(response.success) {
                        $('.popup_render_div').html(response.htmlView);
                        $('#editTask').modal('show');

                        $('.select2').select2({
                            width: '100%',
                            dropdownParent: $('#editTask'),
                            selectOnClose: false
                        });

                         $('#project_id').on('change', function () {
                            let projectId = $(this).val();
                            $('#milestone_id').html('<option value="">Loading...</option>');
                            $('#parent_task_id').html('<option value="">Loading...</option>');
                            if (projectId) {
                                $.ajax({
                                    url: '{{ route("tasks.milestones.byProject") }}',
                                    type: 'GET',
                                    data: { project_id: projectId },
                                    success: function (data) {
                                        $('#milestone_id').html('<option value="">Select Milestone</option>');
                                        $('#parent_task_id').html('<option value="">Select Task</option>');
                                        $.each(data, function (key, milestone) {
                                            $('#milestone_id').append('<option value="' + milestone.uuid + '">' + milestone.name + '</option>');
                                        });
                                    },
                                    error: function () {
                                        $('#milestone_id').html('<option value="">Error loading milestones</option>');
                                    }
                                });
                            } else {
                                $('#milestone_id').html('<option value="">Select Milestone</option>');
                                $('#parent_task_id').html('<option value="">Select Task</option>');
                            }
                        });
                          $('#milestone_id').on('change', function () {
                            let milestoneId = $(this).val();
                            $('#parent_task_id').html('<option value="">Loading...</option>');
                            console.log(milestoneId);
                            if (milestoneId) {
                                $.ajax({
                                    url: "{{ route('tasks.byMilestones') }}",
                                    type: 'GET',
                                    data: { milestone_id: milestoneId },
                                    success: function (data) {
                                        $('#parent_task_id').html('<option value="">Select Task</option>');
                                        if (data.length > 0) {
                                            $.each(data, function (key, task) {
                                                $('#parent_task_id').append('<option value="' + task.uuid + '">' + task.name + '</option>');
                                            });
                                        }
                                    },
                                    error: function () {
                                        $('#parent_task_id').html('<option value="">Error loading milestones</option>');
                                    }
                                });
                            } else {
                                $('#parent_task_id').html('<option value="">Select Task</option>');
                            }
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

        $(document).on('submit','#editTaskForm', function(e) {
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
                    if(response.success) {
                        $('#editTask').modal('hide');
                        $('#task-table').DataTable().ajax.reload(null, false);
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

                            if (key === 'task_type') {
                                $("#task_type").next('.select2-container').after(errorLabelTitle);
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

    @can('task_delete')
    $(document).on("click",".deleteTaskBtn", function() {
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
                                $('#task-table').DataTable().ajax.reload(null, false);
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