<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

<script src="{{asset('admin-assets/vendor/select2/js/select2.min.js')}}"></script>

{!! $dataTable->scripts() !!}

<script>
    $(document).ready(function(e){
        $(document).on('shown.bs.modal', '#AddTask, #editTask', function () {
            const $modal = $(this);
            $modal.find('.select2').each(function () {
                const $select = $(this);
                console.log($select.val());
                // Prevent double initialization
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }

                $select.select2({
                    width: '100%',
                    dropdownParent: $modal,
                    selectOnClose: false,
                }).on('select2:open', function () {
                    const dropdown = $('.select2-container--open .select2-dropdown');
                    const width = $select.outerWidth();
                    if (dropdown.length) {
                        dropdown.css({
                            'width': width + 'px',
                            'max-width': '100%',
                            'box-sizing': 'border-box',
                            'position': 'absolute'
                        });
                    }
                });
            });
        });
    });
    $(document).on("change", "#project_id", function() {
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

    $(document).on("change", "#milestone_id", function(){
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
                        
    @can('task_create')
        $(document).on("click", ".btnAddTask", function() {
            pageloader('show');
            var url = $(this).data('href');

            $.ajax({
                type: 'get',
                url: "{{route('tasks.create')}}",
                dataType: 'json',
                success: function (response) {
                    if(response.success) {
                        $('.popup_render_div').html(response.htmlView);
                        
                        $('#AddTask').modal('show');
                    }
                    else {
                        toasterAlert('error',response.error);
                    }
                },
                error: function(res){
                    toasterAlert('error',res.responseJSON.error);
                },
                complete: function(xhr){
                    pageloader('show');
                }
            });
        });

        $(document).on('submit','#AddTaskForm', function(e) {
            e.preventDefault();
            pageloader('show', true);

            $('.validation-error-block').remove();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('tasks.store')}}",
                data: formData,
                dataType: 'json',
                success: function (response) {
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
                    pageloader('show', true);
                }
            });
        }); 
    @endcan

    @can('task_view')
        $(document).on("click", ".btnViewTask", function() {
            pageloader('show');
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
                    pageloader('show');
                }
            });
        });
    @endcan

    @can('task_edit')
        $(document).on("click", ".btnEditTask", function() {
            pageloader('show');
            var url = $(this).data('href');

            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function (response) {
                    if(response.success) {
                        $('.popup_render_div').html(response.htmlView);
                        $('#editTask').modal('show');
                    }
                    else {
                        toasterAlert('error',response.error);
                    }
                },
                error: function(res){
                    toasterAlert('error',res.responseJSON.error);
                },
                complete: function(xhr){
                    pageloader('show');
                }
            });
        });

        $(document).on('submit','#editTaskForm', function(e) {
            e.preventDefault();
            pageloader('show', true);

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

                             $("#"+key).siblings('.select2').after(errorLabelTitle);
                        });
                    }
                },
                complete: function(xhr){
                    pageloader('show', true);
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
                    pageloader('show');
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
                            pageloader('show');
                        }
                    });
                }
            });
        });
    @endcan

</script>